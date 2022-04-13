<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Http\Middleware\TrustHosts;
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

    public function getPhotoAttribute(): string
    {
        $photo = Photo::where('user_id', $this->id)->get();
        if ($photo == null) {
            $photo = "https://i.pravatar.cc/500?u=" . $this->email;
        } else
            $photo = "/storage/" . ($photo->pluck('photo')->reverse())[0] . ".jpg";
        return $photo;
    }

    public function getAgeAttribute(): string
    {
        $birthday = Profile::whereIn('user_id', [$this->id])->get('birthday');
        return Carbon::parse($birthday->pluck('birthday')[0])->age;
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
                ->whereNotIn('id', [$this->id])
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
        if ($result == null) {
            $result = User::with('profile')
                ->whereNotIn('id', [$this->id])
                ->inRandomOrder()
                ->first();
        }
        return $result;
    }
}
