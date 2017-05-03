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
use NZS\Core\PersonNewspaper;
use NZS\Core\Person;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessBuilder;

class ThenMakeGraphics extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Person $user){
        $this->user = $user;
    }

    /**
     * Execute the job.Options:
     *
     * @return void
     */
    public function handle() {
        $options = array(
            'background' => storage_path('app/nn-images/graphics.jpg'),
            'profile' => storage_path('app/' . $this->user->getFacebookProfileImagePath()),
            'name' => $this->user->getFullName(),
            'output' => '-',
            'text-file' => '-',
        );

        $python_path = base_path('image_grid/env/bin/python');
        $command_path = base_path('image_grid/create_image_newspaper.py');

        $builder = new ProcessBuilder([$python_path, $command_path]);

        foreach($options as $key => $value) {
            $builder->add("--$key=$value");
        }

        $buider->setWorkingDirectory(base_path('image_grid'));

        $process = $builder->getProcess();
        echo $process->getCommandLine();

        $newspaper = PersonNewspaper::findOrNew($this->user->id);
        $filename = $newspaper->generateFilename();
        $newspaper->id = $this->user->id;
        $newspaper->save();

        $process->setInput("ome long long text fad fsdf asdf asdf daf dsf asdg sg asgd asdg gd dg adsg asdg asdg agd asgd ag sdg sdg sgd asg sdg asdgsgd asdg sgd sgd sgd sdg asg asg dg sgd dg sgdsg\n");

        echo $process->run();

        $storageTempFilename = "newspaper-images/image_tmp_{$this->user->id}.jpg";
        $storageFilename = "newspaper-images/image_$filename.jpg";

        $publicStorage = Storage::disk('public');

        if(!$publicStorage->has('newspaper-images')) {
            $publicStorage->makeDirectory('newspaper-images');
        }

        $publicStorage->put($storageTempFilename, $process->getOutput());
        $publicStorage->delete($storageFilename);
        $publicStorage->move($storageTempFilename, $storageFilename);
    }
}
