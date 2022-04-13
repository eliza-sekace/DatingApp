<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
}
