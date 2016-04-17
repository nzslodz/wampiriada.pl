from __future__ import division, unicode_literals
from PIL import Image, ImageOps, ImageFilter
from tile_sequence import TileSequence
import image_helpers

range = xrange
TRANSPARENT = (0, 0, 0, 0)


class ImageGrid(object):

    def __init__(self, options):
        self.backgroundImage = options['background'].convert('RGBA')
        self.overlayImage = options['overlay'].convert('RGBA')
        self.achievementIconImage = options['achievementIcon'].convert('RGBA')
        self.imageWidth = self.backgroundImage.width
        self.imageHeight = self.backgroundImage.height
        self.imageSize = self.backgroundImage.size
        self.achievementUsers = options['achievementUsers']
        self.rescaleOverlay()
        self.createTilesImage()

        self.gridWidth = options['gridWidth']
        self.gridHeight = options['gridHeight']
        self.cellWidth = int(round(self.imageWidth / self.gridWidth))
        self.cellHeight = int(round(self.imageHeight / self.gridHeight))
        self.cellSize = (self.cellWidth, self.cellHeight)
        self.cellAspect = self.cellWidth / self.cellHeight
        self.createSequence(options['seed'])
        self.tileCounter = 0
        self.achievementPositions = []

    def rescaleOverlay(self):
        if self.overlayImage.size != self.imageSize:
            self.overlayImage = self.overlayImage.resize(
                self.imageSize, Image.BILINEAR)

    def createTilesImage(self):
        self.tilesImage = Image.new('RGBA', self.imageSize, TRANSPARENT)

    def createSequence(self, seed):
        # TODO
        edges = self.backgroundImage.filter(ImageFilter.EMBOSS)

        # compute weights for each tile
        items = []
        for tx in range(self.gridWidth):
            for ty in range(self.gridHeight):
                tileValue = self.getTileValue(edges, tx, ty)
                items.append({"x": tx, "y": ty, "weight": tileValue})

        self.sequence = iter(TileSequence(items, seed))

    def addTiles(self, tiles):
        for tile in tiles:
            position = next(self.sequence)
            self.addTile(tile, position)

    def addTile(self, tileImage, position):
        tileImage = tileImage.convert('RGBA')
        tileImage = image_helpers.crop_to_aspect(tileImage, self.cellAspect)
        tileImage = image_helpers.remove_transparency(tileImage)

        tileImage = tileImage.resize(self.cellSize, resample=Image.BILINEAR)
        self.tilesImage.paste(tileImage, (self.gridX(position['x']),
                                          self.gridY(position['y'])))

        self.tileCounter += 1
        if self.tileCounter in self.achievementUsers:
            iconWidth = self.achievementIconImage.width
            iconHeight = self.achievementIconImage.height
            self.achievementPositions.append((
                self.gridX(position['x']) + self.cellWidth - iconWidth,
                self.gridY(position['y']) + self.cellHeight - iconHeight,
            ))

    def gridX(self, posX):
        return posX * self.cellWidth

    def gridY(self, posY):
        return posY * self.cellHeight

    def getTileValue(self, img, tx, ty):
        sum = 0
        for x in range(self.gridX(tx), self.gridX(tx) + self.cellWidth):
            if x >= img.width:
                continue
            for y in range(self.gridY(ty), self.gridY(ty) + self.cellHeight):
                if y >= img.height:
                    continue
                color = img.getpixel((x, y))
                colorValue = abs(color[0]-127) + abs(color[1]-127) + abs(color[2]-127)
                sum += colorValue

        return sum

    def generate(self):
        # prepare masked overlay
        trimmedOverlay = Image.new('RGBA', self.imageSize, TRANSPARENT)
        mask = ImageOps.invert(self.tilesImage.split()[3])
        trimmedOverlay.paste(self.overlayImage, mask=mask)

        # join background with avatars (wee)
        source = self.backgroundImage
        dest = self.tilesImage
        dest = Image.blend(self.backgroundImage, self.tilesImage, 0.5)
        dest = Image.alpha_composite(dest, trimmedOverlay)

        # add achievements!
        for position in self.achievementPositions:
            dest.paste(self.achievementIconImage, position,
                       mask=self.achievementIconImage.split()[3])
        return dest
