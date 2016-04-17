<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use NZS\Wampiriada\ImageGrid\ImageGrid;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\EditionRepository;
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
            'gridWidth' => 40, // XXX to be configured
            'gridHeight' => 25, // XXX to be configured
            'seed' => 123
        );
        $grid = new ImageGrid($props);
        $grid->addTiles($this->getTilesToDisplay());
        $outputImage = $grid->generate();
        $this->upload($outputImage);
    }

    private function getRandomTilesToDisplay($count) {
        $localStorage = Storage::disk('local');
        $avatars = array_map(
            function($name) use ($localStorage) {
                return imagecreatefromstring($localStorage->get("$name"));
            }, $localStorage->files("default-images/"));

        $tiles = array_map(function($i) use($avatars) {
            return $avatars[array_rand($avatars)];
        }, range(0, $count));
        return $tiles;
    }

    private function getTilesToDisplay() {
        $localStorage = Storage::disk('local');
        $editionNumber = Option::get('wampiriada.edition', 28);
        $repository = new EditionRepository($editionNumber);
        $editionId = $repository->getEdition()->id;
        $checkins = Checkin::whereEditionId($editionId)->with('user')->get();
        $images = $checkins->map(function($checkin, $key) use($localStorage) {
            $path = $checkin->user->getFacebookProfileImagePath();
            return imagecreatefromstring($localStorage->get($path));
        });
        return $images->toArray();
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
