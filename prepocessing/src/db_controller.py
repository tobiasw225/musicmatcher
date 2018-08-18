#!/usr/bin/python3
# -*- coding: utf-8 -*-


import psycopg2
import sys
from datetime import datetime
import os.path

conn_string = "host=172.19.0.2 port=5432 dbname=musicmatcher user=postgres password=cs2018"

import base64
import re

def file_to_base64(filename):
    with open(filename, "rb") as image_file:
        # decoding to not save byte but string
        return str(base64.b64encode(image_file.read()).decode('utf-8'))


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

        if "RETURNING" in sql:
            id = self.cur.fetchone()[0]
        self.con.commit()
        self.cur.close()
        return id

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
        thumbnail_path = img_path.replace('_img/', '_thumb/T_')
        pdf_path = img_path.replace('_img', '_pdf').replace('png', 'pdf')

        sql = """INSERT INTO tbl_res (res_added_date, res_status, res_pdf_path, res_img_path,
        res_img_thumb_path)
         VALUES (%s, %s, %s, %s, %s) RETURNING res_id"""
        try:
            img_id = self.insert(sql=sql,
                                 args=[now, status, pdf_path, img_path, thumbnail_path])
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
            pg_db.insert_res_into_db(file)
        else:
            print('dont take {}'.format(os.path.basename(file)))


def create_db():
    """

    :return:
    """
    pg_db = PostGresDb()

    """ create tables in the PostgreSQL database"""
    commands = (
        """CREATE TABLE public.tbl_tags
            (
                tag_id SERIAL NOT NULL ,
                tag_name character varying COLLATE pg_catalog."default" NOT NULL,
                CONSTRAINT tbl_tags_pkey PRIMARY KEY (tag_id),
                CONSTRAINT tbl_tags_tag_name_key UNIQUE (tag_name)
            )
            WITH (
                OIDS = FALSE
            )
            TABLESPACE pg_default;
            
            ALTER TABLE public.tbl_tags
                OWNER to postgres;
        """,
        """CREATE TABLE public.tbl_res
            (
                res_id SERIAL NOT NULL,
                res_added_date timestamp(4) with time zone,
                res_status character varying COLLATE pg_catalog."default",
                res_pdf_path character varying COLLATE pg_catalog."default",
                res_img_path character varying COLLATE pg_catalog."default",
                res_img_thumb_path character varying COLLATE pg_catalog."default",

                CONSTRAINT tbl_images_txt_pkey PRIMARY KEY (res_id)
            )
            WITH (
                OIDS = FALSE
            )
            TABLESPACE pg_default;
            
            ALTER TABLE public.tbl_res
                OWNER to postgres;
        """,
        """CREATE TABLE public.tbl_users
            (
                u_id SERIAL NOT NULL,
                u_name character varying COLLATE pg_catalog."default" NOT NULL,
                u_psw character varying COLLATE pg_catalog."default" NOT NULL,
                u_mail character varying COLLATE pg_catalog."default",
                u_points bigint NOT NULL DEFAULT 0,
                CONSTRAINT tbl_users_pkey PRIMARY KEY (u_id)
            )
            WITH (
                OIDS = FALSE
            )
            TABLESPACE pg_default;
            
            ALTER TABLE public.tbl_users
                OWNER to postgres;

        """,
        """CREATE TABLE public.rel_user_edited_res
            (
                res_id bigint NOT NULL,
                u_id bigint NOT NULL,
                edit_time date NOT NULL,
                CONSTRAINT rel_user_edited_res_pkey PRIMARY KEY (res_id, u_id),
                CONSTRAINT rel_user_edited_res_id_fkey FOREIGN KEY (res_id)
                    REFERENCES public.tbl_res (res_id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION,
                CONSTRAINT rel_user_edited_img_u_id_fkey FOREIGN KEY (u_id)
                    REFERENCES public.tbl_users (u_id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION
            )
            WITH (
                OIDS = FALSE
            )
            TABLESPACE pg_default;
            
            ALTER TABLE public.rel_user_edited_res
                OWNER to postgres;
        """,
        """
                CREATE TABLE public.tbl_res_info
        (
            res_id bigint NOT NULL,
            u_id bigint NOT NULL,
            res_name character varying COLLATE pg_catalog."default",
            res_has_text boolean,
            res_has_sheet_music boolean,
            res_source character varying COLLATE pg_catalog."default",
            CONSTRAINT tbl_resources_pkey PRIMARY KEY (res_id),
            CONSTRAINT tbl_resources_fkey FOREIGN KEY (res_id)
                REFERENCES public.tbl_res (res_id) MATCH SIMPLE
                ON UPDATE NO ACTION
                ON DELETE NO ACTION,
            CONSTRAINT tbl_resources_fkey2 FOREIGN KEY (u_id)
                REFERENCES public.tbl_users (u_id) MATCH SIMPLE
                ON UPDATE NO ACTION
                ON DELETE NO ACTION
        )
        WITH (
            OIDS = FALSE
        )
        TABLESPACE pg_default;
        
        ALTER TABLE public.tbl_res_info
            OWNER to postgres;
        """,
        """
            CREATE TABLE public.rel_res_has_tags
            (
                res_id bigint NOT NULL,
                tag_id bigint NOT NULL,
                CONSTRAINT rel_res_has_tags_pkey PRIMARY KEY (res_id, tag_id),
                CONSTRAINT rel_res_has_tags_res_id_fkey FOREIGN KEY (res_id)
                    REFERENCES public.tbl_res (res_id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION,
                CONSTRAINT rel_res_has_tags_tag_id_fkey FOREIGN KEY (tag_id)
                    REFERENCES public.tbl_tags (tag_id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION
            )
            WITH (
                OIDS = FALSE
            )
            TABLESPACE pg_default;
            
            ALTER TABLE public.rel_res_has_tags
                OWNER to postgres;
        """
        )
    conn = None
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


if __name__ == '__main__':
    pass
    load_folder_into_db("/home/tobias/mygits/musicmatcher/test_files/bub_gb_1UMvAAAAMAAJ_img")
    #create_db()
    #pg_db = PostGresDb()
    #pg_db.insert_res_into_db("/home/tobias/mygits/musicmatcher/test_files/res/bsb10527854_00145.jpg")
    # file_to_base64("/home/tobias/mygits/musicmatcher/test_files/res/bsb10527854_00145.jpg")
