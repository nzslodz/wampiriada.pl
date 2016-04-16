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
                $alpha = 1 - $pixel['alpha'];
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
    $new_width = $height / $aspect;
    $new_height = $width * $aspect;
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
    // TODO tiling

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
        imagefill($this->tilesImage, 0, 0, 0x6fff0000);

        $this->gridWidth = $gridWidth;
        $this->gridHeight = $gridHeight;
        $this->cellWidth = $this->imageWidth / $gridWidth;
        $this->cellHeight = $this->imageWidth / $gridHeight;
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

    public function gridX($posX) {
        return $this->imageWidth * $posX / $this->gridWidth;
    }
    private function gridY($posY) {
        return $this->imageHeight * $posY / $this->gridHeight;
    }

    public function generate() {
        // join background with avatars
        // prepare masked overlay
        // cover background with overlay
        $output = $this->tilesImage;
        return $output;
    }
}

$grid = new ImageGrid(imagecreatefrompng("../pics/background.png"),
                      imagecreatefrompng("../pics/overlay.png"),
                      4, 4);

$avatars = array_map(imagecreatefrompng, [
                        "../pics/av1.png",
                        "../pics/av2.png",
                        "../pics/av3.png",
                        "../pics/av4.png",
                        "../pics/av5.png",
                    ]);

$grid->addTile($avatars[0],
               0, 0);
$grid->addTile($avatars[2],
               1, 2);

$output = $grid->generate();

header("Content-type: image/png");
imagepng($output);
imagedestroy($output);

?>


