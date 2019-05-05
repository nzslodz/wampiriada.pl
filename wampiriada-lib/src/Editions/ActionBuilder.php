<?php namespace NZS\Wampiriada\Editions;
use NZS\Wampiriada\ActionDay;
use NZS\Wampiriada\Editions\Edition;
use Carbon\Carbon;

class ActionBuilder {
    public function __construct($date, $place) {
        $this->action_day = new ActionDay;
        $this->action_day->created_at = new Carbon($date);
        $this->action_day->updated_at = new Carbon($date);
        $this->action_day->place_id = $place;
    }

    public function hours($start, $end) {
        $this->action_day->start = "$start:00:00";
        $this->action_day->end = "$end:00:00";

        return $this;
    }

    public function hidden() {
        $this->hidden = true;

        return $this;
    }

    public function marrow($marrow) {
        $this->action_day->marrow = $marrow;

        return $this;
    }

    public function getActionDay(Edition $edition) {
        $action_day = $this->action_day;

        $action_day->start = "10:00:00";

        var_dump($action_day->start);

        if(!$action_day->start) {
            $action_day->start = "10:00:00";
        }

        if(!$action_day->end) {
            $action_day->end = "16:00:00";
        }

        if($action_day->marrow === null) {
            $action_day->marrow = true;
        }

        $action_day->edition_id = $edition->id;

        return $action_day;
    }

}
