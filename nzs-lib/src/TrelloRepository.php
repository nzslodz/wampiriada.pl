<?php namespace NZS\Core;


use Stevenmaguire\Services\Trello\Client as TrelloClient;

class TrelloRepository {
    protected $client;

    public function __construct(TrelloClient $client) {
        $this->client = $client;
    }

    public function getCardsFromReleaseBoards($boards) {
        $cards = [];

        foreach($boards as $board) {
            $cards = array_merge($cards, $this->client->getBoardCards($board));
        }

        return $cards;
    }
}
