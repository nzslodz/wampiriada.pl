<?php namespace NZS\Core\Facebook;
use NZS\Core\Facebook\ProfileDownloader;
use NZS\Core\Contracts\FBProfileDownloaderSchema;
use Storage;

abstract class BaseProfileDownloaderSchema implements FBProfileDownloaderSchema {
    protected $allow_silhouette;
    protected $directory;
    protected $size;

    public function __construct() {
        $this->directory = array_wrap($this->directory);
        $this->size = array_wrap($this->size);
    }

    public function getDownloader() {
        $downloader = new ProfileDownloader;

        if($this->allow_silhouette) {
            $downloader->allowSilhouette();
        }

        if(!empty($this->directory)) {
            $downloader->setDirectory($this->directory[0]);
        }

        if(!empty($this->size)) {
            $downloader->setSize(...$this->size);
        }

        return $downloader;
    }

    public function getImagePath($user) {
        if(!$user->facebook_user_id) {
            return null;
        }

        foreach($this->directory as $directory) {
            if(Storage::has("$directory/$user->facebook_user_id.jpg")) {
                return "$directory/$user->facebook_user_id.jpg";
            }
        }

        return null;
    }
}
