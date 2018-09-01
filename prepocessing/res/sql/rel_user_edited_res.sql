CREATE TABLE IF NOT EXISTS public.rel_user_edited_res
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
