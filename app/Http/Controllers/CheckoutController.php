<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\City;
use App\Models\Courier;
use App\Models\Store;
use App\Models\Product;
use App\Models\Province;
use Exception;
use Midtrans\Snap;
use App\Models\Transaction;
use Midtrans\Config;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Midtrans\Notification;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function proccess() {
        //ambil total cart
        $total_cart = Cart::where('user_id', Auth::user()->id)->count();

        $carts = Cart::with(['user' => function($u){
                                        $u->with(['province', 'city']);
                                    }, 
                            'product' => function($q){
                                        $q->with('store', function($s){
                                            $s->with('user', function($u){
                                                $u->with(['province', 'city']);
                                            });
                                        });
                            }
        ])->where('user_id', Auth::user()->id)->first();


        $courier = Courier::select('code', 'title')->get();    

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();
       

        return view('pages.checkout', [
            'carts' => $carts,
            'total_cart' => $total_cart,
            'courier'  => $courier,
            'admin' => $admin,
        ]);
    }

    public function cekongkir(Request $request){
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $request->city_origin,     // ID kota/kabupaten asal
            'destination'   => $request->city_destination,      // ID kota/kabupaten tujuan
            'weight'        => $request->weight,    // berat barang dalam gram
            'courier'       => $request->courier,
        ])->get();
        return json_encode($cost);
    }

    public function selectedongkir(Request $request){
        $ongkir = $request->ongkir;
        return json_encode($ongkir);
    }

    public function checkout(Request $request){;

        //data user yg beli diambil dari id user yg login
        //data toko diambil 
        $code = 'INV-' . mt_rand(000000,999999);
        

        $carts = Cart::with(['user' => function($u){
                    $u->with(['province', 'city']);
                    }, 
                    'product' => function($q){
                                $q->with('store', function($s){
                                    $s->with('user', function($u){
                                        $u->with(['province', 'city']);
                                    });
                                });
                    }
        ])->where(['user_id' => Auth::user()->id, 'product_id' => $request->product_id])->get();

        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'shipping_price' => $request->input("ongkos_kirim"),
            'total_price' => $request->input("total_price"),
            'shipping_courier' => $request->courier,
            'transaction_date' => now(),
            'transaction_status' => 'PENDING',
            'code' => $code,
            'custom_card' => $request->custom_card,
        ]);

        foreach ($carts as $cart) {
            $id_cart = $cart->id;
            $trx = 'INV-TRD-' . mt_rand(000000,999999);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cart->product_id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'code' => $trx,
                'quantity' => $cart->quantity,
            ]);

            $stock = (($cart->product->stock) - ($cart->quantity));
            Product::where('id', $cart->product_id)->update([
                'stock' => $stock,
            ]);
        }

        Cart::where('id', $id_cart)->delete();
        

        //Konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat array untuk dikirim ke midtrans
        $midtrans = array(
            'transaction_details' => array(
                'order_id' =>  $code,
                'gross_amount' => (int) $request->input("total_price"),
            ),
            'customer_details' => array(
                'first_name'    => Auth::user()->fullname,
                'email'         => Auth::user()->email,
                'phone_number' => Auth::user()->phone_number,
                'shipping_address' => array(
                    'address' => Auth::user()->address,
                )
            ),
            'enabled_payments' => array('gopay','bank_transfer', 'Indomaret', 'alfamart', 'ShopeePay',),
            'vtweb' => array()
        );

        try {
            // Ambil halaman payment midtran
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect ke halaman midtrans
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function callback(Request $request)
    {
        // Set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat instance midtrans notification
        $notification = new Notification();

        // Assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Cari transaksi berdasarkan ID

        // Handle notification status midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card'){
                if($fraud == 'challenge'){
                    $transaction = Transaction::where('code', $order_id)->update([
                        'transaction_status' => 'PENDING'
                    ]);
                }
                else {
                    $transaction = Transaction::where('code', $order_id)->update(['transaction_status' => 'SUCCESS']);
                }
            }
        }
        else if ($status == 'settlement'){
            $transaction = Transaction::where('code', $order_id)->update(['transaction_status' => 'SUCCESS']);
        }
        else if($status == 'pending'){
            $transaction = Transaction::where('code', $order_id)->update(['transaction_status' => 'PENDING']);
        }
        else if ($status == 'deny') {
            $transaction = Transaction::where('code', $order_id)->update(['transaction_status' => 'CANCELLED']);
        }
        else if ($status == 'expire') {
            $transaction = Transaction::where('code', $order_id)->update(['transaction_status' => 'CANCELLED']);
        }
        else if ($status == 'cancel') {
            $transaction = Transaction::where('code', $order_id)->update(['transaction_status' => 'CANCELLED']);
        }

        
    }

    public function paylater(Request $request, $code){

        $transaction = Transaction::where([
            'user_id' => Auth::user()->id,
            'code' => $code,
        ])->first();

        //Konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat array untuk dikirim ke midtrans
        $midtrans = array(
            'transaction_details' => array(
                'order_id' =>  $transaction->code,
                'gross_amount' => (int) $transaction->total_price,
            ),
            'customer_details' => array(
                'first_name'    => Auth::user()->fullname,
                'email'         => Auth::user()->email,
                'phone_number' => Auth::user()->phone_number,
                'shipping_address' => array(
                    'address' => Auth::user()->address,
                )
            ),
            'enabled_payments' => array('gopay','bank_transfer', 'Indomaret', 'alfamart', 'ShopeePay',),
            'vtweb' => array()
        );

        try {
            // Ambil halaman payment midtran
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect ke halaman midtrans
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}
