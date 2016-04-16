<?php

function errHandle($errNo, $errStr, $errFile, $errLine) {
    $msg = "$errStr in $errFile on line $errLine";
    if ($errNo == E_NOTICE || $errNo == E_WARNING) {
        throw new ErrorException($msg, $errNo);
    } else {
        echo $msg;
    }
}
set_error_handler('errHandle');

require('grid.php');

$props = array(
    'background' => imagecreatefromjpeg("../pics/wampir.jpg"),
    'overlay' => imagecreatefrompng("../pics/overlay.png"),
    'gridWidth' => 20,
    'gridHeight' => 15,
    'seed' => 123
);
$grid = new ImageGrid($props);

$avatars = array_map('imagecreatefrompng', [
                        "../pics/av1.png",
                        "../pics/av2.png",
                        "../pics/av3.png",
                        "../pics/av4.png",
                        "../pics/av5.png",
                    ]);
$tiles = array_map(
    function($i) {
        global $avatars;
        return $avatars[array_rand($avatars)];
    },
    range(0, $props['gridWidth'] * $props['gridHeight'] * 0.7));
$grid->addTiles($tiles);
$output = $grid->generate();

header("Content-type: image/png");
imagepng($output);
imagedestroy($output);
