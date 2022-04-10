<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;


class ProfilesController extends Controller
{
    public function show(User $user, Profile $profile)
    {
        $user->load(['profile', 'photos']);
        $photos = $user->photos()->paginate(1);
        return view('Profile/profile', compact('user'), compact('photos'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'description' => ['required', 'string'],
            'birthday' => ['required', 'date'],
            'gender' => ['required'],
            'interested_in' => ['required'],
            'location' => ['required'],
            'photo' => ['mimes:png,jpg, jpeg, max:102400']
        ]);
        $id = auth()->id();


        $addedPhoto = $request->file('photo');
        $filename = Str::random(32);
        if (!empty($addedPhoto)){
            Image::make($addedPhoto)
                ->resize(400, 400, function ($const) {
                    $const->aspectRatio();
                })
                ->save(storage_path() . "/app/public/pictures/{$filename}.jpg", 90, "jpg");

            DB::table('photos')->insert([
                'user_id' => $id,
                'photo' => "pictures/" . $filename
            ]);
        }

        auth()->user()->profile()->updateOrCreate(['user_id' => auth()->id()], $attributes);
        return redirect("profiles/$id");
    }
}
