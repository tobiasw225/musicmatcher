CREATE TABLE public.rel_user_in_group
(
    g_id bigint NOT NULL,
    u_id bigint NOT NULL,
    since timestamp with time zone,
    CONSTRAINT rel_user_in_group_pkey PRIMARY KEY (g_id, u_id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.rel_user_in_group
    OWNER to postgres;
