<?php

// based on http://stackoverflow.com/questions/7203160/php-gd-use-one-image-to-mask-another-image-including-transparency
// (changed to use alpha channel as mask, not red)
function imagealphamask(&$picture, $mask, $reverse=false) {
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

function crop_to_aspect($image, $aspect) {
    $width = imagesx($image);
    $height = imagesy($image);
    $new_width = $height * $aspect;
    $new_height = $width / $aspect;
    if ($new_width < $width) {
        return crop_centered($image, $new_width, $height);
    } else {
        return crop_centered($image, $width, $new_height);
    }
}

function crop_centered($image, $new_width, $new_height) {
    return imagecrop($image, array(
        'x' => floor((imagesx($image) - $new_width) / 2),
        'y' => floor((imagesy($image) - $new_height) / 2),
        'width' => $new_width,
        'height' => $new_height
    ));
}

class ImageGrid {
    public function __construct($backgroundImage, $overlayImage,
                                $gridWidth, $gridHeight) {
        $this->backgroundImage = $backgroundImage;
        $this->overlayImage = $overlayImage;
        // TODO assert or resize overlayImage
        $this->imageWidth = imagesx($backgroundImage);
        $this->imageHeight = imagesy($backgroundImage);

        $this->tilesImage = imagecreatetruecolor($this->imageWidth,
                                                 $this->imageHeight);
        imagealphablending($this->tilesImage, true);
        imagesavealpha($this->tilesImage, true);
        imagefill($this->tilesImage, 0, 0, 0x7fff0000);

        $this->gridWidth = $gridWidth;
        $this->gridHeight = $gridHeight;
        $this->cellWidth = round($this->imageWidth / $gridWidth);
        $this->cellHeight = round($this->imageWidth / $gridHeight);
        $this->cellAspect = $this->cellWidth / $this->cellHeight;
    }

    public function addTile($tileImage, $posX, $posY) {
        $tileImage = crop_to_aspect($tileImage, $this->cellAspect);
        imagecopyresampled($this->tilesImage, $tileImage,
                           $this->gridX($posX), $this->gridY($posY), // dst pos
                           0, 0, // src pos
                           $this->cellWidth, $this->cellHeight, // dst-size
                           imagesx($tileImage), imagesy($tileImage)); // src size
    }

    private function gridX($posX) {
        return $posX * $this->cellWidth;
    }
    private function gridY($posY) {
        return $posY * $this->cellHeight;
    }

    public function generate() {
        // prepare masked overlay
        imagealphamask($this->overlayImage,
                       $this->tilesImage,
                       true);

        // join background with avatars (grr)
        $source = $this->backgroundImage;
        $dest = $this->tilesImage;
        // $this->overlayBlending($dest, $source);
        $this->sweetBlending($dest, $source);
        imagelayereffect($dest, IMG_EFFECT_ALPHABLEND);
        imagecopy($dest, $this->overlayImage,
                  0, 0, 0, 0, $this->imageWidth, $this->imageHeight);
        $output = $dest;
        return $output;
    }
    /* Blend src into dst */
    private function sweetBlending($dst, $src) {
        $R = "red"; $G = "green"; $B = "blue";
        for($x = 0; $x < $this->imageWidth; $x++) {
            for($y = 0; $y < $this->imageHeight; $y++) {
                $bg = imagecolorsforindex($dst, imagecolorat($dst, $x, $y));
                $fg = imagecolorsforindex($src, imagecolorat($src, $x, $y));
                $bg[$R] = $bg[$R] * 0.5 + $fg[$R] * 0.5;
                $bg[$G] = $bg[$G] * 0.5 + $fg[$G] * 0.5;
                $bg[$B] = $bg[$B] * 0.5 + $fg[$B] * 0.5;
                imagesetpixel($dst, $x, $y,
                              imagecolorallocatealpha($dst, $bg['red'], $bg['green'], $bg['blue'], $bg['alpha']));
            }
        }
    }
    private function overlayBlending($dst, $src) {
        imagelayereffect($dst, IMG_EFFECT_OVERLAY);
        imagecopy($dst, $src,
                  0, 0, 0, 0, $this->imageWidth, $this->imageHeight);
    }

}

$grid = new ImageGrid(imagecreatefrompng("../pics/background.png"),
                      imagecreatefrompng("../pics/overlay.png"),
                      4, 4);

$avatars = array_map('imagecreatefrompng', [
                        "../pics/av1.png",
                        "../pics/av2.png",
                        "../pics/av3.png",
                        "../pics/av4.png",
                        "../pics/av5.png",
                    ]);

for ($i=0; $i < 12; ++$i) {
    $grid->addTile($avatars[rand() % count($avatars)],
                   rand() % $grid->gridWidth,
                   rand() % $grid->gridHeight);
}

$output = $grid->generate();

header("Content-type: image/png");
imagepng($output);
imagedestroy($output);

?>


