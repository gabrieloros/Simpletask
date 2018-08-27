<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ClaimType.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/TelepromClaim.class.php';

/**
 * 
 * Class that defines de Teleprom's claim type. CAU = Reclamos telefonicos
 * @author Gabriel Guzman
 *
 */
class TelepromClaimType extends ClaimType {
	
	function __construct() {
	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ClaimType::parse()
	 * Parses an array and seeks for Teleprom-formatted claims
	 * @return array $parsedData
	 */
	public function parse($data){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if(!isset($data) || $data == null || !is_array($data)){
			$_SESSION ['logger']->error("Data variable to parse must be an array");
			throw new InvalidArgumentException("Data variable to parse must be an array");
		}
		
		$parsedData = array();
			
		//Check if is CAU valid claim list
		$firstColumnLabel = trim($data[1]['A']);
		
		if($firstColumnLabel != claimsConcepts::CLAIMTYPETELEPROMCOLUMNCHECK){
			$_SESSION['logger']->error("Invalid file format");
			throw new InvalidArgumentException("Invalid file format");
		}
		
		//Remove the first three row, left only claims data
		$parsedData = array_slice($data, 1);
		
		if(count($parsedData) > 0){
			
			$telepromCount = $this->getTelepromCount();
			$counter = 0;
			
			foreach ($parsedData as $row){
				
				if(!isset($row['F']) || $row['F'] == null || !isset($row['D']) || $row['D'] == null){
					continue;
				}
				
				//Entry date
				$fullDate = date("d/m/Y");
				
				//Code generation
				$code = $this->generateCode($telepromCount);
				
				$claimObj = new TelepromClaim(null, $code, $row['D'], null);
				
				//Check if 'datum' is = 5 to retrieve requester data from phone directory
				if($row['P'] == '5'){
					
					$phone = trim($row['D']);
					
					if(substr($phone, 0, 1) != '0'){
						$phone = '0261' . $phone;
					}
					
					$requesterDataByPhone = $claimObj->getDataFromPhoneDirectory($phone);
					
					//Address
					if(isset($requesterDataByPhone['address']))
						$claimObj->setRequesterAddress($requesterDataByPhone['address']);
						
					$claimObj->setClaimAddress('');
					
					//Requester name
					if(isset($requesterDataByPhone['name']))
						$claimObj->setRequesterName($requesterDataByPhone['name']);
					
				}
				
				//Set entry date				
				$claimObj->setEntryDate($fullDate, 'd/m/Y');
				
				//Set input type
				$claimObj->setInputTypeId(claimsConcepts::CLAIMINPUTTYPETELEPROMID);
				
				//Set origin
				$originId = array_search(claimsConcepts::CLAIMTYPETELEPROM, $_SESSION['claimsConcepts']['origins']);
				if($originId !== false){
					$claimObj->setOriginId($originId);
				}
				
				//Set subject
				$claimObj->setSubjectId('NULL');
				
				//Set cause
				$claimObj->setCauseId('NULL');
				
				//Set dependency
				//The current XLS for Teleprom doesn't have the dependency field
				$claimObj->setDependencyId($_SESSION['loggedUser']->getDependencyid());
				
				//Set assigned
				//Currently all the claims are marked as assigned, in the future it will change
				$claimObj->setAssigned('true');
				
				//Set state
				//By default is pending
				$claimObj->setStateId(claimsConcepts::PENDINGSTATE);
				
				//Datum (teleprom especific field)
				$claimObj->setDatum($row['P']);
				
				//Inserting
				$result = $claimObj->insert();
				
				if(!$result){
					$_SESSION['logger']->error("Error inserting claim");
					throw new Exception("Error inserting claim", $counter);
				}
				
				//Adds 1 to count for code generation
				$telepromCount ++;
				
				$counter ++;
				
			}
			
		}
		else{
			$_SESSION['logger']->error("Claims file is empty");
			throw new Exception("Claims file is empty");
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $counter;
		
	}
	
	/**
	 * Generates the code for Teleprom's claims
	 * @return string
	 */
	private function generateCode($code){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$newCode = 'T-' . date("Y") . '-' . ((int)$code+1);
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $newCode;
		
	}
	
	/**
	 * Returns the current count of teleprom claims
	 * @return number
	 */
	private function getTelepromCount(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$telepromQuery = ClaimsDB::getTelepromCount();
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $telepromQuery );
		
		$code = 0;
		
		if(isset($rs[0]['telepromclaimscount']) && $rs[0]['telepromclaimscount'] != null){
			$code = (int)$rs[0]['telepromclaimscount'];
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $code;
		
	}
	
}

?>