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
            'tags' => 'required|string|max:255',
            'url' => 'required|url',
            'content' => 'required|string|max:150',
        ]);

        // Create a new post
        $post = new Post;
        $post->title = $form['title'];
        $post->tags = $form['tags'];
        $post->url = $form['url'];
        $post->content = $form['content'];

        // Assign the post to the website
        $post->website()->associate($website);

        // Save the post
        $post->save();

        return response()->json($post);
    }


    /**
     * Update post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Website $website, Post $post)
    {
        // Validate the request
        $form = $request->validate([
            'title' => 'string|max:255',
            'tags' => 'string|max:255',
            'url' => 'url',
            'content' => 'string|max:150',
        ]);

        // Update the post
        $post->title = $form['title'] ?? $post->title;
        $post->tags = $form['tags'] ?? $post->tags;
        $post->url = $form['url'] ?? $post->url;
        $post->content = $form['content'] ?? $post->content;

        // Save the post
        $post->save();

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Models\Website $website
     * @param  \Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website, Post $post)
    {
        return response()->json($post);
    }


    /**
     * Destroy the specified resource.
     *
     * @param  \Models\Website $website
     * @param  \Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Website $website, Post $post)
    {
        $post->delete();

        return response()->json($post);
    }
}
