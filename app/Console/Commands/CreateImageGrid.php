<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use NZS\Wampiriada\ImageGrid\ImageGrid;
use Storage;


class CreateImageGrid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create_image_grid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or refresh the image with avatars';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $localStorage = Storage::disk('local');
        $publicStorage = Storage::disk('public');
        $props = array(
            'background' => imagecreatefromstring($localStorage->get('image-grid-images/wampir.jpg')),
            'overlay' => imagecreatefromstring($localStorage->get('image-grid-images/overlay.png')),
            'gridWidth' => 20,
            'gridHeight' => 15,
            'seed' => 123
        );
        $grid = new ImageGrid($props);

        $avatars = array_map(
            function($name) use ($localStorage) {
                return imagecreatefromstring($localStorage->get("$name"));
            }, $localStorage->files("default-images/"));
        $tiles = array_map(
            function($i) use($avatars) {
                return $avatars[array_rand($avatars)];
            },
            range(0, $props['gridWidth'] * $props['gridHeight'] * 0.7));
        $grid->addTiles($tiles);
        $outputImage = $grid->generate();

        $outputTempFilename = tempnam(sys_get_temp_dir(), 'output');
        imagepng($outputImage, $outputTempFilename);

        $storageTempFilename = "ImageGrid_tmp.png";
        $storageFilename = "ImageGrid.png";
        // upload to storage, then rename;
        // don't upload until it's uploaded
        $outputTempFile = fopen($outputTempFilename, "rb");
        $publicStorage->put($storageTempFilename, $outputTempFile);
        fclose($outputTempFile);
        $publicStorage->delete($storageFilename);
        $publicStorage->move($storageTempFilename, $storageFilename);
    }
}
