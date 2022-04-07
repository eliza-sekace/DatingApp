<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;


class ProfilesController extends Controller
{
    public function show(User $user, Profile $profile)
    {
        return view('Profile/profile', compact('user'), compact('profile'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'description' => ['required', 'string'],
            'birthday'=>['required','date'],
            'gender'=>['required'],
            'interested_in'=>['required'],
            'location'=>['required'],
        ]);

        auth()->user()->profile()->updateOrCreate(['user_id' => auth()->id()], $attributes);
        $id=auth()->id();

        return redirect("profiles/$id");
    }
}
