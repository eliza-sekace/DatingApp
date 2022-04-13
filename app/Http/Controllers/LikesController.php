<?php

namespace App\Http\Controllers;

use App\Events\MatchEvent;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class LikesController extends Controller
{
    protected $fillable = [
        'user_id',
        'liked_user_id',
        'created_at'
    ];

    public function like(User $user)
    {
        auth()->user()->likes()->attach($user);
        if ($user->likes()->where('id', auth()->id())->exists()) {
            MatchEvent::dispatch($user);
        }
        return Redirect::home();
    }

    public function dislike(User $user)
    {
        auth()->user()->dislikes()->attach($user);
        return Redirect::home();
    }
}
