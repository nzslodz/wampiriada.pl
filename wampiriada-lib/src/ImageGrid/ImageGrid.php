<?php namespace NZS\Wampiriada\ImageGrid;

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
        $this->cellHeight = round($this->imageHeight / $this->gridHeight);
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

        /* compute weights for each tile */
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
        $tileImage = ImageHelpers::crop_to_aspect($tileImage, $this->cellAspect);
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
        ImageHelpers::imagealphamask($this->overlayImage,
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
