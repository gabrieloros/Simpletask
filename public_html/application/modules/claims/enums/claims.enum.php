<?php
class claimsConcepts{

	//File types
	const FILETYPEXLS = "xls";
	
	//CAU Claims column label to check
	const CLAIMTYPECAUCOLUMNCHECK = 'FORMA INGRESO';
	const CLAIMTYPECAUELECTRICITYCOLUMNCHECK = 'FECHA';
	
	//Teleprom Claims column label to check
	const CLAIMTYPETELEPROMCOLUMNCHECK = 'SERIAL';
	
	//Claims states
	const PENDINGSTATE = 1;
	const CLOSEDSTATE = 2;
	const CANCELLEDSTATE = 3;
	const CLOSEDSTATENOGEO = 4;
	
	//Claims SUBSTATE ldr
	const SUBSTATE_CAME_TO_THE_PLACE = 1;
	const SUBSTATE_YOU_CAN_CANCEL= 2;
	const SUBSTATE_YOU_CAN_CLOSE = 3;
	
	//Claims Origins
	const CLAIMTYPECAUID = 1;
	const CLAIMTYPECAU = "origincau";
	const CLAIMTYPETELEPROMID = 2;
	const CLAIMTYPETELEPROM = "originteleprom";
	const CLAIMTYPECAUELECTRICITYID = 3; 
	const CLAIMTYPECAUELECTRICITY = "origincauelectricity";
	const CLAIMTYPEMANUALID = 4;
	const CLAIMTYPEMANUAL = "manual";
	
	//Claims input types
	const CLAIMINPUTTYPEPHONEID = 1; 
	const CLAIMINPUTTYPEPHONE= 'telefonico';
	const CLAIMINPUTTYPEPERSONALID = 2;
	const CLAIMINPUTTYPEPERSONAL = 'personal';
	const CLAIMINPUTTYPETELEPROMID = 3;
	const CLAIMINPUTTYPEPTELEPROM = 'teleprom';
	const CLAIMINPUTTYPEMANUALID = 4;
	const CLAIMINPUTTYPEMANUAL = 'manual';
	
	//Constants for 'Alumbrado Público'
	const ALUMBRADO_PUBLICO_CAUSE_ID = 14;
	const SIN_ESTADO_ID = 35;
	const ALUMBRADO_PUBLICO_SUBJECT_ID = 10; 
	
	//Time to change pending claim to critical pending claim state (in days)
	const CRITICALPENDINGSTATETIME = 2;
	
	//Asignadas
	const ASSIGNEDCLAIM = 't';
	
	const CLAIM_STREET_NUMBER= 'street_number';
	const CLAIM_DISTRICT_BLOCK_HOUSE = 'district_block_house';
	const CLAIM_ADDRESS = 'claim_address';
	const CLAIM_TYPE_ADDRESS = 'type_address';
	const PUSH_ACTION_UPDATE = 'update';
	const PUSH_ACTION_DELETE = 'delete';
	const PUSH_ACTION_ADD = 'add';
	
}

//this constant must contain all the filetypes defined in the class
define('VALIDFILETYPES', serialize(array("xls")));

define('TELEPROMDATUM', serialize(array("", "B", "N", "5")));