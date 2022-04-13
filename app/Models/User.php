<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Http\Middleware\TrustHosts;

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
        } else
            $photo = "/storage/" . array_reverse($photo)[0]->photo . ".jpg";
        return $photo;
    }

    public function getAgeAttribute()
    {
        $birthday = DB::select("select birthday from profiles where user_id=$this->id");
        return Carbon::parse($birthday[0]->birthday)->age;
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
        return $this->likes()->whereHas('likes', function (Builder $query) {
            $query->where('id', $this->id);
        })->get();
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
        $allLikes = [];
        $likes = Like::whereIn('user_id', [$this->id])->get('liked_user_id');
        foreach ($likes as $like) {
            $allLikes[] = $like['liked_user_id'];
        };

        $allDislikes = [];
        $dislikes = Dislike::whereIn('user_id', [$this->id])->get('liked_user_id');
        foreach ($dislikes as $dislike) {
            $allDislikes[] = $dislike['liked_user_id'];
        };

        $result = User::with('profile')
            ->inRandomOrder()
            ->whereNotIn('id', [$this->id])
            ->whereHas('profile', function (Builder $query) {
                $query
                    ->where('gender', $this->profile->interested_in)
                    ->whereIn('interested_in', [$this->profile->gender, "Everyone"])
                    ->whereBetween('birthday', [
                        date("Y-m-d", strtotime(date("Y-m-d") . " -{$this->profile->age_to} year")),
                        date("Y-m-d", strtotime(date("Y-m-d") . " -{$this->profile->age_from} year")),
                    ])
                ->where('age_from', '<=', $this->getAgeAttribute())
                ->where('age_to', '>=', $this->getAgeAttribute());
            })
            ->whereNotIn('id', $allLikes)
            ->whereNotIn('id', $allDislikes)
            ->first();

        if ($this->profile->interested_in == "Everyone") {
            $result = User::with('profile')
                ->whereHas('profile', function (Builder $query) {
                    $query
                        ->whereIn('interested_in', [$this->profile->gender, 'Everyone'])
                        ->where('age_from', '<=', $this->getAgeAttribute())
                        ->where('age_to', '>=', $this->getAgeAttribute())
                        ->whereBetween('birthday', [
                            date("Y-m-d", strtotime(date("Y-m-d") . " -{$this->profile->age_to} year")),
                            date("Y-m-d", strtotime(date("Y-m-d") . " -{$this->profile->age_from} year")),
                        ]);

                })
                ->whereNotIn('id', $allLikes)
                ->whereNotIn('id', $allDislikes)
                ->inRandomOrder()
                ->first();
        }

        if ($result== null ) {
            $result = User::with('profile')
                ->inRandomOrder()
                ->first();
        }
        return $result;
    }

}
