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

    /**
    *   Gets the Trello board object used for releases.
    */
    public function getReleaseBoard() {
        if($this->release_board) {
            return $this->release_board;
        }

        $this->release_board = $this->client->getBoard($this->release_board_key);

        return $this->release_board;
    }


    /**
    *   Get name of the release board.
    */
    public function getName() {
        return $this->getReleaseBoard()->name;
    }

    /**
    *   Get all release
    */

    public function getReleases() {
        if($this->release_board_lists) {
            return $this->release_board_lists;
        }

        $this->release_board_lists = collect($this->client->getBoardLists($this->release_board_key));

        return $this->release_board_lists;
    }

    public function getRelease($id_or_release) {
        if($id_or_release instanceof Release) {
            $id = $id_or_release->trello_list_id;
        } else {
            $id = $id_or_release;
        }

        $list = $this->client->getList($id);
        $cards = $this->client->getListCards($id, ['members' => 'true', 'checkItemStates' => 'true', 'checklists' => 'all']);

        return new TrelloList($cards, $list);
    }
    public function getKey() {
        return  $this->release_board_key;
    }

    public function getCardsForBoards() {
        $cards = [];

        $lists = $this->getListsForBoards();

        foreach($lists as $list) {
            $cards = array_merge($cards, $this->client->getListCards($list->id));
        }

        return collect($cards)->groupBy('idList')->transform(function($item, $key) use($lists) {
            return new TrelloList($item, $lists[$key]);
        })->sortBy(function($list) {
            return $list->getDefinition()->pos;
        });
    }

    public function getListsForBoards() {
        $lists = [];

        foreach($this->source_boards as $board) {
            $lists = array_merge($lists, $this->client->getBoardLists($board));
        }

        return collect($lists)->mapWithKeys(function($item) {
            return [$item->id => $item];
        })->filter(function($list) {
            return starts_with($list->name, "+");
        });
    }

    public function createRelease($cardIds, $name) {
        $list = $this->client->addBoardList($this->getReleaseBoard()->id, [
            'name' => $name,
        ]);

        $release = new Release;
        $release->trello_board_id = $list->idBoard;
        $release->trello_list_id = $list->id;
        $release->name = $name;
        $release->save();

        foreach($cardIds as $cardId) {
            $trello_card = $this->client->getCard($cardId, ['members' => 'true', 'board' => 'true']);

            $board = Board::whereTrelloBoardId($trello_card->idBoard)->firstOrNew();
            $board->trello_board_name = $trello_card->board->name;
            $board->save();

            $card = new CardMetadata;
            $card->trello_original_list_id = $trello_card->idList;
            $card->trello_original_board_id = $trello_card->idBoard;
            $card->original_board_id = $board->id;
            $card->release_id = $release->id;
            $card->save();

            $this->client->updateCardIdBoard($cardId, ['value' => $list->idBoard, 'idList' => $list->id]);
        }

        return $release;
    }

    // XXX TODO
    /*public function getBoardCards(Board $board) {
        return $board->cards->groupBy('release_id')->transform(function($card_metas, $release_id) {
            $release = Release::find($release_id);
            $list = $this->client->getList($release->trello_list_id);
            $cards = collect($this->client->getListCards())

            return new TrelloList($cards, $list;)
        })
    }*/

}
