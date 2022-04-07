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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute()
    {
        return "https://i.pravatar.cc/40?u=" . $this->email;
    }

    public function getProfilePictureAttribute()
    {
        return "https://i.pravatar.cc/500?u=" . $this->email;
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'user_id', 'liked_user_id');
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

    public function getRandom()
    {
        return User::with('profile')
            ->inRandomOrder()
            ->whereNotIn('id', [$this->id])
            // Add contraint on profile
            ->whereHas('profile', function (Builder $query) {
                $query
                    ->where('gender', $this->profile->interested_in)
                    ->where('interested_in', $this->profile->gender);
            })
//            ->whereDoesntHave('dislikes')
            ->first();
    }
}
