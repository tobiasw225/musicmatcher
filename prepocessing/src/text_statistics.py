from nltk.tokenize import WordPunctTokenizer
import nltk
from nltk.corpus import words
import numpy as np
import operator
import os.path
from my_logging import *
from json_helper import *
logger = get_my_logger(fout_name="logger.log")

def read_german_words():
    with open('/usr/share/dict/ngerman', 'r') as fin:
        words = temp = [line[:-1].lower() for line in fin]
    return words

class FileStatistics:

    def __init__(self, filename):
        assert os.path.isfile(filename) == True
        self.filename = filename
        self.words = set(read_german_words()) #set(words.words())

        self.correct_words = 0
        self.words_with_mistakes = 0

    def run_method_on_file(self, func):
        """
        @todo check if func

        :param func:
        :return:
        """
        with open(self.filename, 'r') as fin:
            file_text = fin.read()
        if len(file_text):
            logger.info('run {}'.format(func.__name__))
            func(file_text)
        else:
            logger.info('won\'t run {} - {} has no text'.format(func.__name__, self.filename))

    def get_tokenized_text(self, text):
        return WordPunctTokenizer().tokenize(text)


    def word_ist_correct(self, word):
        """
        :param word:
        :return:
        """
        if word.lower() in self.words:
            return True
        elif word.isdigit():
            return True
        else:
            return False

    def get_number_of_correct_words(self, text):
        """
        :param text:
        :return:
        """
        word_candidates = self.get_tokenized_text(text)
        for i, word in enumerate(word_candidates, 0):
            self.correct_words += self.word_ist_correct(word)
        self.words_with_mistakes =  len(word_candidates) -self.correct_words
        percent = (self.correct_words/len(word_candidates))*100
        logger.info("{:.2f}% words are correct".format(percent))
        logger.info("{}/{} words are correct".format(self.correct_words,len(word_candidates)))


    def character_statistic(self, text):
        """

        :return:
        """
        signs = [sign.lower() for sign in sorted(set(text), reverse=True)]
        logger.info(signs)



    def word_statistic(self, text):
        """
        @todo write words in json
        :return:
        """

        words_lst = [word.lower() for word in self.get_tokenized_text(text)]
        word_set = set(words_lst)

        word_dict = {}
        for word in word_set:
            word_dict[word] = 0

        for word in words_lst:
            word_dict[word] += 1

        word_dict = sorted(word_dict.items(), key=operator.itemgetter(1), reverse=True)
        for i, word in enumerate(word_dict, 0):
            if i > 15:
                break
            logger.info("{} {}".format(word[0], word[1]))


    def run_all_tests(self):
        pass


#fs = FileStatistics('/home/tobias/Dokumente/Citizen Science/project/crawling/out/nzfm_raw/txt/Nzfm1918Jg085_djvu.txt')
#fs.run_method_on_file(fs.get_number_of_correct_words)
#fs.run_method_on_file(fs.word_statistic)
#fs.run_method_on_file(fs.character_statistic)


def create_txt_file_statistic(folder_name):
    """

    :param folder_name:
    :return:
    """
    print(folder_name)
    assert os.path.isdir(folder_name) is True
    files = os.listdir(folder_name)
    num_files = len(files)
    res = []
    for i, file in enumerate(files, 0):
        filename = os.path.join(folder_name, file)
        #print(filename)

        fs = FileStatistics(filename)
        fs.run_method_on_file(fs.get_number_of_correct_words)
        res.append({
            'file': fs.filename,
            'correct': fs.correct_words,
            'false': fs.words_with_mistakes,
            'total': fs.words_with_mistakes+fs.correct_words
        })

    save_as_json(res, folder_name+"stats.json")

def create_txt_stat_overview(stat_file):
    assert os.path.isfile(stat_file)
    stats = load_json(stat_file)
    correct_ar = []
    false_ar = []
    total_ar = []
    correct_perc_ar = []
    for stat in stats:
        correct_ar.append(stat['correct'])
        false_ar.append(stat['false'])
        total_ar.append(stat['total'])
        correct_perc_ar.append(100*stat['correct']/stat['total'])
    print('median number of words by file')
    print("{:.2f} correct".format(np.median(correct_ar)))
    print("{:.2f} false".format(np.median(false_ar)))
    print("{:.2f} total".format(np.median(total_ar)))
    print("{:.2f} %".format(np.median(correct_perc_ar)))




create_txt_file_statistic("/home/tobias/Dokumente/Citizen Science/project/crawling/out/mwb_raw/txt/")

create_txt_stat_overview("/home/tobias/Dokumente/Citizen Science/project/crawling/out/mwb_raw/txt/stats.json")