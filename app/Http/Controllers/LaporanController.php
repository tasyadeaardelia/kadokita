<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Store;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

class LaporanController extends Controller
{
    public function index(){
        // $transactions_details = TransactionDetail::with(['transaction', 'product'])
        //     ->whereHas('product', function($q){
        //         $q->with('store')->whereHas('store', function($e){
        //             $e->where('user_id', Auth::user()->id);
        //         });
        //     })->get();

        $buy_notif = TransactionDetail::with(['transaction', 'product'])
        ->whereHas('transaction', function($q){
            $q->where('user_id', Auth::user()->id);
        })
        ->whereNotNull('resi')->whereDate('updated_at', Carbon::today())->get();

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

        return view('pages.frontend.laporanpenjualan', [
            // 'transactions_details' => $transactions_details,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all
        ]);
    }

    public function pdflaporan(Request $request){

        if($request->periode == 'hari ini'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereDate('transaction_date', Carbon::today());
                            })->get();
        }
        elseif($request->periode == 'januari'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '01');
                            })->get();
        }
        elseif($request->periode == 'februari'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '02');
                            })->get();
        }
        elseif($request->periode == 'maret'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '03');
                            })->get();
        }
        elseif($request->periode == 'april'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '04');
                            })->get();
        }
        elseif($request->periode == 'mei'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '05');
                            })->get();
        }
        elseif($request->periode == 'juni'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '06');
                            })->get();
        }
        elseif($request->periode == 'juli'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '07');
                            })->get();
        }
        elseif($request->periode == 'agustus'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '08');
                            })->get();
        }
        elseif($request->periode == 'september'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '09');
                            })->get();
        }
        elseif($request->periode == 'oktober'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '10');
                            })->get();
        }
        elseif($request->periode == 'november'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '11');
                            })->get();
        }
        elseif($request->periode == 'desember'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('product', function($q){
                                $q->with('store')->whereHas('store', function($e){
                                    $e->where('user_id', Auth::user()->id);
                                });
                            })
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '12');
                            })->get();
        }
        else{
            return redirect()->route('laporan.penjualan')->withError('Silahkan pilih periode penjualan');
        }

        $data = [
            'transactions' => $transactions,
        ];

        $pdf = PDF::loadView('laporan', $data);  
        return $pdf->setPaper('a2', 'landscape')->download('laporan-penjualan.pdf');
    }

    public function pdflaporanadmin(Request $request){

        if($request->periode == 'hari ini'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereDate('transaction_date', Carbon::today());
                            })->get();
        }
        elseif($request->periode == 'januari'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '01');
                            })->get();
        }
        elseif($request->periode == 'februari'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '02');
                            })->get();
        }
        elseif($request->periode == 'maret'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '03');
                            })->get();
        }
        elseif($request->periode == 'april'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '04');
                            })->get();
        }
        elseif($request->periode == 'mei'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '05');
                            })->get();
        }
        elseif($request->periode == 'juni'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '06');
                            })->get();
        }
        elseif($request->periode == 'juli'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '07');
                            })->get();
        }
        elseif($request->periode == 'agustus'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '08');
                            })->get();
        }
        elseif($request->periode == 'september'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '09');
                            })->get();
        }
        elseif($request->periode == 'oktober'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '10');
                            })->get();
        }
        elseif($request->periode == 'november'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '11');
                            })->get();
        }
        elseif($request->periode == 'desember'){
            $transactions = TransactionDetail::with(['transaction', 'product'])
                            ->whereHas('transaction', function($q){
                                $q->whereMonth('transaction_date', '12');
                            })->get();
        }
        else{
            return redirect()->route('laporan.penjualan')->withError('Silahkan pilih periode penjualan');
        }

        $data = [
            'transactions' => $transactions,
        ];

        $pdf = PDF::loadView('adminlaporan', $data);  
        return $pdf->setPaper('a1', 'landscape')->download('laporan-penjualan.pdf');
    }
}
