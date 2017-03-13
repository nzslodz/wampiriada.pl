<?php namespace NZS\Core;


use Stevenmaguire\Services\Trello\Client as TrelloClient;

class TrelloList {
    protected $items;
    protected $definition;

    public function __construct($items, $definition) {
        $this->definition = $definition;
        $this->items = $items;
    }

    public function getItems() {
        return collect($this->items)->sortBy('pos');
    }

    public function getDefinition() {
        return $this->definition;
    }
}
