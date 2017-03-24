from __future__ import division, unicode_literals
from PIL import Image, ImageOps, ImageFilter
from tile_sequence import TileSequence
import image_helpers

from image_utils import ImageText

range = xrange
TRANSPARENT = (0, 0, 0, 0)


class ImageGrid(object):

    def __init__(self, options):
        self.backgroundImage = options['background'].convert('RGBA')
        self.overlayImage = options['overlay'].convert('RGBA')
        self.imageWidth = self.backgroundImage.width
        self.imageHeight = self.backgroundImage.height
        self.imageSize = self.backgroundImage.size

        self.achievementUsers = options['achievementUsers']

        for key, value in self.achievementUsers.iteritems():
            self.achievementUsers[key] = value.convert('RGBA')

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
            image = self.achievementUsers[self.tileCounter]

            iconWidth = image.width
            iconHeight = image.height
            self.achievementPositions.append((
                (
                    self.gridX(position['x']) + self.cellWidth - iconWidth,
                    self.gridY(position['y']) + self.cellHeight - iconHeight,
                ),
                image
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
        for position, image in self.achievementPositions:
            dest.paste(image, position, mask=image.split()[3])

        return dest

class Paragraph(object):
    def __init__(self, text, font='arial.ttf', size=10, skip=20, color=None):
        self.text = text
        self.font = font
        self.size = size
        self.skip = skip
        self.color = color

    def get_text(self, replacements):
        return self.text % replacements

class NewspaperImageGrid(object):
    def __init__(self, options):
        self.backgroundImage = options['background'].convert('RGBA')
        self.profileImage = options['profile'].convert('RGBA')
        self.blockWidth = options['w']
        self.blockPosition = (options['x'], options['y'])

        self.imageWidth = self.backgroundImage.width
        self.imageHeight = self.backgroundImage.height
        self.imageSize = self.backgroundImage.size

        self.replacements = {}
        self.lines = []
        self.rescaleProfile()

    def rescaleProfile(self):
        if self.profileImage.width != self.blockWidth:
            self.profileImage = self.profileImage.resize((self.blockWidth, self.blockWidth), Image.BILINEAR)

    def addParagraph(self, line, **kwargs):
        if len(line) == 0:
            return

        self.lines.append(Paragraph(line, **kwargs))

    def setReplacements(self, replacements):
        self.replacements = replacements

    def generate(self):
        # 1. paste image on image
        self.backgroundImage.paste(self.profileImage, self.blockPosition)

        # 2. put text on image
        position = (self.blockPosition[0], self.blockPosition[1] + self.blockWidth)

        for paragraph in self.lines:
            image_text = ImageText((self.blockWidth, self.imageHeight - self.blockPosition[1]))

            (x,y) = image_text.write_text_box((0, 0), paragraph.get_text(self.replacements), self.blockWidth, font_filename=paragraph.font, font_size=paragraph.size, color=paragraph.color, place='justify')

            self.backgroundImage.paste(image_text.image, position, image_text.image)

            position = (position[0], position[1] + y + paragraph.skip)

        return self.backgroundImage
