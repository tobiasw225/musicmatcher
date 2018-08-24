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