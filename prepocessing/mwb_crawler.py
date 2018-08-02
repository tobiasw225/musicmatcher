

import os
import urllib
from urllib import request
import re
from bs4 import BeautifulSoup


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
        links = {
            'book_url': url,
            'txt_url':
        }
        txt_link = self.get_txt_link(page=page, url=url)
        pdf_link = self.get_pdf_link(page=page, url=url)
        links = {
            'book_url': url,
            'txt_url': txt_link,
            'pdf_url': pdf_link
        }
        return links


    def get_all_links_of_file(self):
        """
        loads all links of given file
        :return:
        """
        pass

    def scrape_srcs(self):
        """
        actually scrape txt+pdf
        :return:
        """
        pass

mbwb = MWBCrawler()


mbwb.get_links(url="http://www.archive.org/details/musikalischeswo02unkngoog")