<?php

class ImageGrid {
    public function __construct($options) {
        $this->backgroundImage = $options['background'];
        $this->overlayImage = $options['overlay'];
        $this->imageWidth = imagesx($this->backgroundImage);
        $this->imageHeight = imagesy($this->backgroundImage);
        $this->rescaleOverlay();
        $this->createTilesImage();

        $this->gridWidth = $options['gridWidth'];
        $this->gridHeight = $options['gridHeight'];
        $this->cellWidth = round($this->imageWidth / $this->gridWidth);
        $this->cellHeight = round($this->imageWidth / $this->gridHeight);
        $this->cellAspect = $this->cellWidth / $this->cellHeight;
        $this->createSequence($options['seed']);
    }
    private function rescaleOverlay() {
        if (imagesx($this->overlayImage) != $this->imageWidth ||
            imagesy($this->overlayImage) != $this->imageHeight) {
                $this->overlayImage = imagescale($this->overlayImage,
                                                 $this->imageWidth,
                                                 $this->imageHeight);
        }
    }
    private function createTilesImage() {
        $this->tilesImage = imagecreatetruecolor($this->imageWidth,
                                                 $this->imageHeight);
        imagealphablending($this->tilesImage, true);
        imagesavealpha($this->tilesImage, true);
        imagefill($this->tilesImage, 0, 0, 0x7fff0000);
    }
    private function createSequence($seed) {
        $edges = imagecrop($this->backgroundImage, array(
            'x' => 0, 'y' => 0,
            'width' => $this->imageWidth,
            'height' => $this->imageHeight));
        imagefilter($edges, IMG_FILTER_EDGEDETECT);

        $items = array();
        for($tx = 0; $tx < $this->gridWidth; $tx++) {
            for($ty = 0; $ty < $this->gridHeight; $ty++) {
                $tileValue = $this->getTileValue($edges, $tx, $ty);
                imagestring($edges, 1,
                            $this->gridX($tx), $this->gridY($ty),
                            $tileValue, 0x00ffffff);
                array_push($items, array("x" => $tx, "y" => $ty, "weight" => $tileValue));
            }
        }
        $this->sequence = new TileSequence($items, $seed);
    }

    public function addTiles($tiles) {
        foreach ($tiles as $tile) {
            $position = $this->sequence->next();
            $this->addTile($tile, $position);
        }
    }

    public function addTile($tileImage, $position) {
        $tileImage = crop_to_aspect($tileImage, $this->cellAspect);
        imagecopyresampled($this->tilesImage, $tileImage,
                           $this->gridX($position['x']), $this->gridY($position['y']), // dst pos
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
    private function getTileValue($img, $tx, $ty) {
        $sum = 0;
        for ($x=$this->gridX($tx); $x<$this->gridX($tx) + $this->cellWidth; ++$x) {
            if ($x >= imagesx($img)) continue;
            for ($y=$this->gridY($ty); $y<$this->gridY($ty) + $this->cellHeight; ++$y) {
                if ($y >= imagesy($img)) continue;
                $color = imagecolorsforindex($img, imagecolorat($img, $x, $y));
                $colorValue = abs($color['red']-127) + abs($color['green']-127) + abs($color['blue']-127);
                $sum += $colorValue;
            }
        }
        return $sum;
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

class TileSequence {
    public function __construct($tiles, $seed) {
        $this->tiles = $tiles;
        $this->shuffleTiles($seed);
    }
    private function shuffleTiles($seed) {
        $medianWeight = $this->getMedianWeight();
        foreach ($this->tiles as $key => $value) {
            $this->tiles[$key]['rare'] = ($value['weight'] > $medianWeight);
        }
        $nextSeed = rand();
        srand($seed); // Entering deterministic zone
        shuffle($this->tiles);
        $j = count($this->tiles) - 1;
        for ($i=0; $i<$j; ++$i) {
            if ($this->tiles[$i]['rare']) {
                $k = rand($i+1, $j);
                $tmp = $this->tiles[$i];
                $this->tiles[$i] = $this->tiles[$k];
                $this->tiles[$k] = $tmp;
                $j -= 1;
            }
        }
        srand($nextSeed); // Exiting deterministic zone
    }

    private function getMedianWeight() {
        usort($this->tiles, function($a, $b) {
            return $b['weight'] - $a['weight'];
        });
        return $this->tiles[floor(count($this->tiles)/2)]['weight'];
    }

    public function next() {
        return array_shift($this->tiles);
    }
}

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


?>
