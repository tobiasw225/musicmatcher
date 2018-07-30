from wand.image import Image
from os.path import dirname, basename
import subprocess
from PIL import Image as PILImage
import pytesseract
import cv2
import os

from my_logging import *
logger = get_my_logger(fout_name="logger.log")


class Pdf2Text:

    def __init__(self):
        self.output_folder = "/home/tobias/pyenvs/tesseractvenv/out/"
        self.output_img_folder= self.output_folder + "img/"
        self.output_folder_text = self.output_folder + "txt/"

    def convert_pdf2png(self, filename):
        """
        use magick to convert pdf
        :param filename:
        :return:
        """
        base_filename = basename(filename)
        output_filename = self.output_img_folder+ base_filename.split(".")[:-1][0] \
                          + ".conv.png"
        logger.info(output_filename)
        with Image(filename=filename,resolution=400) as img:
            img.compression_quality = 100
            img.format = 'png'
            img.save(filename=output_filename)
        return output_filename

    # performs poorly
    def convert_image_to_greyscale(self, filename, args={}):
        """

        :param filename:
        :param args:
        :return:
        """
        output_folder = dirname(filename) + "/"
        # load the example image and convert it to grayscale
        image = cv2.imread(filename)
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

        # check to see if we should apply thresholding to preprocess the
        # image
        if args["preprocess"] == "thresh":
            gray = cv2.threshold(gray, 0, 255,
                                 cv2.THRESH_BINARY | cv2.THRESH_OTSU)[1]

        # make a check to see if median blurring should be done to remove
        # noise
        elif args["preprocess"] == "blur":
            gray = cv2.medianBlur(gray, 3)
        # write the grayscale image to disk as a temporary file so we can
        # apply OCR to it
        output_filename = output_folder+"{}.png".format(os.getpid())
        cv2.imwrite(output_filename, gray)
        return output_filename

    def call_textcleaner(self, filename):
        """

        :param filename:
        :return:
        """
        output_filename = self.output_img_folder + "clean."+basename(filename)
        proc = subprocess.Popen(["/home/tobias/pyenvs/tesseractvenv/textcleaner -g -e stretch -f 50 -o 10  -s 1  {} {}".format(filename, output_filename)],shell=True)
        proc.wait()
        logger.info("save as {}".format(output_filename))
        return output_filename

    def run_tesseract_on_file(self, filename):
        """
        load the image as a PIL/Pillow image, apply OCR, and then delete
        the temporary file
        :param filename:
        :return:
        """
        output_file = self.output_folder_text + basename(filename) + ".txt"

        logger.info("write to {}".format(output_file))

        text = pytesseract.image_to_string(PILImage.open(filename), lang='deu')

        with open(output_file, 'w') as fout:
            fout.write(text)

    def run_on_file(self, filename):
        """

        :param filename:
        :return:
        """
        conv_filename = self.convert_pdf2png(filename)
        conv_filename = self.call_textcleaner(conv_filename)
        self.run_tesseract_on_file(conv_filename)

    def run_on_folder(self, folder_name):
        """

        :param folder_name:
        :return:
        """

        if os.path.isfile(folder_name):
            self.run_on_file(filename=folder_name)

        elif os.path.isdir(folder_name):
            logger.info("convert dir {}".format(folder_name))
            files = os.listdir(folder_name)
            num_files = len(files)
            for i, file in enumerate(files, 0):
                if i % 10 == 0:
                    print_progress(i, num_files, prefix='', suffix='',
                                   decimals=2, bar_length=100)

                if os.path.isfile(os.path.join(folder_name, file)):
                    if file.endswith(".pdf"):
                        self.run_on_file(os.path.join(folder_name, file))
            pass
        else:
            raise ValueError("no valid file or dir.")
        pass


if __name__ == '__main__':
    filename = "/home/tobias/pyenvs/tesseractvenv/input/Page_001.pdf"
    p2t = Pdf2Text()
    p2t.run_on_folder("/home/tobias/pyenvs/tesseractvenv/input")

    # p2t.run_on_file(filename)
    #conv_filename = p2t.convert_pdf2png(filename)
    #conv_filename = p2t.convert_image_to_greyscale("/home/tobias/pyenvs/tesseractvenv/mw.png", args={"preprocess":"blur"})
    #p2t.run_tesseract_on_file(conv_filename)