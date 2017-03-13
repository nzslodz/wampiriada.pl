<?php namespace NZS\Core;


use Stevenmaguire\Services\Trello\Client as TrelloClient;

class TrelloRepository {
    protected $client;
    protected $release_board_key;
    protected $release_board = null;
    protected $release_board_lists = null;
    protected $source_boards;

    public function __construct(TrelloClient $client, $key, $config) {
        $this->client = $client;
        $this->release_board_key = $key;
        $this->source_boards = $config['from'];
    }

    public function getReleaseBoard() {
        if($this->release_board) {
            return $this->release_board;
        }

        $this->release_board = $this->client->getBoard($this->release_board_key);

        return $this->release_board;
    }

    public function getName() {
        return $this->getReleaseBoard()->name;
    }

    public function getReleases() {
        if($this->release_board_lists) {
            return $this->release_board_lists;
        }

        $this->release_board_lists = collect($this->client->getBoardLists($this->release_board_key));

        return $this->release_board_lists;
    }

    public function getRelease($id) {
        $list = $this->client->getList($id);
        $cards = $this->client->getListCards($id);

        return new TrelloList($cards, $list);
    }
    public function getKey() {
        return  $this->release_board_key;
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
