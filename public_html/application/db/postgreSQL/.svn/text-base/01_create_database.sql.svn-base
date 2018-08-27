-- Role: gdr

-- DROP ROLE gdr;

-- crypted password: 'gdr1324' (must match with config.ini password)

CREATE ROLE gdr LOGIN
  ENCRYPTED PASSWORD 'md5737038163c7a9b2dd7e60dfe18ca6306'
  NOSUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION;

-- Database: gdr

-- DROP DATABASE gdr;

CREATE DATABASE gdr
  WITH OWNER = gdr
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'es_ES.UTF-8'
       LC_CTYPE = 'es_ES.UTF-8'
       CONNECTION LIMIT = -1;

