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
            'email' => 'required|string|max:255',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $website = Website::find($id);

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
            'email' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($form['email']);

        // If user is not the owner of the website, return error
        if ($user->id !== $website->user_id) {
            return response()->json(['message' => 'User is not the owner of this website.']);
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Validate the request
        $form = $request->validate([
            'id' => 'required|integer',
            'email' => 'required|string|max:255',
        ]);

        // Find the website
        $website = Website::find($form['id']);

        $user = User::findOrFail($form['email']);

        // If user is not the owner of the website, return error
        if ($user->id !== $website->user_id) {
            return response()->json(['message' => 'User is not the owner of this website.']);
        }

        // Delete the website
        $website->delete();

        return response()->json(['message' => 'Website has been deleted.']);
    }
}
