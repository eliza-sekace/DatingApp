<?php

namespace App\Listeners;

use App\Events\MatchEvent;
use App\Mail\MatchMail;
use Illuminate\Support\Facades\Mail;

class MatchListener
{

    public function handle(MatchEvent $event)
    {
        Mail::to(auth()->user()->email)->send(new MatchMail($event->getMatch()));
        Mail::to($event->getMatch()->email)->send(new MatchMail(auth()->user()));
    }
}
