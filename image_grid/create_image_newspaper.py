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
"""
import argopen
from docopt import docopt
import random
from PIL import Image
from image_grid import NewspaperImageGrid
import sys
import io


VERSION="1.0"

if __name__ == '__main__':
    arguments = docopt(__doc__, version=VERSION)

    props = {
        'background': Image.open(arguments['--background']),
        'profile': Image.open(arguments['--profile']),
        'name': arguments['--name'],
        'x': 200,
        'y': 700,
        'w': 400,
    }

    grid = NewspaperImageGrid(props)

    with argopen.argopen(arguments['--text-file'], 'r') as f:
        lines = map(lambda x: x.strip(), f.readlines())

        grid.addLines(lines)

    output_image = grid.generate()

    bytes_io = io.BytesIO()
    output_image.save(bytes_io, 'JPEG', quality=80)

    bytes_io.seek(0)

    with argopen.argopen(arguments['--output'], 'wb') as o:
        o.write(bytes_io.read())
