<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

//use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute()
    {
        return "https://i.pravatar.cc/40?u=" . $this->email;
    }

    public function getProfilePictureAttribute($value)
    {
        $userId = auth()->id();
        $photo = DB::select("select photo from photos where user_id = $userId");
        if ($photo == null) {
            return "https://i.pravatar.cc/500?u=" . $this->email;
        } else return $photo;
        //return asset($value);
        //return "https://i.pravatar.cc/500?u=" . $this->email;
    }

    public function getRandomUserPictures($randomUserId)
    {
        $photo = DB::select("select photo from photos where user_id = $randomUserId");
        if ($photo == null) {
            $photo = "https://i.pravatar.cc/500?u=" . $this->email;
        } else $photo = "/storage/" . $photo[0]->photo.".jpg";
        return $photo;

    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'user_id', 'liked_user_id');
    }

    public function dislikes()
    {
        return $this->belongsToMany(User::class, 'dislikes', 'user_id', 'liked_user_id');
    }

    public function matches()
    {
        $sql = "select * from likes where user_id = {$this->id} and liked_user_id in (select user_id from likes where liked_user_id = {$this->id})";
        $matches = DB::select($sql);
        return User::whereIn('id', collect($matches)->pluck('liked_user_id'))->get();


//        return $this->likes()->whereHas('likes', function (Builder $query) {
//            $query->where('id', $this->id);
//        })->get();

    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function getRandom()
    {
        $result=User::with('profile')
            ->inRandomOrder()
            ->whereNotIn('id', [$this->id])
            // Add contraint on profile
            ->whereHas('profile', function (Builder $query) {
                $query
                    ->where('gender', $this->profile->interested_in)
                    ->where('interested_in', $this->profile->gender);
            })
            //->where not in likes table
//            ->where not in dislikes table
            ->first();


        if($result == null){
            $result = User::with('profile')
                ->inRandomOrder()
                ->first();
        }

        return $result;
    }
}
