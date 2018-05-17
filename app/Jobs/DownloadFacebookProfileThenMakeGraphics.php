<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Jobs\DownloadFacebookProfile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use NZS\Core\Contracts\FBProfileDownloaderSchema;
use NZS\Core\Facebook\NewspaperProfileDownloaderSchema;
use Storage;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use NZS\Core\PersonNewspaper;

class DownloadFacebookProfileThenMakeGraphics extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user){
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NewspaperProfileDownloaderSchema $schema) {
        $result = $schema->getDownloader()->downloadProfilePicture($this->user);

        if(!$result) {
            return;
        }

        $options = array(
            'background' => storage_path('app/nn-images/graphics.jpg'),
            'profile' => storage_path('app/' . $this->user->getFacebookProfileImagePath($schema)),
            'name' => $this->user->getFullName(),
            'output' => '-',
            'text-file' => '-',
        );

        $python_path = base_path('image_grid/env/bin/python');
        $command_path = base_path('image_grid/create_image_newspaper.py');

        $command = [$python_path, $command_path];

        foreach($options as $key => $value) {
            $command[] = "--$key=$value";
        }

        $process = new Process($command, base_path('image_grid'));
        echo $process->getCommandLine();

        $newspaper = PersonNewspaper::findOrNew($this->user->id);
        $filename = $newspaper->generateFilename();
        $newspaper->id = $this->user->id;
        $newspaper->save();

        $process->setInput("On robi to dobrze\nZapytany, czy będzie chciał kontynuować swoje działane, odpowiedział, że chętnie.");

        echo $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

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
