<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Store;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index() {
        if(Auth::check()) {
            $user = User::where('id', Auth::user()->id)->firstOrFail();
            $transaction = TransactionDetail::with(['transaction', 'product'])->whereHas('product', function($q){
                $q->with('store')->whereHas('store', function($s){
                    $s->where('user_id',Auth::user()->id);
                });
            })->whereHas('transaction', function($t){
                $t->where('transaction_status', 'SUKSES');
            })->count();

            $buy = Transaction::where('user_id', Auth::user()->id)->count();

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

            // $pendapatan = TransactionDetail::with(['transaction', 'product'])
            // ->whereHas('product', function($q){
            //     $q->with('store')->whereHas('store', function($e){
            //         $e->where('user_id', Auth::user()->id);
            //     });
            // })->whereHas('transaction', function($q){
            //     $q->select('total_price')->where('transaction_status', 'SUCCESS');
            // })->whereNotNull('resi')->get();

            $pendapatan = Transaction::select(DB::raw('SUM(total_price) AS total_pendapatan'))
            ->join('transaction_details','transaction_details.transaction_id', 'transactions.id')
            ->join('products', 'products.id', 'transaction_details.product_id')
            ->join('store', 'store.id', 'products.store_id')
            ->join('users', 'users.id', 'store.user_id')
            ->where([
                'store.user_id' => Auth::user()->id,
                'transactions.transaction_status' => 'SUCCESS',
            ])->whereMonth('transactions.updated_at', Carbon::now()->format('m'))->get();

            $transaction_to_all = TransactionDetail::with(['transaction', 'product'])
            ->whereHas('product', function($q){
                $q->with('store')->whereHas('store', function($e){
                    $e->where('user_id', '!=', Auth::user()->id);
                });
            })
            ->whereHas('transaction', function($q){
                $q->where('transaction_status', 'SUCCESS');
            })->whereNull('resi')->get();

            return view('pages.frontend.dashboard', [
                'transaction' => $transaction,
                'buy' => $buy,
                'verif_toko' => $verif_toko,
                'transactions_for_notif' => $transactions_for_notif,
                'buy_notif' => $buy_notif,
                'transaction_pending' => $transaction_pending,
                'pendapatan' => $pendapatan,
                'transaction_to_all' => $transaction_to_all
            ]);
        }
        else {
            return redirect()->route('login');
        }
    }

    public function profil(){
        $type = DB::select(DB::raw('SHOW COLUMNS FROM users WHERE Field = "gender"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }
        $user = User::where('id', Auth::user()->id)->firstOrFail();
        $provinces = Province::pluck('title', 'province_id');

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


        return view('pages.dashboard-account', [
            'user' => $user,
            'provinces' => $provinces,
            'values' => $values,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all,
        ]);
    }

    public function update(Request $request, $redirect)
    {
        $fullname = $request->input("fullname");
        $address = $request->input("address");
        $gender = $request->gender;
        $province = $request->province;
        $city = $request->city;
        $phone_number = $request->input("phone_number");
        $zip_code = $request->input("zip_code");
        if($request->file('profil')){
            $profilFile = $request->file('profil');
            $profil = $profilFile->getClientOriginalName();
            $profilFile->move(\base_path() . "/public/library/users/profil/", $profil);
            $data = [
                'fullname' => $fullname,
                'address' => $address,
                'province_id' => $province,
                'city_id' => $city,
                'phone_number' => $phone_number,
                'zip_code' => $zip_code,
                'gender' => $gender,
                'profil' => $profil
            ];
        }
        else{
            $data = [
                'fullname' => $fullname,
                'address' => $address,
                'province_id' => $province,
                'city_id' => $city,
                'phone_number' => $phone_number,
                'zip_code' => $zip_code,
                'gender' => $gender,
            ];
        }
       
        $item = User::where('id', Auth::user()->id)->update($data);
        return redirect()->route($redirect)->with('sukses', 'Akun Berhasil di perbaharui');
    }

    public function alluser()
    {
        $users = User::all();

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


        return view('pages.backend.user', [
            'users' => $users,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all
        ]);
    }

    public function detailuser($id){
        $user = User::where('id', $id)->first();

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


        return view('pages.backend.detailuser', [
            'user' => $user,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all
        ]);
    }


    public function formupdatepassword(){
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

        return view('pages.update-password', [
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all,
        ]);
    }
    
    public function updatepassword(Request $request, $redirect){
        $this->validate($request, [
            'password' => 'required',
            'old-password' => 'required',
        ]);

        $user = User::findOrFail(Auth::user()->id);
        if (Hash::check($request->old_password, $user->password)) { 
            $user->fill([
             'password' => Hash::make($request->password)
             ])->save();
             return redirect()->route($redirect)
             ->with('sukses','Password Anda berhasil di update');
         
         } else {
             return redirect()->back()->with('gagal', 'Password lama anda salah');
         }
    }
}
