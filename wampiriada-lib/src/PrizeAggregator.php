<?php namespace NZS\Wampiriada;
use Illuminate\Support\Collection;

// XXX would be wise to refactor it a little bit for clarity
class PrizeAggregator {
    protected $collection;

    protected $claimed_collection = null;
    protected $unclaimed_collection = null;

    protected $item_collections = [];

    public function __construct(Collection $collection) {
        $this->collection = $collection;
    }

    protected function filterClaimed($claimed=true) {
        if($claimed && $this->claimed_collection) {
            return $this->claimed_collection;
        }

        if(!$claimed && $this->unclaimed_collection) {
            return $this->unclaimed_collection;
        }

        $collection = $this->collection->filter(function($object) use($claimed) {
            return ((bool) $object->claimed_at) == $claimed;
        });

        if($claimed) {
            $this->claimed_collection = $collection;
        } else {
            $this->unclaimed_collection = $collection;
        }

        return ($claimed) ? $this->claimed_collection : $this->unclaimed_collection;
    }

    public function countClaimedPrizes() {
        return $this->filterClaimed()->count();
    }

    public function countUnclaimedPrizes() {
        return $this->filterClaimed(false)->count();
    }

    public function getItemsInSet() {
        $new_collection = collect([]);

        foreach($this->collection as $prize) {
            foreach($prize->items as $prize_type) {
                if(!$new_collection->has($prize_type->id)) {
                    $prize_type->count = 0;
                    $prize_type->claimed = 0;
                    $prize_type->unclaimed = 0;

                    $new_collection->put($prize_type->id, $prize_type);
                }

                $new_collection->get($prize_type->id)->count++;

                if($prize->claimed_at) {
                    $new_collection->get($prize_type->id)->claimed++;
                } else {
                    $new_collection->get($prize_type->id)->unclaimed++;
                }
            }
        }

        return $new_collection;
    }

}
