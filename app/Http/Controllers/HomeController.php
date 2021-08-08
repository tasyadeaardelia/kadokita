<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Banner;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::with('store')
        ->whereHas('store', function($q){
            $q->where('is_approved', 1);
        })->inRandomOrder()->limit(5)->get();
        $categories = Category::limit(6)->get();
        $blog_posts = Post::inRandomOrder()->limit(1)->get();
        $banner = Banner::all();
        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();
        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }
        
        return view('pages.home', [
            'banner' =>$banner,
            'products' => $products,
            'total_cart' => $total_cart,
            'categories' => $categories,
            'blog_posts' => $blog_posts,
            'admin' => $admin,
        ]);
    }

    public function category(){
        $categories = Category::all();
        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }
        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();
        

        return view('pages.allcategory', [
            'categories' => $categories,
            'total_cart' => $total_cart,
            'admin' => $admin,
        ]);
    }
}
