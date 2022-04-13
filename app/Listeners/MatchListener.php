<?php

namespace App\Listeners;

use App\Mail\MatchMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class MatchListener
{

    public function __construct(User $user)
    {
       $this->user = $user;
    }

    public function handle($event)
    {
        Mail::to(auth()->user()->email)->send(new MatchMail($this->user));
        Mail::to($this->user->email)->send(new MatchMail(auth()->user()));
    }
}
