--
-- Name: telepromclaim; 
--

ALTER TABLE ONLY telepromclaim
	ADD COLUMN causeid bigint;
	
--
-- Name: telepromclaim_causeid_fkey;
--

ALTER TABLE ONLY telepromclaim
    ADD CONSTRAINT telepromclaim_causeid_fkey FOREIGN KEY (causeid) REFERENCES telepromcause(id);