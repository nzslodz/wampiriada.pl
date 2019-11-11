<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
    public function __construct($user){
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $this->downloadFacebookImage($this->user);
    }

    protected function downloadFacebookImage($user) {
        $ch = curl_init ("https://graph.facebook.com/$user->facebook_user_id/picture?redirect=false&type=large");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $rawdata=curl_exec($ch);
        curl_close ($ch);

        $storage = Storage::disk('local');

        $json = json_decode($rawdata);
        if($json->data->is_silhouette) {
            return;
        }

        $ch = curl_init ($json->data->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
        $rawdata=curl_exec($ch);
        curl_close ($ch);

        if(!$storage->has('fb-images')) {
            $storage->makeDirectory('fb-images');
        }

        $storage->put("fb-images/$user->facebook_user_id.jpg", $rawdata);
    }
}
