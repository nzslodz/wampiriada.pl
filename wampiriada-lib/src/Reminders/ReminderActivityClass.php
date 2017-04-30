<?php namespace NZS\Wampiriada\Reminders;

use NZS\Core\ModelActivityClass;
use NZS\Core\Activity;
use NZS\Core\ActivityContainer;
use NZS\Core\Contracts\Timeline;
use NZS\Wampiriada\Action;

class ReminderActivityClass extends ModelActivityClass {
    public function getModel() {
        return Reminder::class;
    }

    public function getInterface($contract) {
        if($contract == Timeline::class) {
            return ReminderTimeline::class;
        }
    }

    public function loadData(ActivityContainer $container) {
        $container->action = Action::find($container->object->action_day_id);

        return $container;
    }
}
