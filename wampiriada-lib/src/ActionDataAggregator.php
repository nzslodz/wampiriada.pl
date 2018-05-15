<?php namespace NZS\Wampiriada;
use Illuminate\Support\Collection;


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
