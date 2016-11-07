<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class DispatchWampiriadaMailing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wampiriada:dispatch-mailing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatches a mailing to Wampiriada users.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }

}
