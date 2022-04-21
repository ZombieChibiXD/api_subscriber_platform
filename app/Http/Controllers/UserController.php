<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Index route. Used to get user by email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Validate the request
        $form = $request->validate([
            'email' => 'required|string|max:255',
        ]);

        // Find the user using the email
        $user = User::where('email', $form['email'])->first();

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Show User
     * @param  \Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255'
        ]);

        // Create a new user
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;

        // Save the user
        $user->save();

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Validate the request
        $form = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255'
        ]);

        // Update the user
        $user->name = $form['name'];
        $user->email = $form['email'];

        // Save the user
        $user->save();

        return response()->json($user);
    }


    /**
     * Delete User
     * @param  \Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted', 'user' => $user]);
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
