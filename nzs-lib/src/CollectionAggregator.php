<?php namespace NZS\Core;

use Illuminate\Support\Collection;
use LogicException;

class CollectionAggregator {
    protected
        $collection;

    public function __construct(Collection $collection) {
        $this->collection = $collection;
    }

    protected function reduceNumbers($name) {
    }

    public function __call($name, $args) {
        if(!starts_with($name, 'get')) {
            throw new LogicException("Unknown method $name called on CollectionAggregator");
        }

        $name = snake_case(substr($name, 3));

        return $this->collection->reduce(function($carry, $item) use($name) {
            if(!$item->data) {
                return $carry;
            }

            return $carry + $item->data->$name;
        }, 0);
    }
}
