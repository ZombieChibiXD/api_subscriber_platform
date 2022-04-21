<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
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
            'email' => 'required|email|max:255',
        ]);

        $user = UserController::findUserByEmailOrCreate($form['email']);
        // Create a new subscription
        $subscription = new Subscription;

        // Assign the subscription to the user
        $subscription->user()->associate($user);

        // Assign the subscription to the website
        $subscription->website()->associate($website);

        // Save the subscription
        $subscription->save();

        return response()->json($subscription);
    }
    /**
     * Display if the user is subscribed to the website.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Website $website)
    {
        // Validate the request
        $form = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $form['email'])->first();

        $subscription = Subscription::where('user_id', $user->id)
            ->where('website_id', $website->id)
            ->first();

        if ($subscription) {
            $subscription->load('user', 'website');
            return response()->json($subscription);
        } else {
            return response()->json(['message' => 'User is not subscribed to this website.'], 404);
        }
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
        $form = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $form['email'])->first();

        $subscription = Subscription::where('user_id', $user->id)
        ->where('website_id', $website->id)
        ->first();

        if ($subscription) {
            $subscription->delete();
            return response()->json(['message' => 'User have stopped subscribing to this website.']);
        } else {
            return response()->json(['message' => 'User is not subscribed to this website.']);
        }
    }

    /**
     * Index route. Used to get list of subscribers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Models\Website $website
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Website $website)
    {
        $form = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $form['email'])->first();

        if ($user->id == $website->user_id) {
            $subscriptions = $website->subscribers()->get();
            return response()->json($subscriptions);
        }
        return response()->json(['message' => 'User is not the owner of this website.']);
    }
}
