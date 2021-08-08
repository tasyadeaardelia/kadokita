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

        //ambil data cart dengan user id yg login
        // $carts = Cart::select('carts.id', 'carts.product_id', 'carts.quantity', 'carts.user_id', 'products.name AS nama_produk',
        //         'products.price AS harga_produk')->join('products', 'products.id', '=', 'carts.product_id')
        //         ->join('users', 'users.id', 'carts.user_id')->where('carts.user_id', Auth::user()->id)->get();
        $carts = Cart::with(['user' => function($u){
            $u->with(['province', 'city']);
        }, 'product' => function($q){
            $q->with('store', function($s){
                $s->with('user', function($u){
                    $u->with(['province', 'city']);
                });
            });
        }])->first();

        $users = User::select('users.id AS id_penerima','users.fullname AS nama_penerima', 'users.address_one AS alamat_tujuan', 'provinces.province_id AS id_provinsi_tujuan', 'provinces.title AS provinsi_tujuan', 'cities.city_id AS id_kota_tujuan',
        'cities.title AS kota_tujuan', 'users.email AS email_penerima', 'users.phone_number AS hp_penerima')->join('provinces', 'provinces.province_id', 'users.province_id')
        ->join('cities', 'cities.city_id', 'users.city_id')->where('users.id', Auth::user()->id)->get();


        $courier = Courier::select('code', 'title')->get();

        // $toko = Store::select('store.name AS nama_toko', 'users.fullname as pemilik_toko',
        //         'users.address_one AS alamat_asal', 'users.phone_number AS nomor_pemilik_toko', 'users.city_id AS id_kota_asal',
        //         'users.province_id AS id_provinsi_asal', 'products.name AS nama_produk', 'products.weight AS berat',
        //         'provinces.title AS provinsi_asal', 'cities.title AS kota_asal')
        //         ->join('products','products.store_id', 'store.id')
        //         ->join('carts', 'carts.product_id', 'products.id')
        //         ->join('users', 'users.id', 'store.user_id')
        //         ->join('provinces', 'provinces.province_id', 'users.province_id')
        //         ->join('cities', 'cities.city_id', 'users.city_id')
        //         ->where('carts.user_id', Auth::user()->id)->get();
    

             

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();
       

        return view('pages.checkout', [
            'carts' => $carts,
            'total_cart' => $total_cart,
            'users' => $users,
            // 'provinsi' => $provinsi,
            // 'kota' => $kota,
            'courier'  => $courier,
            // 'toko' => $toko,
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
        $code = 'INV-' . mt_rand(0000,9999);
        
        $carts = Cart::select('carts.id', 'carts.product_id', 'carts.quantity', 'carts.user_id', 'products.name AS nama_produk', 'products.price', 'products.photo', 'products.stock AS stok_produk',
        'products.store_id', 'store.name AS nama_toko', 'store.user_id AS id_pemilik')->join('products', 'products.id', '=', 'carts.product_id')
        ->join('store', 'store.id', '=', 'products.store_id')->join('users', 'users.id', '=', 'carts.user_id')
        ->where('carts.user_id', Auth::user()->id)->get();


        $transaction = Transaction::create([
            'user_id' => Auth::user()->id,
            'shipping_price' => $request->input("ongkos_kirim"),
            'total_price' => $request->input("total_price"),
            'shipping_courier' => $request->courier,
            'transaction_status' => 'PENDING',
            'code' => $code,
            'custom_card' => $request->custom_card,
        ]);

        foreach ($carts as $cart) {
            $trx = 'INV-TR-' . mt_rand(0000,9999);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'resi' => '',
                'code' => $trx
            ]);
        }

        // Delete cart data
        Cart::join('products', 'products.id', 'carts.product_id')->join('users', 'users.id', 'carts.user_id')
        ->where('user_id', Auth::user()->id)->delete();

        //delete stok produk dari tbl 
      
        foreach($carts as $item)  {
            $stok = (($item->stok_produk)-($item->quantity));
            Product::where('id', $item->product_id)->update([
                'stock' => $stok,
            ]);
        }
        

        // Konfigurasi midtrans
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
                'email'         => Auth::user()->email
            ),
            'enabled_payments' => array('gopay','bank_transfer'),
            'vtweb' => array()
        );

        try {
            // Ambil halaman payment midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect ke halaman midtrans
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
