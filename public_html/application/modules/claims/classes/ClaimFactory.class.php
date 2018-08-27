<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/CAUElectricClaim.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/TelepromClaim.class.php';


/** 
 * @author Gabriel Guzman
 * 
 * 
 */
class ClaimFactory {
	
	function __construct() {
	
	}
	
	/**
	 * Creates the claim entities
	 * @param array $claimData
	 * @throws Exception
	 * @return Claim
	 */
	public function createClaim($claimData){
		
		switch ($claimData['originname']) {
			
			case claimsConcepts::CLAIMTYPECAUELECTRICITY:{
				$claimObj = new CAUElectricClaim($claimData['claimid'], $claimData['code'], $claimData['claimaddress']);
				
				//Electric specific data
				$claimObj->setFusible($claimData['fusible']);
				$claimObj->setLamp_125($claimData['lamp_125']);
				$claimObj->setLamp_150($claimData['lamp_150']);
				$claimObj->setLamp_250($claimData['lamp_250']);
				$claimObj->setLamp_400($claimData['lamp_400']);
				$claimObj->setExt_125($claimData['ext_125']);
				$claimObj->setExt_150($claimData['ext_150']);
				$claimObj->setExt_250($claimData['ext_250']);
				$claimObj->setExt_400($claimData['ext_400']);
				$claimObj->setInt_125($claimData['int_125']);
				$claimObj->setInt_150($claimData['int_150']);
				$claimObj->setInt_250($claimData['int_250']);
				$claimObj->setInt_400($claimData['int_400']);
				$claimObj->setMorceto($claimData['morceto']);
				$claimObj->setEspejo($claimData['espejo']);
				$claimObj->setColumna($claimData['columna']);
				$claimObj->setAtrio($claimData['atrio']);
				$claimObj->setNeutro($claimData['neutro']);
				$claimObj->setCable($claimData['cable']);
				$claimObj->setTulipa($claimData['tulipa']);
				$claimObj->setPortalampara($claimData['portalampara']);
				$claimObj->setCanasto($claimData['canasto']);
				
				//General Data
				$claimObj->setRequesterPhone($claimData['requesterphone']);
				$claimObj->setRequesterName($claimData['requestername']);
				
				break;
			}
			case claimsConcepts::CLAIMTYPETELEPROM:{
				
				$claimObj = new TelepromClaim();
				
				//General Data
				$claimObj->setId($claimData['claimid']);
				$claimObj->setCode($claimData['code']);
				$claimObj->setRequesterPhone($claimData['requesterphone']);
				
				//properties claim
				$claimObj->setLights($claimData['lights']);
				$claimObj->setClaimAddress($claimData['claimaddress']);
				$claimObj->setRequesterName($claimData['requestername']);
				$claimObj->setRequesterAddress($claimData['requesteraddress']);
				$claimObj->setDetail($claimData['detail']);
				
				break;
			}
			default:{
				$claimObj = new Claim($claimData['claimid'], $claimData['code'], $claimData['requestername'], $claimData['claimaddress'], $claimData['requesterphone']);
				break;
			}
			
		}
		
		if(is_object($claimObj)){
			
			$claimObj->setSubjectName($claimData['subjectname']);
			$claimObj->setInputTypeName($claimData['inputtypename']);
			$claimObj->setCauseName($claimData['causename']);
			$claimObj->setOriginName($claimData['originname']);
			$claimObj->setDependencyName($claimData['dependencyname']);
			$claimObj->setStateId($claimData['stateid']);
			$claimObj->setStateName($claimData['statename']);
			$claimObj->setEntryDate($claimData['entrydate'],"Y-m-d");
			//$claimObj->setClosedDate($claimData['closedate'],$_SESSION['s_message']['date_format']);
			$claimObj->setClosedDate($claimData['closedate'],"Y-m-d");
			$claimObj->setAssigned($claimData['assigned']);

			$claimObj->setDetail($claimData['detail']);
			
			if(isset($claimData['piquete']) && $claimData['piquete'] != null){
				$claimObj->setPiquete($claimData['piquete']);
			}
			
			if(isset($claimData['neighborhood']) && $claimData['neighborhood'] != null){
				$claimObj->setNeighborhood($claimData['neighborhood']);
			}
			
			if(isset($claimData['latitude']) && $claimData['latitude'] != null){
				$claimObj->setLatitude($claimData['latitude']);
			}
			
			if(isset($claimData['longitude']) && $claimData['longitude'] != null){
				$claimObj->setLongitude($claimData['longitude']);
			}
			
			return $claimObj;
			
		}
		else{
			$_SESSION['logger']->error("Error crating claim object");
			throw new Exception("Error crating claim object");
		}
		
	}
	
}
