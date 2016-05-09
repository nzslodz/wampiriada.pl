<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use NZS\Wampiriada\Option;
use NZS\Wampiriada\Checkin;
use NZS\Wampiriada\EditionRepository;

use Storage;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessBuilder;

class RegenerateTileImage extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {       
        $arguments = [];
        foreach(config('app.achievements') as $key => $value) {
            $path = storage_path('app/image-grid-images/'. $value['icon']);

            $arguments[] = "$key:$path";
        }

        $outputTempFilename = tempnam(sys_get_temp_dir(), 'output');

        $options = array(
            'background' => storage_path('app/image-grid-images/wampir-1610.jpg'),
            'overlay' => storage_path('app/image-grid-images/overlay.png'),
            'width' => 40,
            'height' => 25,
            'seed' => Option::get('wampiriada.image_seed', 123),
            'output' => '-',
        );


        $python_path = base_path('image_grid/env/bin/python');
        $command_path = base_path('image_grid/create_image_grid.py');

        $builder = new ProcessBuilder([$python_path, $command_path]);

        foreach($options as $key => $value) {
            $builder->add("--$key=$value");
        }

        foreach($arguments as $value) {
            $builder->add($value);
        }

        $process = $builder->getProcess();
        echo $process->getCommandLine();

        $editionNumber = Option::get('wampiriada.edition', 28);
        $repository = new EditionRepository($editionNumber);
        $editionId = $repository->getEdition()->id;
        $checkins = Checkin::whereEditionId($editionId)->with('user')->get();

        $images = $checkins->map(function($checkin) {
            return storage_path('app/'.$checkin->user->getFacebookProfileImagePath());
        });

        $process->setInput(join("\n", $images->toArray()));

        echo $process->run();

        $storageTempFilename = "ImageGrid_tmp.jpg";
        $storageFilename = "ImageGrid.jpg";

        $publicStorage = Storage::disk('public');
        $publicStorage->put($storageTempFilename, $process->getOutput());
        $publicStorage->delete($storageFilename);
        $publicStorage->move($storageTempFilename, $storageFilename);
    }
}