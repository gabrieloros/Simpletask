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
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY country ALTER COLUMN id SET DEFAULT nextval('country_id_seq'::regclass);


--
-- Data for Name: country; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO country (id, name) VALUES (1, 'Argentina');


--
-- Name: country_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_pkey PRIMARY KEY (id);
    


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
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY province ALTER COLUMN id SET DEFAULT nextval('province_id_seq'::regclass);


--
-- Data for Name: province; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO province (id, name, countryid) VALUES (1, 'Mendoza', 1);


--
-- Name: province_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY province
    ADD CONSTRAINT province_pkey PRIMARY KEY (id);


--
-- Name: province_countryid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY province
    ADD CONSTRAINT province_countryid_fkey FOREIGN KEY (countryid) REFERENCES country(id);


    
--
-- Name: location; Type: TABLE; Schema: public; Owner: gdr; Tablespace: 
--

CREATE TABLE location (
    id bigint NOT NULL,
    name character varying(100) NOT NULL,
    provinceid bigint NOT NULL
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
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY location ALTER COLUMN id SET DEFAULT nextval('location_id_seq'::regclass);


--
-- Data for Name: location; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO location (id, name, provinceid) VALUES (1, 'Godoy Cruz', 1);


--
-- Name: location_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY location
    ADD CONSTRAINT location_pkey PRIMARY KEY (id);


--
-- Name: location_provinceid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY location
    ADD CONSTRAINT location_provinceid_fkey FOREIGN KEY (provinceid) REFERENCES province(id);
    
    

--
-- Name: dependency
--
    
ALTER TABLE ONLY dependency
	ADD COLUMN locationid bigint NOT NULL;

--
-- Name: dependency_locationid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY dependency
	ADD CONSTRAINT dependency_locationid_fkey FOREIGN KEY (locationid) REFERENCES location (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;
	
--
-- Data for Name: dependency; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO dependency (id, name, locationid) VALUES (1, 'Electricidad', 1);

	 
--
-- Data for Name: menu; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO menu VALUES (7, 'geolocation_claims', NULL, 0, 40, 1, true);



--
-- Data for Name: menu_translation; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO menu_translation (menuid, languageid, title, body) VALUES (7, 1, 'Georreferenciación manual', NULL);



--
-- Data for Name: urlmapping; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO urlmapping VALUES ('reclamos?action=getGeoLocationPendingList', 7, 1);



--
-- Data for Name: usertypeaccess; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO usertypeaccess VALUES (1, 7);



--
-- Name: claim
--
    
ALTER TABLE ONLY claim
	ADD COLUMN piquete character varying(100) DEFAULT NULL::character varying,
  	ADD COLUMN latitude character varying(255) DEFAULT NULL::character varying,
  	ADD COLUMN longitude character varying(255) DEFAULT NULL::character varying
  	ADD COLUMN neighborhood character varying(255)
  	
  	
--
-- Name: systemuser
--
    
ALTER TABLE ONLY systemuser
	ADD COLUMN dependencyid bigint
	

--
-- Data for Name: systemuser; Type: TABLE DATA; Schema: public; Owner: gdr
--

UPDATE systemuser set dependencyid = 1 where id = 1

ALTER TABLE ONLY systemuser
	ALTER COLUMN dependencyid SET NOT NULL
	

--
-- Name: systemuser_dependencyid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY systemuser
	ADD CONSTRAINT systemuser_dependencyid_fkey FOREIGN KEY (dependencyid) REFERENCES dependency (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION;
	
	
--
-- Name: street_lights_claims_data
--
ALTER TABLE only street_lights_claims_data
	DROP COLUMN IF EXISTS piquete
	
	
	
--
-- Data for Name: telepromcause; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO telepromcause (id, name, causeid) VALUES (7, 'Sin Reclamo', 27);