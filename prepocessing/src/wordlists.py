import os
import lxml.html

def parse_music_words():
    """
    more or less dummy data at this moment
    :return:
    """
    folder_name = '/home/tobias/Downloads/words'
    files = os.listdir(folder_name)
    num_files = len(files)
    res = []
    words = []

    for i, file in enumerate(files, 0):
        filename = os.path.join(folder_name, file)

        with open(filename, 'r', encoding='utf-8') as fin:
            html = fin.read()
        c_doc = lxml.html.fromstring(html)

        words = [word.strip().lower() for word in c_doc.xpath("""//td/h1/font/text()""")[2:]]
        for i, word in enumerate(words):
            # nur einfach begriffe
            if len(word.split(" ")) == 1:
                print(word.replace('-','_').rstrip('.'), file=open('/home/tobias/Downloads/words/words.txt', 'a'))
