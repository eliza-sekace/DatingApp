<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class LikesController extends Controller
{
    //attach detach sink
    protected $fillable=[
        'user_id',
        'liked_user_id',
        'created_at'
    ];

    public function like(User $user)
    {
        auth()->user()->likes()->attach($user);
        return Redirect::home();
    }

    public function dislike(User $user)
    {
        auth()->user()->dislikes()->attach($user);
        return Redirect::home();
    }
}
