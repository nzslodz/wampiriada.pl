<?php namespace NZS\Core\Contracts;
use NZS\Core\Person;

interface FBProfileDownloaderSchema {
    public function getDownloader();
    public function getImagePath(Person $user);
}
