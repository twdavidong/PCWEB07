<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function create()
    {
        return view("post.create");
    }

    public function store(Request $request)
   {
       $data = request()->validate([
           'caption' => 'required',
           'postpic' => ['required', 'image'],
       ]);

       $user = Auth::user();
       $profile = new Post();
       $imagePath = request('postpic')->store('uploads', 'public');

       $profile->user_id = $user->id;
       $profile->caption = request('caption');
       $profile->image = $imagePath;
       $saved = $profile->save();

       if ($saved) {
           return redirect('/profile');
       }
   }

   public function show(Post $post)
   {
    $post = Post::where('id', $post->id)->first();
    $user = Auth::user();
    
    return view('post.show', [
        'post' => $post,
        'user' => $user
    ]);
}

}
