--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: cause_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE cause_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cause_id_seq OWNER TO gdr;

--
-- Name: cause_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('cause_id_seq', 28, true);


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: cause; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE cause (
    id bigint DEFAULT nextval('cause_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL,
    subjectid bigint NOT NULL
);


ALTER TABLE public.cause OWNER TO gdr;

--
-- Name: claim_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE claim_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.claim_id_seq OWNER TO gdr;

--
-- Name: claim_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('claim_id_seq', 1, true);


--
-- Name: claim; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE claim (
    id bigint DEFAULT nextval('claim_id_seq'::regclass) NOT NULL,
    code character varying(50) NOT NULL,
    subjectid bigint,
    inputtypeid bigint,
    causeid bigint,
    originid bigint NOT NULL,
    dependencyid bigint,
    stateid bigint NOT NULL,
    entrydate date NOT NULL,
    closedate date,
    requestername character varying(100) NOT NULL,
    claimaddress character varying(255) NOT NULL,
    requesterphone numeric DEFAULT 0 NOT NULL,
    assigned boolean NOT NULL,
    piquete character varying(100) DEFAULT NULL::character varying,
    latitude character varying(255) DEFAULT NULL::character varying,
    longitude character varying(255) DEFAULT NULL::character varying,
    neighborhood character varying(255),
    regionid bigint
);


ALTER TABLE public.claim OWNER TO gdr;

--
-- Name: country; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE country (
    id bigint NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.country OWNER TO gdr;

--
-- Name: country_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE country_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.country_id_seq OWNER TO gdr;

--
-- Name: country_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE country_id_seq OWNED BY country.id;


--
-- Name: country_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('country_id_seq', 1, false);


--
-- Name: dependency_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE dependency_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dependency_id_seq OWNER TO gdr;

--
-- Name: dependency_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('dependency_id_seq', 1, true);


--
-- Name: dependency; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE dependency (
    id bigint DEFAULT nextval('dependency_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL,
    locationid bigint NOT NULL
);


ALTER TABLE public.dependency OWNER TO gdr;

--
-- Name: systemuser; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE systemuser (
    userlogin character varying(50) NOT NULL,
    userpassword character varying(512) NOT NULL,
    id bigint NOT NULL,
    usertypeid bigint NOT NULL,
    dependencyid bigint NOT NULL
);


ALTER TABLE public.systemuser OWNER TO gdr;

--
-- Name: gdr_user_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE gdr_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gdr_user_id_seq OWNER TO gdr;

--
-- Name: gdr_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE gdr_user_id_seq OWNED BY systemuser.id;


--
-- Name: gdr_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('gdr_user_id_seq', 2, true);


--
-- Name: importlog; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE importlog (
    id bigint NOT NULL,
    filename character varying(255) NOT NULL,
    claims integer DEFAULT 0 NOT NULL,
    importdate date NOT NULL
);


ALTER TABLE public.importlog OWNER TO gdr;

--
-- Name: importlog_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE importlog_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.importlog_id_seq OWNER TO gdr;

--
-- Name: importlog_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE importlog_id_seq OWNED BY importlog.id;


--
-- Name: importlog_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('importlog_id_seq', 1, false);


--
-- Name: inputtype_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE inputtype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.inputtype_id_seq OWNER TO gdr;

--
-- Name: inputtype_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('inputtype_id_seq', 4, true);


--
-- Name: inputtype; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE inputtype (
    id bigint DEFAULT nextval('inputtype_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.inputtype OWNER TO gdr;

--
-- Name: language; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE language (
    id bigint NOT NULL,
    lang_name character varying(50) NOT NULL,
    lang_iso character varying(2) NOT NULL
);


ALTER TABLE public.language OWNER TO gdr;

--
-- Name: language_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE language_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.language_id_seq OWNER TO gdr;

--
-- Name: language_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE language_id_seq OWNED BY language.id;


--
-- Name: language_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('language_id_seq', 2, true);


--
-- Name: literal; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE literal (
    id bigint NOT NULL,
    lit_key character varying(50) NOT NULL,
    lit_text text NOT NULL,
    lit_lang bigint NOT NULL
);


ALTER TABLE public.literal OWNER TO gdr;

--
-- Name: literal_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE literal_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.literal_id_seq OWNER TO gdr;

--
-- Name: literal_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE literal_id_seq OWNED BY literal.id;


--
-- Name: literal_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('literal_id_seq', 43, true);


--
-- Name: literalchanges; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE literalchanges (
    idliteralchanges bigint NOT NULL,
    languageid bigint NOT NULL
);


ALTER TABLE public.literalchanges OWNER TO gdr;

--
-- Name: literalchanges_idliteralchanges_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE literalchanges_idliteralchanges_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.literalchanges_idliteralchanges_seq OWNER TO gdr;

--
-- Name: literalchanges_idliteralchanges_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE literalchanges_idliteralchanges_seq OWNED BY literalchanges.idliteralchanges;


--
-- Name: literalchanges_idliteralchanges_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('literalchanges_idliteralchanges_seq', 1, false);


--
-- Name: location; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE location (
    id bigint NOT NULL,
    name character varying(100) NOT NULL,
    provinceid bigint NOT NULL,
    mapfile character varying(255),
    mapstyle character varying(255)
);


ALTER TABLE public.location OWNER TO gdr;

--
-- Name: location_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE location_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.location_id_seq OWNER TO gdr;

--
-- Name: location_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE location_id_seq OWNED BY location.id;


--
-- Name: location_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('location_id_seq', 1, false);


--
-- Name: menu; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE menu (
    id bigint NOT NULL,
    menukey character varying(50) NOT NULL,
    parentid bigint,
    menulevel integer NOT NULL,
    menuorder integer NOT NULL,
    moduleid bigint,
    visible boolean
);


ALTER TABLE public.menu OWNER TO gdr;

--
-- Name: menu_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.menu_id_seq OWNER TO gdr;

--
-- Name: menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE menu_id_seq OWNED BY menu.id;


--
-- Name: menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('menu_id_seq', 7, true);


--
-- Name: menu_translation; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE menu_translation (
    menuid bigint NOT NULL,
    languageid bigint NOT NULL,
    title character varying(255) NOT NULL,
    body text
);


ALTER TABLE public.menu_translation OWNER TO gdr;

--
-- Name: module; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE module (
    id bigint NOT NULL,
    modulename character varying(50) NOT NULL
);


ALTER TABLE public.module OWNER TO gdr;

--
-- Name: module_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE module_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.module_id_seq OWNER TO gdr;

--
-- Name: module_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE module_id_seq OWNED BY module.id;


--
-- Name: module_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('module_id_seq', 2, true);


--
-- Name: origin_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE origin_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.origin_id_seq OWNER TO gdr;

--
-- Name: origin_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('origin_id_seq', 4, true);


--
-- Name: origin; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE origin (
    id bigint DEFAULT nextval('origin_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.origin OWNER TO gdr;

--
-- Name: parameters; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE parameters (
    id bigint NOT NULL,
    paramname character varying(100) NOT NULL,
    paramvalue character varying(255) NOT NULL
);


ALTER TABLE public.parameters OWNER TO gdr;

--
-- Name: parameters_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE parameters_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parameters_id_seq OWNER TO gdr;

--
-- Name: parameters_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE parameters_id_seq OWNED BY parameters.id;


--
-- Name: parameters_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('parameters_id_seq', 4, true);


--
-- Name: province; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE province (
    id bigint NOT NULL,
    name character varying NOT NULL,
    countryid bigint NOT NULL
);


ALTER TABLE public.province OWNER TO gdr;

--
-- Name: province_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE province_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.province_id_seq OWNER TO gdr;

--
-- Name: province_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE province_id_seq OWNED BY province.id;


--
-- Name: province_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('province_id_seq', 1, false);


--
-- Name: region; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE region (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    locationid bigint NOT NULL,
    coordinates text NOT NULL,
    "position" text
);


ALTER TABLE public.region OWNER TO gdr;

--
-- Name: region_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE region_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.region_id_seq OWNER TO gdr;

--
-- Name: region_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE region_id_seq OWNED BY region.id;


--
-- Name: region_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('region_id_seq', 10, true);


--
-- Name: state_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE state_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.state_id_seq OWNER TO gdr;

--
-- Name: state_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('state_id_seq', 4, true);


--
-- Name: state; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE state (
    id bigint DEFAULT nextval('state_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.state OWNER TO gdr;

--
-- Name: street_lights_claims_data; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE street_lights_claims_data (
    claimid bigint,
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
-- Name: subject_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE subject_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.subject_id_seq OWNER TO gdr;

--
-- Name: subject_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('subject_id_seq', 32, true);


--
-- Name: subject; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE subject (
    id bigint DEFAULT nextval('subject_id_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.subject OWNER TO gdr;

--
-- Name: telepromcause; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE telepromcause (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    causeid bigint
);


ALTER TABLE public.telepromcause OWNER TO gdr;

--
-- Name: telepromclaim; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE telepromclaim (
    claimid bigint NOT NULL,
    datum character varying(255),
    datum1 character varying(255),
    datum2 character varying(255),
    datum3 character varying(255),
    datum4 character varying(255),
    datum5 character varying(255),
    datum6 character varying(255),
    datum7 character varying(255),
    datum8 character varying(255),
    datum9 character varying(255),
    lights integer,
    requesteraddress character varying(255),
    causeid bigint
);


ALTER TABLE public.telepromclaim OWNER TO gdr;

--
-- Name: telepromsubject_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE telepromsubject_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.telepromsubject_id_seq OWNER TO gdr;

--
-- Name: telepromsubject_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE telepromsubject_id_seq OWNED BY telepromcause.id;


--
-- Name: telepromsubject_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('telepromsubject_id_seq', 7, true);


--
-- Name: urlmapping; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE urlmapping (
    url character varying(50) NOT NULL,
    menuid bigint NOT NULL,
    languageid bigint NOT NULL
);


ALTER TABLE public.urlmapping OWNER TO gdr;

--
-- Name: usertype; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE usertype (
    id bigint NOT NULL,
    typename character varying(50) NOT NULL
);


ALTER TABLE public.usertype OWNER TO gdr;

--
-- Name: usertype_id_seq; Type: SEQUENCE; Schema: public; Owner: gdr
--

CREATE SEQUENCE usertype_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usertype_id_seq OWNER TO gdr;

--
-- Name: usertype_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: gdr
--

ALTER SEQUENCE usertype_id_seq OWNED BY usertype.id;


--
-- Name: usertype_id_seq; Type: SEQUENCE SET; Schema: public; Owner: gdr
--

SELECT pg_catalog.setval('usertype_id_seq', 3, true);


--
-- Name: usertypeaccess; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE usertypeaccess (
    usertypeid bigint NOT NULL,
    menuid bigint NOT NULL
);


ALTER TABLE public.usertypeaccess OWNER TO gdr;

--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY country ALTER COLUMN id SET DEFAULT nextval('country_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY importlog ALTER COLUMN id SET DEFAULT nextval('importlog_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY language ALTER COLUMN id SET DEFAULT nextval('language_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY literal ALTER COLUMN id SET DEFAULT nextval('literal_id_seq'::regclass);


--
-- Name: idliteralchanges; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY literalchanges ALTER COLUMN idliteralchanges SET DEFAULT nextval('literalchanges_idliteralchanges_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY location ALTER COLUMN id SET DEFAULT nextval('location_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY menu ALTER COLUMN id SET DEFAULT nextval('menu_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY module ALTER COLUMN id SET DEFAULT nextval('module_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY parameters ALTER COLUMN id SET DEFAULT nextval('parameters_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY province ALTER COLUMN id SET DEFAULT nextval('province_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY region ALTER COLUMN id SET DEFAULT nextval('region_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY street_lights_claims_data ALTER COLUMN id SET DEFAULT nextval('street_light_data_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY systemuser ALTER COLUMN id SET DEFAULT nextval('gdr_user_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY telepromcause ALTER COLUMN id SET DEFAULT nextval('telepromsubject_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY usertype ALTER COLUMN id SET DEFAULT nextval('usertype_id_seq'::regclass);


--
-- Data for Name: cause; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO cause (id, name, subjectid) VALUES (1, 'HIERRO', 11);
INSERT INTO cause (id, name, subjectid) VALUES (2, 'MADERA', 11);
INSERT INTO cause (id, name, subjectid) VALUES (3, 'BACHEO', 5);
INSERT INTO cause (id, name, subjectid) VALUES (4, 'ESCOMBROS', 5);
INSERT INTO cause (id, name, subjectid) VALUES (5, 'LIMPIEZA', 5);
INSERT INTO cause (id, name, subjectid) VALUES (6, 'REPARACIÓN CALLE', 5);
INSERT INTO cause (id, name, subjectid) VALUES (7, 'RETIRO DE ANIMAL MUERTO', 5);
INSERT INTO cause (id, name, subjectid) VALUES (8, 'ROTURA', 5);
INSERT INTO cause (id, name, subjectid) VALUES (9, 'ARREGLO', 4);
INSERT INTO cause (id, name, subjectid) VALUES (10, 'EMBANQUE', 4);
INSERT INTO cause (id, name, subjectid) VALUES (11, 'LIMPIEZA', 4);
INSERT INTO cause (id, name, subjectid) VALUES (12, 'ARREGLO DE FAROLAS', 1);
INSERT INTO cause (id, name, subjectid) VALUES (13, 'REPOSICIÓN DE LAMPARA', 1);
INSERT INTO cause (id, name, subjectid) VALUES (14, 'ALUMBRADO', 10);
INSERT INTO cause (id, name, subjectid) VALUES (15, 'MANTENIMIENTO', 10);
INSERT INTO cause (id, name, subjectid) VALUES (16, 'ARBOL CAIDO', 3);
INSERT INTO cause (id, name, subjectid) VALUES (17, 'CORTE DE RAMAS', 3);
INSERT INTO cause (id, name, subjectid) VALUES (18, 'MATERIAL DE CONSTRUCCIÓN', 30);
INSERT INTO cause (id, name, subjectid) VALUES (19, 'CAJEO', 2);
INSERT INTO cause (id, name, subjectid) VALUES (20, 'INEFICIENCIA EN SERVICIO', 2);
INSERT INTO cause (id, name, subjectid) VALUES (21, 'REFUGIOS', 12);
INSERT INTO cause (id, name, subjectid) VALUES (22, 'CEMENTERIO', 26);
INSERT INTO cause (id, name, subjectid) VALUES (23, 'ANIMALES ABANDONADOS', 8);
INSERT INTO cause (id, name, subjectid) VALUES (24, 'DESRRATIZACION', 8);
INSERT INTO cause (id, name, subjectid) VALUES (25, 'ANIMALES PERMITIDOS POR DOMICILIO', 8);
INSERT INTO cause (id, name, subjectid) VALUES (26, 'ESTACIONAMIENTO', 29);
INSERT INTO cause (id, name, subjectid) VALUES (27, 'OTROS', 31);


--
-- Data for Name: claim; Type: TABLE DATA; Schema: public; Owner: gdr
--



--
-- Data for Name: country; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO country (id, name) VALUES (1, 'Argentina');


--
-- Data for Name: dependency; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO dependency (id, name, locationid) VALUES (1, 'Electricidad', 1);


--
-- Data for Name: importlog; Type: TABLE DATA; Schema: public; Owner: gdr
--



--
-- Data for Name: inputtype; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO inputtype (id, name) VALUES (1, 'telefonico');
INSERT INTO inputtype (id, name) VALUES (2, 'personal');
INSERT INTO inputtype (id, name) VALUES (3, 'teleprom');


--
-- Data for Name: language; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO language (id, lang_name, lang_iso) VALUES (1, 'Español', 'es');

--
-- Data for Name: location; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO location (id, name, provinceid, mapfile, mapstyle) VALUES (1, 'Godoy Cruz', 1, '/maps/godoy_cruz.png', 'width: 1024px; height: 595px;');


--
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO menu (id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES (2, '404', NULL, 0, 0, NULL, false);
INSERT INTO menu (id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES (3, '401', NULL, 0, 0, NULL, false);
INSERT INTO menu (id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES (1, 'home', NULL, 0, 0, NULL, false);
INSERT INTO menu (id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES (6, 'import', NULL, 0, 10, 1, true);
INSERT INTO menu (id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES (4, 'claims', NULL, 0, 20, 1, true);
INSERT INTO menu (id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES (5, 'automatic_claims', NULL, 0, 30, 1, true);
INSERT INTO menu (id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES (7, 'geolocation_claims', NULL, 0, 40, 1, true);
INSERT INTO menu (id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES (8, 'stats', NULL, 0, 50, 1, true);


--
-- Data for Name: menu_translation; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO menu_translation (menuid, languageid, title, body) VALUES (1, 1, 'Inicio', NULL);
INSERT INTO menu_translation (menuid, languageid, title, body) VALUES (2, 1, '404', NULL);
INSERT INTO menu_translation (menuid, languageid, title, body) VALUES (3, 1, '401', NULL);
INSERT INTO menu_translation (menuid, languageid, title, body) VALUES (4, 1, 'Reclamos', NULL);
INSERT INTO menu_translation (menuid, languageid, title, body) VALUES (5, 1, 'Reclamos automáticos', NULL);
INSERT INTO menu_translation (menuid, languageid, title, body) VALUES (6, 1, 'Importar', NULL);
INSERT INTO menu_translation (menuid, languageid, title, body) VALUES (7, 1, 'Georreferenciación manual', NULL);
INSERT INTO menu_translation (menuid, languageid, title, body) VALUES (8, 1, 'Estadísticas', NULL);


--
-- Data for Name: module; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO module (id, modulename) VALUES (1, 'claims');


--
-- Data for Name: origin; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO origin (id, name) VALUES (1, 'origincau');
INSERT INTO origin (id, name) VALUES (2, 'originteleprom');
INSERT INTO origin (id, name) VALUES (3, 'origincauelectricity');


--
-- Data for Name: parameters; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO parameters (id, paramname, paramvalue) VALUES (1, 'site_title', 'Gestión de Reclamos');
INSERT INTO parameters (id, paramname, paramvalue) VALUES (2, 'menu_split_level_1', '2');
INSERT INTO parameters (id, paramname, paramvalue) VALUES (4, 'pager_max_pages', '20');
INSERT INTO parameters (id, paramname, paramvalue) VALUES (3, 'page_size', '20');


--
-- Data for Name: province; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO province (id, name, countryid) VALUES (1, 'Mendoza', 1);


--
-- Data for Name: region; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (2, 'Villa Hipódromo', 1, '-32.901277747857776,-68.86594377589063;-32.90268298687957,-68.86735998225049;-32.9084838657794,-68.86555753779248;-32.909636790224596,-68.86448465418653;-32.92228194465211,-68.86354051661328;-32.92339866633772,-68.8640125853999;-32.923614804390986,-68.86461340021924;-32.924587419097385,-68.86435590815381;-32.92239001510858,-68.85972105097608;-32.92080496851948,-68.85603033137158;-32.92152544776131,-68.85418497156934;-32.921381352382205,-68.85203920304775;-32.91464463153056,-68.85079465806484;-32.91136614874146,-68.85053716599941;-32.908159603074104,-68.8515242189169;-32.90246679771219,-68.85212503373623;-32.90185425887188,-68.85667406022549;-32.901277747857776,-68.86594377589063', 'position: absolute; top: 78px; right: 607px; bottom: 146px; left: 432px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (3, 'Centro', 1, '-32.90243076613298,-68.85208211839199;-32.906250031943074,-68.85169588029385;-32.91100586850291,-68.85062299668789;-32.915112976302645,-68.85079465806484;-32.92130930460467,-68.85208211839199;-32.92628046363874,-68.85238252580166;-32.93395278910634,-68.85109506547451;-32.9338807515657,-68.85015092790127;-32.93589778052644,-68.85062299668789;-32.93701433035011,-68.85053716599941;-32.93737450470561,-68.8478334993124;-32.937806711996,-68.84684644639492;-32.93820290015665,-68.84079538285732;-32.925704111687246,-68.83731923997402;-32.92393901048114,-68.8368471711874;-32.92127328069403,-68.83761964738369;-32.91738261201739,-68.83710466325283;-32.91320355515077,-68.83770547807217;-32.91053750200095,-68.83856378495693;-32.90823166155583,-68.83787713944912;-32.906141941779715,-68.8383062928915;-32.90434041962909,-68.83779130876064;-32.90243076613298,-68.85208211839199', 'position: absolute; top: 172px; right: 701px; bottom: 241px; left: 525px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (4, 'San Francisco del Monte', 1, '-32.928946038180065,-68.83843504154356;-32.92599228373522,-68.83277021610411;-32.921957728093524,-68.82564626896055;-32.92772132269479,-68.80401693546446;-32.936438046132096,-68.80848013126524;-32.93586176035728,-68.81174169742735;-32.94392941948555,-68.81568990909727;-32.94076006974963,-68.83019529544981;-32.93831094896697,-68.84100996219786;-32.928946038180065,-68.83843504154356', 'position: absolute; top: 266px; right: 861px; bottom: 335px; left: 685px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (7, 'Trapiche', 1, '-32.93705034785159,-68.8504084199667;-32.94223671493584,-68.84963594377041;-32.95127611368266,-68.85508619248867;-32.955813471372984,-68.85727487504482;-32.9588382470895,-68.86238180100918;-32.958082062866495,-68.87250982224941;-32.95268055881104,-68.8677891343832;-32.95192432189946,-68.86907659471035;-32.94947551036135,-68.86753164231777;-32.94997968298847,-68.87444101274014;-32.943677318476965,-68.8758572191;-32.94014779811096,-68.86766038835049;-32.93888722098082,-68.86547170579433;-32.93831095116508,-68.86302553117275;-32.93705034785159,-68.8504084199667', 'position: absolute; top: 421px; right: 467px; bottom: 490px; left: 291px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (8, 'Villa Marini', 1, '-32.93885120422735,-68.86551462113857;-32.941516404363604,-68.86259637773037;-32.93820290015658,-68.86281095445156;-32.937986797743534,-68.8582619279623;-32.933808713966314,-68.85912023484707;-32.930026657609226,-68.8584765046835;-32.922137848306065,-68.85980688035488;-32.923650825149814,-68.8637550920248;-32.924515371731495,-68.86418424546719;-32.924371281221156,-68.86457048356533;-32.923975031107844,-68.86474214494228;-32.92635250517004,-68.8752993196249;-32.92847776881244,-68.8793333619833;-32.93762662588163,-68.87748800218105;-32.94364130367449,-68.8762005418539;-32.94194859141107,-68.87156568467617;-32.93885120422735,-68.86551462113857', 'position: absolute; top: 290px; right: 467px; bottom: 359px; left: 326px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (6, 'Benegas', 1, '-32.93705034565346,-68.85036550462246;-32.94223671273783,-68.8495071977377;-32.95138414651779,-68.8550003618002;-32.95592149866222,-68.85723195970058;-32.95837013161209,-68.86100850999355;-32.95887425350303,-68.85259710252285;-32.95584947901896,-68.8501938432455;-32.95203235394235,-68.84607397019863;-32.94432558021496,-68.84169660508633;-32.938202897958476,-68.84100995957851;-32.93705034565346,-68.85036550462246', 'position: absolute; top: 364px; right: 688px; bottom: 433px; left: 512px; width: 174 px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (1, 'Villa del parque', 1, '-32.90133179592478,-68.89358125758008;-32.903637816055706,-68.89413915705518;-32.90432240422235,-68.89122091364698;-32.904718742320874,-68.8845261199458;-32.90540332213091,-68.88504110407666;-32.90612392673952,-68.88594232630567;-32.90688055526693,-68.88555608820752;-32.90691658503553,-68.88461195063428;-32.907889383245845,-68.88341032099561;-32.90889819973015,-68.88319574427442;-32.90976289042492,-68.88662897181348;-32.91296937802298,-68.88572774958448;-32.91368992105168,-68.884740696667;-32.913798002000114,-68.88229452204541;-32.9205708115029,-68.88079248499707;-32.92129129265111,-68.88212286066846;-32.92622643080277,-68.88032041621045;-32.92993660887607,-68.8882168395503;-32.92763127381343,-68.89044843745069;-32.92845976051671,-68.8946112258418;-32.93267411623667,-68.89268003535108;-32.93253003901395,-68.89152132105664;-32.92968446577952,-68.88405405115918;-32.9265866490859,-68.87495599818067;-32.92565007849931,-68.86821828913526;-32.92424520403085,-68.86388383936719;-32.91631985333296,-68.86409841608838;-32.90933054613319,-68.864570484875;-32.908682025736894,-68.86542879175977;-32.90298925396325,-68.8674887282832;-32.90122369975779,-68.86611543726758;-32.899602240870585,-68.87705885004834;-32.89938604418266,-68.8871010406001;-32.9001427302815,-68.8922508819087;-32.90133179592478,-68.89358125758008', 'position: absolute; top: 78px; right: 398px; bottom: 146px; left: 224px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (5, 'Las Tortugas', 1, '-32.94392941948555,-68.81568990909727;-32.947674868164576,-68.81809316837462;-32.9491874082284,-68.81929479801329;-32.94911538309792,-68.82015310489805;-32.95372487313986,-68.82238470279844;-32.953796894514454,-68.8265904065338;-32.96006252943831,-68.82933698856505;-32.959774464012284,-68.83731924259337;-32.9555974098054,-68.83543096744688;-32.949763607159746,-68.83251272403868;-32.94076006974966,-68.83036695682677;-32.941984604705034,-68.82358633243712;-32.94392941948555,-68.81568990909727', 'position: absolute; top: 463px; right: 743px; bottom: 532px; left: 567px; width: 174px; height: 72px;');


--
-- Data for Name: state; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO state (id, name) VALUES (1, 'pending');
INSERT INTO state (id, name) VALUES (2, 'closed');
INSERT INTO state (id, name) VALUES (3, 'cancelled');


--
-- Data for Name: street_lights_claims_data; Type: TABLE DATA; Schema: public; Owner: gdr
--



--
-- Data for Name: subject; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO subject (id, name) VALUES (1, 'ELECTRICIDAD');
INSERT INTO subject (id, name) VALUES (2, 'RECOLECCION');
INSERT INTO subject (id, name) VALUES (3, 'FORESTALES');
INSERT INTO subject (id, name) VALUES (4, 'CUNETAS');
INSERT INTO subject (id, name) VALUES (5, 'CALLES');
INSERT INTO subject (id, name) VALUES (6, 'INSPECCION DE OBRAS PARTICULARES');
INSERT INTO subject (id, name) VALUES (7, 'PERSONAL');
INSERT INTO subject (id, name) VALUES (8, 'ZOONOSIS');
INSERT INTO subject (id, name) VALUES (9, 'INSPECTORES DE COMERCIO');
INSERT INTO subject (id, name) VALUES (10, 'ESPACIOS VERDES Y PLAZAS');
INSERT INTO subject (id, name) VALUES (11, 'BOCAS DE TORMENTA');
INSERT INTO subject (id, name) VALUES (12, 'REPARACIONES VARIAS');
INSERT INTO subject (id, name) VALUES (13, 'INSPECTORES DE CONTROL AMBIENTAL');
INSERT INTO subject (id, name) VALUES (14, 'BOLETAS DE COMERCIO');
INSERT INTO subject (id, name) VALUES (15, 'BOLETAS POR TASAS');
INSERT INTO subject (id, name) VALUES (16, 'BOLETAS POR TASAS VARIOS');
INSERT INTO subject (id, name) VALUES (17, 'CARTELERIA');
INSERT INTO subject (id, name) VALUES (18, 'COMERCIO');
INSERT INTO subject (id, name) VALUES (19, 'ESCOMBROS');
INSERT INTO subject (id, name) VALUES (20, 'EXPEDIENTES');
INSERT INTO subject (id, name) VALUES (21, 'LOTES');
INSERT INTO subject (id, name) VALUES (22, 'PLANIFICACION URBANA');
INSERT INTO subject (id, name) VALUES (23, 'SALUD');
INSERT INTO subject (id, name) VALUES (24, 'SISTEMAS');
INSERT INTO subject (id, name) VALUES (25, 'SOLICITUD DE MATERIAL');
INSERT INTO subject (id, name) VALUES (26, 'VARIOS');
INSERT INTO subject (id, name) VALUES (27, 'VIVIENDAS');
INSERT INTO subject (id, name) VALUES (28, 'LIMPIEZA EN PROPIEDAD PRIVADA- EMPLAZAMIENTO');
INSERT INTO subject (id, name) VALUES (29, 'POLICIA MUNICIPAL');
INSERT INTO subject (id, name) VALUES (30, 'INSPECTORES DE CONTROL DE GESTION');
INSERT INTO subject (id, name) VALUES (31, 'OTROS');


--
-- Data for Name: systemuser; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO systemuser (userlogin, userpassword, id, usertypeid, dependencyid) VALUES ('gabo', '$1$rB2.qx5.$NAPgitQgnfQyudLgJuYSq/ ', 1, 1, 1);


--
-- Data for Name: telepromcause; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO telepromcause (id, name, causeid) VALUES (1, 'Alumbrado Público', 14);
INSERT INTO telepromcause (id, name, causeid) VALUES (2, 'Árbol', 16);
INSERT INTO telepromcause (id, name, causeid) VALUES (3, 'Otros', 27);
INSERT INTO telepromcause (id, name, causeid) VALUES (4, 'Cuelga', 27);
INSERT INTO telepromcause (id, name, causeid) VALUES (5, 'Contestador', 27);
INSERT INTO telepromcause (id, name, causeid) VALUES (6, 'No contesta', 27);
INSERT INTO telepromcause (id, name, causeid) VALUES (7, 'Sin Reclamo', 27);


--
-- Data for Name: telepromclaim; Type: TABLE DATA; Schema: public; Owner: gdr
--



--
-- Data for Name: urlmapping; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO urlmapping (url, menuid, languageid) VALUES ('inicio', 1, 1);
INSERT INTO urlmapping (url, menuid, languageid) VALUES ('404', 2, 1);
INSERT INTO urlmapping (url, menuid, languageid) VALUES ('401', 3, 1);
INSERT INTO urlmapping (url, menuid, languageid) VALUES ('reclamos', 4, 1);
INSERT INTO urlmapping (url, menuid, languageid) VALUES ('reclamos?action=getPendingTelepromClaimsList', 5, 1);
INSERT INTO urlmapping (url, menuid, languageid) VALUES ('reclamos?action=import', 6, 1);
INSERT INTO urlmapping (url, menuid, languageid) VALUES ('reclamos?action=getGeoLocationPendingList', 7, 1);
INSERT INTO urlmapping (url, menuid, languageid) VALUES ('reclamos?action=getClaimsStats', 8, 1);


--
-- Data for Name: usertype; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO usertype (id, typename) VALUES (1, 'Administrador');


--
-- Data for Name: usertypeaccess; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO usertypeaccess (usertypeid, menuid) VALUES (1, 1);
INSERT INTO usertypeaccess (usertypeid, menuid) VALUES (1, 2);
INSERT INTO usertypeaccess (usertypeid, menuid) VALUES (1, 3);
INSERT INTO usertypeaccess (usertypeid, menuid) VALUES (1, 4);
INSERT INTO usertypeaccess (usertypeid, menuid) VALUES (1, 5);
INSERT INTO usertypeaccess (usertypeid, menuid) VALUES (1, 6);
INSERT INTO usertypeaccess (usertypeid, menuid) VALUES (1, 7);
INSERT INTO usertypeaccess (usertypeid, menuid) VALUES (1, 8);


--
-- Name: country_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_pkey PRIMARY KEY (id);


--
-- Name: gdr_user_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY systemuser
    ADD CONSTRAINT gdr_user_pkey PRIMARY KEY (id);


--
-- Name: language_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY language
    ADD CONSTRAINT language_pkey PRIMARY KEY (id);


--
-- Name: literal_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY literal
    ADD CONSTRAINT literal_pkey PRIMARY KEY (id);


--
-- Name: literalchanges_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY literalchanges
    ADD CONSTRAINT literalchanges_pkey PRIMARY KEY (idliteralchanges);


--
-- Name: location_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY location
    ADD CONSTRAINT location_pkey PRIMARY KEY (id);


--
-- Name: menu_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (id);


--
-- Name: menu_translation_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY menu_translation
    ADD CONSTRAINT menu_translation_pkey PRIMARY KEY (menuid, languageid);


--
-- Name: module_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY module
    ADD CONSTRAINT module_pkey PRIMARY KEY (id);


--
-- Name: parameters_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY parameters
    ADD CONSTRAINT parameters_pkey PRIMARY KEY (id);


--
-- Name: pk_cause; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY cause
    ADD CONSTRAINT pk_cause PRIMARY KEY (id);


--
-- Name: pk_claim; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY claim
    ADD CONSTRAINT pk_claim PRIMARY KEY (id);


--
-- Name: pk_claimorigin; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY origin
    ADD CONSTRAINT pk_claimorigin PRIMARY KEY (id);


--
-- Name: pk_claimstate; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY state
    ADD CONSTRAINT pk_claimstate PRIMARY KEY (id);


--
-- Name: pk_dependency; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY dependency
    ADD CONSTRAINT pk_dependency PRIMARY KEY (id);


--
-- Name: pk_inputtype; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY inputtype
    ADD CONSTRAINT pk_inputtype PRIMARY KEY (id);


--
-- Name: pk_subject; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY subject
    ADD CONSTRAINT pk_subject PRIMARY KEY (id);


--
-- Name: province_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY province
    ADD CONSTRAINT province_pkey PRIMARY KEY (id);


--
-- Name: region_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY region
    ADD CONSTRAINT region_pkey PRIMARY KEY (id);


--
-- Name: street_light_data_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY street_lights_claims_data
    ADD CONSTRAINT street_light_data_pkey PRIMARY KEY (id);


--
-- Name: telepromclaim_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY telepromclaim
    ADD CONSTRAINT telepromclaim_pkey PRIMARY KEY (claimid);


--
-- Name: telepromsubject_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY telepromcause
    ADD CONSTRAINT telepromsubject_pkey PRIMARY KEY (id);


--
-- Name: uq_cause_id; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY cause
    ADD CONSTRAINT uq_cause_id UNIQUE (id);


--
-- Name: uq_claim_id; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY claim
    ADD CONSTRAINT uq_claim_id UNIQUE (id);


--
-- Name: uq_claimstate_name; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY state
    ADD CONSTRAINT uq_claimstate_name UNIQUE (name);


--
-- Name: uq_code_entrydate; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY claim
    ADD CONSTRAINT uq_code_entrydate UNIQUE (code, entrydate);


--
-- Name: uq_inputtype_id; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY inputtype
    ADD CONSTRAINT uq_inputtype_id UNIQUE (id);


--
-- Name: uq_inputtype_name; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY inputtype
    ADD CONSTRAINT uq_inputtype_name UNIQUE (name);


--
-- Name: uq_origin_id; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY origin
    ADD CONSTRAINT uq_origin_id UNIQUE (id);


--
-- Name: uq_state_id; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY state
    ADD CONSTRAINT uq_state_id UNIQUE (id);


--
-- Name: uq_subject_id; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY subject
    ADD CONSTRAINT uq_subject_id UNIQUE (id);


--
-- Name: urlmapping_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY urlmapping
    ADD CONSTRAINT urlmapping_pkey PRIMARY KEY (url, menuid, languageid);


--
-- Name: user_username_key; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY systemuser
    ADD CONSTRAINT user_username_key UNIQUE (userlogin);


--
-- Name: usertype_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY usertype
    ADD CONSTRAINT usertype_pkey PRIMARY KEY (id);


--
-- Name: usertypeaccess_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY usertypeaccess
    ADD CONSTRAINT usertypeaccess_pkey PRIMARY KEY (usertypeid, menuid);


--
-- Name: cause_subjectid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY cause
    ADD CONSTRAINT cause_subjectid_fkey FOREIGN KEY (subjectid) REFERENCES subject(id);


--
-- Name: claim_regionid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY claim
    ADD CONSTRAINT claim_regionid_fkey FOREIGN KEY (regionid) REFERENCES region(id);


--
-- Name: dependency_locationid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY dependency
    ADD CONSTRAINT dependency_locationid_fkey FOREIGN KEY (locationid) REFERENCES location(id);


--
-- Name: fk_claim_cause; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY claim
    ADD CONSTRAINT fk_claim_cause FOREIGN KEY (causeid) REFERENCES cause(id);


--
-- Name: fk_claim_claimorigin; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY claim
    ADD CONSTRAINT fk_claim_claimorigin FOREIGN KEY (originid) REFERENCES origin(id);


--
-- Name: fk_claim_claimstate; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY claim
    ADD CONSTRAINT fk_claim_claimstate FOREIGN KEY (stateid) REFERENCES state(id);


--
-- Name: fk_claim_dependency; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY claim
    ADD CONSTRAINT fk_claim_dependency FOREIGN KEY (dependencyid) REFERENCES dependency(id);


--
-- Name: fk_claim_inputtype; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY claim
    ADD CONSTRAINT fk_claim_inputtype FOREIGN KEY (inputtypeid) REFERENCES inputtype(id);


--
-- Name: fk_claim_subject; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY claim
    ADD CONSTRAINT fk_claim_subject FOREIGN KEY (subjectid) REFERENCES subject(id);


--
-- Name: fk_telepromclaim_claim; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY telepromclaim
    ADD CONSTRAINT fk_telepromclaim_claim FOREIGN KEY (claimid) REFERENCES claim(id);


--
-- Name: gdr_user_usertypeid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY systemuser
    ADD CONSTRAINT gdr_user_usertypeid_fkey FOREIGN KEY (usertypeid) REFERENCES usertype(id);


--
-- Name: literal_lit_lang_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY literal
    ADD CONSTRAINT literal_lit_lang_fkey FOREIGN KEY (lit_lang) REFERENCES language(id);


--
-- Name: literalchanges_languageid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY literalchanges
    ADD CONSTRAINT literalchanges_languageid_fkey FOREIGN KEY (languageid) REFERENCES language(id);


--
-- Name: location_provinceid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY location
    ADD CONSTRAINT location_provinceid_fkey FOREIGN KEY (provinceid) REFERENCES province(id);


--
-- Name: menu_moduleid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_moduleid_fkey FOREIGN KEY (moduleid) REFERENCES module(id);


--
-- Name: menu_parentid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_parentid_fkey FOREIGN KEY (parentid) REFERENCES menu(id);


--
-- Name: menu_translation_languageid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY menu_translation
    ADD CONSTRAINT menu_translation_languageid_fkey FOREIGN KEY (languageid) REFERENCES language(id);


--
-- Name: menu_translation_menuid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY menu_translation
    ADD CONSTRAINT menu_translation_menuid_fkey FOREIGN KEY (menuid) REFERENCES menu(id);


--
-- Name: province_countryid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY province
    ADD CONSTRAINT province_countryid_fkey FOREIGN KEY (countryid) REFERENCES country(id);


--
-- Name: region_locationid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY region
    ADD CONSTRAINT region_locationid_fkey FOREIGN KEY (locationid) REFERENCES location(id);


--
-- Name: street_light_data_claimid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY street_lights_claims_data
    ADD CONSTRAINT street_light_data_claimid_fkey FOREIGN KEY (claimid) REFERENCES claim(id);


--
-- Name: systemuser_dependencyid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY systemuser
    ADD CONSTRAINT systemuser_dependencyid_fkey FOREIGN KEY (dependencyid) REFERENCES dependency(id);


--
-- Name: telepromcause_causeid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY telepromcause
    ADD CONSTRAINT telepromcause_causeid_fkey FOREIGN KEY (causeid) REFERENCES cause(id);


--
-- Name: telepromclaim_causeid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY telepromclaim
    ADD CONSTRAINT telepromclaim_causeid_fkey FOREIGN KEY (causeid) REFERENCES telepromcause(id);


--
-- Name: urlmapping_languageid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY urlmapping
    ADD CONSTRAINT urlmapping_languageid_fkey FOREIGN KEY (languageid) REFERENCES language(id);


--
-- Name: urlmapping_menuid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY urlmapping
    ADD CONSTRAINT urlmapping_menuid_fkey FOREIGN KEY (menuid) REFERENCES menu(id);


--
-- Name: usertypeaccess_menuid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY usertypeaccess
    ADD CONSTRAINT usertypeaccess_menuid_fkey FOREIGN KEY (menuid) REFERENCES menu(id);


--
-- Name: usertypeaccess_usertypeid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY usertypeaccess
    ADD CONSTRAINT usertypeaccess_usertypeid_fkey FOREIGN KEY (usertypeid) REFERENCES usertype(id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- Name: literal; Type: ACL; Schema: public; Owner: gdr
--

REVOKE ALL ON TABLE literal FROM PUBLIC;
REVOKE ALL ON TABLE literal FROM gdr;
GRANT ALL ON TABLE literal TO gdr;


--
-- PostgreSQL database dump complete
--

