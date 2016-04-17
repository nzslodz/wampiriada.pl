from __future__ import division

from PIL import Image


def crop_to_aspect(image, aspect):
    width = image.width
    height = image.height
    new_width = int(height * aspect)
    new_height = int(width / aspect)
    if new_width < width:
        return crop_centered(image, (new_width, height))
    else:
        return crop_centered(image, (width, new_height))


def crop_centered(image, size):
    new_width, new_height = size
    box = {
        'x': (image.width - new_width) // 2,
        'y': (image.width - new_height) // 2,
        'width': new_width,
        'height': new_height
    }
    return image.crop((box['x'], box['y'],
                       box['x']+box['width'], box['y']+box['height']))


def remove_transparency(image, color='black'):
    bg = Image.new("RGBA", image.size, color)
    return Image.alpha_composite(bg, image)
