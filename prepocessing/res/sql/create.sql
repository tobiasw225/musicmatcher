

CREATE TABLE public.tbl_tags
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



--------------------------------



CREATE TABLE public.tbl_res
(
    res_id SERIAL NOT NULL,
    res_added_date timestamp(4) with time zone,
    res_status character varying COLLATE pg_catalog."default",
    res_path character varying COLLATE pg_catalog."default",
    CONSTRAINT tbl_images_txt_pkey PRIMARY KEY (res_id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tbl_res
    OWNER to postgres;

-----------------------------

CREATE TABLE public.tbl_users
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



----------------------------

CREATE TABLE public.rel_user_edited_res
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

---------------------------

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

-------------------------

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


