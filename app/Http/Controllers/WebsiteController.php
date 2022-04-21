<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $websites = Website::all();

        return response()->json($websites);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $form = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Create a new website
        $website = new Website;
        $website->name = $form['name'];
        $website->url = $form['url'];
        $website->description = $form['description'];
        $website->category = $form['category'];

        // Find the user
        $user = UserController::findUserByEmailOrCreate($form['email']);

        // Assign the user to the website
        $website->user_id = $user->id;

        // Save the website
        $website->save();

        return response()->json($website);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        return response()->json($website);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Website $website)
    {
        // Validate the request
        $form = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'email' => 'required|email|max:255|exists:users,email',
        ]);

        $user = User::where('email', $form['email'])->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // If user is not the owner of the website, return error
        if ($user->id !== $website->user_id) {
            return response()->json(['message' => 'User is not the owner of this website.'], 403);
        }


        // Update the website
        $website->name = $form['name'];
        $website->url = $form['url'];
        $website->description = $form['description'];
        $website->category = $form['category'];

        // Save the website
        $website->save();

        return response()->json($website);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Website $website)
    {
        // Validate the request
        // Email must belong to a user
        $form = $request->validate([
            'email' => 'required|email|max:255|exists:users,email',
        ]);

        // Find the user
        $user = User::where('email', $form['email'])->first();

        // If user is not the owner of the website, return error
        if ($user->id !== $website->user_id) {
            return response()->json(['message' => 'User is not the owner of this website.']);
        }

        // Delete the website
        $website->delete();

        return response()->json(['message' => 'Website has been deleted.']);
    }


    /**
     * Create route. Not allowed for public
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(['message' => 'Not allowed'], 403);
    }

    /**
     * Edit route. Not allowed for public
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return response()->json(['message' => 'Not allowed'], 403);
    }

}
