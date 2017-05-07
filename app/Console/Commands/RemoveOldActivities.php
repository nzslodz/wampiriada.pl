<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use NZS\Core\Activity;
use NZS\Core\ModelActivityClass;

class RemoveOldActivities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:remove-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old activities that have no related objects.';

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
        foreach(Activity::all() as $activity) {
            $activity_class = $activity->getActivityClass();

            if($activity_class instanceof ModelActivityClass) {
                $removed = $activity_class->removeIfStale($activity);

                if($removed) {
                    $this->info("Removed activity {$activity->id} of class {$activity->class_name}");
                }
            }
        }
    }
}
