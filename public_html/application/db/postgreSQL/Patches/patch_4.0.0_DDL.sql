-- Systemuser
ALTER TABLE systemuser ADD COLUMN name varchar(255);
ALTER TABLE systemuser ADD COLUMN surname varchar(255);


-- Table: plan
CREATE SEQUENCE plan_id_seq INCREMENT 1 START 1
;

CREATE TABLE plan ( 
	id integer DEFAULT nextval(('plan_id_seq'::text)::regclass) NOT NULL,
	name varchar(255),
	postUrl varchar(255) NOT NULL,
	coordinateUpdateTime integer DEFAULT 20 NOT NULL,
	latitude character varying(255) DEFAULT NULL::character varying,
    longitude character varying(255) DEFAULT NULL::character varying,
	CONSTRAINT PK_plan PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
)
;

ALTER TABLE plan
  OWNER TO postgres;


-- Table: systemuseradr
CREATE TABLE systemuseradr
(
  systemuserid bigint NOT NULL,
  phone character varying(50),
  planid integer NOT NULL,
  stateid integer NOT NULL,
  phonecompany character varying(255),
  identikey character(100),
  CONSTRAINT fk_systemusergdr_plan FOREIGN KEY (planid)
      REFERENCES plan (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_systemusergdr_systemuser FOREIGN KEY (systemuserid)
      REFERENCES systemuser (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_systemusergdr_systemusergdrstate FOREIGN KEY (stateid)
      REFERENCES systemuseradrstate (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);

ALTER TABLE systemuseradr
  OWNER TO postgres;
  

-- Table: systemuseradrstate
CREATE SEQUENCE systemuseradrstate_id_seq INCREMENT 1 START 1;

CREATE TABLE systemuseradrstate
(
  id integer NOT NULL DEFAULT nextval(('systemuseradrstate_id_seq'::text)::regclass),
  description character varying(255) NOT NULL,
  CONSTRAINT pk_systemusergdrstate PRIMARY KEY (id )
)
WITH (
  OIDS=FALSE
);

ALTER TABLE systemuseradrstate
  OWNER TO postgres;


-- Table: userlocation

CREATE TABLE userlocation
(
  iduserlocation bigint NOT NULL DEFAULT nextval('gdr_userlocation_id_seq'::regclass),
  iduser bigint,
  latitude numeric(20,12),
  longitude numeric(20,12),
  reportedtime numeric(13,0), -- Date Time in millisecons
  CONSTRAINT iduserlocation PRIMARY KEY (iduserlocation ),
  CONSTRAINT idsystemuser FOREIGN KEY (iduser)
      REFERENCES systemuser (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);

ALTER TABLE userlocation
  OWNER TO gdr;
COMMENT ON COLUMN userlocation.reportedtime IS 'Date Time in millisecons';


-- Table: claimsystemuseradr
CREATE SEQUENCE claimsystemuseradr_id_seq INCREMENT 1 START 1;

CREATE TABLE claimsystemuseradr (
	id integer DEFAULT nextval(('claimsystemuseradr_id_seq'::text)::regclass) NOT NULL,
	systemuserAdrId bigint ,
	claimId integer NOT NULL,
	listPlace integer NOT NULL
)
WITH (
  OIDS=FALSE
)
;

ALTER TABLE claimsystemuseradr
  OWNER TO postgres;


-- Table: substateldr
CREATE TABLE substateldr
(
  id integer NOT NULL,
  description character varying(255) NOT NULL,
  CONSTRAINT pk_substateldr PRIMARY KEY (id )
)
WITH (
  OIDS=FALSE
);

ALTER TABLE substateldr
  OWNER TO postgres;






--claim
ALTER TABLE claim ADD substateid integer;


ALTER TABLE claim ADD CONSTRAINT FK_claim_substateldr
	FOREIGN KEY (substateid) REFERENCES substateldr (id)
;




CREATE SEQUENCE materialldr_id_seq INCREMENT 1 START 1;

CREATE TABLE materialldr ( 
	id integer DEFAULT nextval(('materialldr_id_seq'::text)::regclass) NOT NULL,
	name varchar(50),
	description varchar(255)
);

ALTER TABLE materialldr ADD CONSTRAINT PK_materialldrId
	PRIMARY KEY (id)
;



CREATE SEQUENCE withoutfixingldr_id_seq INCREMENT 1 START 1;

CREATE TABLE withoutfixingldr ( 
	id integer DEFAULT nextval(('withoutfixingldr_id_seq'::text)::regclass) NOT NULL,
	name varchar(50),
	description varchar(255)
);
ALTER TABLE withoutfixingldr ADD CONSTRAINT PK_withoutfixingldrid
	PRIMARY KEY (id)
;


-- Table: claimclosureldr
CREATE SEQUENCE claimclosureldr_id_seq INCREMENT 1 START 1;

CREATE TABLE claimclosureldr ( 
	id integer DEFAULT nextval(('claimclosureldr_id_seq'::text)::regclass) NOT NULL,
	claimId integer NOT NULL,
	systemuserId integer NOT NULL,
	materialldrId integer,
	withoutfixingldrId integer,
	description varchar(255),
	actiondate date,
	CONSTRAINT PK_claimclosureldr 
		PRIMARY KEY (id),
	CONSTRAINT FK_claimclosureldr_claimid 
		FOREIGN KEY (claimId) REFERENCES claim (id),
	CONSTRAINT FK_claimclosureldr_materialldrId
		FOREIGN KEY (materialldrId) REFERENCES materialldr (id),
	CONSTRAINT FK_claimclosureldr_systemuserId
		FOREIGN KEY (systemuserId) REFERENCES systemuser (id),
	CONSTRAINT FK_claimclosureldr_withoutfixingldrId
		FOREIGN KEY (withoutfixingldrId) REFERENCES withoutfixingldr(id)
)
WITH (
  OIDS=FALSE
);

ALTER TABLE claimclosureldr
  OWNER TO postgres;


-- Table: state

CREATE TABLE state
(
  id bigserial NOT NULL,
  name character varying(255) NOT NULL,
  CONSTRAINT pk_claimstate PRIMARY KEY (id ),
  CONSTRAINT uq_claimstate_name UNIQUE (name ),
  CONSTRAINT uq_state_id UNIQUE (id )
)
WITH (
  OIDS=FALSE
);

ALTER TABLE state
  OWNER TO gdr;


-- Table: zone

CREATE TABLE zone
(
  id bigserial NOT NULL,
  name character varying(255) NOT NULL,
  locationid bigint NOT NULL,
  coordinates text NOT NULL,
  "position" text,
  CONSTRAINT zone_pkey PRIMARY KEY (id ),
  CONSTRAINT zone_locationid_fkey FOREIGN KEY (locationid)
      REFERENCES location (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);

ALTER TABLE zone
  OWNER TO gdr;
