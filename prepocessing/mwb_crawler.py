# -*- coding: utf-8 -*-

# __filename__: mwb_crawler.py
#
# __description__:  Class for crawling data from 'Musikales Wochenblatt' & 'Neue Zeitschrift für Musik'
# 1) crawl links to txt/pdf files -> save to json
# 2) crawl data
#
#
# __remark__:
#
# __todos__:
#
# Created by Tobias Wenzel in August 2018

import os
import urllib
from urllib import request
import requests

import re
from bs4 import BeautifulSoup
import json

output_folder = "/home/tobias/Dokumente/Citizen Science/project/crawling/out/"

def save_as_json(output, filename="", as_array=True):
    """

    :param output:
    :param filename:
    :return:
    """

    with open(filename, "wb") as fout:
        if as_array:
            fout.write(json.dumps([k for k in output],
                                  separators=(',', ':'),
                                  sort_keys=True, indent=2, ensure_ascii=False).encode('utf8'))
        else:
            fout.write(json.dumps(output,
                                  separators=(',', ':'),
                                  sort_keys=True, indent=2, ensure_ascii=False).encode('utf-8'))

def load_json(filename):
    """

    :param filename:
    :return:
    """
    with open(filename, 'r') as fin:
        return json.load(fin)


class MWBCrawler:
    book_id = ""
    book_name = ""

    output_path = ""
    output_file = ""
    base_url = "http://www.archive.org"

    def __init__(self):
        self.headers = {}

        self.headers[
            'User-Agent'] = """Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.27 Safari/537.17"""


    def load_page(self, url):
        """
        tries to download page. if page doesn't exist, return false
        :param number:
        :return:
        """
        req = urllib.request.Request(url, headers=self.headers)
        try:
            with urllib.request.urlopen(req) as response:
                return response.read().decode('utf-8')
        except urllib.error.HTTPError:
            return False

    def get_txt_link(self, page, url):
        """

        :param page:
        :param url:
        :return:
        """
        res = re.search(r'href=\"(.*\.txt)\"',page)
        if res:
            link = self.base_url + res.group(1)

            return link
            # test link
        else:
            return None

    def get_pdf_link(self, page, url):
        """

        :param page:
        :param url:
        :return:
        """
        res = re.search(r'href=\"(.*\.pdf)\"', page)
        if res:
            link = self.base_url + res.group(1)
            # test link
            return link
        else:
            return None

    def get_links(self, url):
        """

        :param url:
        :return:
        """
        page = self.load_page(url)

        txt_link = self.get_txt_link(page=page, url=url)
        pdf_link = self.get_pdf_link(page=page, url=url)
        links = {
            'book_url': url.strip(),
            'txt_url': txt_link,
            'pdf_url': pdf_link
        }
        return links

    def get_all_links_of_file(self, link_file):
        """
        loads all links of given file
        :return:
        :param: link_file
        """
        link_ar = []
        with open(link_file, 'r') as fin:
            lines = fin.readlines()
            num_lines = len(lines)
            for i, link in enumerate(lines,0):
                if link:
                    print("{0}/{1} Links:\t {2}".format(i+1,num_lines,link))
                    link_ar.append(self.get_links(link))
        save_as_json(output=link_ar,filename=link_file+".json")

    def crawl_txt(self, url):
        """

        :param url:
        :return:
        """
        req = urllib.request.Request(url, headers=self.headers)
        try:
            with urllib.request.urlopen(req) as response:
                html  = response.read().decode('utf-8')

                soup2 = BeautifulSoup(html, "html.parser")
                text_el= str(soup2.find("pre"))
                if text_el:
                    output_file = output_folder+'txt/'+url.split("/")[-1]
                    with open(output_file, 'w') as fout:
                        fout.write(text_el)

        except urllib.error.HTTPError:
            return False

    def crawl_pdf(self, url):
        """
        this takes very long, since the files are ~80MB
        :param url:
        :return:
        """
        output_file = output_folder +'pdf/'+ url.split("/")[-1]
        print(output_file)

        # download the url contents in binary format
        r = requests.get(url)
        # open method to open a file on your system and write the contents
        with open(output_file, "wb") as code:
            code.write(r.content)

    def scrape_srcs(self, link_file):
        """
        actually scrape txt+pdf
        :return:
        """
        link_objs = load_json(link_file+ '.json')#
        for i, link_obj in enumerate(link_objs, 0):

            name = link_obj['book_url'].strip().split("/")[-1]
            if link_obj['txt_url']:
                print("{0}/{1} Links:\t {2}".format(i + 1, len(link_objs), name))
                self.crawl_pdf(link_obj['pdf_url'])
                #self.crawl_txt(link_obj['txt_url'])
                print(name)

            else:
                print('mistake while downloading')




mbwb = MWBCrawler()

link_file = "/home/tobias/Dokumente/Citizen Science/project/crawling/musikalisches_wochenblatt_links.txt"
#mbwb.get_all_links_of_file(link_file)
mbwb.scrape_srcs(link_file)

#mbwb.get_links(url="http://www.archive.org/details/musikalischeswo02unkngoog")