<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Province;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\TransactionDetail;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store = Store::with('user')->whereHas('user', function($q){
            $q->where('id', Auth::user()->id);
        })->first();


        $transactions_for_notif = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('product', function($q){
            $q->with('store')->whereHas('store', function($e){
                $e->where('user_id', Auth::user()->id);
            });
        })
        ->whereHas('transaction', function($q){
            $q->where('transaction_status', 'SUCCESS');
        })
        ->whereNull('resi')->get();

        $buy_notif = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('transaction', function($q){
            $q->where('user_id', Auth::user()->id);
        })
        ->whereNotNull('resi')->whereDate('updated_at', Carbon::today())->get();

        $transaction_pending = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('transaction', function($q){
            $q->where([
                'transaction_status' => 'PENDING',
                'user_id'=> Auth::user()->id,
            ]);
        })->get();

        $transaction_to_all = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('product', function($q){
            $q->with('store')->whereHas('store', function($e){
                $e->where('user_id', '!=', Auth::user()->id);
            });
        })
        ->whereHas('transaction', function($q){
            $q->where('transaction_status', 'SUCCESS');
        })->whereNull('resi')->get();


        
        //jika belum buka toko
        if(!$store) {
            return view('pages.frontend.store.index', [
                'store' => $store,
                'transactions_for_notif' => $transactions_for_notif,
                'buy_notif' => $buy_notif,
                'transaction_pending' => $transaction_pending,
                'transaction_to_all' => $transaction_to_all
            ]);
        }
        else {
            return redirect()->route('store.edit', $store->id);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //ambil id user yang login
       $auth = Auth::user();
       $toko = new Store();
    //    $toko->name = '';
    //    $toko->url = '';
    //    $toko->description = '';
    //    $toko->profil = '';
       $toko->is_approved = false;
       $toko->user_id = $auth->id;
       $toko->save();

       $user = User::where('id', $auth->id)->firstOrFail();
       //update role nya menjadi penjual juga
       $user->syncRoles(['buyer', 'seller']);

       return redirect()->route('store.edit', $auth->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user_id)
    {
        $type = DB::select(DB::raw('SHOW COLUMNS FROM users WHERE Field = "gender"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }

        
        $store = Store::with('user')->whereHas('user', function($q){
            $q->where('id', Auth::user()->id);
        })->first();

        $provinces = Province::pluck('title', 'province_id');

   
        $transactions_for_notif = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('product', function($q){
            $q->with('store')->whereHas('store', function($e){
                $e->where('user_id', Auth::user()->id);
            });
        })
        ->whereHas('transaction', function($q){
            $q->where('transaction_status', 'SUCCESS');
        })
        ->whereNull('resi')->get();

        $buy_notif = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('transaction', function($q){
            $q->where('user_id', Auth::user()->id);
        })
        ->whereNotNull('resi')->whereDate('updated_at', Carbon::today())->get();

        $transaction_pending = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('transaction', function($q){
            $q->where([
                'transaction_status' => 'PENDING',
                'user_id'=> Auth::user()->id,
            ]);
        })->get();

        $transaction_to_all = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('product', function($q){
            $q->with('store')->whereHas('store', function($e){
                $e->where('user_id', '!=', Auth::user()->id);
            });
        })
        ->whereHas('transaction', function($q){
            $q->where('transaction_status', 'SUCCESS');
        })->whereNull('resi')->get();

        $verif_toko = Store::where('is_approved', false)->get();


        return view('pages.frontend.store.edit', [
            'store' => $store,
            'provinces' => $provinces,
            'values'  => $values,
            'transactions_for_notif'=> $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all,
            'verif_toko' => $verif_toko,
        ]); 
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required',
            'description' => 'required',
            'profil' => 'required',
            'fullname' => 'required',
            'gender' => 'required',
            'id_card' => 'required',
            'account_number' => 'required',
            'address' => 'required',
            'province' => 'required',
            'city' => 'required',
        ]);

        $name = $request->input("name");
        $url = $request->input("url");
        $description = $request->input("description");
        $profilFile = $request->file('profil');
        $profil = $profilFile->getClientOriginalName();
        $profilFile->move(\base_path() . "/public/library/store/", $profil);
        $fullname = $request->input("fullname");
        $gender = $request->gender;
        $idcard = $request->input("id_card");
        $idcardFile = $request->file('id_card');
        $idcard = $idcardFile->getClientOriginalName();
        $idcardFile->move(\base_path() . "/public/library/seller/", $idcard);
        $account_number = $request->input("account_number");
        $phone_number = $request->input("phone_number");
        $address = $request->input("address");
        $province = $request->province;
        $city = $request->city;
        $user_id = $request->input("user_id");
        $data_store = [
            "name" => $name,
            "url" => $url,
            "description" => $description,
            "profil" => $profil,
            "user_id" => Auth::user()->id,
        ];
        $data_user = [
            "fullname" => $fullname,
            "gender" => $gender,
            "phone_number" => $phone_number,
            "account_number" => $account_number,
            "id_card" => $idcard,
            "address" => $address,
            "province_id" => $province,
            "city_id" => $city,
        ];

        $update_store = Store::findOrFail($id);
        $update_store->update($data_store);
        $update_user = User::where('id', Auth::user()->id)->update($data_user);
        
        if($update_store && $update_user) {
            return redirect()->route('store.index')->with('sukses', 'Toko berhasil dibuat');
        }
        else {
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
