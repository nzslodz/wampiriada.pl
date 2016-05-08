from random import Random


class TileSequence(object):
    def __init__(self, tiles, seed):
        self.tiles = tiles
        self.shuffleTiles(seed)

    def shuffleTiles(self, seed):
        medianWeight = self.getMedianWeight()
        for tile in self.tiles:
            tile['rare'] = (tile['weight'] > medianWeight)

        if seed:
            rng = Random(seed)
        else:
            rng = Random()
        rng.shuffle(self.tiles)
        i = 0
        j = len(self.tiles) - 1
        while i < j:
            if self.tiles[i]['rare']:
                k = rng.randint(i+1, j)
                tmp = self.tiles[i]
                self.tiles[i] = self.tiles[k]
                self.tiles[k] = tmp
                j -= 1
            i += 1

    def getMedianWeight(self):
        self.tiles.sort(key=lambda tile: tile['weight'])
        return self.tiles[len(self.tiles) // 2]['weight']

    def __iter__(self):
        return iter(self.tiles)
