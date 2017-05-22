<?php namespace NZS\Core\Facebook;

use NZS\Core\Facebook\BaseProfileDownloaderSchema;
use NZS\Core\Person;

class LargeProfileDownloaderSchema extends BaseProfileDownloaderSchema {
    protected $allow_silhouette = false;
    protected $directory = 'fb-images';
    protected $size = 'large';
}
