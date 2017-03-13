<?php namespace NZS\Core;


use Stevenmaguire\Services\Trello\Client as TrelloClient;

class TrelloRepository {
    protected $client;

    public function __construct(TrelloClient $client) {
        $this->client = $client;
    }

    public function getCardsForBoards($boards) {
        $cards = [];

        foreach($boards as $board) {
            $cards = array_merge($cards, $this->client->getBoardCards($board));
        }

        $lists = $this->getListsForBoards($boards);

        return collect($cards)->groupBy('idList')->transform(function($item, $key) use($lists) {
            return new TrelloList($item, $lists[$key]);
        })->sortBy(function($list) {
            return $list->getDefinition()->pos;
        });
    }

    public function getListsForBoards($boards) {
        $lists = [];

        foreach($boards as $board) {
            $lists = array_merge($lists, $this->client->getBoardLists($board));
        }

        return collect($lists)->mapWithKeys(function($item) {
            return [$item->id => $item];
        });
    }
}
