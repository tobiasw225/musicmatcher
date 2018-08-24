import glob
from PIL import Image


def create_thumbnails_for_folder(folder: str):
    """

    :param folder:
    :return:
    """
    # get all the png files from the current folder
    for infile in glob.glob(folder+"/*.png"):

        thumbnail_path = infile.replace('png/', 'thumb/T_')
        print(thumbnail_path)
        im = Image.open(infile)
        im.thumbnail((667, 880), Image.ANTIALIAS)
        # don't save if thumbnail already exists
        if infile[0:2] != "T_":
            im.save(thumbnail_path, "PNG")

if __name__ == '__main__':
    create_thumbnails_for_folder('/home/tobias/mygits/musicmatcher/test_files/bub_gb_ppAPAAAAYAAJ/png')
