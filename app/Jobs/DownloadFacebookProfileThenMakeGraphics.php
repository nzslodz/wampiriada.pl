<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Jobs\DownloadFacebookProfile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use NZS\Core\Person;
use Storage;

class DownloadFacebookProfileThenMakeGraphics extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Person $user){
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $job = new DownloadFacebookProfile($this->user);

        $job->handle();

        $job = new ThenMakeGraphics($this->user);

        $job->handle();
    }
}
