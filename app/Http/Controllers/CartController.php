<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::select('carts.id', 'carts.product_id', 'carts.quantity', 'carts.user_id', 'products.name AS nama_produk', 'products.price', 'products.photo',
        'products.store_id', 'store.name AS nama_toko', 'store.user_id AS id_pemilik')->join('products', 'products.id', '=', 'carts.product_id')
        ->join('store', 'store.id', '=', 'products.store_id')->join('users', 'users.id', '=', 'carts.user_id')
        ->where('carts.user_id', Auth::user()->id)->get();
        $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();
        $provinces = Province::get();   
         return view('pages.cart', [
                'carts' => $carts,
                'total_cart'=> $total_cart,
                'provinces' => $provinces,
                'admin' => $admin,
            ]);
        
    }

    public function delete(Request $request, $id)
    {
        $data = Cart::where('id', $id)->delete();
        return json_encode($data);
    
    }
    

}
