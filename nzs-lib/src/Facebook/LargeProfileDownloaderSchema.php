<?php namespace NZS\Core\Facebook;

use NZS\Core\Facebook\BaseProfileDownloaderSchema;

class LargeProfileDownloaderSchema extends BaseProfileDownloaderSchema {
    protected $allow_silhouette = false;
    protected $directory = 'fb-images';
    protected $size = 'large';
}
