<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }

    public function index(){

        $posts = Post::latest()->with(['user','likes'])->paginate(5);//eager loading
        return view('posts.index',[
            'posts'=>$posts
        ]);
    }

    public function store(Request $request){
        
        //validate the form
        $this->validate($request, [
            'body' => 'required',

        ]);

        $request->user()->posts()->create($request->only('body'));

        return back();
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }
}