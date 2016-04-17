import random
from PIL import Image
from image_grid import ImageGrid

if __name__ == '__main__':
    props = {
        'background': Image.open('../storage/app/image-grid-images/wampir-1610.jpg'),
        'overlay': Image.open('../storage/app/image-grid-images/overlay.png'),
        'achievementIcon': Image.open('../storage/app/image-grid-images/crown.png'),
        'gridWidth': 40,
        'gridHeight': 25,
        'seed': 123,
        'achievementUsers': [10, 20]
    }
    grid = ImageGrid(props)
    tiles = []
    for i in xrange(700):
        path = '../storage/app/default-images/%d.png' % random.randint(0, 31)
        tiles.append(Image.open(path))
    grid.addTiles(tiles)
    grid.generate().show()
