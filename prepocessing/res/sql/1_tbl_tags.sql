CREATE TABLE IF NOT EXISTS public.tbl_tags
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