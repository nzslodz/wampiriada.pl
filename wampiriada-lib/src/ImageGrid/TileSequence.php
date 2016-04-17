<?php namespace NZS\Wampiriada\ImageGrid;

class TileSequence {
    public function __construct($tiles, $seed) {
        $this->tiles = $tiles;
        $this->shuffleTiles($seed);
    }
    private function shuffleTiles($seed) {
        $medianWeight = $this->getMedianWeight();
        foreach ($this->tiles as $key => $value) {
            $this->tiles[$key]['rare'] = ($value['weight'] > $medianWeight);
        }
        $nextSeed = rand();
        srand($seed); // Entering deterministic zone
        shuffle($this->tiles);
        $j = count($this->tiles) - 1;
        for ($i=0; $i<$j; ++$i) {
            if ($this->tiles[$i]['rare']) {
                $k = rand($i+1, $j);
                $tmp = $this->tiles[$i];
                $this->tiles[$i] = $this->tiles[$k];
                $this->tiles[$k] = $tmp;
                $j -= 1;
            }
        }
        srand($nextSeed); // Exiting deterministic zone
    }

    private function getMedianWeight() {
        usort($this->tiles, function($a, $b) {
            return $b['weight'] - $a['weight'];
        });
        return $this->tiles[floor(count($this->tiles)/2)]['weight'];
    }

    public function next() {
        return array_shift($this->tiles);
    }
}
