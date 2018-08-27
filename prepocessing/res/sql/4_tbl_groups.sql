
CREATE TABLE public.tbl_groups
(
    g_id bigint NOT NULL SERIAL NOT NULL,
    g_name character varying COLLATE pg_catalog."default" NOT NULL,
    g_created_at timestamp with time zone,
    CONSTRAINT tbl_group_pkey PRIMARY KEY (g_id),
    CONSTRAINT tbl_group_g_name_key UNIQUE (g_name)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.tbl_groups
    OWNER to postgres;
COMMENT ON TABLE public.tbl_groups
    IS 'Each user can be assigned to several groups. These can be e.g. workgroups';
