<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MatchMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


    private User $match;

    public function __construct(User $match)
    {
        $this->match = $match;
    }

    public function build()
    {
        return $this->view('mails.match-mail', [
            'match' => $this->match
        ]);
    }
}
