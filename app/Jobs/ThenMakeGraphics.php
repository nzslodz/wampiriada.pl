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
            'profile' => storage_path($this->user->getFacebookProfileImagePath()),
            'name' => $this->user->getFullName(),
            'seed' => Option::get('wampiriada.image_seed', 123),
            'output' => '-',
            'text-file' => '-',
        );

        $python_path = base_path('image_grid/env/bin/python');
        $command_path = base_path('image_grid/create_image_newspaper.py');

        $builder = new ProcessBuilder([$python_path, $command_path]);

        foreach($options as $key => $value) {
            $builder->add("--$key=$value");
        }

        $process = $builder->getProcess();
        echo $process->getCommandLine();



        $process->setInput("ome long long text fad fsdf asdf asdf daf dsf asdg sg asgd asdg gd dg adsg asdg asdg agd asgd ag sdg sdg sgd asg sdg asdgsgd asdg sgd sgd sgd sdg asg asg dg sgd dg sgdsg\n");

        echo $process->run();

        $storageTempFilename = "newspaper-images/image_tmp_{$this->user->id}.jpg";
        $storageFilename = "newapaper-images/image_{$this->user->id}.jpg";

        $publicStorage = Storage::disk('public');
        $publicStorage->put($storageTempFilename, $process->getOutput());
        $publicStorage->delete($storageFilename);
        $publicStorage->move($storageTempFilename, $storageFilename);
    }
}
