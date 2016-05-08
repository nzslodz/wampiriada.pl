#!/usr/bin/env python

"""
Usage:
   create_image_grid [options] [ACHIEVEMENT...]

Options:
    -h --help           Show this screen.
    --version           Show version information.
    --width=WIDTH       Number of images per grid horizontally [default: 40].
    --height=HEIGHT     Number of images per grid vertically [default: 25].
    --background=BACKGROUND     Background image path (revealed).
    --overlay=OVERLAY           Overlay image path.
    --seed=SEED         Seed the RNG with a specific value.
    --tiles=TILES       Path to the file specifying image paths to tile images [default: -].
    --output=OUTPUT     Path to the output image.

Achievements are in the form 20:path_to_image.
"""

from docopt import docopt
import random
from PIL import Image
from image_grid import ImageGrid
import sys

VERSION="1.0"

if __name__ == '__main__':
    arguments = docopt(__doc__, version=VERSION)

    achievement_users = {}
    for achievement_def in arguments['ACHIEVEMENT']:
        bits = achievement_def.split(':')

        achievement_users[int(bits[0])] = Image.open(':'.join(bits[1:]))
    
    props = {
        'background': Image.open(arguments['--background']),
        'overlay': Image.open(arguments['--overlay']),
        'gridWidth': int(arguments['--width']),
        'gridHeight': int(arguments['--height']),
        'seed': arguments['--seed'],
        'achievementUsers': achievement_users,
    }

    grid = ImageGrid(props)
    
    if arguments['--tiles'] == '-':
        f = sys.stdin
    else:
        f = open(arguments['--tiles'])

    tiles = []
    for line in f:
        tiles.append(Image.open(line.strip()))

    f.close()

    grid.addTiles(tiles)
    output = grid.generate()
    output.save(arguments['--output'])
