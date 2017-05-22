#!/usr/bin/env python

"""
Usage:
   create_image_newspaper [options]

Options:
    -h --help           Show this screen.
    --version           Show version information.
    --background=BACKGROUND     Background image path (revealed).
    --profile=PICTURE   Profile picture to use.
    --name=NAME         Profile name to use.
    --output=OUTPUT     Path to the output image [default: output.jpg].
    --text-file=FILE    Path to file with article text [default: -].
    --font-path=PATH    Path to the directory where fonts are stored [default: fonts].
"""
import argopen
from docopt import docopt
import random
from PIL import Image
from image_grid import NewspaperImageGrid
import sys
import io
import os


VERSION="1.0"

if __name__ == '__main__':
    arguments = docopt(__doc__, version=VERSION)

    props = {
        'background': Image.open(arguments['--background']),
        'profile': Image.open(arguments['--profile']),
        'x': 48,
        'y': 294,
        'imgx': 48,
        'imgy': 587,
        'w': 460,
    }

    grid = NewspaperImageGrid(props)

    grid.setReplacements({
        'name': arguments['--name'],
    })

    with argopen.argopen(arguments['--text-file'], 'r') as f:
        lines = map(lambda x: x.strip(), f.readlines())

        for number, line in enumerate(lines):
            if number == 0:
                grid.addParagraph(line, font=os.path.join(arguments['--font-path'], 'Alegreya-Regular.otf'), size=48, skip=48, color=(0,0,0))
            else:
                grid.addParagraph(line, font=os.path.join(arguments['--font-path'], 'Alegreya-Regular.otf'), size=24, skip=24, color=(0,0,0))

    output_image = grid.generate()

    bytes_io = io.BytesIO()
    output_image.save(bytes_io, 'JPEG', quality=90)

    bytes_io.seek(0)

    with argopen.argopen(arguments['--output'], 'wb') as o:
        o.write(bytes_io.read())
