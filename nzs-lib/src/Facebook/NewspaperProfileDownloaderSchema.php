<?php namespace NZS\Core\Facebook;

use NZS\Core\Facebook\BaseProfileDownloaderSchema;

class NewspaperProfileDownloaderSchema extends BaseProfileDownloaderSchema {
    protected $allow_silhouette = true;
    protected $directory = 'newspaper-images';
    protected $size = [500, 500];
}
