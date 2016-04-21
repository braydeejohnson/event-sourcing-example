<?php

namespace App\Jobs;

use App\DomainEvent;
use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishEvent extends Job implements SelfHandling
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var DomainEvent
     */
    private $event;

    /**
     * Create a new job instance.
     *
     * @param $event
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
