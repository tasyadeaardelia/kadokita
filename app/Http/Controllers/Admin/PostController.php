<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Str;
use App\Models\Post_Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use App\Models\Store;
use App\Models\TransactionDetail;
use Illuminate\Support\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

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

        return view('pages.backend.post.index', [
            'posts' => $posts,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif, 
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' =>$transaction_to_all,
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = DB::select(DB::raw('SHOW COLUMNS FROM posts WHERE Field = "status"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }

        $verif_toko = Store::where('is_approved', false)->get();;

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

        return view('pages.backend.post.create', [
            'values' => $values,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all,
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
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
            'publishedAt' => 'required',
            'status' => 'required',
            'tags' => 'required',
        ]);

        $title = $request->input("title");
        $content = $request->input("content");
        $imageFile = $request->file('image');
        $image = $imageFile->getClientOriginalName();
        $imageFile->move(\base_path() . "/public/library/blog/", $image);
        $publishedAt = $request->publishedAt;
        $status = $request->status;
        $author = Auth::user();
        $authorId = $author->id;
        $slug = Str::slug($request->input("title"));
        $tags = explode(',', $request->input("tags"));

        $data = [
            'title' => $title,
            'content' => $content,
            'image' => $image,
            'publishedAt' => $publishedAt,
            'status' => $status,
            'user_id' => $authorId,
            'slug' => $slug,
            'tags' => $tags,
        ];

        // return $data;
        $post = Post::create($data);

        foreach ($tags as $tag) 
        {
            //cek apakah ada tag yang diinput sudah ada di dalam database?
            $itemTag = Tag::where('name', trim($tag))->first();
            //jika belum ada, maka buat tag baru diambil dari tag yang diinput di form
           if (!$itemTag) {
            $itemTag = Tag::create(['name' => trim($tag), 'slug' => Str::slug($tag)]);
           }
           //simpan ke table post_tags untuk post dan tag yang sudah dibuat
           $post_tag = Post_Tag::create(['post_id' => $post->id, 'tag_id'=>$itemTag->id]);
        }

        if($post && $post_tag) 
        {
            return redirect()->route('post.index')->with('sukses', 'Data berhasil ditambahkan');
        }
        else 
        {
            return redirect()->back()->with('gagal', 'Data tidak berhasil ditambahkan');
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
        $data = Post::where('id', $id)->get();        
        foreach($data as $item) {
            $tags = Post_Tag::join('posts', 'posts.id', '=', 'post_tags.post_id')
                ->join('tags', 'tags.id', '=', 'post_tags.tag_id')
                ->where('post_tags.post_id', '=', $item->id)
                ->get('tags.name');
        }


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

        return view('pages.backend.post.show',[
            'data' => $data,
            'tags' => $tags,
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
        $post = Post::findOrFail($id);
        $postTags = Post_Tag::where('post_id', $post->id)->get();
        $tags = Post_Tag::join('posts', 'posts.id', '=', 'post_tags.post_id')
                ->join('tags', 'tags.id', '=', 'post_tags.tag_id')
                ->where('post_tags.post_id', '=', $id)
                ->get('tags.name');
        $type = DB::select(DB::raw('SHOW COLUMNS FROM posts WHERE Field = "status"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }

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

        return view('pages.backend.post.edit', [
            'post'  => $post,
            'posttag' => $postTags,
            'tag' => $tags,
            'values' => $values,
            'verif_toko' => $verif_toko,
            'transactions_for_notif' => $transactions_for_notif,
            'buy_notif' => $buy_notif,
            'transaction_pending' => $transaction_pending,
            'transaction_to_all' => $transaction_to_all,
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
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'image' => 'required',
            'publishedAt' => 'required',
            'status' => 'required',
            'tags' => 'required',
        ]);

        $title = $request->input("title");
        $content = $request->input("content");
        $imageFile = $request->file('image');
        $image = $imageFile->getClientOriginalName();
        $imageFile->move(\base_path() . "/public/library/blog/", $image);
        $publishedAt = $request->publishedAt;
        $status = $request->status;
        $user = Auth::user();
        $user_id = $user->id;
        $slug = Str::slug($request->input("title"));
        $tags = explode(',', $request->input("tags"));

        $data = [
            'title' => $title,
            'content' => $content,
            'image' => $image,
            'publishedAt' => $publishedAt,
            'status' => $status,
            'user_id' => $user_id,
            'slug' => $slug,
        ];
        $data2 = [
            'tags' => $tags,
        ];
        // return $data;
        $post = Post::where('id', $id)->update($data);

        $tags = explode(',', $request->input("tags"));
        $cekposttag = array();
        foreach ($tags as $tag) {
            echo $tag." ";
            //cek apakah tag yang diinput sudah ada di dalam tabel tags pada database
            $itemTag = Tag::where('name', trim($tag))->first();
            //jika belum ada, maka buat tag baru diambil dari tag yang diinput di form
            if(!$itemTag) {
                $itemTag = Tag::create(['name' => trim($tag), 'slug' => Str::slug($tag)]);
                $create_post_tag = Post_Tag::create(['post_id' => $id, 'tag_id' => $itemTag->id]);
            }
            //jika sudah ada,
            else {
                $cekposttag = Post_Tag::where('tag_id', $itemTag->id)
                            ->where('post_id', $id)->first();
                //jika belum ada postId dgn id post = $id && tagId dgn id tag = $itemTag->id,
                //maka buat post_tag dgn postId = $id, dan tagId = $itemTag->id;
                if(!$cekposttag) {
                    $create_post_tag = Post_Tag::create(['post_id' => $id, 'tag_id' => $itemTag->id]);
                }
            }
            // $idtag[] = Post_Tag::join('tags', 'tags.id', '=', 'post_tags.tagId')
            // ->join('posts', 'posts.id', '=', 'post_tags.postId')
            // ->where('postId', $id)
            // ->where('tags.title', $tag)->get('post_tags.tagId');
        }

        $deleteposttag = Post_Tag::join('tags', 'tags.id', '=', 'post_tags.tag_id')
            ->join('posts', 'posts.id', '=', 'post_tags.post_id')
            ->where('post_id', $id)
            ->whereNotIn('tags.name', $tags)->delete();
        
        

        if($post) {
            return redirect()->route('post.index')->with('sukses', 'Data berhasil diupdate');
        }
        else {
            return redirect()->back()->with('gagal', 'Data tidak berhasil diupdate');
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
        $post = Post::find($id);
        $post_tags = Post_Tag::where(['post_id'=>$id]);
        if(\File::exists(public_path('library/blog/'.$post['image']))) {
            \File::delete(public_path('library/blog/'.$post['image']));
            $post = Post::find($id)->delete();
            $post_tags = Post_Tag::where(['post_id'=>$id])->delete();
            if($post && $post_tags) {
                return redirect()->route('post.index')->with('sukses', 'Data berhasil dihapus');
            }
            else{
                return redirect()->back()->with('gagal', 'Data tidak berhasil dihapus');
            }
        }

    }
}
