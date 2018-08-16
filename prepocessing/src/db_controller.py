#!/usr/bin/python3
# -*- coding: utf-8 -*-


import psycopg2
import sys
from datetime import datetime
import os.path

conn_string = "host=localhost port=5432 dbname=test user=tobias password=test123"

import base64
def file_to_base64(filename):

    with open(filename, "rb") as image_file:
        return base64.b64encode(image_file.read())

class PostGresDb:
    con = None
    cur = None

    def __init__(self):

        self.con = psycopg2.connect(conn_string)


    def select(self, sql, args):
        self.con = psycopg2.connect(conn_string)
        self.cur = self.con.cursor()
        self.cur.execute(sql, args)
        rows = self.cur.fetchall()
        self.con.close()
        return rows

    def update(self, sql, args):
        self.con = psycopg2.connect(conn_string)
        self.cur = self.con.cursor()
        self.cur.execute(sql, args)
        self.con.commit()
        self.con.close()


    def insert(self, sql, args):
        self.con = psycopg2.connect(conn_string)
        self.cur = self.con.cursor()
        id = None
        if len(args) ==1:
            self.cur.execute(sql, (args[0],))
        elif len(args) == 2:
            self.cur.execute(sql, (args[0],args[1],))
        elif len(args) == 3:
            self.cur.execute(sql, (args[0],args[1],args[2],))
        elif len(args) == 4:
            self.cur.execute(sql, (args[0],args[1],args[2],args[3],))

        if "RETURNING" in sql:
            id = self.cur.fetchone()[0]
        self.con.commit()
        self.cur.close()
        return id


    def insert_img_into_db(self, img_path=""):
        """
        update to new structure
        :param person:
        :return:
        """
        now = datetime.now()
        status = 'fresh'
        base64_img = file_to_base64(img_path)

        sql = """INSERT INTO tbl_images_txt (img_obj_txt, img_added_date, img_status) VALUES (%s, %s, %s) RETURNING img_id"""
        try:
            img_id = self.insert(sql=sql,
                               args=[base64_img, now, status])
            print(img_id)


        except psycopg2.DatabaseError as e:
            if self.con:
                self.con.rollback()

            print('Error %s' % e)
            sys.exit(1)



def load_folder_into_db(folder_path):
    """

    :param folder_path:
    :return:
    """
    pg_db = PostGresDb()

    for file in os.listdir(folder_path):
        file = os.path.join(folder_path, file)
        if os.path.isfile(file):
            print("load {}".format(os.path.basename(file)))
            pg_db.insert_img_into_db(file)
        else:
            print('dont take {}'.format(os.path.basename(file)))


if __name__ == '__main__':

    #load_folder_into_db("/home/tobias/mygits/musicmatcher/test_files/res")
    pg_db.insert_img_into_db(file)