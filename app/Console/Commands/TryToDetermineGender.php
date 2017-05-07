<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\RegenerateTileImage as RegenerateTileImageJob;
use NZS\Core\Person;

class TryToDetermineGender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:determine-gender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Determine gender for all people that have null genders';

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
      foreach(Person::all() as $person) {
          if($person->updateGender()) {
              $this->info("{$person->getFullName()}: gender determined as $person->gender with probability $person->gender_probability");
              $person->save();
          }
      }
    }
}
