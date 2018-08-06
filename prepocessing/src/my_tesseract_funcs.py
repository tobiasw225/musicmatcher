from wand.image import Image
from os.path import dirname, basename
import subprocess
from PIL import Image as PILImage
import pytesseract
import cv2
import os

from my_logging import *
logger = get_my_logger(fout_name="logger.log")

TEXT_CLEANER_PATH = "/home/tobias/mygits/musicmatcher/prepocessing/src/textcleaner"


class Pdf2Text:

    def __init__(self, output_folder):
        self.output_folder = output_folder
        self.output_img_folder= self.output_folder + "img/"
        self.output_folder_text = self.output_folder + "txt/"

    def convert_pdf2png(self, filename, output_folder=""):
        """
        use magick to convert pdf
        :param filename:
        :return:
        """

        base_filename = basename(filename)
        if not output_folder:
            output_filename = self.output_img_folder+ base_filename.split(".")[:-1][0] \
                              + ".conv.png"
        else:
            output_filename = output_folder + base_filename +".png"
        #logger.info(output_filename)
        if os.path.isfile(output_filename):
            return

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

    def call_textcleaner(self, filename, output_folder="" ):
        """

        :param filename:
        :return:
        """
        output_filename = self.output_img_folder + "clean."+basename(filename)

        base_filename = basename(filename)
        if not output_folder:
            output_filename = self.output_img_folder+ "clean."+basename(filename)
        else:
            output_filename = output_folder + "clean."+ base_filename

        logger.info(output_filename)
        if os.path.isfile(output_filename):
            return


        cmd = TEXT_CLEANER_PATH + " -g -e stretch -f 50 -o 10  -s 1  {} {}".format(filename, output_filename)
        proc = subprocess.Popen([cmd],shell=True)
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

    def run_complete_on_folder(self, folder_name):
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
                    print("{0}/{1}:\t {2}".format(i + 1, num_files, file))

                if os.path.isfile(os.path.join(folder_name, file)):
                    if file.endswith(".pdf"):
                        self.run_on_file(os.path.join(folder_name, file))
            pass
        else:
            raise ValueError("no valid file or dir.")
        pass


    def run_pdf_to_png_on_folder(self, folder_name):
        """

        :param folder_name:
        :return:
        """

        if os.path.isdir(folder_name):
            logger.info("convert dir {}".format(folder_name))
            img_output = folder_name + "/img/"

            if not os.path.exists(img_output):
                os.makedirs(img_output)

            files = os.listdir(folder_name)
            num_files = len(files)
            for i, file in enumerate(files, 0):
                proc_file = os.path.join(folder_name, file)
                if os.path.isfile(proc_file) and not proc_file.endswith('txt'):
                    if i % 50 == 0:
                        print("{0}/{1}:\t {2}".format(i + 1, num_files, file))
                    self.convert_pdf2png(filename=proc_file, output_folder=img_output)

        else:
            raise ValueError("no valid file or dir.")


    def run_func_complete(self, base_input_folder=""):
        """
        could also be called with tesseract function
        :param base_input_folder:
        :return:
        """
        if os.path.isdir(base_input_folder):
            logger.info("convert everything directly below dir {}".format(base_input_folder))

        sub_folders = os.listdir(base_input_folder)
        d = base_input_folder
        sub_folders = [os.path.join(d, o) for o in os.listdir(d)
         if os.path.isdir(os.path.join(d, o))]

        num_files = len(sub_folders)
        for i, folder in enumerate(sub_folders, 0):

            if os.path.isdir(folder):
                print("{0}/{1}:\t of everything {2}".format(i + 1, num_files, folder))
                self.run_pdf_to_png_on_folder(folder_name=folder)



if __name__ == '__main__':
    filename = "/home/tobias/pyenvs/tesseractvenv/input/Page_001.pdf"
    output_folder = "/home/tobias/Dokumente/Citizen Science/project/crawling/out/mwb_raw/"
    p2t = Pdf2Text(output_folder)
    #p2t.run_on_folder("/home/tobias/pyenvs/tesseractvenv/input")
    p2t.call_textcleaner("/home/tobias/Dokumente/Citizen\ Science/project/crawling/out/mwb_raw/splitted/bub_gb_1UMvAAAAMAAJ/img/bub_gb_1UMvAAAAMAAJ_Page_0x1bdf.png",
                         output_folder="/home/tobias/Dokumente/Citizen\ Science/project/crawling/out/mwb_raw/splitted/bub_gb_1UMvAAAAMAAJ/")

    #p2t.run_on_file(filename)

    #p2t.run_pdf_to_png_on_folder("/home/tobias/Dokumente/Citizen Science/project/crawling/out/mwb_raw/splitted/bub_gb_1UMvAAAAMAAJ")
    #p2t.run_func_complete("/home/tobias/Dokumente/Citizen Science/project/crawling/out/mwb_raw/splitted/")
    #conv_filename = p2t.convert_image_to_greyscale("/home/tobias/pyenvs/tesseractvenv/mw.png", args={"preprocess":"blur"})
    #p2t.run_tesseract_on_file(conv_filename)