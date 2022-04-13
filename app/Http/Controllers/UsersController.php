<?php

namespace App\Http\Controllers;


use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    public function edit(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['string'],
            'email' => ['string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $id = auth()->id();
        auth()->user()->update(
            ['user_id' => $id,
                'name' => $attributes['name'],
                'email' => $attributes['email'],
                'password' => Hash::make($attributes['password'])
            ]);
        return redirect("profiles/$id");
    }

    public function getRandom()
    {
        $userRepository = new UsersRepository;
        $randomUser = $userRepository->getRandomUser();
        return view('Home/home', [
            'user' => auth()->user(),
            'randomUser' => $randomUser
        ]);
    }

}
