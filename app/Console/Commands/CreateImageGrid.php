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
        $props = array(
            'background' => imagecreatefromstring($localStorage->get('image-grid-images/wampir.jpg')),
            'overlay' => imagecreatefromstring($localStorage->get('image-grid-images/overlay.png')),
            'gridWidth' => 20,
            'gridHeight' => 15,
            'seed' => 123
        );
        $grid = new ImageGrid($props);
        $grid->addTiles($this->getTilesToDisplay());
        $outputImage = $grid->generate();
        $this->upload($outputImage);
    }

    private function getTilesToDisplay() {
        $localStorage = Storage::disk('local');
        $avatars = array_map(
            function($name) use ($localStorage) {
                return imagecreatefromstring($localStorage->get("$name"));
            }, $localStorage->files("default-images/"));

        $tiles = array_map(
            function($i) use($avatars) {
                return $avatars[array_rand($avatars)];
            },
            range(0, 20*15*0.7));
        return $tiles;
    }

    private function upload($outputImage) {
        // Save to local tempfile. No reasonable way to save to memory
        $outputTempFilename = tempnam(sys_get_temp_dir(), 'output');
        imagepng($outputImage, $outputTempFilename);

        // Upload to storage under a temp name
        // (Don't overwrite the current one too early)
        $publicStorage = Storage::disk('public');
        $storageTempFilename = "ImageGrid_tmp.png";
        $outputTempFile = fopen($outputTempFilename, "rb");
        $publicStorage->put($storageTempFilename, $outputTempFile);
        fclose($outputTempFile);

        // Overwrite the current image
        $storageFilename = "ImageGrid.png";
        $publicStorage->delete($storageFilename);
        $publicStorage->move($storageTempFilename, $storageFilename);

    }
}
