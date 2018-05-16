<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use NZS\Wampiriada\Editions\EditionRepository;
use NZS\Wampiriada\Mailing\WampiriadaReminderMailingComposer;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Reminders\Reminder;
use NZS\Core\Mailing\MailingRepository;
use NZS\Core\Contracts\MailingComposer;

use Carbon\Carbon;

use NZS\Wampiriada\ActionDay;


class DispatchReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wampiriada:dispatch-reminder-emails
        {--hours=0.5 : distribute recipients over time in hours (can be set to 0 to dispatch immediately)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatches reminder emails to Wampiriada users.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $actions = ActionDay::where('created_at', '<=', Carbon::now()->addDays(3))->get();

        foreach($actions as $action) {
            $composer = new WampiriadaReminderMailingComposer($action);

            $reminders = Reminder::whereSent(false)->whereActionDayId($action->id)->get();

            foreach($reminders as $reminder) {
                if($reminder->hasAnyCheckin()) {
                    continue;
                }

                $job = $composer->getJobInstance($reminder->user);

                $hours = (float) $this->option('hours');

                $delay = Carbon::now()->addSeconds(rand(0, $hours * 3600));

                $job->delay($delay);

                dispatch($job);

                // XXX here?
                $reminder->sent = true;
                $reminder->save();
            }
        }
    }
}
