<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

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
            'email' => 'required|string|max:255'
        ]);

        // Create a new user
        $user = new User;
        $user->name = $form['name'];
        $user->email = $form['email'];

        // Save the user
        $user->save();

        return response()->json($user);
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
        // Validate the request
        $form = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255'
        ]);

        // Find the user
        $user = User::findOrFail($id);

        // Update the user
        $user->name = $form['name'];
        $user->email = $form['email'];

        // Save the user
        $user->save();

        return response()->json($user);
    }



    public static function findUserByEmailOrCreate(string $email) : User
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = new User;
            $user->name = $email;
            $user->email = $email;
            $user->save();
        }

        return $user;
    }
}
