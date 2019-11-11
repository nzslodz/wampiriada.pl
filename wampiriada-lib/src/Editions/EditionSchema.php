<?php namespace NZS\Wampiriada\Editions;
use NZS\Wampiriada\Editions\EditionConfiguration;
use NZS\Wampiriada\ActionDay;
use DB;


class EditionSchema {
    public static function create($edition_number, $configure, $dates) {
        $edition = Edition::whereNumber($edition_number)->first();

        if($edition) {
            return;
        }

        DB::transaction(function() use($edition_number, $configure, $dates) {
            $obj = new static($edition_number, $dates);

            $configure($obj);

            $obj->build();
        });
    }

    public static function remove($edition_number) {
        $edition = Edition::whereNumber($edition_number)->first();

        if(!$edition) {
            return;
        }

        EditionConfiguration::whereId($edition->id)->delete();
        ActionDay::whereEditionId($edition->id)->delete();
        $edition->delete();
    }

    protected $edition = null;
    protected $actions = null;
    protected $config = null;

    public $name = null;

    protected function __construct($edition_number, $dates) {
        $this->edition = new Edition;

        $this->edition->number = $edition_number;
        $this->edition->start_date = $dates[0];
        $this->edition->end_date = $dates[1];

        $this->actions = [];
    }

    public function action($date, $place) {
        $action_builder = new ActionBuilder($date, $place);

        $this->actions[] = $action_builder;

        return $action_builder;
    }

    public function configure($options) {
        $this->config = new EditionConfiguration;

        foreach($options as $key => $value) {
            $this->config->$key = $value;
        }
    }

    protected function getEditionName() {
        if(!$this->name) {
            return "{$this->edition->number}. edycja";
        }

        return $this->name;
    }

    protected function build() {
        $this->edition->name = $this->getEditionName();

        $this->edition->save();

        if($this->config) {
            $this->config->id = $this->edition->id;
            $this->config->save();
        }


        foreach($this->actions as $action_day_builder) {
            $action_day = $action_day_builder->getActionDay($this->edition);

            $action_day->save();
        }
    }
}
