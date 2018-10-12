<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ClaimType.class.php';

/**
 *
 * Class that defines de Manual's claim type.
 * @author mmogrovejo
 *
 */
class ManualClaimsMultipleType extends ClaimType {

	function __construct() {
	}

	/**
	 * (non-PHPdoc)
	 * @see ClaimType::parse()
	 * Parses an array and seeks for claims
	 * @return boolean
	 */
	public function parse($data){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if(!isset($data) || $data == null || !is_array($data)){
			$_SESSION ['logger']->error("Data variable to parse must be an array");
			throw new InvalidArgumentException("Data variable to parse must be an array");
		}
		
		//Entry date
		$entryDate = $data['entryDate'];
		
		//Address
		$address = '';
		
		//Code generation
		$claimCount = $this->getClaimsCount();
		$code = $this->generateCode($claimCount);
		
		$claimObj = new Claim(null, $code, $data['requesterName'], $address, $data['requesterPhone']);
		
		//Set entry date
		$claimObj->setEntryDate($entryDate, 'd/m/Y');
		
		//Set input type
		$claimObj->setInputTypeId($data['inputTypeId']);
		
		//Set origin
		$claimObj->setOriginId($data['originId']);
		
		//Set subject
		$claimObj->setSubjectId($data['subjectId']);
		
		//Set cause
		$claimObj->setCauseId($data['causeId']);
		
		//Set dependency
		$claimObj->setDependencyId($data['dependencyId']);
		
		//Set assigned
		$claimObj->setAssigned('false');
		
		//Set state
		//Siempre viene pending
		$claimObj->setStateId($data['stateId']);
		
		//Set Neighborhood
		$claimObj->setNeighborhood($data['neighborhood']);

		if(isset($data['id_type_address'])){
			
		$claimObj->setTypeAddressId($data['id_type_address']);
			
		}
		//Get GeoLocation data
		if (trim ( $data ['claimAddress'] ) != '' && trim($data ['latitude']) == '' && trim($data['longitude']) == '') {
			if(trim($address) != '') {
				require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/GeoLocation.class.php';
			
				$fullAddress = trim($address) . ' ' . $_SESSION['loggedUser']->getLocationName() . ' ' . $_SESSION['loggedUser']->getProvinceName() . ' ' . $_SESSION['loggedUser']->getCountryName();
			
				$geoLocation = new GeoLocation();
				$geoCodes = $geoLocation->getGeoLocationFromAddress($fullAddress);
			
				if(is_array($geoCodes) && count($geoCodes) > 0){
					$claimObj->setLatitude($geoCodes ['lat']);
					$claimObj->setLongitude($geoCodes ['lon']);
				}
			}			
			
		}else{
			if(trim($data ['latitude']) != '' && trim($data['longitude']) != ''){				
				$claimObj->setLatitude($data['latitude']);
				$claimObj->setLongitude($data['longitude']);				
			}
						
		}

		$result = $claimObj->insert();

		if(!$result){
			$_SESSION['logger']->error("Error inserting claim");
			throw new Exception("Error inserting claim");
		}

		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return true;

	}
	
	/**
	 * Generates the code for Manual's claims
	 * @return string
	 */
	private function generateCode($code){
	
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	
		$newCode = 'M-' . date("Y") . '-' . ((int)$code+1);
	
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	
		return $newCode;
	
	}
	
	/**
	 * Returns the current count of claims
	 * @return number
	 */
	private function getClaimsCount(){
	
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	
		$telepromQuery = ClaimsDB::getAllClaimsCount();
	
		$connectionManager = ConnectionManager::getInstance ();
	
		$rs = $connectionManager->select ( $telepromQuery );
	
		$code = 0;
	
		if(isset($rs[0]['numrows']) && $rs[0]['numrows'] != null){
			$code = (int)$rs[0]['numrows'];
		}
	
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	
		return $code;
	
	}

}