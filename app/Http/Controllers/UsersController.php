<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    public function edit(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['string'],
            'email'=> ['string'],
            'password' => ['required',  'confirmed', Rules\Password::defaults()],
        ]);

        $id=auth()->id();
        auth()->user()->update(
            ['user_id' => $id,
                'name' => $attributes['name'],
                'email'=> $attributes['email'],
                'password'=>Hash::make($attributes['password'])
            ]);
        return redirect("profiles/$id");
    }
}
