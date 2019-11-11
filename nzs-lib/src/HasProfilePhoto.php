<?php namespace NZS\Core;

use Storage;

trait HasProfilePhoto {
    public function getFacebookProfileImagePath() {
        if($this->facebook_user_id && Storage::has("fb-images/$this->facebook_user_id.jpg")) {
            return "fb-images/$this->facebook_user_id.jpg";
        }

        $image_id = crc32($this->facebook_user_id . $this->email) % 32;

        return "default-images/$image_id.png";
    }
}
