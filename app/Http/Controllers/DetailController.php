<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DateTime;
use App\Models\Cart;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function index($slug) {

        $product = Product::with(['store', 'productcategory'])->whereHas('store', function($q) use($slug){
            $q->with('user')->where([
                'slug' => $slug,
                'is_approved' => 1,
            ]);
        })->first();

        foreach($product->productcategory as $item){
            $c[] = $item->category_id;
        }

        $detailproduct = ProductCategory::with(['product', 'category'])->whereIn('category_id', $c)->get();


        $countproduct = Product::where('store_id', $product->store_id)->count();
        $tglgabung = new DateTime($product->store->created_at);
        
        $now = new DateTime();
        $diff = $tglgabung->diff($now);
        
        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();

        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else {
            $total_cart = 0;
        }
       
        return view('pages.detailproduct', [
            'product' => $product,
            'countproduct' => $countproduct,
            'diff' => $diff,
            'total_cart' => $total_cart,
            'admin' => $admin,
            'detailproduct' => $detailproduct,
        ]);
        // dd($detailproduct);
    }

    public function addToCart(Request $request, $id){
        $quantity = $request->input("quantity");
        $add = [
            "product_id" => $id,
            "user_id" => Auth::user()->id,
            "quantity" => $quantity,
        ];
        $cek = Product::find($id);
        if($cek->stock != 0 ){
            if($quantity <= $cek->stock){
                $cart = Cart::create($add);
                if($cart) {
                    return redirect()->route('cart.index')->with('sukses', 'Produk telah berhasil di masukkan ke keranjang.');
                }
                else{
                    return redirect()->back()->withfailed('Maaf Produk gagal dimasukkan ke keranjang');
                }
            }
            else{
                return redirect()->back()->withfailed('Maaf stok produk tidak mencukupi');
            }
            
        }
        else{
            return redirect()->back()->withfailed('Maaf stok produk tidak mencukupi');
        }
       
    }

    public function deleteCartItem($id){
        $cart = Cart::find($id)->delete($id);
        
    }

    public function detailstore($url) {
       
        $store = Store::with('user')->whereHas('user', function($q){
            $q->with(['province', 'city']);
        })->where('url', $url)->get();

        foreach($store as $item) {
            $id = $item->id;
            $created_at = $item->created_at;
        }
        
        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();

        $tglgabung = new DateTime($created_at);
        $now = new DateTime();
        $diff = $tglgabung->diff($now);

        $products = Product::with('store')->whereHas('store', function($q) use($url){
            $q->where([
                'url'=> $url,
                'is_approved' => 1,
            ]);
        })->paginate(10);

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
            'store_categories_products' => $store_categories_products
        ]);
    }

    public function detailcategory($slug){


        $category = Category::where('slug', $slug)->first();
     

        $detailcategory = Product::select('products.name', 'products.slug', 'products.price', 'products.weight', 
        'products.photo', 'products.stock' )
        ->join('store', 'store.id', 'products.store_id')
        ->join('product_categories', 'product_categories.product_id', 'products.id')
        ->join('categories', 'categories.id', 'product_categories.category_id')
        ->where([
            'categories.slug' => $slug,
            'store.is_approved' => 1,
        ])->paginate(10);
       
        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();

        return view('pages.category', [
            'category' => $category,
            'detailcategory' => $detailcategory,
            'total_cart' => $total_cart,
            'admin' => $admin,
        ]);
    }

}
