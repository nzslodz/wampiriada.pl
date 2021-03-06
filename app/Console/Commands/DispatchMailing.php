<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use NZS\Wampiriada\Editions\EditionRepository;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Donor;
use NZS\Core\Mailing\MailingRepository;
use NZS\Core\Contracts\MailingComposer;

use Carbon\Carbon;

class DispatchMailing extends Command
{

    protected $mailing_repository;

    public function __construct(MailingRepository $mailing_repository) {
        parent::__construct();

        $this->mailing_repository = $mailing_repository;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nzs:dispatch-mailing
        {--all : dispatch e-mails to all checked in people in the past}
        {--production : dispatch e-mails instead of just printing recipients}
        {--edition= : dispatch mailing with specific edition, by default use current edition}
        {--hours=24 : distribute recipients over time in hours (can be set to 0 to dispatch immediately)}
        {mailing? : Mailing Class to be used}
        {user?* : specify users manually}';

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
        if($this->argument('mailing') === null) {
            $this->printMailingClasses();

            return 1;
        }

        $number = $this->option('edition');
        if($number === null) {
            $number = Option::get('wampiriada.edition', 28);
        }

        $repository = EditionRepository::fromNumber($number);

        $mailing = $this->resolveMailing($this->argument('mailing'));

        if(!$mailing) {
            $this->error(sprintf('Error: Mailing class %s not found.', $this->argument('mailing')));

            return 1;
        }

        $this->comment(sprintf('Chosen mailing class: %s', get_class($mailing)));

        if($this->option('all')) {
            $users = $this->constructRecipientListFromAllCheckins();
        } elseif($array = $this->argument('user')) {
            // XXX: this wont work because of SerializesModels trait on Job that requires functional user in database
            $users = $this->constructRecipientListFromArray($array);
        } else {
            $users = $this->constructRecipientListFromRepository($repository);
        }

        if($this->option('production')) {
            $this->dispatchEmails($mailing, $users, (int) $this->option('hours'));
        } else {
            $this->printRecipientList($users);
        }
    }

    protected function printMailingClasses() {
        $this->comment('Available classes:');
        foreach ($this->mailing_repository->filterClassesByInterface(MailingComposer::class) as $key => $class) {
            $this->info(sprintf('{%d}: %s', $key, $class));
        }

        $this->comment('You can also use index instead of the class to choose mailing class.');
    }

    protected function resolveMailing($index_or_class_name) {
        if(is_numeric($index_or_class_name)) {
            $class_name = $this->mailing_repository->filterClassesByInterface(MailingComposer::class)->get((int) $index_or_class_name);
        } else {
            $class_name = $this->mailing_repository->getClassOfInterface($index_or_class_name, MailingComposer::class);
        }

        if(!$class_name) {
            return null;
        }

        return new $class_name;
    }

    protected function constructRecipientListFromArray($users) {
        return collect($users)->transform(function($user_email) {
            $user = Donor::whereEmail($user_email)->first();

            if($user === null) {
                $this->warn(sprintf("User with e-mail %s not found in database", $user_email));
            }

            return $user;
        })->filter(function($object) {
            return $object !== null;
        });
    }

    protected function constructRecipientListFromAllCheckins() {
        return Checkin::with('user')->get()->transform(function($checkin) {
            return $checkin->user;
        })->unique('id');
    }

    protected function constructRecipientListFromRepository($repository) {
        return $repository->getEdition()->checkins->transform(function($checkin) {
            return $checkin->user;
        });
    }

    protected function printRecipientList($users) {
        $this->comment('This mailing will be sent to the following users:');

        foreach($users as $index => $user) {
            $this->info(sprintf('{%d}: %s <%s>', $index, $user->getFullName(), $user->email));
        }
    }

    protected function dispatchEmails(MailingComposer $composer, $users, $hours) {
        $this->comment('This mailing has been dispatched to the following users:');
        foreach($users as $index => $user) {
            if(!trim($user->email)) {
                $this->warn(sprintf('{%d}: %s (%d) omitted - no email address', $index, $user->getFullName(), $user->id));
                continue;
            }

            $job = $composer->getJobInstance($user);

            $delay = "immediately";

            if($hours > 0) {
                $delay = Carbon::now()->addSeconds(rand(0, $hours * 3600));

                $job->delay($delay);
            }

            dispatch($job);

            $this->info(sprintf('{%d}: %s <%s> (%s)', $index, $user->getFullName(), $user->email, $delay));
        }
    }
}
