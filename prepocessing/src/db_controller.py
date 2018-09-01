#!/usr/bin/python3
# -*- coding: utf-8 -*-


import psycopg2
import sys
from datetime import datetime
import os.path
import glob
conn_string = "host=172.18.0.2 port=5432 dbname=musicmatcher user=postgres password=cs2018"

import base64
import re

def file_to_base64(filename):
    with open(filename, "rb") as image_file:
        # decoding to not save byte but string
        return str(base64.b64encode(image_file.read()).decode('utf-8'))


def read_sql_create_cmds(sql_folder: str):
    """

    :param sql_folder:
    :return:
    """
    sql_commands = []
    for sql_file in sorted(glob.glob(sql_folder + "/*.sql")):
        print(sql_file)
        with open(sql_file, 'r') as fin:
            sql_commands.append(fin.read())
    return sql_commands


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
        d_id = None
        if len(args) == 1:
            self.cur.execute(sql, (args[0],))
        elif len(args) == 2:
            self.cur.execute(sql, (args[0], args[1],))
        elif len(args) == 3:
            self.cur.execute(sql, (args[0], args[1], args[2],))
        elif len(args) == 4:
            self.cur.execute(sql, (args[0], args[1], args[2], args[3],))
        elif len(args) == 5:
            self.cur.execute(sql, (args[0], args[1], args[2], args[3], args[4]))
        elif len(args) == 6:
            self.cur.execute(sql, (args[0], args[1], args[2], args[3], args[4], args[5]))

        if "RETURNING" in sql:
            d_id = self.cur.fetchone()[0]
        self.con.commit()
        self.cur.close()
        return d_id

    def insert_res_into_db(self, img_path=""):
        """
        update to new structure
        :param img_path:
        :return:
        """
        now = datetime.now()
        status = 'fresh'
        # not very elegant...
        img_path = "/".join(img_path.split("/")[5:])
        img_path = 'test_files/'+img_path
        thumbnail_path = img_path.replace('png/', 'thumb/T_')
        pdf_path = img_path.replace('png', 'pdf')
        hocr_path = img_path.replace('png', 'hocr')

        sql = """INSERT INTO tbl_res (res_added_date, res_status, res_pdf_path, res_img_path,
        res_img_thumb_path, res_hocr_path)
         VALUES (%s, %s, %s, %s, %s, %s) RETURNING res_id"""
        img_id = None
        try:
            img_id = self.insert(sql=sql,
                                 args=[now, status, pdf_path, img_path, thumbnail_path, hocr_path])
            print(img_id)
        except psycopg2.IntegrityError as ie:
            if self.con:
                self.con.rollback()
                pass
        except psycopg2.DatabaseError as e:
            if self.con:
                self.con.rollback()
            print('Error %s' % e)
            sys.exit(1)

        # funktioniert anders als gedacht.

        # if img_id:
        #     preprocessing_path = os.path.abspath(os.path.join(os.getcwd(), os.pardir))
        #     project_path = os.path.abspath(os.path.join(preprocessing_path, os.pardir))
        #
        #     abshocr_path = project_path + "/"+hocr_path
        #     with open(abshocr_path, 'r') as fin:
        #         hocr = fin.read()
        #
        #     sql = """INSERT INTO rel_res_has_hocr (res_id, hocr)
        #      VALUES (%s, %s)"""
        #     try:
        #         img_id = self.insert(sql=sql,
        #                              args=[img_id, hocr])
        #         print(img_id)
        #     except psycopg2.IntegrityError as ie:
        #         if self.con:
        #             self.con.rollback()
        #             pass
        #     except psycopg2.DatabaseError as e:
        #         if self.con:
        #             self.con.rollback()
        #         print('Error %s' % e)
        #         sys.exit(1)

    def assign_default_group(self, u_id):
        sql_insert = """INSERT INTO rel_user_in_group (u_id, g_id)
             VALUES (%s, 1)"""
        try:
            self.insert(sql=sql_insert, args=[u_id])
        except psycopg2.IntegrityError:
            pass

    def insert_user(self, user: str, psw: str):
        """

        :param user:
        :param psw:
        :return:
        """
        sql_insert = """INSERT INTO tbl_users (u_name, u_psw)
             VALUES (%s, %s) RETURNING u_id"""
        try:
            u_id = self.insert(sql=sql_insert, args=[user, psw])
            self.assign_default_group(u_id)
        except psycopg2.IntegrityError:
            pass



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
            pg_db.insert_res_into_db(file)

        else:
            print('dont take {}'.format(os.path.basename(file)))


def create_db(sql_folder: str):
    """

    :return:
    """
    pg_db = PostGresDb()
    commands = read_sql_create_cmds(sql_folder)


    """ create tables in the PostgreSQL database"""
    try:
        cur = pg_db.con.cursor()
        # create table one by one
        for command in commands:
            cur.execute(command)
        # close communication with the PostgreSQL database server
        cur.close()
        pg_db.con.commit()
    except (Exception, psycopg2.DatabaseError) as error:
        print(error)
    finally:
        if pg_db.con is not None:
            pg_db.con.close()
    print('created db')

    default_group = """INSERT INTO tbl_groups (g_name)
         VALUES (%s)"""
    try:
        pg_db.insert(sql=default_group, args=['default'])
    except psycopg2.IntegrityError:
        pass
    pg_db.insert_user(user='admin', psw='admin')


def create_db_with_test_data(folder):
    """
        @todo -> this is only for one sample!
        call this function to read some test pdf/png -data into the database
        you should have thumbnails created and pdfs
    """
    create_db(sql_folder='../res/sql')
    load_folder_into_db(folder)


if __name__ == '__main__':
    create_db_with_test_data("/home/pasha/musicmatcher/test_files/bub_gb_ppAPAAAAYAAJ/png")
    #load_folder_into_db("/home/tobias/mygits/musicmatcher/test_files/bub_gb_ppAPAAAAYAAJ/png")
