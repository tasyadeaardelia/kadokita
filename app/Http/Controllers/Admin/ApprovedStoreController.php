<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use Illuminate\Support\Carbon;
use App\Models\TransactionDetail;

class ApprovedStoreController extends Controller
{
    public function approved(){
        $stores = Store::where('is_approved', true)->get();
        $verif_toko = Store::where('is_approved', false)->get();

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
        })->whereNotNull('resi')->whereDate('updated_at', Carbon::today())->get();

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

        return view('pages.backend.stores.approved', [
            'stores' => $stores,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all
        ]);
    }

    public function new(){
        $stores = Store::where('is_approved', 0)->get();
        $verif_toko = Store::where('is_approved', false)->get();

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
        })->whereNotNull('resi')->whereDate('updated_at', Carbon::today())->get();

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


            return view('pages.backend.stores.new', [
                'stores' => $stores,
                'verif_toko' => $verif_toko,
                'transactions_for_notif' => $transactions_for_notif,
                'buy_notif' => $buy_notif,
                'transaction_pending' => $transaction_pending,
                'transaction_to_all' => $transaction_to_all
            ]);
    }

    public function show($url){
        $stores = Store::with('user')->where('url', $url)->get();

        $verif_toko = Store::where('is_approved', false)->get();

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
        })->whereNotNull('resi')->whereDate('updated_at', Carbon::today())->get();

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

        return view('pages.backend.stores.show', [
            'stores' => $stores,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all
        ]);
    }

    public function accept(Request $request, $url) {
        $is_approved = $request->input('is_approved');
        $data = [
            'is_approved' => $is_approved,
        ];
        $store = Store::where('url', $url)->update($data);
        if($store) {
            return redirect()->route('approved-store')->with('sukses', 'Toko telah disetujui');
        }
        else{
            return redirect()->back();
        }
    }

    public function disapproved(Request $request, $url){
        $is_approved = $request->input('is_approved');
        $data = [
            'is_approved' => $is_approved,
        ];
        $store = Store::where('url', $url)->update($data);
        if($store) {
            return redirect()->route('new-store')->with('sukses', 'Persetujuan Toko telah dibatalkan');
        }
        else{
            return redirect()->back();
        }
    }
}
