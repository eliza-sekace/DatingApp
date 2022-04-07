<?php

namespace App\Http\Controllers;

use App\Jobs\HelloJob;
use App\Jobs\HiJob;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function sendHi(Request $request)
    {
        $this->dispatch(new HiJob('Joe'));
   }

    public function sendHello(Request $request)
    {
        $this->dispatch(new HelloJob);
    }
}
