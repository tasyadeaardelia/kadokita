<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Post_Tag;

class BlogController extends Controller
{

    public function index(){
        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();

        $blog = Post::all();

        return view('pages.blog', [
            'total_cart' => $total_cart, 
            'admin' => $admin,
            'blog' => $blog,
        ]);
    }

    public function detail($slug){
        if(Auth::check()){
            $total_cart = Cart::where('user_id', Auth::user()->id)->count();
        }
        else{
            $total_cart = 0;
        }

        $admin = User::join('model_has_roles', 'model_has_roles.model_id', 'users.id')
        ->join('roles', 'roles.id', 'model_has_roles.role_id')->where('roles.name', 'admin')->get();
        $blog = Post::where('slug', $slug)->get();
        foreach($blog as $item) {
            $posts = Post::join('users', 'users.id', '=', 'posts.user_id')->where('posts.id', '=', $item->id)->get();
            $tags = Post_Tag::join('posts', 'posts.id', '=', 'post_tags.post_id')
                ->join('tags', 'tags.id', '=', 'post_tags.tag_id')
                ->where('post_tags.post_id', '=', $item->id)
                ->get('tags.name');
        }

        return view('pages.detail-blog', [
            'admin' => $admin,
            'blog' => $blog,
            'total_cart' => $total_cart,
            'tags' => $tags,
        ]);
    }
}
