<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use NZS\Core\Person;
use NZS\Core\Facebook\LargeProfileDownloaderSchema;
use Storage;

class DownloadFacebookProfile extends Job implements ShouldQueue
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
    public function handle(LargeProfileDownloaderSchema $schema) {
        $schema->getDownloader()->downloadProfilePicture($this->user);
    }
}
