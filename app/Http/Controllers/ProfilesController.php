<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
            'birthday' => ['required', 'date', 'before:-18 years'],
            'gender' => ['required'],
            'interested_in' => ['required'],
            'location' => ['required'],
            'age_from' => ['required', 'int'],
            'age_to' => ['required', 'int'],
            'photo' => ['mimes:png,jpg, jpeg, max:102400']
        ]);

        $id = auth()->id();
        $addedPhoto = $request->file('photo');
        $filename = Str::random(32);

        if (!empty($addedPhoto)) {
            Image::make($addedPhoto)
                ->fit(400, 400)
                ->save(storage_path() . "/app/public/pictures/{$filename}.jpg", 90, "jpg");

            Photo::create([
                'user_id' => $id,
                'photo' => "pictures/" . $filename
            ]);
        }
        auth()->user()->profile()->updateOrCreate(['user_id' => auth()->id()], $attributes);
        return redirect("profiles/$id");
    }

}
