<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\User;
use App\Models\Province;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(){
        $categories = Category::all();

        $count = DB::table('product_categories')->select(DB::raw("COUNT(category_id) AS hitung, category_id"))
        ->groupBy('category_id')->havingRaw("COUNT(category_id) >= 0")->get();

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();
        
        
        $provinces = Province::pluck('title', 'province_id');

        $products = Product::with('store')->whereHas('store', function($q){
            $q->where('is_approved', 1);
        })->inRandomOrder()->paginate(10);

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

}
