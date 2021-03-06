<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/db/ClaimsDB.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/db/ClaimPicDB.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Claim.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ClaimMap.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Group.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ClaimPic.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/TypeAddress.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/TelepromClaim.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ClaimFactory.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Map.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/State.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Origin.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Dependency.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Cause.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/InputType.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Subject.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ManualClaimFactory.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/MaterialLdr.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/WithoutFixing.php');


/**
 * Handles all the claims operations
 *
 * @author Gabriel Guzmano
 *
 */
class ClaimsManager implements ModuleManager {
	private static $instance;
	private static $logger;
	public static function getInstance() {
		if (! isset ( ClaimsManager::$instance )) {
			self::$instance = new ClaimsManager ();
		}

		return ClaimsManager::$instance;
	}
	private function __construct() {
		self::$logger = $_SESSION ['logger'];
	}

	/**
	 * Returns a list of claims causes
	 *
	 * @return array
	 */
	public function getCauses() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getCauses ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {
			$list [$element ["id"]] = array (
					"name" => Util::cleanString ( $element ["name"] ),
					"subjectId" => $element ["subjectid"]
			);
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claims cause objects
	 *
	 * @return array
	 */
	public function getCausesList() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getCauses ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {

			$obj = new Cause();

			$obj->setId($element['id']);
			$obj->setName($element['name']);
			$obj->setSubjectId($element['subjectid']);

			$list [] = $obj;
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claims cause objects by subject
	 *
	 * @return array
	 */
	public function getCausesBySubject($subjectId) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getCausesBySubject($subjectId);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {

			$obj = new Cause();

			$obj->setId($element['id']);
			$obj->setName($element['name']);

			$list [] = $obj;
			
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claims dependencies
	 *
	 * @return array
	 */
	public function getDependencies() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getDependencies ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {
			$list [$element ["id"]] = Util::cleanString ( $element ["name"] );
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claims dependency objects
	 *
	 * @return array
	 */
	public function getDependenciesList() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getDependencies ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {

			$obj = new Dependency();

			$obj->setId($element['id']);
			$obj->setName($element['name']);
			$obj->setLocation($element['locationid']);

			$list [] = $obj;
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claims input types
	 *
	 * @return array
	 */
	public function getInputTypes() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getInputTypes ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {
			$list [$element ["id"]] = Util::cleanString ( $element ["name"] );
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claims input type objects
	 *
	 * @return array
	 */
	public function getInputTypesList() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getInputTypes ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {

			$obj = new InputType();

			$obj->setId($element['id']);
			$obj->setName(Util::getLiteral($element['name']));

			$list [] = $obj;
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claim origins
	 *
	 * @return array
	 */
	public function getOrigins() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getOrigins ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {
			$list [$element ["id"]] = Util::cleanString ( $element ["name"] );
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claim origin objects
	 *
	 * @return array
	 */
	public function getOriginsList() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getOrigins ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {

			$obj = new Origin();

			$obj->setId($element['id']);
			$obj->setName($element['name']);

			$list [] = $obj;
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claims states
	 *
	 * @return array
	 */
	public function getStates() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getStates ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {
			$list [$element ["id"]] = Util::cleanString ( $element ["name"] );
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claims state objects
	 *
	 * @return array
	 */
	public function getStatesList() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getStates ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {

			$obj = new State();

			$obj->setId($element['id']);
			$obj->setName(Util::getLiteral($element['name']));

			$list [] = $obj;
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claims subjects
	 *
	 * @return array
	 */
	public function getSubjects() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getSubjects ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {
			$list [$element ["id"]] = Util::cleanString ( $element ["name"] );
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of claims subject objects
	 *
	 * @return array
	 */
	public function getSubjectsList() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getSubjects ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {

			$obj = new Subject();

			$obj->setId($element['id']);
			$obj->setName($element['name']);

			$list [] = $obj;
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns a list of teleprom claims causes
	 *
	 * @return array
	 */
	public function getTelepromCauses() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getTelepromCauses ();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {
			$list [$element ["id"]] = array (
					"name" => Util::cleanString ( $element ["name"] ),
					"causeId" => $element ["causeid"]
			);
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Loads all the claims concepts stored in DB
	 */
	public function getClaimsConcepts($locationId) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $_SESSION ['claimsConcepts'] )) {

			unset ( $_SESSION ['claimsConcepts'] );

			$_SESSION ['claimsConcepts'] = array ();

			$_SESSION ['claimsConcepts'] ['causes'] = $this->getCauses ();

			$_SESSION ['claimsConcepts'] ['dependencies'] = $this->getDependencies ();

			$_SESSION ['claimsConcepts'] ['inputtypes'] = $this->getInputTypes ();

			$_SESSION ['claimsConcepts'] ['origins'] = $this->getOrigins ();

			$_SESSION ['claimsConcepts'] ['states'] = $this->getStates ();

			$_SESSION ['claimsConcepts'] ['subjects'] = $this->getSubjects ();

			$_SESSION ['claimsConcepts'] ['telepromCauses'] = $this->getTelepromCauses ();

			$_SESSION ['claimsConcepts'] ['regions'] = $this->getRegions ( $locationId );
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	}

	/**
	 * Uploads a file for importaion
	 *
	 * @param array $file
	 * @throws InvalidArgumentException
	 * @throws Exception
	 * @return string
	 */
	public function uploadFile($file) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $file ) || $file == null || ! is_array ( $file )) {
			$_SESSION ['logger']->error ( "Error uploading file" );
			throw new InvalidArgumentException ( "Error uploading file" );
		}

		$validFileTypes = unserialize ( VALIDFILETYPES );

		$fileData = pathinfo ( $file ['name'] );

		if (! in_array ( $fileData ['extension'], $validFileTypes )) {
			$_SESSION ['logger']->error ( "The selected file has an invalid extension" );
			throw new InvalidArgumentException ( "The selected file has an invalid extension" );
		}

		$file = $file ['tmp_name'];
		$newfile = $_SERVER ['DOCUMENT_ROOT'] . '/modules/claims/imports/' . $fileData ['basename'];

		if (! copy ( $file, $newfile )) {
			$_SESSION ['logger']->error ( "Error uploading file" );
			throw new Exception ( "Error uploading file" );
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $newfile;
	}

	/**
	 * Returns a list of claims
	 *
	 * @param int $begin
	 * @param int $count
	 * @param array $filters
	 * @return Claim array
	 */
	public function getClaims($begin, $count, $filters, $order = 'desc') {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $begin ) || $begin == '') {
			$begin = '0';
		}

		if (! isset ( $count ) || $count == '') {
			$count = '20';
		}

		$list = array ();

		$query = ClaimsDB::getClaims ( $begin, $count, $filters, $order );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );
		
		if (is_array ( $rs )) {

			foreach ( $rs as $element ) {

				$obj = new Claim ( $element ['claimid'], $element ['code'], $element ['requestername'], $element ['claimaddress'], $element ['requesterphone'] );

				$obj->setSubjectName ( $element ['subjectname'] );
				$obj->setInputTypeName ( $element ['inputtypename'] );
				$obj->setCauseName ( $element ['causename'] );
				$obj->setCauseId( $element ['icon']);
				$obj->setOriginName ( $element ['originname'] );
				$obj->setDependencyName ( $element ['dependencyname'] );
				$obj->setStateId ( $element ['stateid'] );
				$obj->setStateName ( $element ['statename'] );
				$obj->setEntryDate ( $element ['entrydate'], 'Y-m-d' );
				$obj->setClosedDate ( $element ['closedate'], 'Y-m-d' );
				$obj->setAssigned ( $element ['assigned'] );
				$obj->setDetail($element['detail']);
				$obj->setPriority($element['priority']);
				$obj->setDetailCloseClaim($element['description']);
				$obj->setMat_1($element['mat_1']);
				$obj->setMat_2($element['mat_2']);
				$obj->setMat_3($element['mat_3']);
				$obj->setMat_4($element['mat_4']);
				$obj->setMat_5($element['mat_5']);



        /*        var_dump($element);
                die();*/

			

				$idUser = 0;
				$nameUser = 'Sin asignar';

				if(isset($element['id'])){
					$idUser = $element['id'];
						
				}


				if(isset($element['name'])){
					$nameUser = $element['name'];
				}
				if(isset ($element['surname'])){
					$nameUser .=' - ' .$element['surname'];
						
				}

				$obj->setUserId($idUser);

				$obj->setUserName($nameUser);

					

				$list [] = $obj;
			}

			
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Returns claim
	 *
	 * @param int $begin
	 * @param int $count
	 * @param array $filters
	 * @return Claim array
	 */
	public function getClaim($id) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = ClaimsDB::getClaim ( $id );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		//$obj = new Claim ();

		if (is_array ( $rs )) {

			foreach ( $rs as $element ) {


				$obj = new Claim ( $element ['claimid'], $element ['code'], $element ['requestername'], $element ['claimaddress'], $element ['requesterphone'] );
				$obj->setSubjectName ( $element ['subjectname'] );
				$obj->setSubjectId ( $element ['subjectid'] );
				$obj->setInputTypeName ( $element ['inputtypename'] );
				$obj->setDetail($element['detail']);
				$obj->setInputTypeId ( $element ['inputtypeid'] );
				$obj->setCauseName ( $element ['causename'] );
				$obj->setCauseId ( $element ['causeid'] );
				$obj->setOriginName ( $element ['originname'] );
				$obj->setOriginId ( $element ['originid'] );
				$obj->setDependencyName ( $element ['dependencyname'] );
				$obj->setDependencyId ( $element ['dependencyid'] );
				$obj->setStateId ( $element ['stateid'] );
				$obj->setStateName ( $element ['statename'] );
				$obj->setStateId ( $element ['stateid'] );
				$obj->setEntryDate ( $element ['entrydate'], 'Y-m-d' );
				$obj->setClosedDate ( $element ['closedate'], 'Y-m-d' );
				$obj->setAssigned ( $element ['assigned'] );
				$obj->setLatitude( $element['latitude'] );
				$obj->setLongitude( $element['longitude'] );
				$obj->setNeighborhood( $element['neighborhood'] );
				$obj->setTypeAddressId($element['typeaddressid']);
				$obj->setUserId($element['systemuserid']);
				$obj->setRegionName($element['regionname']);
				$obj->setPiquete($element['piquete']);
				$obj->setSubstateid($element['substateid']);
				$obj->setNamegroup($element['namegroup']);
				//$obj->setDetail($element['detail']);
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $obj;
	}

	/**
	 * Returns claimPic
	 *
	 *
	 */

	function byteStr2byteArray($s) {
		return array_slice(unpack("C*", "\0".$s), 1);
	}

	public function getClaimPic($id) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = ClaimPicDB::getClaimViewPic($id);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );



			if (is_array ( $rs )) {

				foreach ( $rs as $element ) {


					$obj = new ClaimPic ($element ['claim_id'] );

					if($element[2] != null){

						$obj ->setPhoto($element[2]);
					}

					$obj ->setId('id');


				}
			}



		//var_dump($obj);
		//die();

		//$obj = new Claim ();


		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		//var_dump($element[2]);
		//die();
		return $obj;
	}
    
	/**
	 * Return the claims count
	 *
	 * @param array $filters
	 * @return number
	 */
	public function getClaimsCount($filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$count = 0;

		$query = ClaimsDB::getClaimsCount ( $filters );

		$connectionManager = ConnectionManager::getInstance ();

		$countRS = $connectionManager->select ( $query );

		if (isset ( $countRS [0] ['numrows'] ))
			$count = ( int ) $countRS [0] ['numrows'];

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $count;
	}

	/**
	 * Returns a list of pending teleprom claims
	 *
	 * @param int $begin
	 * @param int $count
	 * @param array $filters
	 * @return Claim array
	 */
	public function getPendingTelepromClaims($begin, $count, $filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $begin ) || $begin == '') {
			$begin = '0';
		}

		if (! isset ( $count ) || $count == '') {
			$count = '20';
		}

		$list = array ();

		$query = ClaimsDB::getPendingTelepromClaims ( $begin, $count, $filters );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if (is_array ( $rs )) {

			foreach ( $rs as $element ) {

				$obj = new TelepromClaim ( $element ['claimid'], $element ['code'], $element ['requesterphone'], '' );

				$obj->setRequesterName ( $element ['requestername'] );
				$obj->setClaimAddress ( $element ['claimaddress'] );
				$obj->setSubjectName ( $element ['subjectname'] );
				$obj->setInputTypeName ( $element ['inputtypename'] );
				$obj->setCauseName ( $element ['causename'] );
				$obj->setOriginName ( $element ['originname'] );
				$obj->setDependencyName ( $element ['dependencyname'] );
				$obj->setStateId ( $element ['stateid'] );
				$obj->setStateName ( $element ['statename'] );
				$obj->setEntryDate ( $element ['entrydate'], 'Y-m-d' );
				$obj->setClosedDate ( $element ['closedate'], 'Y-m-d' );
				$obj->setAssigned ( $element ['assigned'] );
				$obj->setRequesterAddress ( $element ['requesteraddress'] );

				$list [] = $obj;
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Return the pending teleprom claims count
	 *
	 * @param array $filters
	 * @return number
	 */
	public function getPendingTelepromClaimsCount($filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$count = 0;

		$query = ClaimsDB::getPendingTelepromClaimsCount ( $filters );

		$connectionManager = ConnectionManager::getInstance ();

		$countRS = $connectionManager->select ( $query );

		if (isset ( $countRS [0] ['numrows'] ))
			$count = ( int ) $countRS [0] ['numrows'];

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $count;
	}

	/**
	 * Updates claim/s states
	 *
	 * @param int $stateId
	 * @param array $claims
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function changeClaimState($stateId, $claims) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $stateId ) || $stateId == null) {
			self::$logger->error ( 'stateId parameter expected' );
			throw new InvalidArgumentException ( 'stateId parameter expected' );
		}

		if (! isset ( $claims ) || $claims == null || ! is_array ( $claims )) {
			self::$logger->error ( 'claims list must be an array' );
			throw new InvalidArgumentException ( 'claims list must be an array' );
		}

		$query = ClaimsDB::changeClaimState ( $stateId, $claims );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->executeTransaction ( $query );

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $rs;
	}
	/**
	 *
	 * @param int $claimId
	 * @param int $stateId
	 * @throws InvalidArgumentException
	 * @return unknown
	 */
	public function changeStateClaim($claimId, $stateId) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $stateId ) || $stateId == null) {
			self::$logger->error ( 'stateId parameter expected' );
			throw new InvalidArgumentException ( 'stateId parameter expected' );
		}

		if (! isset ( $claimId ) || $claimId == null) {
			self::$logger->error ( 'claimId id ' );
			throw new InvalidArgumentException ( 'claims id parameter expected' );
		}

		$query = ClaimsDB::changeStateClaim ( $claimId, $stateId );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->executeTransaction ( $query );

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $rs;
	}

	/**
	 * Updates a teleprom claim
	 *
	 * @param int $claimId
	 * @param array $claimData
	 * @throws InvalidArgumentException
	 * @throws Exception
	 * @return boolean
	 */
	public function updateTelepromClaim($claimId, $claimData) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $claimId ) || $claimId == null) {
			self::$logger->error ( 'claimId parameter expected' );
			throw new InvalidArgumentException ( 'claimId parameter expected' );
		}

		if (! isset ( $claimData ) || $claimData == null || ! is_array ( $claimData )) {
			self::$logger->error ( 'claimData must be an array' );
			throw new InvalidArgumentException ( 'claimData must be an array' );
		}

		if (! isset ( $claimData ['causeId'] ) || $claimData ['causeId'] == null) {
			self::$logger->error ( 'causeId parameter expected' );
			throw new InvalidArgumentException ( 'causeId parameter expected' );
		}
		$cause = explode ( "_", $claimData ['causeId'] );

		if ($cause [1] == 1) {
			if (! isset ( $claimData ['street'] ) || $claimData ['street'] == null) {
				self::$logger->error ( 'causeId parameter expected' );
				throw new InvalidArgumentException ( 'causeId parameter expected' );
			}

			if (! isset ( $claimData ['streetNumber'] ) || $claimData ['streetNumber'] == null) {
				self::$logger->error ( 'causeId parameter expected' );
				throw new InvalidArgumentException ( 'causeId parameter expected' );
			}
		}

		// Parse cause
		$claimCauses = explode ( '_', $claimData ['causeId'] );
		$claimData ['causeId'] = $claimCauses [0];
		$claimData ['telepromCauseId'] = $claimCauses [1];

		// Update claim address
		$claimData ['claimAddress'] = $claimData ['street'] . ' ' . $claimData ['streetNumber'];

		// Get GeoLocation data
		if (trim ( $claimData ['claimAddress'] ) != '') {

			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/GeoLocation.class.php';

			$fullAddress = trim ( $claimData ['claimAddress'] ) . ' ' . $_SESSION ['loggedUser']->getLocationName () . ' ' . $_SESSION ['loggedUser']->getProvinceName () . ' ' . $_SESSION ['loggedUser']->getCountryName ();

			$geoLocation = new GeoLocation ();
			$geoCodes = $geoLocation->getGeoLocationFromAddress ( $fullAddress );

			if (is_array ( $geoCodes ) && count ( $geoCodes ) > 0) {
				$claimData ['latitude'] = $geoCodes ['lat'];
				$claimData ['longitude'] = $geoCodes ['lon'];
				$claimData ['regionId'] = Util::getClaimRegion ( $claimData ['latitude'], $claimData ['longitude'] );
			}
		}

		// Update basic claim data
		$query1 = ClaimsDB::updateClaim ( $claimId, $claimData );

		$connectionManager = ConnectionManager::getInstance ();

		$rs1 = $connectionManager->executeTransaction ( $query1 );

		if (! $rs1) {
			self::$logger->error ( 'Error updating claim' );
			throw new Exception ( 'Error updating claim' );
		}

		// Insert new phone directory street number
		$streetNumberChk = $claimData ['streetNumberChk'] === 'true' ? true : false;

		if ($streetNumberChk == true) {

			// Insert phone_directory
			$query2 = ClaimsDB::insertPhoneDirectory ( $claimId, $claimData );
			$rs2 = $connectionManager->executeTransaction ( $query2 );

			if (! $rs2) {
				self::$logger->error ( 'Error updating teleprom claim' );
				throw new Exception ( 'Error updating teleprom claim' );
			}
		}

		// Update requester address
		$requesterAddressChk = $claimData ['requesterAddressChk'] === 'true' ? true : false;

		if ($requesterAddressChk == true) {

			if (! isset ( $claimData ['requesterAddress'] ) || $claimData ['requesterAddress'] == null) {
				self::$logger->error ( 'requesterAddress parameter expected' );
				throw new InvalidArgumentException ( 'requesterAddress parameter expected' );
			}

			$query3 = ClaimsDB::updateTelepromClaimRequesterAddress ( $claimId, $claimData );

			$connectionManager = ConnectionManager::getInstance ();

			$rs1 = $connectionManager->executeTransaction ( $query3 );

			if (! $rs1) {
				self::$logger->error ( 'Error updating teleprom claim' );
				throw new Exception ( 'Error updating teleprom claim' );
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return true;
	}

	/**
	 * Return the claims for export processs
	 *
	 * @param array $filters
	 * @return Claim array
	 */
	public function getExportClaims($filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$count = $this->getClaimsCountForExport ( $filters );

		if ($count > 0) {

			$query = ClaimsDB::getClaimsForExport ( 0, $count, $filters, 'asc' );

			$connectionManager = ConnectionManager::getInstance ();

			$rs = $connectionManager->select ( $query );

			$claimFactory = new ClaimFactory ();

			if (is_array ( $rs )) {

				foreach ( $rs as $element ) {

					$obj = $claimFactory->createClaim ( $element );

					$list [] = $obj;
				}
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		var_dump($list);
		die();
		return $list;
	}
	/**
	 * Return the claims for export processs
	 *
	 * @param array $filters
	 * @return Claim array
	 */
	public function getExportExcelClaims($filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$count = $this->getClaimsCountForExport ( $filters );

		if ($count > 0) {

			$query = ClaimsDB::getClaimsForExport ( 0, $count, $filters, 'asc' );

			$connectionManager = ConnectionManager::getInstance ();

			$rs = $connectionManager->select ( $query );


			if (is_array ( $rs )) {

				foreach ( $rs as $element ) {

				$obj = new Claim ( $element ['claimid'], $element ['code'], $element ['requestername'], $element ['claimaddress'], $element ['requesterphone'] );

				$obj->setSubjectName ( $element ['subjectname'] );
				$obj->setInputTypeName ( $element ['inputtypename'] );
				$obj->setCauseName ( $element ['causename'] );
				$obj->setCauseId( $element ['icon']);
				$obj->setOriginName ( $element ['originname'] );
				$obj->setDependencyName ( $element ['dependencyname'] );
				$obj->setStateId ( $element ['stateid'] );
				$obj->setStateName ( $element ['statename'] );
				$obj->setEntryDate ( $element ['entrydate'], 'Y-m-d' );
				$obj->setClosedDate ( $element ['closedate'], 'Y-m-d' );
				$obj->setAssigned ( $element ['assigned'] );
				$obj->setDetail($element['detail']);
				$obj->setPriority($element['priority']);
				$obj->setDetailCloseClaim($element['description']);
				$obj->setMat_1($element['mat_1']);
				$obj->setMat_2($element['mat_2']);
				$obj->setMat_3($element['mat_3']);
				$obj->setMat_4($element['mat_4']);
				$obj->setMat_5($element['mat_5']);

				$idUser = 0;
				$nameUser = 'Sin asignar';

				if(isset($element['id'])){
					$idUser = $element['id'];
						
				}


				if(isset($element['name'])){
					$nameUser = $element['name'];
				}
				if(isset ($element['surname'])){
					$nameUser .=' - ' .$element['surname'];
						
				}

				$obj->setUserId($idUser);

				$obj->setUserName($nameUser);

					

				$list [] = $obj;
				}
			}
		}


		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		// var_dump($list);
		// die();
		return $list;
	}

	/**
	 * Return the claims count for export
	 *
	 * @param array $filters
	 * @return number
	 */
	public function getClaimsCountForExport($filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$count = 0;

		$query = ClaimsDB::getClaimsCountForExport ( $filters );

		$connectionManager = ConnectionManager::getInstance ();

		$countRS = $connectionManager->select ( $query );

		if (isset ( $countRS [0] ['numrows'] ))
			$count = ( int ) $countRS [0] ['numrows'];

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $count;
	}

	/**
	 * Get the total of claims group by state
	 *
	 * @param array $filters
	 * @return array
	 */
	public function getCounters($filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$counters = array ();

		$query = ClaimsDB::getCounters ( $filters );

		$connectionManager = ConnectionManager::getInstance ();

		$countersRS = $connectionManager->select ( $query );

		foreach ( $countersRS as $counter ) {

			if (isset ( $counter ['stateid'] ) && $counter ['stateid'] == claimsConcepts::PENDINGSTATE) {
				$counters [claimsConcepts::PENDINGSTATE] = $counter ['claims'];
			} elseif (isset ( $counter ['stateid'] ) && $counter ['stateid'] == claimsConcepts::CLOSEDSTATE) {
				$counters [claimsConcepts::CLOSEDSTATE] = $counter ['claims'];
			} elseif (isset ( $counter ['stateid'] ) && $counter ['stateid'] == claimsConcepts::CANCELLEDSTATE) {
				$counters [claimsConcepts::CANCELLEDSTATE] = $counter ['claims'];
			} elseif (isset ( $counter ['stateid'] ) && $counter ['stateid'] == claimsConcepts::CLOSEDSTATENOGEO) {
				$counters [claimsConcepts::CLOSEDSTATENOGEO] = $counter ['claims'];
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $counters;
	}

	/**
	 * Updates basic claim data
	 *
	 * @param int $claimId
	 * @param array $claimData
	 * @throws InvalidArgumentException
	 * @throws Exception
	 * @return boolean
	 */
	public function updateClaim($claimId, $claimData) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $claimId ) || $claimId == null) {
			self::$logger->error ( 'claimId parameter expected' );
			throw new InvalidArgumentException ( 'claimId parameter expected' );
		}

		if (! isset ( $claimData ) || $claimData == null || ! is_array ( $claimData )) {
			self::$logger->error ( 'claimData must be an array' );
			throw new InvalidArgumentException ( 'claimData must be an array' );
		}

		// Region retrieving
		if (isset ( $claimData ['latitude'] ) && $claimData ['latitude'] != null && isset ( $claimData ['longitude'] ) && $claimData ['longitude'] != null) {
			$claimData ['regionId'] = Util::getClaimRegion ( $claimData ['latitude'], $claimData ['longitude'] );
		}

		// Update basic claim data
		$query = ClaimsDB::updateClaim ( $claimId, $claimData );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->executeTransaction ( $query );

		if (! $rs) {
			self::$logger->error ( 'Error updating claim' );
			throw new Exception ( 'Error updating claim' );
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return true;
	}

	/**
	 * Loads the regions for a given location
	 *
	 * @param int $locationId
	 * @return array
	 */
	public function getRegions($locationId) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = ClaimsDB::getRegions ( $locationId );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {
			$list [$element ["id"]] = array (
					"name" => $element ["name"],
					"coordinates" => explode ( ';', $element ["coordinates"] ),
					"position" => $element ["position"]
			);
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Loads a region for a given id
	 *
	 * @param int $regionId
	 * @return Region region
	 */
	public function getRegionById($regionId) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$region = new Region ();

		$query = ClaimsDB::getRegionById ( $regionId );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		foreach ( $rs as $element ) {
			$region->setId ( $element ['id'] );
			$region->setName ( $element ['name'] );			
			$region->setCoordinates ( explode ( ';', $element ['coordinates'] ) );
			$region->setPosition ( $element ['position'] );
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $region;
	}

	/**
	 * Retrieves all the claim stats for a given dependency
	 *
	 * @param int $dependencyId
	 * @param array $filters
	 * @param string $mapImage
	 * @return Map
	 */
	public function getRegionsStats($dependencyId, $filters, $mapImage) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$map = false;
		$regions = array ();

		$query = ClaimsDB::getRegionsStats ( $dependencyId, $filters );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if (is_array ( $rs ) && count ( $rs ) > 0) {

			foreach ( $rs as $element ) {

				if (isset ( $element ['regionid'] ) && $element ['regionid'] != null) {

					if (! isset ( $regions [$element ['regionid']] )) {
						$regions [$element ['regionid']] = new Region ( $element ['regionid'], $element ['regionname'], '', '' );
						$regions [$element ['regionid']]->setPosition ( $element ['position'] );
					}

					$stat = array (
							"stateid" => $element ['stateid'],
							"state" => Util::getLiteral ( $element ['statename'] ),
							"total" => $element ['total']
					);

					$regions [$element ['regionid']]->addStat ( $stat );
				}
			}
		}

		$map = new Map ( $mapImage, $regions );

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $map;
	}

	/**
	 * Retrieves all the claim stats.
	 *
	 * @param
	 *        	Int dependencyId
	 * @param array $filters
	 * @return Region[] An array containing the regions.
	 */
	public function getRegionsStatsForClaims($dependencyId, $filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$map = false;
		$regions = array ();
		$query = ClaimsDB::getRegionsStats ( $dependencyId, $filters );
		$connectionManager = ConnectionManager::getInstance ();
		$regionStats = $connectionManager->select ( $query );

		if (is_array ( $regionStats ) && count ( $regionStats ) > 0) {
			foreach ( $regionStats as $element ) {
				if (isset ( $element ['regionid'] ) && $element ['regionid'] != null) {
					if (! isset ( $regions [$element ['regionid']] )) {
						$id = $element ['regionid'];
						$regions [$id] = new Region ( $id, $element ['regionname'], '', '' );
						$regions [$id]->setPosition ( $element ['position'] );
						$regions [$id]->setCoordinates ( $element ['coordinates'] );
					}
				}
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $regions;
	}

	/**
	 *
	 * @param integer $regionId
	 */
	public function getCountStatsByRegion($regionId, $filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $regionId ) || $regionId == null) {
			self::$logger->error ( 'regionId parameter expected' );
			throw new InvalidArgumentException ( 'regionId parameter expected' );
		}

		$count = 0;

		$query = ClaimsDB::getStatsByRegion ( $regionId, $filters );
		$connectionManager = ConnectionManager::getInstance ();
		$countRS = $connectionManager->select ( $query );

		if (isset ( $countRS [0] ['count'] ))
			$count = ( int ) $countRS [0] ['count'];

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $count;
	}

	/**
	 * Get the stats for teleprom claims
	 *
	 * @param int $dependencyId
	 * @param array $filters
	 * @return array
	 */
	public function getTelepromStats($dependencyId, $filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$stats = array ();

		$query = ClaimsDB::getTelepromStats ( $dependencyId, $filters );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if (is_array ( $rs ) && count ( $rs ) > 0) {

			foreach ( $rs as $element ) {

				if ($element ['datum'] != '' && $element ['datum'] != null) {

					if ($element ['causeid'] != '' && $element ['causeid'] != null) {
						$stats [$element ['datum']] [$element ['causename']] = $element ['total'];
					} else {
						$stats [$element ['datum']] ["emptyCause"] = $element ['total'];
					}
				} else {

					if ($element ['causeid'] != '' && $element ['causeid'] != null) {
						$stats ["Datum Vacio"] [$element ['causename']] = $element ['total'];
					} else {
						$stats ["Datum Vacio"] ["emptyCause"] = $element ['total'];
					}
				}
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $stats;
	}

	/**
	 * Get the claim coordinates
	 *
	 * @param array $filters
	 * @return array
	 */
	public function getAdrClaimCoords($filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = ClaimsDB::getAdrClaimCoords ( $filters );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		$list = array ();

		if (is_array ( $rs )) {

			foreach ( $rs as $element ) {

				$obj = new Claim ( $element ['id'], $element ['code'], $element ['requestername'], $element ['claimaddress'], $element ['requesterphone'] );

				$obj->setSubjectName ( $element ['subjectname'] );
				$obj->setInputTypeName ( $element ['inputtypename'] );
				$obj->setCauseName ( $element ['causename'] );
				$obj->setOriginName ( $element ['originname'] );
				$obj->setDependencyName ( $element ['dependencyname'] );
				$obj->setStateId ( $element ['stateid'] );
				$obj->setStateName ( $element ['statename'] );
				$obj->setEntryDate ( $element ['entrydate'], 'Y-m-d' );
				$obj->setClosedDate ( $element ['closedate'], 'Y-m-d' );
				$obj->setAssigned ( $element ['assigned'] );
				$obj->setLatitude ( $element ['latitude'] );
				$obj->setLongitude ( $element ['longitude'] );

				$list [] = $obj;
			}
		}


		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	public function getPublicClaimCoords($filters) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$query = ClaimsDB::getPublicClaimCoords ( $filters );
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		$list = array ();
		
		if (is_array ( $rs )) {
			
			foreach ( $rs as $element ) {
				
				$obj = new Claim ( $element ['id'], $element ['code'], $element ['requestername'], $element ['claimaddress'], $element ['requesterphone'] );
				
				$obj->setSubjectName ( $element ['subjectname'] );
				$obj->setInputTypeName ( $element ['inputtypename'] );
				$obj->setCauseName ( $element ['causename'] );
				$obj->setOriginName ( $element ['originname'] );
				$obj->setDependencyName ( $element ['dependencyname'] );
				$obj->setStateId ( $element ['stateid'] );
				$obj->setStateName ( $element ['statename'] );
				$obj->setEntryDate ( $element ['entrydate'], 'Y-m-d' );
				$obj->setClosedDate ( $element ['closedate'], 'Y-m-d' );
				$obj->setAssigned ( $element ['assigned'] );
				$obj->setLatitude ( $element ['latitude'] );
				$obj->setLongitude ( $element ['longitude'] );
				
				$list [] = $obj;
			}
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	 public function getPublicClaim($filters) {
                self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

                $query = ClaimsDB::getPublicClaim ( $filters );

                $connectionManager = ConnectionManager::getInstance ();

                $rs = $connectionManager->select ( $query );

                $list = array ();

                if (is_array ( $rs )) {

                        foreach ( $rs as $element ) {

                                $obj = new Claim ( $element ['id'], $element ['code'], $element ['requestername'], $element ['claimaddress'], $element ['requesterphone'] );

                                $obj->setSubjectName ( $element ['subjectname'] );
                                $obj->setInputTypeName ( $element ['inputtypename'] );
                                $obj->setCauseName ( $element ['causename'] );
                                $obj->setOriginName ( $element ['originname'] );
                                $obj->setDependencyName ( $element ['dependencyname'] );
                                $obj->setStateId ( $element ['stateid'] );
                                $obj->setStateName ( $element ['statename'] );
                                $obj->setEntryDate ( $element ['entrydate'], 'Y-m-d' );
                                $obj->setClosedDate ( $element ['closedate'], 'Y-m-d' );
                                $obj->setAssigned ( $element ['assigned'] );
                                $obj->setLatitude ( $element ['latitude'] );
                                $obj->setLongitude ( $element ['longitude'] );

                                $list [] = $obj;
                        }
                }

                self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

                return $list;
        }

	/**
	 * Get the critical time for a pending claim
	 *
	 * @param int $stateId
	 * @param date $entryDate
	 * @return number
	 */
	public static function getCheckCriticalPendingClaim($claimId) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$isCritical = 0;

		$query = ClaimsDB::getClaim ( $claimId );
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select ( $query );

		if ($rs [0] ['stateid'] == claimsConcepts::PENDINGSTATE) {
			$now = DateTime::createFromFormat ( 'd/m/Y', date ( 'd/m/Y' ) );
			$diff = $now->diff ( DateTime::createFromFormat ( 'Y-m-d H:i:s', $rs [0] ['entrydate'] . ' 00:00:00' ) );
			$years = $diff->y;
			$months = $diff->m;
			$days = $diff->d;
			if ($years > 0 || $months > 0 || $days >= claimsConcepts::CRITICALPENDINGSTATETIME) {
				$isCritical = 1;
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $isCritical;
	}

	/**
	 * Gets all unassigned claims
	 *
	 * @param array $filters
	 * @return array
	 */
	public static function getAdrUnassignedClaimsCoords($groupId) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = ClaimsDB::getAdrUnassignedClaimsCoords ($groupId);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		$list = array ();

		if (is_array ( $rs )) {

			foreach ( $rs as $element ) {

				$obj = new Claim ( $element ['id'], $element ['code'], $element ['requestername'], $element ['claimaddress'], $element ['requesterphone'] );

				$obj->setSubjectName ( $element ['subjectname'] );
				$obj->setInputTypeName ( $element ['inputtypename'] );
				$obj->setCauseName ( $element ['causename'] );
				$obj->setOriginName ( $element ['originname'] );
				$obj->setDependencyName ( $element ['dependencyname'] );
				$obj->setStateId ( $element ['stateid'] );
				$obj->setStateName ( $element ['statename'] );
				$obj->setEntryDate ( $element ['entrydate'], 'Y-m-d' );
				$obj->setClosedDate ( $element ['closedate'], 'Y-m-d' );
				$obj->setAssigned ( $element ['assigned'] );
				$obj->setLatitude ( $element ['latitude'] );
				$obj->setLongitude ( $element ['longitude'] );
				$obj->setPriority( $element['priority']);
				$obj->setCauseId ( $element ['icon'] );
				

				$list [] = $obj;

			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}

	/**
	 * Gets all unassigned claims
	 *
	 * @param array $filters
	 * @return array
	 */
	public static function getAssignedClaimsForUser($filters,$groupId, $orderField = NULL) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = ClaimsDB::getAssignedClaimsForUser ( $filters,$groupId, $orderField );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );
		
		$list = array ();

		if (is_array ( $rs )) {

			foreach ( $rs as $element ) {

				 $obj = new Claim ( $element ['id'], $element ['code'], $element ['requestername'], $element ['claimaddress'], $element ['requesterphone'] );

				 $obj->setSubjectName ( $element ['subjectname'] );
				 $obj->setInputTypeName ( $element ['inputtypename'] );
				 $obj->setCauseName ( $element ['causename'] );
				 $obj->setOriginName ( $element ['originname'] );
				 $obj->setDependencyName ( $element ['dependencyname'] );
				 $obj->setStateId ( $element ['stateid'] );
				 $obj->setStateName ( $element ['statename'] );
				 $obj->setEntryDate ( $element ['entrydate'], 'Y-m-d' );
				 $obj->setClosedDate ( $element ['closedate'], 'Y-m-d' );
				 $obj->setAssigned ( $element ['assigned'] );
				 $obj->setLatitude ( $element ['latitude'] );
				 $obj->setLongitude ( $element ['longitude'] );
				 $obj->setSubstateid ( $element ['substateid'] );


				//  $obj = new ClaimMap ( $element ['id'], $element ['code']);
				//  $obj->setLatitude ( $element ['latitude'] );
				//  $obj->setLongitude ( $element ['longitude'] );
				//  $obj->setGroupid ($element ['groupid']);
				//  $obj->setStateid ( $element ['stateid'] );


				$list [] = $obj;
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	}
	
		/**
	 * Gets all unassigned claims by group
	 *
	 * @return array
	 */
	public static function getClaimsMapGroup() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = ClaimsDB::getClaimsMapGroup();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );
		
		$list = array ();

		if (is_array ( $rs )) {

			foreach ( $rs as $element ) {
				
				$obj = new ClaimMap ( $element ['id'], $element ['code']);
				$obj->setLatitude ( $element ['latitude'] );
				$obj->setLongitude ( $element ['longitude'] );
				$obj->setGroupid ($element ['groupid']);
				$obj->setNamegroup ($element ['namegroup']);
				$obj->setIcon ($element ['icon']);

				
				$list [] = $obj;
			}
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;
	}
	/**
	 * Get a claim
	 *
	 * @param array $filters
	 * @param string $order
	 * @return claim
	 */
	public static function getClaimByCode($filters, $order = 'ASC') {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = ClaimsDB::getClaimByCode ( $filters, $order );

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $rs;
	}
	public function getClaimsByUser($id, $groupId){
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' beging' );
		
		$query = ClaimsDB::getClaimsByUser($id, $groupId);
		
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		$list = array();
			if (is_array ( $rs )) {
			
				foreach ( $rs as $element ) {
			
					$obj = new Claim ( $element ['id'], $element ['code'],null,null,null);		
					$obj->setUserId($element ['systemuserid']);
					$list [] = $obj;
				}
			}		
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $list;
	}
	

	/**
	 * Assign claims to adr user
	 *
	 * @param array $postData
	 */
	public static function assignClaimsToAdrUser($userId, $claimData,$groupId) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$connectionManager = ConnectionManager::getInstance ();

		// Get claims id for $userId
		$query = ClaimsDB::getClaimsByUser ( $userId ,$groupId);
		$currentAssignedClaims = $connectionManager->select ( $query );

		if ($currentAssignedClaims != null && is_array ( $currentAssignedClaims )) {

			// Delete the systemuserid to the prev found claims
			$query1 = ClaimsDB::unassignUserByClaims ( $currentAssignedClaims );
			$rs = $connectionManager->executeTransaction ( $query1 );

			if (! $rs) {
				self::$logger->error ( 'Error updating claim' );
				throw new Exception ( 'Error updating claim' );
			}

			// Delete the claims from the ordered list
			$query4 = ClaimsDB::removeClaimFromList ( $currentAssignedClaims );
			$rs3 = $connectionManager->executeTransaction ( $query4 );

			if (! $rs3) {
				self::$logger->error ( 'Error updating claims ordered list' );
				throw new Exception ( 'Error updating claims ordered list' );
			}
		}

		if (isset ( $claimData ) && $claimData != null && is_array ( $claimData )) {

			// Set the systemuserid to the new claims
			$query2 = ClaimsDB::assignClaimsToUser ( $userId, $claimData );
			$rs1 = $connectionManager->executeTransaction ( $query2 );

			if (! $rs1) {
				self::$logger->error ( 'Error updating claim' );
				throw new Exception ( 'Error updating claim' );
			}

			// Set the order of the new list
			for($i = 0; $i < count ( $claimData ); $i ++) {

				$query3 = ClaimsDB::setListPlace ( $userId, $claimData [$i], $i + 1 );
				$rs2 = $connectionManager->executeTransaction ( $query3 );

				if (! $rs2) {
					self::$logger->error ( 'Error inserting order' );
					throw new Exception ( 'Error inserting order' );
				}
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return true;
	}

	/**
	 * Assign claims to groupId
	 *
	 * @param array $postData
	 */
	public static function assignClaimsToGroupId($groupId, $claimData) {
		//self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$connectionManager = ConnectionManager::getInstance ();

		// Get claims id for $userId
		$query = ClaimsDB::getClaimsByGroup ( $groupId );
		$currentAssignedClaims = $connectionManager->select ( $query );

		if ($currentAssignedClaims != null && is_array ( $currentAssignedClaims )) {

			// Delete the systemuserid to the prev found claims
			$query1 = ClaimsDB::unassignGroupByClaims ( $currentAssignedClaims );
			$rs = $connectionManager->executeTransaction ( $query1 );

			if (! $rs) {
				self::$logger->error ( 'Error updating claim' );
				throw new Exception ( 'Error updating claim' );
			}

		}

		if (isset ( $claimData ) && $claimData != null && is_array ( $claimData )) {

			// Set the systemuserid to the new claims
			$query2 = ClaimsDB::assignClaimsToGroup ( $groupId, $claimData );
			$rs1 = $connectionManager->executeTransaction ( $query2 );

			if (! $rs1) {
				self::$logger->error ( 'Error updating claim' );
				throw new Exception ( 'Error updating claim' );
			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return true;
	}

/**
	 * Add a claims multiple
	 *
	 * @param int $claimId
	 * @param array $claimData
	 * @throws InvalidArgumentException
	 * @throws Exception
	 * @return boolean
	 */

	/**
	 * Add or update a claim
	 *
	 * @param int $claimId
	 * @param array $claimData
	 * @throws InvalidArgumentException
	 * @throws Exception
	 * @return boolean
	 */
	public function saveManualClaim($claimId, $claimData) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $claimData ) || $claimData == null || ! is_array ( $claimData )) {
			self::$logger->error ( 'claimData must be an array' );
			throw new InvalidArgumentException ( 'claimData must be an array' );
		}

		if (! isset ( $claimId ) || $claimId == null) {
			//Nuevo reclamo, generar code.
			$manualClaimFactory = new ManualClaimFactory();

			//Devuelve el ManualClaimCreator
			$creator = $manualClaimFactory->create();

			$records = $creator->create($claimData);

			if(!$records) {
				self::$logger->error ( 'Error inserting a new claim' );
				throw new Exception ( 'Error inserting a new claim' );
			}

		} else {
			//Reclamo existente
			//$cause = explode ( "_", $claimData ['causeId'] );
			if(isset($claimData ['causeId'])){
				$causeId = $claimData ['causeId'];
			}
			
			if ($causeId == 1) {
				if (! isset ( $claimData ['street'] ) || $claimData ['street'] == null) {
					self::$logger->error ( 'causeId parameter expected' );
					throw new InvalidArgumentException ( 'causeId parameter expected' );
				}
					
				if (! isset ( $claimData ['streetNumber'] ) || $claimData ['streetNumber'] == null) {
					self::$logger->error ( 'causeId parameter expected' );
					throw new InvalidArgumentException ( 'causeId parameter expected' );
				}
			}

			// Parse cause
			$claimCauses = explode ( '_', $claimData ['causeId'] );
			$claimData ['causeId'] = $claimCauses [0];

			// Get GeoLocation data
			if (trim ( $claimData ['claimAddress'] ) != '' && trim($claimData ['latitude']) == '' && trim($claimData['longitude']) == '') {
					
				require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/GeoLocation.class.php';
					
				$fullAddress = trim ( $claimData ['claimAddress'] ) . ' ' . $_SESSION ['loggedUser']->getLocationName () . ' ' . $_SESSION ['loggedUser']->getProvinceName () . ' ' . $_SESSION ['loggedUser']->getCountryName ();
					
				$geoLocation = new GeoLocation ();
				$geoCodes = $geoLocation->getGeoLocationFromAddress ( $fullAddress );
					
				if (is_array ( $geoCodes ) && count ( $geoCodes ) > 0) {
					$claimData ['latitude'] = $geoCodes ['lat'];
					$claimData ['longitude'] = $geoCodes ['lon'];
					$claimData ['regionId'] = Util::getClaimRegion ( $claimData ['latitude'], $claimData ['longitude'] );
				}
			}

			// Update basic claim data
			$query = ClaimsDB::updateClaim ( $claimId, $claimData );

			$connectionManager = ConnectionManager::getInstance ();

			$rs = $connectionManager->executeTransaction ( $query );

			if (!$rs) {
				self::$logger->error ( 'Error updating claim' );
				throw new Exception ( 'Error updating claim' );
			}
			
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return true;
	}

	public static function getAllClaimStreet($filters, $order='ASC'){
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		$query = ClaimsDB::getAllClaimStreet($filters, $order);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $rs;
	}
	
	public static function getAllNumberStreet($filters, $order='ASC'){
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		$query = ClaimsDB::getAllNumberStreet($filters, $order);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $rs;
	}
	
	public function getAllDistrict($filters, $order='ASC'){
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		$query = ClaimsDB::getAllDistrict($filters, $order);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $rs;
	
	}
	
	public static function getLatLong($filters){
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		$query = ClaimsDB::getLatLong($filters);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $rs;
	}
	
	public function getAllBlockDistrict($filters, $order='ASC'){
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		$query = ClaimsDB::getAllBlockDistrict($filters, $order);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $rs;
	
	}
	
	public function getAllHomeBlock($filters, $order='ASC'){
	
		$query = ClaimsDB::getAllHomeBlock($filters, $order);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $rs;
	}
	public function getTypeAddress($filters){
		$query = ClaimsDB::getTypeAddress($filters);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $rs;
	}
	
	public function getCountMapCity(){
		$query = ClaimsDB::getCountMapCity();
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );		
		$count = 0;
		foreach ($rs as $element){
			
			$count = $element[0];			
			
		}
		return $count;
	}
	
	public function getTypeAddressConcept($id){
		$query = ClaimsDB::getTypeAddressConceptById($id);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		$concept = "";
		foreach ($rs as $element){
			
			$concept = $element[0];
		}
		return $concept;
	}
	
	public function getTypeAddressById($id){
		$query = ClaimsDB::getTypeAddressById($id);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );		
		$typeAddress = new TypeAddress();
		foreach ($rs as $element){
			
			$typeAddress->setId($element['id']);
			$typeAddress->setBlock($element['block']);
			$typeAddress->setHouse($element['house']);
			$typeAddress->setDistrict($element['district']);
			$typeAddress->setStreet($element['street']);
			$typeAddress->setNumber($element['number']);
			$typeAddress->setLatitude($element['latitude']);
			$typeAddress->setLongitude($element['longitude']);
			$typeAddress->setType($element['type']);
		}	
		
		return $typeAddress;			
	}
	
	public function getClaimsByGroup($id){
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' beging' );
		
		$query = ClaimsDB::getClaimsByGroup($id);
		
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		$list = array();
			if (is_array ( $rs )) {
			
				foreach ( $rs as $element ) {
					$obj = new Claim ( $element ['id'], $element ['code']);		
					$obj->setGroupId($element ['groupid']);
					$list [] = $obj;
					
				}
			}		
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $list;
	}
	public function getClaimByGroup($id){
		//self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' beging' );
		
		$query = ClaimsDB::getClaimsByGroup($id);
		
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		$list = array();
			if (is_array ( $rs )) {
			
				foreach ( $rs as $element ) {
					$obj = new ClaimMap ( $element ['id'], $element ['code']);		
					$obj->setGroupId($element ['groupid']);
					$list [] = $obj;
					
				}
			}		
		
		//self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $list;
	}
	public function getGroupInfo($id){
		//self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' beging' );
		
		$query = ClaimsDB::getGroupInfo($id);
		
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		$list = array();
			if (is_array ( $rs )) {
			
				foreach ( $rs as $element ) {
					$obj = new Group ( $element ['id'], $element ['name'], $element ['icon']);
					$list [] = $obj;
					
				}
			}	
		
		return $list;
	}
	public function getMaterialsByClaim($id){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' beging' );
		$query = ClaimsDB::getMaterialsByClaim($id);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		
		$list = array();
		
		if(is_array($rs)){
			
			foreach ($rs as $element) {
				
				$material = new MaterialLdr($element['id'], $element['name'], $element['description']);
				
				$list[] = $material;
			}
			
		}
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	}
	
	public static function getWithoutFixingByClaim($id){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' beging' );
		$query = ClaimsDB::getWithoutFixingByClaim($id);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		$without= null;
		
		if(is_array($rs)){
				
			foreach ($rs as $element) {
		
				$without = new WithoutFixing($element['id'], $element['name'], $element['description']);
				
			}

		return $without;	
		}
		
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
	}
	
	public static function getClosedDescription($id){
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' beging' );
		$query = ClaimsDB::getClosedDescription($id);
		$connectionManager = ConnectionManager::getInstance ();
		$rs = $connectionManager->select($query);
		$description = "";
		
		if(is_array($rs)){
			
			foreach ($rs as $element) {
				
				
				$description = $element['description'];
				
			}
						
		}
		
		return $description;
	}
	
}
