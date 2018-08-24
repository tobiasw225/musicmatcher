CREATE TABLE public.tbl_users
            (
                u_id SERIAL NOT NULL,
                u_name character varying COLLATE pg_catalog."default" NOT NULL,
                u_psw character varying COLLATE pg_catalog."default" NOT NULL,
                u_mail character varying COLLATE pg_catalog."default",
                u_points bigint NOT NULL DEFAULT 0,
                CONSTRAINT tbl_users_pkey PRIMARY KEY (u_id),
                CONSTRAINT tbl_users_u_name_key UNIQUE (u_name)
            )
            WITH (
                OIDS = FALSE
            )
            TABLESPACE pg_default;

            ALTER TABLE public.tbl_users
                OWNER to postgres;