<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Post;
use App\Models\Store;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $transaction = Transaction::count();

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

        $seller = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'seller')->count();
        
        $post = Post::where('status', 'aktif')->count();

        $buyer = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'buyer')->count();

        $pendapatan = Transaction::select(DB::raw('SUM(total_price) AS total_pendapatan'))
            ->join('transaction_details','transaction_details.transaction_id', 'transactions.id')
            ->join('products', 'products.id', 'transaction_details.product_id')
            ->join('store', 'store.id', 'products.store_id')
            ->join('users', 'users.id', 'store.user_id')
            ->where([
                'store.user_id' => Auth::user()->id,
                'transactions.transaction_status' => 'SUCCESS',
            ])->whereMonth('transactions.updated_at', Carbon::now()->format('m'))->get();

        $bulan = Carbon::now()->format('F');
        return view('pages.backend.dashboard', [
            'transaction' => $transaction,
            'verif_toko' => $verif_toko,
            'seller' => $seller,
            'post' => $post,
            'buyer' => $buyer, 
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'pendapatan' => $pendapatan,
            'transaction_to_all' => $transaction_to_all,
            'bulan' => $bulan,
        ]);
    }
}
