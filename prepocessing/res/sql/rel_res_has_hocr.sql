CREATE TABLE public.rel_res_has_hocr
(
    res_id bigint NOT NULL,
    hocr xml NOT NULL,
    CONSTRAINT rel_res_has_hocr_pkey PRIMARY KEY (res_id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.rel_res_has_hocr
    OWNER to postgres;