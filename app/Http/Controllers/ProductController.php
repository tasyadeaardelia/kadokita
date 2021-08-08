<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('store')->whereHas('store', function($q){
            $q->where('user_id', Auth::user()->id);
        })->get();

        $store = Store::select('is_approved')->where('user_id', Auth::user()->id)->first();
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

        return view('pages.backend.product.index', [
            'products' => $products,
            'store' => $store,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $store = Store::select('is_approved')->where('user_id', Auth::user()->id)->first();

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

        return view('pages.backend.product.create', [
            'category' => $category,
            'store' => $store,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'stock' => 'required',
            'photo' => 'required',
            'description' => 'required',
            'category' => 'required',
        ]);

        $name = $request->input("name");
        $slug = Str::slug($request->input("name"));
        $price = $request->input("price");
        $weight = $request->input("weight");
        $stock = $request->input("stock");
        $photoFile = $request->file("photo");
        $photo = $photoFile->getClientOriginalName();
        $photoFile->move(\base_path() . "/public/library/products/", $photo);
        $description = $request->input("description");
        $auth = Auth::user();
        $store = Store::where('user_id', Auth::user()->id)->first();
        $category = $request->input('category');

       $data = [
           "name" => $name,
           "slug" => $slug,
           "price" => $price,
           "weight" => $weight,
           "stock" => $stock,
           "photo" => $photo,
           "description" => $description,
           "store_id" => $store->id,
       ];

        //    return $data;

        $product = Product::create($data);

        foreach($category as $item) {
            // echo "Kategory nya : ".$item.'</br>';
            $product_categories = ProductCategory::create([
                'product_id' => $product->id,
                'category_id' => $item,
            ]);
        }

        if($product && $product_categories){
            return redirect()->route('product.index')->with('sukses', 'Data berhasil ditambahkan');
        }
        else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->get();
        $productcategory = ProductCategory::with(['product', 'category'])->where('product_id', $id)->get();

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

        return view('pages.backend.product.show', [
            'product' => $product,
            'productcategory' => $productcategory,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $productcategory = ProductCategory::with(['product', 'category'])->whereHas('product', function($q) use ($id){
            $q->where('id', $id);
        })->get();
        $category = Category::all();

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

        return view('pages.backend.product.edit', [
            'product' => $product,
            'productcategory' => $productcategory,
            'category' => $category,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all
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
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'stock' => 'required',
            'photo' => 'required',
            'description' => 'required',
        ]);

        $name = $request->input("name");
        $price = $request->input("price");
        $weight = $request->input("weight");
        $stock = $request->input("stock");
        $photoFile = $request->file("photo");
        $photo = $photoFile->getClientOriginalName();
        $photoFile->move(\base_path() . "/public/library/products/", $photo);
        $description = $request->input("description");
        $auth = Auth::user();
        $store = Store::where('user_id', $auth->id)->get();
        $category = $request->input('category');

        foreach($store as $value) {
            if($value->id) {
                $store_id = $value->id;
            }
        }

       $data = [
           "name" => $name,
           "price" => $price,
           "weight" => $weight,
           "stock" => $stock,
           "photo" => $photo,
           "description" => $description,
           "store_id" => $store_id,
       ];

        $product = Product::where('id', $id)->update($data);
      
       foreach($category as $item){
           $simpanid = $item;
           $cek = ProductCategory::where(['product_id' => $id, 'category_id' => $item])->first();
           //cek jika belum ada
           if(!$cek) {
               $create_new = ProductCategory::create([
                   'product_id' => $id,
                   'category_id' => $item,
               ]);
           }
       }
       $deleteproductcategories = ProductCategory::where('product_id', $id)->whereNotIn('category_id', $category)->delete();

        if($product){
            return redirect()->route('product.index')->with('sukses', 'Data berhasil diedit');
        }
        else {
            return redirect()->back()->with('gagal', 'Maaf, isi data dengan baik ya');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id)->delete();
        $product_categories = ProductCategory::where(['product_id'=>$id]);
        if($product) {
            return redirect()->route('product.index')->with('sukses', 'Data berhasil dihapus');
        }
        else {
            return redirect()->back()->with('gagal', 'Data tidak berhasil dihapus');
        }
    }
}
