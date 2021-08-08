<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class UserTransactionsController extends Controller
{
    public function index()
    {
        $transactions_details = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('transaction', function($q){
            $q->where('user_id', Auth::user()->id);
        })->get();

        $transaction_pending = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('transaction', function($q){
            $q->where([
                'transaction_status' => 'PENDING',
                'user_id'=> Auth::user()->id,
            ]);
        })->get();

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

        // dd($transactions_details);

        $transaction_to_all = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('product', function($q){
            $q->with('store')->whereHas('store', function($e){
                $e->where('user_id', '!=', Auth::user()->id);
            });
        })
        ->whereHas('transaction', function($q){
            $q->where('transaction_status', 'SUCCESS');
        })->whereNull('resi')->get();

        return view('pages.frontend.usertransaction', [
            'transactions_details' => $transactions_details,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all
        ]);
    }

    public function detail($id)
    {
        $transactions_details = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('transaction', function($q){
            $q->where('user_id', Auth::user()->id);
        })->where('id', $id)->first();

        $transaction_pending = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('transaction', function($q){
            $q->where([
                'transaction_status' => 'PENDING',
                'user_id'=> Auth::user()->id,
            ]);
        })->get();

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

        $transaction_to_all = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('product', function($q){
            $q->with('store')->whereHas('store', function($e){
                $e->where('user_id', '!=', Auth::user()->id);
            });
        })
        ->whereHas('transaction', function($q){
            $q->where('transaction_status', 'SUCCESS');
        })->whereNull('resi')->get();

        return view('pages.frontend.detail-usertransaction', [
            'transactions_details' => $transactions_details,
            'transactions_for_notif' => $transactions_for_notif,
            'transaction_pending' => $transaction_pending,
            'buy_notif' => $buy_notif,
            'transaction_to_all' => $transaction_to_all
        ]);
    }

    public function pdf($code){

        $transactions_details = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('transaction', function($q){
            $q->where('user_id', Auth::user()->id);
        })->where('code', $code)->first();

        $data = [
            'transactions_details' => $transactions_details,
        ];

        $pdf = PDF::loadView('pdf', $data);  
        return $pdf->download('transaksi-pembelian.pdf');
    }
}
