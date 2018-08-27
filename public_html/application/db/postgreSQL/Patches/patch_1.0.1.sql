--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

ALTER TABLE ONLY public.street_lights_claims_data DROP CONSTRAINT street_light_data_claimid_fkey;
ALTER TABLE ONLY public.street_lights_claims_data DROP CONSTRAINT street_light_data_pkey;
ALTER TABLE public.street_lights_claims_data ALTER COLUMN id DROP DEFAULT;
DROP SEQUENCE public.street_light_data_id_seq;
DROP TABLE public.street_lights_claims_data;
SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: street_lights_claims_data; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE street_lights_claims_data (
    claimid bigint,
    piquete character varying(100),
    tulipa integer,
    portalampara integer,
    canasto integer,
    id bigint NOT NULL,
    fusible integer,
    lamp_125 integer,
    lamp_150 integer,
    lamp_250 integer,
    lamp_400 integer,
    ext_125 integer,
    ext_150 integer,
    ext_250 integer,
    ext_400 integer,
    int_125 integer,
    int_150 integer,
    int_250 integer,
    int_400 integer,
    morceto integer,
    espejo integer,
    columna integer,
    atrio integer,
    neutro integer,
    cable integer
);


ALTER TABLE public.street_lights_claims_data OWNER TO gdr;

--
-- Name: street_light_data_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE street_light_data_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.street_light_data_id_seq OWNER TO gdr;

--
-- Name: street_light_data_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE street_light_data_id_seq OWNED BY street_lights_claims_data.id;


--
-- Name: street_light_data_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('street_light_data_id_seq', 1, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY street_lights_claims_data ALTER COLUMN id SET DEFAULT nextval('street_light_data_id_seq'::regclass);


--
-- Data for Name: street_lights_claims_data; Type: TABLE DATA; Schema: public; Owner: gdr
--



--
-- Name: street_light_data_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY street_lights_claims_data
    ADD CONSTRAINT street_light_data_pkey PRIMARY KEY (id);


--
-- Name: street_light_data_claimid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY street_lights_claims_data
    ADD CONSTRAINT street_light_data_claimid_fkey FOREIGN KEY (claimid) REFERENCES claim(id);

    
--
-- Data for Name: origin; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO origin (name) VALUES ('origincauelectricity');


--
-- PostgreSQL database dump complete
--