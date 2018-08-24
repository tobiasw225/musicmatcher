CREATE TABLE IF NOT EXISTS public.tbl_res
            (
                res_id SERIAL NOT NULL,
                res_added_date timestamp(4) with time zone,
                res_status character varying COLLATE pg_catalog."default",
                res_pdf_path character varying COLLATE pg_catalog."default",
                res_img_path character varying COLLATE pg_catalog."default",
                res_img_thumb_path character varying COLLATE pg_catalog."default",
                res_hocr_path character varying COLLATE pg_catalog."default",
                CONSTRAINT tbl_images_txt_pkey PRIMARY KEY (res_id),
                CONSTRAINT tbl_res_img_path_key UNIQUE (res_img_path),
                CONSTRAINT tbl_res_pdf_path UNIQUE (res_pdf_path),
                CONSTRAINT tbl_res_hocr_path UNIQUE (res_hocr_path)
            )
            WITH (
                OIDS = FALSE
            )
            TABLESPACE pg_default;

            ALTER TABLE public.tbl_res
                OWNER to postgres;