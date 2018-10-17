<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/importer/Importer.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/importer/XlsFileType.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/enums/claims.enum.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/CAUClaimType.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/TelepromClaimType.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/CAUClaimTypeElectricity.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/DataClaimType.class.php';

class ImporterFactory {
	
	function __construct() {
	
	}
	
	/**
	 * Creates an importer and configures it
	 * @param string $fileType
	 * @param string $originName
	 * @throws InvalidArgumentException
	 * @return Importer
	 */
	public function create($fileType, $originName){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if(!isset($fileType) || $fileType == null){
			$_SESSION ['logger']->error("fileType must be a string");
			throw new InvalidArgumentException("fileType must be a string");
		}
		
		if(!isset($originName) || $originName == null){
			$_SESSION ['logger']->error("originName must be a string");
			throw new InvalidArgumentException("originName must be a string");
		}
		
		//Filetype selection
		switch ($fileType){
			
			case claimsConcepts::FILETYPEXLS:{
				$fileType = new XlsFileType();
				break;
			}
			default:{				
				$_SESSION ['logger']->error("Invalid filetype selected");
				throw new InvalidArgumentException("Invalid filetype selected");
				break;
			}
			
		}
		
		//Claim type selection
		switch ($originName){
			
			case claimsConcepts::CLAIMTYPECAU:{
				$claimType = new CAUClaimType();
				break;
			}
			case claimsConcepts::CLAIMTYPECAUELECTRICITY:{
				$claimType = new CAUClaimTypeElectricity();
				break;
			}
			case claimsConcepts::CLAIMTYPETELEPROM:{
				$claimType = new TelepromClaimType();
				break;
			}
			case claimsConcepts::CLAIMTYPEDATA:{
				$claimType = new DataClaimType();
				break;
			}
			default:{
				$_SESSION ['logger']->error("Invalid origin selected");
				throw new InvalidArgumentException("Invalid origin selected");
				break;
			}
			
		}
		
		$importer = new Importer($fileType, $claimType);
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $importer;
		
	}
}