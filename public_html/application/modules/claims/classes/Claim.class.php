<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/db/ClaimsDB.class.php');

/**
 * Claim entity
 * @author Gabriel Guzman
 *
 */
class Claim {
	
	/**
	 * Claim id
	 * @var int
	 */
	private $id;
	
	/**
	 * Claim code
	 * @var string
	 */
	private $code;
	
	/**
	 * Claim subject id
	 * @var int
	 */
	private $subjectId;
	
	/**
	 * Claim subject name
	 * @var string
	 */
	private $subjectName;
	
	/**
	 * Claim input type id
	 * @var int
	 */
	private $inputTypeId;
	
	/**
	 * Claim input type name
	 * @var string
	 */
	private $inputTypeName;
	
	/**
	 * Claim cause id
	 * @var int
	 */
	private $causeId;
	
	/**
	 * Claim cause name
	 * @var string
	 */
	private $causeName;
	
	/**
	 * Claim origin id
	 * @var int
	 */
	private $originId;
	
	/**
	 * Claim origin name
	 * @var string
	 */
	private $originName;
	
	/**
	 * Claim dependency id
	 * @var int
	 */
	private $dependencyId;
	
	/**
	 * Claim dependency name
	 * @var string
	 */
	private $dependencyName;
  
	/**
	 * Claim state id
	 * @var int
	 */
	private $stateId;
  
	/**
	 * Claim state name
	 * @var string
	 */
	private $stateName;
	
	/**
	 * Claim entry date
	 * @var DateTime
	 */
	private $entryDate;
	
	/**
	 * Claim closed date
	 * @var DateTime
	 */
	private $closedDate;
  
	/**
	 * Claim requester name
	 * @var string
	 */
	private $requesterName;
	
	/**
	 * Claim requester address
	 * @var string
	 */
	private $claimAddress;
  
	/**
	 * Claim requester phone
	 * @var int
	 */
	private $requesterPhone;
  
	/**
	 * Is assigned
	 * @var boolean
	 */
	private $assigned;
	
	/**
	 * Claim latitude
	 * @var string
	 */
	private $latitude;
	
	/**
	 * Claim longitude
	 * @var string
	 */
	private $longitude;
	
	/**
	 * Claim neighborhood
	 * @var string
	 */
	private $neighborhood;
	
	/**
	 * Piquete
	 * @var string
	 */
	private $piquete;
	
	/**
	 * Geographical region
	 * @var int
	 */
	private $regionId;
	
	private $regionName;
	
	/**
	 * Detail
	 */
	private $detail;
	
	/**
	 * SystemUser
	 * @var int
	 */
	private $userId;
	
	private $typeAddress;		

	/**
	 * SubState
	 * @var int
	 */
	private $substateid;

	//Modify Diego Saez
	//----------------------------------------------------------------------------------
	/**
	 * SystemUser name
	 * @var string
	 */
	private $userName;
	
	
	
	private $typeAddressId;
	
	private $withoutFixingDetail;
	
	private $closureMaterials;
	
	private $reportedTime;

	private $priority;

	private $groupid;
	
	private $detailCloseClaim;

	private $namegroup;
	
	private $mat_1;
	private $mat_2;
	private $mat_3;
	private $mat_4;
	private $mat_5;
	
	//----------------------------------------------------------------------------------


	function __construct($id, $code, $requesterName = '', $claimAddress = '', $requesterPhone = '') {
		
		$this->id = $id;
		
		$this->code = $code;
		
		$this->requesterName = $requesterName;
		
		$this->claimAddress = $claimAddress;
		
		$this->requesterPhone = $requesterPhone;
	
	}
	

	
	//editClaim(
	/**
	 * Verifies if the claim already exists in the database
	 * @return boolean
	 */
	protected function checkExistenceInDB(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$claimData['entryDate'] = $this->getEntryDateForDB();
		$claimData['code'] = $this->code;
		
		$query = ClaimsDB::checkExistenceInDB($claimData);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		$result = false;
		
		if(isset($rs[0]['id']) && $rs[0]['id'] != null){
			$result = true;
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $result;
		
	}
	
	/**
	 * Inserts the claim in the Database
	 * @return boolean
	 */
	public function insert(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$rs = true;
		
		if(!$this->checkExistenceInDB()){

			$claimData = array();

			$claimData["code"] = $this->code;
			$claimData["subjectId"] = $this->subjectId;
			$claimData["inputTypeId"] = $this->inputTypeId;
			$claimData["causeId"] = $this->causeId;
			$claimData["originId"] = $this->originId;
			$claimData["dependencyId"] = $this->dependencyId;
			$claimData["stateId"] = $this->stateId;
			$claimData["entryDate"] = $this->getEntryDateForDB();
			$claimData["requesterName"] = $this->requesterName;
			$claimData["claimAddress"] = $this->claimAddress;
			$claimData["requesterPhone"] = $this->requesterPhone;
			$claimData["assigned"] = $this->assigned;
			$claimData['piquete'] = $this->piquete;
			$claimData['latitude'] = $this->latitude;
			$claimData['longitude'] = $this->longitude;
			$claimData['neighborhood'] = $this->neighborhood;
			$claimData['regionId'] = Util::getClaimRegion($this->latitude, $this->longitude);
			$claimData['id_type_address'] = isset($this->typeAddressId)?$this->typeAddressId:'NULL';

			$claimData["priority"] = $this->priority;
			$claimData["detail"] = $this->detail;
			
			$insertQuery = ClaimsDB::insertClaim($claimData);
			
			$_SESSION ['logger']->debug('Insertando reclamo1: '.$insertQuery);
			$connectionManager = ConnectionManager::getInstance ();

			$rs = $connectionManager->executeTransaction($insertQuery, true, 'claim_id_seq');
	
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $rs;

	}

	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $code
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @param string $code
	 */
	public function setCode($code) {
		$this->code = $code;
	}

	/**
	 * @return the $subjectId
	 */
	public function getSubjectId() {
		return $this->subjectId;
	}

	/**
	 * @param int $subjectId
	 */
	public function setSubjectId($subjectId) {
		$this->subjectId = $subjectId;
	}

	/**
	 * @return the $subjectName
	 */
	public function getSubjectName() {
		return $this->subjectName;
	}

	/**
	 * @param string $subjectName
	 */
	public function setSubjectName($subjectName) {
		$this->subjectName = $subjectName;
	}

	/**
	 * @return the $inputTypeId
	 */
	public function getInputTypeId() {
		return $this->inputTypeId;
	}

	/**
	 * @param int $inputTypeId
	 */
	public function setInputTypeId($inputTypeId) {
		$this->inputTypeId = $inputTypeId;
	}

	/**
	 * @return the $inputTypeName
	 */
	public function getInputTypeName() {
		return $this->inputTypeName;
	}

	/**
	 * @param string $inputTypeName
	 */
	public function setInputTypeName($inputTypeName) {
		$this->inputTypeName = $inputTypeName;
	}

	/**
	 * @return the $causeId
	 */
	public function getCauseId() {
		return $this->causeId;
	}

	/**
	 * @param int $causeId
	 */
	public function setCauseId($causeId) {
		$this->causeId = $causeId;
	}

	/**
	 * @return the $causeName
	 */
	public function getCauseName() {
		return $this->causeName;
	}

	/**
	 * @param string $causeName
	 */
	public function setCauseName($causeName) {
		$this->causeName = $causeName;
	}

	/**
	 * @return the $originId
	 */
	public function getOriginId() {
		return $this->originId;
	}

	/**
	 * @param int $originId
	 */
	public function setOriginId($originId) {
		$this->originId = $originId;
	}

	/**
	 * @return the $originName
	 */
	public function getOriginName() {
		return $this->originName;
	}

	/**
	 * @param string $originName
	 */
	public function setOriginName($originName) {
		$this->originName = $originName;
	}

	/**
	 * @return the $dependencyId
	 */
	public function getDependencyId() {
		return $this->dependencyId;
	}

	/**
	 * @param int $dependencyId
	 */
	public function setDependencyId($dependencyId) {
		$this->dependencyId = $dependencyId;
	}

	/**
	 * @return the $dependencyName
	 */
	public function getDependencyName() {
		return $this->dependencyName;
	}

	/**
	 * @param string $dependencyName
	 */
	public function setDependencyName($dependencyName) {
		$this->dependencyName = $dependencyName;
	}

	/**
	 * @return the $stateId
	 */
	public function getStateId() {
		return $this->stateId;
	}

	/**
	 * @param int $stateId
	 */
	public function setStateId($stateId) {
		$this->stateId = $stateId;
	}

	/**
	 * @return the $stateName
	 */
	public function getStateName() {
		return $this->stateName;
	}

	/**
	 * @param string $stateName
	 */
	public function setStateName($stateName) {
		$this->stateName = $stateName;
	}

	/**
	 * @return the $entryDate
	 */
	public function getEntryDate() {
		return $this->entryDate;
	}

	/**
	 * @param DateTime $entryDate
	 */
	public function setEntryDate($entryDate, $format) {
		$this->entryDate = DateTime::createFromFormat($format, $entryDate);
	}
	
	public function getEntryDateForDB(){
		return $this->entryDate->format("Y-m-d");
	}

	public function getEntryDateForLDR(){
		return $this->entryDate->format("d/m/Y");
	}

	/**
	 * @return the $closedDate
	 */
	public function getClosedDate() {
		return $this->closedDate;
	}
	
	public function getClosedDateFormated(){
		return $this->closedDate->format("Y/m/d");
	}

	/**
	 * @param DateTime $closedDate
	 */
	public function setClosedDate($closedDate, $format) {
		$this->closedDate = DateTime::createFromFormat($format, $closedDate);
	}

	/**
	 * @return the $requesterName
	 */
	public function getRequesterName() {
		return $this->requesterName;
	}

	/**
	 * @param string $requesterName
	 */
	public function setRequesterName($requesterName) {
		$this->requesterName = $requesterName;
	}

	/**
	 * @return the $claimAddress
	 */
	public function getClaimAddress() {
		return $this->claimAddress;
	}

	/**
	 * @param string $claimAddress
	 */
	public function setClaimAddress($claimAddress) {
		$this->claimAddress = $claimAddress;
	}

	/**
	 * @return the $requesterPhone
	 */
	public function getRequesterPhone() {
		return $this->requesterPhone;
	}

	/**
	 * @param int $requesterPhone
	 */
	public function setRequesterPhone($requesterPhone) {
		$this->requesterPhone = $requesterPhone;
	}

	/**
	 * @return the $assigned
	 */
	public function getAssigned() {
		return $this->assigned;
	}

	/**
	 * @param boolean $assigned
	 */
	public function setAssigned($assigned) {
		$this->assigned = $assigned;
	}
	
	/**
	 * @return the $piquete
	 */
	public function getPiquete() {
		return $this->piquete;
	}

	/**
	 * @param string $piquete
	 */
	public function setPiquete($piquete) {
		$this->piquete = $piquete;
	}

	/**
	 * @return the $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * @param string $latitude
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	/**
	 * @return the $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * @param string $longitude
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	/**
	 * @return the $neighborhood
	 */
	public function getNeighborhood() {
		return $this->neighborhood;
	}

	/**
	 * @param string $neighborhood
	 */
	public function setNeighborhood($neighborhood) {
		$this->neighborhood = $neighborhood;
	}
	
	/**
	 * @return the $regionId
	 */
	public function getRegionId() {
		return $this->regionId;
	}

	/**
	 * @param int $regionId
	 */
	public function setRegionId($regionId) {
		$this->regionId = $regionId;
	}

	/**
	 * @return the $detail
	 */
	public function getDetail() {
		return $this->detail;
	}
	
	/**
	 * @param string $detail
	 */
	public function setDetail($detail) {
		$this->detail = $detail;
	}

	/**
	 * @return the $userId
	 */
	public function getUserId() {
		return $this->userId;
	}
	
	/**
	 * @param int $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}
	//Modified by Diego Saez
	//----------------------------------------------------
	/**
	 * Set user name
	 * @param $userName
	 */
	public function setUserName($userName){
		$this->userName = $userName ;
		
	}
	/**
	 * Return user name
	 */
	public function getUserName(){
		
		return $this->userName;
	}

	/**
	 * @return mixed
	 */
	public function getPriority()
	{
		return $this->priority;
	}

	/**
	 * @param mixed $priority
	 */
	public function setPriority($priority)
	{
		$this->priority = $priority;
	}


	//----------------------------------------------------
	/**
	 * @return the $substateid
	 */
	public function getSubstateid() {
		return $this->substateid;
	}

	/**
	 * @param number $substateid
	 */
	public function setSubstateid($substateid) {
		$this->substateid = $substateid;
	}

	public function setTypeAddress($typeAddress){
		$this->typeAddress = $typeAddress;
		
	}

	public function getTypeAddress(){
		
		return $this->typeAddress;		
		
	}

	public function getTypeAddressId()
	{
		return $this->typeAddressId;
	}
	
	public function setTypeAddressId($value)
	{
		$this->typeAddressId = $value;
	}
	public function getWithoutFixingDetail() {
		return $this->withoutFixingDetail;
	}
	public function setWithoutFixingDetail($withoutFixingDetail) {
		$this->withoutFixingDetail = $withoutFixingDetail;
		return $this;
	}
	public function getClosureMaterials() {
		return $this->closureMaterials;
	}
	public function setClosureMaterials($closureMaterials) {
		$this->closureMaterials = $closureMaterials;
		return $this;
	}
	public function getRegionName() {
		return $this->regionName;
	}
	public function setRegionName($regionName) {
		$this->regionName = $regionName;
		return $this;
	}
	public function getReportedTime() {
		return $this->reportedTime;
	}
	public function setReportedTime($reportedTime) {
		$this->reportedTime = $reportedTime;
		return $this;
	}

    public function setDetailCloseClaim($detailCloseClaim){
        $this->detailCloseClaim = $detailCloseClaim;

    }

    public function getDetailCloseClaim(){

        return $this->detailCloseClaim;

	}
	
	/**
	 * @return the $groupId
	 */
	public function getGroupid() {
		return $this->groupid;
	}

	/**
	 * @param int $groupId
	 */
	public function setGroupid($groupid) {
		$this->groupid = $groupid;
	}
		/**
	 * @return the $namegroup
	 */
	public function getNamegroup() {
		return $this->namegroup;
	}

	/**
	 * @param int $groupId
	 */
	public function setNamegroup($namegroup) {
		$this->namegroup = $namegroup;
	}		

/**  param set && get de materiales cerrados */
	public function getMat_1() {
		return $this->mat_1;
	}
	public function setMat_1($mat_1) {
		$this->mat_1 = $mat_1;
	}
	
	public function getMat_2() {
		return $this->mat_2;
	}
	public function setMat_2($mat_2) {
		$this->mat_2 = $mat_2;
	}	

	public function getMat_3() {
		return $this->mat_3;
	}
	public function setMat_3($mat_3) {
		$this->mat_3 = $mat_3;
	}	

	public function getMat_4() {
		return $this->mat_4;
	}
	public function setMat_4($mat_4) {
		$this->mat_4 = $mat_4;
	}	

	public function getMat_5() {
		return $this->mat_5;
	}
	public function setMat_5($mat_5) {
		$this->mat_5 = $mat_5;
	}			
}
