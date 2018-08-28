--
-- Name: region; 
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
-- Name: id; Type: DEFAULT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY region ALTER COLUMN id SET DEFAULT nextval('region_id_seq'::regclass);

--
-- Name: region_pkey; Type: CONSTRAINT; Schema: public; Owner: gdr; Tablespace: 
--

ALTER TABLE ONLY region
    ADD CONSTRAINT region_pkey PRIMARY KEY (id);

--
-- Name: region_locationid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: gdr
--

ALTER TABLE ONLY region
    ADD CONSTRAINT region_locationid_fkey FOREIGN KEY (locationid) REFERENCES location(id);
    

--
-- Name: claim
--
    
ALTER TABLE ONLY claim
	ADD COLUMN regionid bigint;
  	
ALTER TABLE ONLY claim
    ADD CONSTRAINT claim_regionid_fkey FOREIGN KEY (regionid) REFERENCES region(id);
    

--
-- Name: location
--

ALTER TABLE ONLY location
    ADD COLUMN mapfile character varying(255),
    ADD COLUMN mapstyle character varying(255)
    ;
    
UPDATE location
	SET mapfile = '/maps/godoy_cruz.png',
		mapstyle = 'width: 1024px; height: 595px;'
		WHERE id = 1;
		
		
--
-- Data for Name: menu;
--
		
INSERT INTO menu (id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES (8, 'stats', NULL, 0, 50, 1, true);


--
-- Data for Name: menu_translation;
--

INSERT INTO menu_translation (menuid, languageid, title, body) VALUES (8, 1, 'Estadísticas', NULL);


--
-- Data for Name: urlmapping; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO urlmapping (url, menuid, languageid) VALUES ('reclamos?action=getClaimsStats', 8, 1);


--
-- Data for Name: usertypeaccess; Type: TABLE DATA; Schema: public; Owner: gdr
--

INSERT INTO usertypeaccess (usertypeid, menuid) VALUES (1, 8);


--
-- Data for Name: region;
--

INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (2, 'Villa Hipódromo', 1, '-32.901277747857776,-68.86594377589063;-32.90268298687957,-68.86735998225049;-32.9084838657794,-68.86555753779248;-32.909636790224596,-68.86448465418653;-32.92228194465211,-68.86354051661328;-32.92339866633772,-68.8640125853999;-32.923614804390986,-68.86461340021924;-32.924587419097385,-68.86435590815381;-32.92239001510858,-68.85972105097608;-32.92080496851948,-68.85603033137158;-32.92152544776131,-68.85418497156934;-32.921381352382205,-68.85203920304775;-32.91464463153056,-68.85079465806484;-32.91136614874146,-68.85053716599941;-32.908159603074104,-68.8515242189169;-32.90246679771219,-68.85212503373623;-32.90185425887188,-68.85667406022549;-32.901277747857776,-68.86594377589063', 'position: absolute; top: 78px; right: 607px; bottom: 146px; left: 432px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (3, 'Centro', 1, '-32.90243076613298,-68.85208211839199;-32.906250031943074,-68.85169588029385;-32.91100586850291,-68.85062299668789;-32.915112976302645,-68.85079465806484;-32.92130930460467,-68.85208211839199;-32.92628046363874,-68.85238252580166;-32.93395278910634,-68.85109506547451;-32.9338807515657,-68.85015092790127;-32.93589778052644,-68.85062299668789;-32.93701433035011,-68.85053716599941;-32.93737450470561,-68.8478334993124;-32.937806711996,-68.84684644639492;-32.93820290015665,-68.84079538285732;-32.925704111687246,-68.83731923997402;-32.92393901048114,-68.8368471711874;-32.92127328069403,-68.83761964738369;-32.91738261201739,-68.83710466325283;-32.91320355515077,-68.83770547807217;-32.91053750200095,-68.83856378495693;-32.90823166155583,-68.83787713944912;-32.906141941779715,-68.8383062928915;-32.90434041962909,-68.83779130876064;-32.90243076613298,-68.85208211839199', 'position: absolute; top: 172px; right: 701px; bottom: 241px; left: 525px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (4, 'San Francisco del Monte', 1, '-32.928946038180065,-68.83843504154356;-32.92599228373522,-68.83277021610411;-32.921957728093524,-68.82564626896055;-32.92772132269479,-68.80401693546446;-32.936438046132096,-68.80848013126524;-32.93586176035728,-68.81174169742735;-32.94392941948555,-68.81568990909727;-32.94076006974963,-68.83019529544981;-32.93831094896697,-68.84100996219786;-32.928946038180065,-68.83843504154356', 'position: absolute; top: 266px; right: 861px; bottom: 335px; left: 685px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (7, 'Trapiche', 1, '-32.93705034785159,-68.8504084199667;-32.94223671493584,-68.84963594377041;-32.95127611368266,-68.85508619248867;-32.955813471372984,-68.85727487504482;-32.9588382470895,-68.86238180100918;-32.958082062866495,-68.87250982224941;-32.95268055881104,-68.8677891343832;-32.95192432189946,-68.86907659471035;-32.94947551036135,-68.86753164231777;-32.94997968298847,-68.87444101274014;-32.943677318476965,-68.8758572191;-32.94014779811096,-68.86766038835049;-32.93888722098082,-68.86547170579433;-32.93831095116508,-68.86302553117275;-32.93705034785159,-68.8504084199667', 'position: absolute; top: 421px; right: 467px; bottom: 490px; left: 291px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (8, 'Villa Marini', 1, '-32.93885120422735,-68.86551462113857;-32.941516404363604,-68.86259637773037;-32.93820290015658,-68.86281095445156;-32.937986797743534,-68.8582619279623;-32.933808713966314,-68.85912023484707;-32.930026657609226,-68.8584765046835;-32.922137848306065,-68.85980688035488;-32.923650825149814,-68.8637550920248;-32.924515371731495,-68.86418424546719;-32.924371281221156,-68.86457048356533;-32.923975031107844,-68.86474214494228;-32.92635250517004,-68.8752993196249;-32.92847776881244,-68.8793333619833;-32.93762662588163,-68.87748800218105;-32.94364130367449,-68.8762005418539;-32.94194859141107,-68.87156568467617;-32.93885120422735,-68.86551462113857', 'position: absolute; top: 290px; right: 467px; bottom: 359px; left: 326px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (6, 'Benegas', 1, '-32.93705034565346,-68.85036550462246;-32.94223671273783,-68.8495071977377;-32.95138414651779,-68.8550003618002;-32.95592149866222,-68.85723195970058;-32.95837013161209,-68.86100850999355;-32.95887425350303,-68.85259710252285;-32.95584947901896,-68.8501938432455;-32.95203235394235,-68.84607397019863;-32.94432558021496,-68.84169660508633;-32.938202897958476,-68.84100995957851;-32.93705034565346,-68.85036550462246', 'position: absolute; top: 364px; right: 688px; bottom: 433px; left: 512px; width: 174 px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (1, 'Villa del parque', 1, '-32.90133179592478,-68.89358125758008;-32.903637816055706,-68.89413915705518;-32.90432240422235,-68.89122091364698;-32.904718742320874,-68.8845261199458;-32.90540332213091,-68.88504110407666;-32.90612392673952,-68.88594232630567;-32.90688055526693,-68.88555608820752;-32.90691658503553,-68.88461195063428;-32.907889383245845,-68.88341032099561;-32.90889819973015,-68.88319574427442;-32.90976289042492,-68.88662897181348;-32.91296937802298,-68.88572774958448;-32.91368992105168,-68.884740696667;-32.913798002000114,-68.88229452204541;-32.9205708115029,-68.88079248499707;-32.92129129265111,-68.88212286066846;-32.92622643080277,-68.88032041621045;-32.92993660887607,-68.8882168395503;-32.92763127381343,-68.89044843745069;-32.92845976051671,-68.8946112258418;-32.93267411623667,-68.89268003535108;-32.93253003901395,-68.89152132105664;-32.92968446577952,-68.88405405115918;-32.9265866490859,-68.87495599818067;-32.92565007849931,-68.86821828913526;-32.92424520403085,-68.86388383936719;-32.91631985333296,-68.86409841608838;-32.90933054613319,-68.864570484875;-32.908682025736894,-68.86542879175977;-32.90298925396325,-68.8674887282832;-32.90122369975779,-68.86611543726758;-32.899602240870585,-68.87705885004834;-32.89938604418266,-68.8871010406001;-32.9001427302815,-68.8922508819087;-32.90133179592478,-68.89358125758008', 'position: absolute; top: 78px; right: 398px; bottom: 146px; left: 224px; width: 174px; height: 72px;');
INSERT INTO region (id, name, locationid, coordinates, "position") VALUES (5, 'Las Tortugas', 1, '-32.94392941948555,-68.81568990909727;-32.947674868164576,-68.81809316837462;-32.9491874082284,-68.81929479801329;-32.94911538309792,-68.82015310489805;-32.95372487313986,-68.82238470279844;-32.953796894514454,-68.8265904065338;-32.96006252943831,-68.82933698856505;-32.959774464012284,-68.83731924259337;-32.9555974098054,-68.83543096744688;-32.949763607159746,-68.83251272403868;-32.94076006974966,-68.83036695682677;-32.941984604705034,-68.82358633243712;-32.94392941948555,-68.81568990909727', 'position: absolute; top: 463px; right: 743px; bottom: 532px; left: 567px; width: 174px; height: 72px;');