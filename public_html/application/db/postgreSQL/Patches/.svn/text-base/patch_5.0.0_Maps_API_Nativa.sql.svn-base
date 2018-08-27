CREATE TABLE "public"."claimclosureldr_materialldr" (
   claimclosureldrid bigint NOT NULL,
   materialldrid bigint NOT NULL,
   CONSTRAINT PK_CLAIMCLOSURELDR_MATERIALLDR PRIMARY KEY (claimclosureldrid,materialldrid)
);


ALTER TABLE "public"."claimclosureldr_materialldr"
ADD CONSTRAINT materialldrid
FOREIGN KEY (materialldrid)
REFERENCES "public"."materialldr"(id);

ALTER TABLE "public"."claimclosureldr_materialldr"
ADD CONSTRAINT claimclsureldrid
FOREIGN KEY (claimclosureldrid)
REFERENCES "public"."claimclosureldr"(id);


CREATE INDEX fki_claimclsureldrid ON "public"."claimclosureldr_materialldr"(claimclosureldrid);


CREATE INDEX fki_materialldrid ON "public"."claimclosureldr_materialldr"(materialldrid);


CREATE UNIQUE INDEX UNIQUE_CLAIMCLOSURELDR_MATERIALLDR ON "public"."claimclosureldr_materialldr"(
  claimclosureldrid,
  materialldrid
);

ALTER TABLE systemuseradr ADD registrationid varchar(512);

-- usuario desktop para loguearse a API REST LDR

INSERT INTO systemuser (userlogin, userpassword, usertypeid, dependencyid,name,surname)
VALUES ('desktop', 'e10adc3949ba59abbe56e057f20f883e', 4, 1, 'gdr','gdr');

INSERT INTO systemuseradr (systemuserid,planid,stateid,identikey)
VALUES ( (SELECT systemuser.id FROM systemuser WHERE userlogin ='desktop'), 41, 2,'desktope10adc3949ba59abbe56e057f20f883e' )

