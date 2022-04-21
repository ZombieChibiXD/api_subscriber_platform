<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Website;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of posts from a website.
     *
     * @param \Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function index(Website $website)
    {
        // Show 10 posts per page
        $posts = $website->posts()->paginate(10);

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Website $website)
    {
        // Validate the request
        $form = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
        ]);

        // Create a new post
        $post = new Post;
        $post->title = $form['title'];
        $post->body = $form['body'];

        // Assign the post to the website
        $post->website()->associate($website);

        // Save the post
        $post->save();

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json($post);
    }
}
