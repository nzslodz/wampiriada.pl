<?php namespace NZS\Wampiriada\ImageGrid;

class ImageHelpers {

    // based on http://stackoverflow.com/questions/7203160/php-gd-use-one-image-to-mask-another-image-including-transparency
    // (changed to use alpha channel as mask, not red)
    public static function imagealphamask(&$picture, $mask, $reverse=false) {
        // Get sizes and set up new picture
        $xSize = imagesx($picture);
        $ySize = imagesy($picture);
        $newPicture = imagecreatetruecolor($xSize, $ySize);
        imagesavealpha($newPicture, true);
        imagefill($newPicture, 0, 0, imagecolorallocatealpha($newPicture, 0, 0, 0, 127));

        // Resize mask if necessary
        if($xSize != imagesx($mask) || $ySize != imagesy($mask)) {
            $tempPic = imagecreatetruecolor($xSize, $ySize);
            imagecopyresampled($tempPic, $mask, 0, 0, 0, 0, $xSize, $ySize, imagesx($mask), imagesy($mask));
            imagedestroy($mask);
            $mask = $tempPic;
        }

        // Perform pixel-based alpha map application
        for($x = 0; $x < $xSize; $x++) {
            for($y = 0; $y < $ySize; $y++) {
                $pixel = imagecolorsforindex($mask, imagecolorat($mask, $x, $y));
                if ($reverse) {
                    $alpha = 127 - $pixel['alpha'];
                } else {
                    $alpha = $pixel['alpha'];
                }
                $color = imagecolorsforindex($picture, imagecolorat($picture, $x, $y));
                imagesetpixel($newPicture, $x, $y, imagecolorallocatealpha($newPicture, $color['red'], $color['green'], $color['blue'], $alpha));
            }
        }

        // Copy back to original picture
        imagedestroy($picture);
        $picture = $newPicture;
    }

    public static function crop_to_aspect($image, $aspect) {
        $width = imagesx($image);
        $height = imagesy($image);
        $new_width = $height * $aspect;
        $new_height = $width / $aspect;
        if ($new_width < $width) {
            return ImageHelpers::crop_centered($image, $new_width, $height);
        } else {
            return ImageHelpers::crop_centered($image, $width, $new_height);
        }
    }

    public static function crop_centered($image, $new_width, $new_height) {
        return imagecrop($image, array(
            'x' => floor((imagesx($image) - $new_width) / 2),
            'y' => floor((imagesy($image) - $new_height) / 2),
            'width' => $new_width,
            'height' => $new_height
        ));
    }

    public static function remove_transparency($image) {
        $width = imagesx($image);
        $height = imagesy($image);
        $bg = imagecreatetruecolor($width, $height);
        $black = imagecolorallocate($bg, 0, 0, 0);
        imagefill($bg, 0, 0, $black);
        imagecopyresampled(
            $bg, $image,
            0, 0, 0, 0,
            $width, $height,
            $width, $height);
        return $bg;
    }
}
