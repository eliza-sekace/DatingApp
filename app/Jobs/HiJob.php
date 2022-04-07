<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HiJob
{
    use Dispatchable, SerializesModels;

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function handle()
    {
     var_dump("Job dispatched. Name= ".$this->name );

    }
}
