<?php namespace NZS\Wampiriada;
use Illuminate\Support\Collection;

// XXX This consumes actually a collection of ActionDays with actiondata
// it probably would be wise to make a specific class that tackles Edition data
// as this container class is used only for one purpose
class ActionDataAggregator {
    protected $collection;

    public function __construct(Collection $collection) {
        $this->collection = $collection;
    }

    public function sumData($field) {
        return $this->collection->sum(function($object) use ($field) {
            return $object->data->$field;
        });
    }
}
