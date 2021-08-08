<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DateTime;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Models\Category;
use App\Models\Province;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class FilterController extends Controller
{
    public function price(Request $request)
    {
        $lowest = 0;
        $low = 100000;
        $middle = 200000;
        $high = 300000;
        $highest = 500000;

        if($request->filter_by_price == $low){
            $products = Product::select("*")->where('store_id', $request->input('store_id'))
            ->whereBetween('price', [$lowest, $request->filter_by_price])
            ->paginate(10);
        }
        elseif($request->filter_by_price == $middle){
            $products = Product::select("*")
            ->where('store_id', $request->input('store_id'))
            ->whereBetween('price', [$low, $request->filter_by_price])
            ->paginate(10);
        }
        elseif($request->filter_by_price == $high){
            $products = Product::select("*")->where('store_id', $request->input('store_id'))
            ->whereBetween('price', [$middle, $request->filter_by_price])
            ->paginate(10);
        }
        elseif($request->filter_by_price == $highest){
            $products = Product::select("*")
            ->where('store_id', $request->input('store_id'))
            ->whereBetween('price', [$high, $request->filter_by_price])
            ->paginate(10);
        }

        $store = Store::with('user')->whereHas('user', function($e){
            $e->with(['province', 'city']);
        })->where('id', $request->input('store_id'))->get();


        foreach($store as $item) {
            $id = $item->id;
            $created_at = $item->created_at;
        }
     

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();

        $tglgabung = new DateTime($created_at);
        $now = new DateTime();
        $diff = $tglgabung->diff($now);


        $store_categories_products = Store::select('categories.id', 'categories.name', DB::raw("count(categories.id) as hitung"))
        ->join('products', 'products.store_id', 'store.id')
        ->join('product_categories', 'product_categories.product_id', 'products.id')
        ->join('categories', 'categories.id', 'product_categories.category_id')
        ->where('store.id', $id)
        ->groupBy('categories.id', 'categories.name')
        ->get();
        
        $countproduct = Product::where('store_id', $id)->count();
        
        
        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }
        
        return view('pages.frontend.store.detail', [ 
            'store' => $store,
            'total_cart' => $total_cart,
            'admin'  => $admin,
            'diff' => $diff,
            'countproduct' => $countproduct,
            'products' => $products,
            'store_categories_products' => $store_categories_products,
         
        ]);
            
    }

    public function category(Request $request, $id, $name)
    {
        
        $products = Product::select('products.id', 'products.name', 'products.price', 'products.stock','products.photo', 
        'products.description AS deskripsi_produk', 'products.store_id', 'products.slug',
        'products.created_at', 'store.name AS nama_toko', 'store.description AS deskripsi_toko', 'categories.id',  'categories.name AS nama_kategori'
        )->join('product_categories', 'product_categories.product_id', 'products.id')
        ->join('categories', 'categories.id', 'product_categories.category_id')
        ->join('store', 'store.id', 'products.store_id')
        ->where('store.id', $id)
        ->where('categories.name', 'LIKE', '%'.$name.'%')
        ->paginate(10);
    

         $store = Store::with('user')->whereHas('user', function($e){
            $e->with(['province', 'city']);
        })->where('id', $id)->get();


        foreach($store as $item) {
            $id = $item->id;
            $created_at = $item->created_at;
        }
     

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();

        $tglgabung = new DateTime($created_at);
        $now = new DateTime();
        $diff = $tglgabung->diff($now);


        $store_categories_products = Store::select('categories.id', 'categories.name', DB::raw("count(categories.id) as hitung"))
        ->join('products', 'products.store_id', 'store.id')
        ->join('product_categories', 'product_categories.product_id', 'products.id')
        ->join('categories', 'categories.id', 'product_categories.category_id')
        ->where('store.id', $id)
        ->groupBy('categories.id', 'categories.name')
        ->get();
        
        $countproduct = Product::where('store_id', $id)->count();
        
        
        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }
        
        return view('pages.frontend.store.detail', [ 
            'store' => $store,
            'total_cart' => $total_cart,
            'admin'  => $admin,
            'diff' => $diff,
            'countproduct' => $countproduct,
            'products' => $products,
            'store_categories_products' => $store_categories_products,
         
        ]);
            
    }


    //filter harga di halaman tampilan semua produk
    public function shopFilterPrice(Request $request)
    {
        $lowest = 0;
        $low = 100000;
        $middle = 200000;
        $high = 300000;
        $highest = 500000;

        if($request->filter_by_price == $low){
            $products = Product::with('store')->whereHas('store', function($q){
                $q->where('is_approved', 1);
            })
            ->whereBetween('price', [$lowest, $request->filter_by_price])
            ->paginate(10);
        }
        elseif($request->filter_by_price == $middle){
            $products = Product::with('store')->whereHas('store', function($q){
                $q->where('is_approved', 1);
            })
            ->whereBetween('price', [$low, $request->filter_by_price])
            ->paginate(10);
        }
        elseif($request->filter_by_price == $high){
            $products = Product::with('store')->whereHas('store', function($q){
                $q->where('is_approved', 1);
            })
            ->whereBetween('price', [$middle, $request->filter_by_price])
            ->paginate(10);
        }
        elseif($request->filter_by_price == $highest){
            $products = Product::with('store')->whereHas('store', function($q){
                $q->where('is_approved', 1);
            })
            ->whereBetween('price', [$high, $request->filter_by_price])
            ->paginate(10);
        }
    

        $provinces = Province::pluck('title', 'province_id');

        $categories = Category::all();
        $count = DB::table('product_categories')->select(DB::raw("COUNT(category_id) AS hitung, category_id"))
        ->groupBy('category_id')->havingRaw("COUNT(category_id) >= 0")->get();

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();

        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }
        
        return view('pages.kado', [
            'total_cart' => $total_cart,
            'categories' => $categories,
            'count' => $count,
            'products' => $products,
            'admin' => $admin,
            'provinces' => $provinces,
        ]);
            
    }

    public function shopFilterCategory(Request $request, $slug)
    {
        
        $products = Product::select('products.id', 'products.name', 'products.price', 'products.stock','products.photo', 
        'products.description AS deskripsi_produk', 'products.store_id', 'products.slug',
        'products.created_at', 'categories.id',  'categories.name AS nama_kategori'
        )->join('store', 'store.id', 'products.store_id')
        ->join('product_categories', 'product_categories.product_id', 'products.id')
        ->join('categories', 'categories.id', 'product_categories.category_id')
        ->where('categories.slug', 'LIKE', '%'.$slug.'%')
        ->where('store.is_approved', 1)
        ->paginate(10);

        $categories = Category::all();
        $count = DB::table('product_categories')->select(DB::raw("COUNT(category_id) AS hitung, category_id"))
        ->groupBy('category_id')->havingRaw("COUNT(category_id) >= 0")->get();

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();

        $provinces = Province::pluck('title', 'province_id');

        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }
        
        return view('pages.kado', [
            'total_cart' => $total_cart,
            'categories' => $categories,
            'count' => $count,
            'products' => $products,
            'admin' => $admin,
            'provinces' => $provinces,
        ]);
            
    }

    public function shopFilterLocation(Request $request)
    {

        $products = Product::with('store')->whereHas('store', function($q) use($request){
            $q->with('user')->whereHas('user', function($u) use($request){
                $u->with(['province', 'city'])->whereHas('province', function($p) use($request){
                    $p->where('province_id', $request->filter_by_location);
                });
            })->where('is_approved', 1);
        })->paginate(10);

        $categories = Category::all();

        $count = DB::table('product_categories')->select(DB::raw("COUNT(category_id) AS hitung, category_id"))
        ->groupBy('category_id')->havingRaw("COUNT(category_id) >= 0")->get();

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();
        $provinces = Province::pluck('title', 'province_id');

        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }
        
        return view('pages.kado', [
            'total_cart' => $total_cart,
            'categories' => $categories,
            'count' => $count,
            'products' => $products,
            'admin' => $admin,
            'provinces' => $provinces,
        ]);
            
    }

    public function shopFilterAsc($q){
        if($q == 'asc'){
            $products = Product::with('store')->whereHas('store', function($q){
                $q->where('is_approved', 1);
            })->orderBy('name', 'asc')->paginate(10);
        }
        elseif($q == 'dsc'){
            $products = Product::with('store')->whereHas('store', function($q){
                $q->where('is_approved', 1);
            })->orderBy('name', 'desc')->paginate(10);
        }
        elseif($q == 'lowest'){
            $products = Product::with('store')->whereHas('store', function($q){
                $q->where('is_approved', 1);
            })->orderBy('price', 'asc')->paginate(10);
        }
        elseif($q == 'highest'){
            $products = Product::with('store')->whereHas('store', function($q){
                $q->where('is_approved', 1);
            })->orderBy('price', 'desc')->paginate(10);
        }

        $categories = Category::all();
        $count = DB::table('product_categories')->select(DB::raw("COUNT(category_id) AS hitung, category_id"))
        ->groupBy('category_id')->havingRaw("COUNT(category_id) >= 0")->get();

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();
        $provinces = Province::pluck('title', 'province_id');

        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }
        
        return view('pages.kado', [
            'total_cart' => $total_cart,
            'categories' => $categories,
            'count' => $count,
            'products' => $products,
            'admin' => $admin,
            'provinces' => $provinces,
        ]);
    }

    public function filterCategoryPrice(Request $request)
    {
        
        $lowest = 0;
        $low = 100000;
        $middle = 200000;
        $high = 300000;
        $highest = 500000;

        $category = Category::where('slug', $request->input('slug'))->first();
    
        if($request->filter_by_price == $low){
            $detailcategory = Product::select('products.id', 'products.name', 'products.price', 'products.stock','products.photo', 
            'products.description AS deskripsi_produk', 'products.store_id', 'products.slug',
            'products.created_at', 'categories.id',  'categories.name AS nama_kategori'
            )->join('store', 'store.id', 'products.store_id')
            ->join('product_categories', 'product_categories.product_id', 'products.id')
            ->join('categories', 'categories.id', 'product_categories.category_id')
            ->where('categories.slug', 'LIKE', '%'.$category->slug.'%')
            ->where('store.is_approved', 1)
            ->whereBetween('products.price', [$lowest, $request->filter_by_price])
            ->paginate(10);
        }
        elseif($request->filter_by_price == $middle){
            $detailcategory = Product::select('products.id', 'products.name', 'products.price', 'products.stock','products.photo', 
            'products.description AS deskripsi_produk', 'products.store_id', 'products.slug',
            'products.created_at', 'categories.id',  'categories.name AS nama_kategori'
            )->join('store', 'store.id', 'products.store_id')
            ->join('product_categories', 'product_categories.product_id', 'products.id')
            ->join('categories', 'categories.id', 'product_categories.category_id')
            ->where('categories.slug', 'LIKE', '%'.$category->slug.'%')
            ->where('store.is_approved', 1)
            ->whereBetween('products.price', [$low, $request->filter_by_price])
            ->paginate(10);
        }
        elseif($request->filter_by_price == $high){
            $detailcategory = Product::select('products.id', 'products.name', 'products.price', 'products.stock','products.photo', 
            'products.description AS deskripsi_produk', 'products.store_id', 'products.slug',
            'products.created_at', 'categories.id',  'categories.name AS nama_kategori'
            )->join('store', 'store.id', 'products.store_id')
            ->join('product_categories', 'product_categories.product_id', 'products.id')
            ->join('categories', 'categories.id', 'product_categories.category_id')
            ->where('categories.slug', 'LIKE', '%'.$category->slug.'%')
            ->where('store.is_approved', 1)
            ->whereBetween('products.price', [$middle, $request->filter_by_price])
            ->paginate(10);
        }
        elseif($request->filter_by_price == $highest){
            $detailcategory = Product::select('products.id', 'products.name', 'products.price', 'products.stock','products.photo', 
            'products.description AS deskripsi_produk', 'products.store_id', 'products.slug',
            'products.created_at', 'categories.id',  'categories.name AS nama_kategori'
            )->join('store', 'store.id', 'products.store_id')
            ->join('product_categories', 'product_categories.product_id', 'products.id')
            ->join('categories', 'categories.id', 'product_categories.category_id')
            ->where('categories.slug', 'LIKE', '%'.$category->slug.'%')
            ->where('store.is_approved', 1)
            ->whereBetween('products.price', [$high, $request->filter_by_price])
            ->paginate(10);
        }


        $count = DB::table('product_categories')->select(DB::raw("COUNT(category_id) countt, category_id"))
        ->groupBy('category_id')->havingRaw("COUNT(category_id) >= 0")->get();

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();

        $provinces = Province::pluck('title', 'province_id');

        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }
        
        return view('pages.category', [
            'total_cart' => $total_cart,
            'category' => $category,
            'count' => $count,
            'detailcategory' => $detailcategory,
            'admin' => $admin,
            'provinces' => $provinces,
        ]);
            
    }

}
