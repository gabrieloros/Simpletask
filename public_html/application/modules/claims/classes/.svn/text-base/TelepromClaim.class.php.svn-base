<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Claim.class.php';

/**
 * Teleprom claim entity
 * @author Gabriel Guzman
 *
 */
class TelepromClaim extends Claim{
	
	/**
	 * Claim datum (Teleprom especific data)
	 * @var string
	 */
	private $datum;
	
	/**
	 * Claim lights
	 * @var int
	 */
	private $lights;
	
	/**
	 * Requester Address
	 * @var string
	 */
	private $requesterAddress;
	
	function __construct($id = null, $code=null, $requesterPhone = '', $lights=null) {
		
		parent::setId($id);
		
		parent::setCode($code);
		
		parent::setRequesterPhone($requesterPhone);
		
		$this->lights = $lights;
	
	}
	
	public function insert(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$result = parent::insert();
		
		if(!$result){
			$_SESSION['logger']->error("Error inserting parent claim");
			throw new Exception("Error inserting parent claim");
		}
		
		$claimData = array();
		
		$claimData['claimId'] = $result;
		$claimData['datum'] = $this->datum;
		$claimData['lights'] = $this->lights;
		$claimData['requesterAddress'] = $this->requesterAddress;
		
		$insertQuery = ClaimsDB::insertTelepromClaim($claimData);
		
		$connectionManager = ConnectionManager::getInstance ();
			
		$rs = $connectionManager->executeTransaction($insertQuery);
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $rs;
		
	}
	
	public function getDataFromPhoneDirectory($phone){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$query = ClaimsDB::getDataFromPhoneDirectory($phone);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		$result = array();
		
		if(isset($rs[0]['id']) && $rs[0]['id'] != null){
			$result = $rs[0];
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
		
	}
	
	/**
	 * @return the $datum
	 */
	public function getDatum() {
		return $this->datum;
	}

	/**
	 * @param string $datum
	 */
	public function setDatum($datum) {
		$this->datum = $datum;
	}

	/**
	 * @return the $lights
	 */
	public function getLights() {
		return $this->lights;
	}

	/**
	 * @param int $lights
	 */
	public function setLights($lights) {
		$this->lights = $lights;
	}
	
	/**
	 * @return the $requesterAddress
	 */
	public function getRequesterAddress() {
		return $this->requesterAddress;
	}

	/**
	 * @param string $requesterAddress
	 */
	public function setRequesterAddress($requesterAddress) {
		$this->requesterAddress = $requesterAddress;
	}

}