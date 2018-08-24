 CREATE TABLE IF NOT EXISTS public.tbl_res_info
        (
            res_id bigint NOT NULL,
            u_id bigint NOT NULL,
            res_is_title_page boolean,
            res_sm_count bigint DEFAULT 0,
            res_ad_count bigint DEFAULT 0,
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