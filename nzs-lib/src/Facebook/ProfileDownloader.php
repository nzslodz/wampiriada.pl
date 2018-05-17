<?php namespace NZS\Core\Facebook;

use Storage;

use Purl\Url;

class ProfileDownloader {
    protected $allow_silhouette = false;
    protected $directory = 'fb-images';
    protected $query_params = ['type' => 'large'];

    public function allowSilhouette() {
        $this->allow_silhouette = true;
    }

    public function setDirectory($directory) {
        $this->directory = $directory;
    }

    public function setSize($type_or_w, $h=null) {
        if(is_numeric($type_or_w) && $h !== null) {
            $this->query_params['width'] = $type_or_w;
            $this->query_params['height'] = $h;
            unset($this->query_params['type']);
        } else {
            $this->query_params['type'] = $type_or_w;
            unset($this->query_params['width']);
            unset($this->query_params['height']);
        }
    }

    public function downloadProfilePicture($user) {
        if(!$user->facebook_user_id) {
            return false;
        }

        $url = new Url("https://graph.facebook.com/$user->facebook_user_id/picture?redirect=false");

        foreach($this->query_params as $key => $value) {
            $url->query->set($key, $value);
        }

        $ch = curl_init($url->getUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $rawdata=curl_exec($ch);
        curl_close($ch);

        $json = json_decode($rawdata);
        if($json->data->is_silhouette && !$this->allow_silhouette) {
            return false;
        }

        $ch = curl_init($json->data->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $rawdata=curl_exec($ch);
        curl_close($ch);

        $storage = Storage::disk('local');

        if(!$storage->has($this->directory)) {
            $storage->makeDirectory($this->directory);
        }

        $storage->put("$this->directory/$user->facebook_user_id.jpg", $rawdata);

        return true;
    }
}
