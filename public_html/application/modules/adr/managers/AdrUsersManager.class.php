<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/db/AdrUsersDB.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/db/UsersDB.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrUser.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrUserPoint.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrUserState.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrZone.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrUserZoneEvent.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrPhoneCompany.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/EnumPhoneCompany.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrPlan.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrSubstateActivityUser.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/EnumSubstateActivityUser.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Claim.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/EnumConceptActivityUser.class.php';
/**
 * Handles all the adr users operations
 * @author mmogrovejo
 *
 */
class AdrUsersManager implements ModuleManager {

	private static $instance;

	private static $logger;

	public static function getInstance() {

		if (! isset ( AdrUsersManager::$instance)) {
			self::$instance = new AdrUsersManager();
		}

		return AdrUsersManager::$instance;

	}

	private function __construct() {

		self::$logger = $_SESSION ['logger'];

	}

	/**
	 * Return the adr users count
	 * @param array $filters
	 * @return number
	 */
	public function getAdrUsersCount($filters) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$count = 0;

		$query = AdrUsersDB::getAdrUsersCount($filters);

		$connectionManager = ConnectionManager::getInstance ();

		$countRS = $connectionManager->select ( $query );

		if (isset ( $countRS [0] ['numrows'] ))
			$count = ( int ) $countRS [0] ['numrows'];

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $count;

	}

	/**
	 * Return the adr plans count
	 * @param array $filters
	 * @return number
	 */
	public function getAdrPlansCount($filters) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$count = 0;

		$query = AdrUsersDB::getAdrUsersCount($filters);

		$connectionManager = ConnectionManager::getInstance ();

		$countRS = $connectionManager->select ( $query );

		if (isset ( $countRS [0] ['numrows'] ))
			$count = ( int ) $countRS [0] ['numrows'];

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $count;

	}

	/**
	 * Returns a list of adr users
	 * @param int $begin
	 * @param int $count
	 * @param array $filters
	 * @return AdrUsers array
	 */
	public function getAdrUsers($begin, $count, $filters, $order = 'desc'){

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $begin ) || $begin == '') {
			$begin = EnumCommon::LIST_ITEM_BEGIN;
		}

		if (! isset ( $count ) || $count == '') {
			$count = EnumCommon::LIST_ITEM_COUNT;
		}

		$list = array ();

		$query = AdrUsersDB::getAdrUsers($begin, $count, $filters, $order);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			foreach ( $rs as $element ) {

				$obj = new AdrUser();

				$obj->setId($element['userid']);
				$obj->setUserLogin($element['userlogin']);
				$obj->setPassword($element['password']);
				$obj->setFirstName($element['name']);
				$obj->setLastName($element['surname']);
				$obj->setPhoneNumber($element['phone']);
				$obj->setPhoneCompany($element['phonecompany']);
				$obj->setPlanName($element['planname']);
				$obj->setStateName($element['statename']);
				$obj->setPlanId($element['planid']);
				$list [] = $obj;
			}

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;

	}

	/**
	 * Returns a list of adr users
	 * @param int $begin
	 * @param int $count
	 * @param array $filters
	 * @return AdrPlan array
	 */
	public function getAdrPlans($begin, $count, $filters, $order = 'desc'){

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if (! isset ( $begin ) || $begin == '') {
			$begin = EnumCommon::LIST_ITEM_BEGIN;
		}

		if (! isset ( $count ) || $count == '') {
			$count = EnumCommon::LIST_ITEM_COUNT;
		}

		$list = array ();

		$query = AdrUsersDB::getAdrUsers($begin, $count, $filters, $order);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			foreach ( $rs as $element ) {

				$obj = new AdrUser( $element['id'], $element['userlogin'], $element['userpassword'] );

				$obj->setId($element['id']);
				$obj->setUserLogin($element['userlogin']);
				$obj->setUserPassword($element['userpassword']);

				$list [] = $obj;
			}

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;

	}

	/**
	 * Deletes one adr user
	 * @param int $userId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function deleteAdrUser($userId){

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$result = false;

		$connectionManager = ConnectionManager::getInstance ();

		$query = AdrUsersDB::deleteAdrUser($userId);
		$rs = $connectionManager->executeTransaction($query);

		$query1 = UsersDB::deleteUser($userId);
		$rs1 = $connectionManager->executeTransaction($query1);

		if(!$rs || !$rs1) {
			$this->logger->error("Error deleting the user");
			throw new UnexpectedValueException("Error deleting the user");
		} else {
			$result = true;
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $result;

	}

	/**
	 * Gets a adr user
	 * @param int $userId
	 * @return array user
	 */
	public function getUser($userId) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = AdrUsersDB::getUserById($userId);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			$user = new AdrUser();

			$user->setId($rs[0]['userid']);
			$user->setUserLogin($rs[0]['userlogin']);
			$user->setPassword($rs[0]['password']);
			$user->setFirstName($rs[0]['name']);
			$user->setLastName($rs[0]['surname']);
			$user->setPhoneNumber($rs[0]['phone']);
			$user->setPhoneCompany($rs[0]['phonecompany']);
			$user->setPlanId($rs[0]['planid']);
			$user->setPlanName($rs[0]['planname']);
			$user->setStateId($rs[0]['stateid']);
			$user->setStateName($rs[0]['statename']);
			$user->setRegistrationId($rs[0]['registrationid']);
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $user;

	}

	/**
	 * Saves an adr user
	 * @param AdrUser $user
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function saveAdrUser($userData) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$result = false;

		// FIXME: cambiar por la query
		$rs = array(
				array(
						'id' 	=> 1,
						'name' 	=> EnumPhoneCompany::CLARO
				),
				array(
						'id' 	=> 2,
						'name' 	=> EnumPhoneCompany::MOVISTAR
				),
				array(
						'id' 	=> 3,
						'name' 	=> EnumPhoneCompany::NEXTEL
				),
				array(
						'id' 	=> 4,
						'name' 	=> EnumPhoneCompany::PERSONAL
				)
		);

		foreach ( $rs as $element ) {
			if($element['id'] == $userData['phoneCompanyId']) {

				$userData['phoneCompany'] = $element['name'];

			}
		}
		/////

		if( $userData['id'] == '' ) {

			$exist = $this->checkAdrUserLoggin($_POST['loggin']);

			if ( $exist ) {
				$this->logger->error("This loggin name exists in the system");
				throw new UnexpectedValueException("This loggin name exists in the system");
			} else {
				$connectionManager = ConnectionManager::getInstance ();

				// Insert the system user
				$query = UsersDB::insertUser($userData);
				$newId = $connectionManager->executeTransaction($query, true, 'gdr_user_id_seq');

				// Insert the adr user
				$query1 = AdrUsersDB::addAdrUser($newId, $userData);
				$rs1 = $connectionManager->executeTransaction($query1);

				if(!$rs1) {
					$this->logger->error("Error saving the new user");
					throw new UnexpectedValueException("Error saving the new user");
				} else {
					$result = true;
				}

			}

		} else {
			$connectionManager = ConnectionManager::getInstance ();

			// Update the system user
			$query = UsersDB::updateUser($userData);
			$rs = $connectionManager->executeTransaction($query);

			// Update the adr user
			$query1 = AdrUsersDB::updateAdrUser($userData);
			$rs1 = $connectionManager->executeTransaction($query1);

			if(!$rs || !$rs1) {
				$this->logger->error("Error saving the new user");
				throw new UnexpectedValueException("Error saving the new user");
			} else {
				$result = true;
			}
		}


		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $result;

	}

	/**
	 * Get an adr user by loggin name
	 * @param strin $loggin
	 * @return boolean
	 */
	public function checkAdrUserLoggin($loggin) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = AdrUsersDB::getAdrUserByLoggin($loggin);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		$userExist = true;

		if(is_array($rs) && count($rs) == 0){

			$userExist = false;

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $userExist;

	}

	/**
	 * Gets the adr user states
	 * @param string $order
	 * @return array state
	 */
	public function getAdrUserStates($order = 'desc') {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$statesList = array ();

		$query = AdrUsersDB::getAdrUserStates($order);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			foreach ( $rs as $element ) {

				$obj = new AdrUserState();

				$obj->setId($element['id']);
				$obj->setDescription($element['description']);

				$statesList [] = $obj;

			}

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $statesList;

	}

	/**
	 * Gets the adr phone companies
	 * @param string $order
	 * @return array phoneCompany
	 */
	public function getAdrPhoneCompanies($order = 'desc') {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$phoneCompanyList = array ();

		// FIXME: cambiar por la query
		$rs = array(
				array(
						'id' 	=> 1,
						'name' 	=> EnumPhoneCompany::CLARO
				),
				array(
						'id' 	=> 2,
						'name' 	=> EnumPhoneCompany::MOVISTAR
				),
				array(
						'id' 	=> 3,
						'name' 	=> EnumPhoneCompany::NEXTEL
				),
				array(
						'id' 	=> 4,
						'name' 	=> EnumPhoneCompany::PERSONAL
				)
		);
		/////

		if(is_array($rs)){

			foreach ( $rs as $element ) {

				$obj = new AdrPhoneCompany();
				$obj->setId($element['id']);
				$obj->setName($element['name']);

				$phoneCompanyList [] = $obj;

			}

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $phoneCompanyList;

	}

	/**
	 * Get a nonpaged list of all adr users
	 * @param string $order
	 * @return multitype:AdrUser
	 */
	public function getAllAdrUsers($filters, $order = 'asc') {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = AdrUsersDB::getAllAdrUsers($filters, $order);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $rs;

	}

	/**
	 * Get the adr user coordinates
	 * @param array $filters
	 * @return array
	 */
	public function getAdrUserCoords($filters) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = AdrUsersDB::getAdrUserCoords($filters);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $rs;

	}

	/**
	 * Get the company coordinates for an user
	 * @param array $filters
	 * @return array
	 */
	public function getCompanyCoordsByUser($filters) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array();

		$query = AdrUsersDB::getCompanyCoordsByUser($filters);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			foreach ( $rs as $element ) {

				$obj = new AdrPlan();

				$obj->setId($element['planid']);
				$obj->setLatitude($element['latitude']);
				$obj->setLongitude($element['longitude']);

				$list [] = $obj;

			}

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;

	}

	/**
	 * Get last user coordinates reported
	 * @param array $filters
	 * @return array
	 */
	public function getAdrUserCoordLast($userId) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array();

		$query = AdrUsersDB::getAdrUserCoordsLast($userId);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			foreach ( $rs as $element ) {

				$obj = new AdrUserPoint();

				$obj->setUserId($element['iduser']);
				$obj->setLatitude($element['latitude']);
				$obj->setLongitude($element['longitude']);
				$obj->setName($element['name']);
				$obj->setReportedTime($element['reportedtime']);

				$list [] = $obj;

			}

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;

	}

	/**
	 * Get claims states
	 * @param array $adrClaimStates
	 * @param string $order
	 * @return multitype:State
	 */
	public function getAdrClaimStates($adrClaimStates, $order = 'ASC') {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$claimStatesList = array();

		$query = ClaimsDB::getAllStates($adrClaimStates, $order);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			foreach ( $rs as $element ) {

				$obj = new State();

				$obj->setId($element['id']);
				$obj->setName(Util::getLiteral($element['name']));

				$claimStatesList [] = $obj;

			}

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $claimStatesList;

	}


	public function getHistoricalRouteByUser($filters) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$coordsList = array();

		$query = AdrUsersDB::getHistoricalRouteByUser($filters);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			foreach ( $rs as $element ) {

				$obj = new AdrUserPoint();

				$obj->setUserId($element['iduser']);
				$obj->setLatitude($element['latitude']);
				$obj->setLongitude($element['longitude']);

				$coordsList [] = $obj;

			}

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $coordsList;

	}

	public function getAdrUserPositionDetail($filters) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array();

		$query = AdrUsersDB::getAdrUserPositionDetail($filters);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			foreach ( $rs as $element ) {

				$obj = new AdrUserPoint();

				$obj->setId($element['iduserlocation']);
				$obj->setUserId($element['iduser']);
				$obj->setReportedTime($element['reportedtime']);

				$list [] = $obj;

			}

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;

	}

	/**
	 * Retrieves all the zones.
	 * @param array $filters
	 * @return Region[] An array containing the regions.
	 */
	public function getAdrZones() {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = AdrUsersDB::getAdrZones($order = 'ASC');

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if (is_array($rs) && count($rs) > 0) {

			foreach($rs as $element) {

				$obj = new AdrZone();

				$obj->setId($element['id']);
				$obj->setName($element['name']);
				//Diego Saez
				$obj->setLocation($element['locationid']);
				$obj->setCoordinates($element['coordinates']);

				$list [] = $obj;

			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;

	}

	/**
	 * Retrieves the user events report
	 * @param array $filters
	 * @return multitype:AdrUserZoneEvent
	 */
	public function getAdrUserHistoryReport($filters, $timeFrom, $timeTo) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$query = AdrUsersDB::getUserHistoryReport($filters, $timeFrom, $timeTo, $order = 'ASC');

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if (is_array($rs) && count($rs) > 0) {

			foreach($rs as $element) {

				$obj = new AdrUserZoneEvent();

				$obj->setId($element['id']);
				$obj->setEvent($element['event']);
				$obj->setEventTimestamp($element['eventtimestamp']);
				$obj->setZoneName($element['zonename']);

				$list [] = $obj;

			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;

	}


	public function getUserActivityReport($filters, $timeFrom, $timeTo, $idUser,$includeUnnatended=true) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$list = array ();

		$rs = $this->getUserActivity($filters, $timeFrom, $timeTo, $idUser,$includeUnnatended);
		if (is_array($rs) && count($rs) > 0) {

			foreach($rs as $element) {

				if ($element['idconcept'] == EnumConceptActivityUser::CLAIM){

					$claim = new Claim($element['claimid'],$element['claimcode'],'',$element['claimaddress'],'' );

				}else{

					$claim = new Claim($element['code'],$element['name'],'',$element['planaddress'],'' );

				}

				if(!isset($element['statename']) ||$element['statename'] == "" ){

					$element['statename'] = '-';
				}

				$claim->setStateName($element['statename']);
				$claim->setStateId($element['stateid']);
				$obj = new AdrSubstateActivityUser();
				$obj->setClaim($claim);
				$obj->setTimeZoneIn($element['timezonein']);
				$obj->setTimeZoneOut($element['timezoneout']);
				$obj->setTranslate($element['translate']);
				$obj->setTimeZone($element['timezone']);
				$obj->setUnattended($element['unattended']);
				$obj->setTimereporting($element['reportedtime']);
				$list [$element['key']] = $obj;

			}
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $list;

	}

	public function getCoordsUserActivity($filters,$timeFrom,$timeTo){

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/modules/adr/classes/AdrPlan.class.php';
		$list = array ();

		$query = AdrUsersDB::getCoordsUserActivity($filters, $timeFrom, $timeTo, $order = 'ASC');

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		$claim = null;
		$plan = null;
		$obj = null;
		if (is_array($rs) && count($rs) > 0) {

			foreach($rs as $element) {

				if ($element['idconcept'] == EnumConceptActivityUser::CLAIM){
					$claim = new Claim($element['code'],$element['claimcode'],'',$element['claimaddress'],'' );
					$claim->setLatitude($element['claimlatitude']);
					$claim->setLongitude($element['claimlongitude']);
					$claim->setSubstateid($element['substateid']);
					$claim->setStateId($element['stateid']);
					$obj = $claim;

				}else{

					$plan = new AdrPlan();
					$plan->setId($element['code']);
					$plan->setName($element['name']);
					$plan->setAddress($element['planaddress']);
					$plan->setLatitude($element['planlatitude']);
					$plan->setLongitude($element['planlongitude']);
					$obj = $plan;

				}

				if(!is_null($obj)){

					$list [] = $obj;
				}

			}
		}
		return $list;

	}

	public function getUserActivity($filters,$timeFrom,$timeTo,$idUser, $includeUnnatended = true){

		$query = AdrUsersDB::getUserActivityReport($filters, $timeFrom, $timeTo, $order = 'ASC');

		$connectionManager = ConnectionManager::getInstance ();

		$result = $connectionManager->select ($query);

		$sortedResult = array();
		$activity = array();
		$timeIn;
		$dateInGlobal = null;
		$dateOutGlobal = null;
		$startIn = false;
		$dateFrom =  $timeFrom;

		$index = 0;
		for ($i = 0; $i < count($result); $i++) {

			$row = $result[$i];

			if($row['eventtype'] == 1){

				$activityIn = array(
						"code" 			=>'',
						"idconcept"		=>'',
						"name" 			=>'',
						"claimcode"		=>'',
						"timezonein"	=>'',
						"timezoneout"	=>'',
						"timezone" 		=>'',
						"claimaddress"	=>'',
						"planaddress"	=>'',
						"statename" 	=>'',
						"stateid"=>'',
						"translate" 	=>'',
						"claimid"=>'',
						"unattended"    => false,
						"reportedtime" => ''
				);
				//$activityIn = array();

				$startIn = true;

				$idIn = $row['code'];
				$timeIn = $row['reportedtime'];
				$dateInObject = DateTime::createFromFormat ( 'd/m/Y H:i:s', date('d/m/Y H:i:s',$timeIn/1000));
				$dateInGlobal  = $dateInObject;
				$stringDate=$dateInObject->format('d/m/Y H:i:s');
				$sortedResult[$row['iduseractivity']] = 'Entrada '.$idIn.' '.$row['idconcept'].' '.$stringDate;

				$activityIn['code'] = $row['code'];
				$activityIn['timezonein'] = $stringDate;
				$activityIn['claimcode'] = $row['claimcode'];
				$activityIn['name'] = $row['name'];
				$activityIn['claimaddress'] = $row['claimaddress'];
				$activityIn['planaddress'] = $row['planaddress'];
				$activityIn['statename'] = $row['statename'];
				$activityIn['stateid'] = $row['stateid'];
				$activityIn['idconcept'] = $row['idconcept'];
				$activityIn['claimid'] = $row['claimid'];
				$activityIn['reportedtime'] = $row['reportedtime'];
				if( !is_null($dateOutGlobal) && !is_null($dateInGlobal)){

					//Make the diference!

					$out = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', ($dateOutGlobal->format('d/m/Y H:i:s')))));
					$in = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', ($dateInGlobal->format('d/m/Y H:i:s')))));

					$secondsDateIn=strtotime($in);
					$secondsDateOut=strtotime($out);

					if($secondsDateIn>$secondsDateOut){
						$difference = $dateInGlobal->diff($dateOutGlobal);
						$time = $difference->days.'d '.$difference ->h.'h '.$difference ->i.'m '.$difference ->s.'s ';

					}else{

						$time = '';
					}

					$dateInGlobal = null;
					$dateOutGlobal = null;
					$activityIn['translate'] = $time;

				}


				$haySalida = false;
				for ($j = $i+1; $j < count($result); $j++) {

					$rowOut = $result[$j];
					$idOut = $rowOut['code'];
					$timeOutSearch = $rowOut['reportedtime'];


					if(($idIn== $idOut) && $rowOut['eventtype'] == 2 &&($timeOutSearch>$timeIn)){


						$haySalida = true;
						//calcular los traslados y el tiempo en zona
						$dateOutObject = DateTime::createFromFormat ( 'd/m/Y H:i:s', date('d/m/Y H:i:s',$timeOutSearch/1000) );
						$stringDate = $dateOutObject->format('d/m/Y H:i:s');
						$sortedResult[$rowOut['iduseractivity']] = ' Salida '.$idIn.' '.$rowOut['idconcept'].' '.$stringDate;

						$dateInObject = DateTime::createFromFormat ( 'd/m/Y H:i:s', date('d/m/Y H:i:s',$timeIn/1000));
						$diff = $dateOutObject->diff($dateInObject);
						$inTimeZone = $diff->days.'d '.$diff->h.'h '.$diff->i.'m '.$diff->s.'s ';

						//echo 'Tiempo en zona '.$inTimeZone.'</br>';
						$dateOutGlobal = $dateOutObject;
						$activityIn['timezoneout'] = $stringDate;
						$activityIn['timezonein'] = $dateInObject->format('d/m/Y H:i:s');
						$activityIn['timezone'] = $inTimeZone;
						$activityIn['reportedtime'] = $rowOut['reportedtime'];
						$activityIn['key'] = "historical_report_".$index;
						$activity[] = $activityIn;
						break;

					}

				}

				if(!$haySalida){
					$activityIn['code'] = $row['code'];
					$activityIn['timezonein'] = $stringDate;
					$activityIn['claimcode'] = $row['claimcode'];
					$activityIn['name'] = $row['name'];
					$activityIn['timezoneout'] = "";
					$activityIn['timezone']  = "";
					$activityIn['reportedtime'] = $row['reportedtime'];
					$activityIn['key'] = "historical_report_".$index;
					$activity[] = $activityIn;
				}

			}else{

				$idIn = $row['code'];
				$timeOut = $row['reportedtime'];

				//echo 'Salida '.$idIn.' '.$row['idconcept'].' '.$row['reportedtime'];

				if(empty($sortedResult[$row['iduseractivity']])){
					$timeIn =$dateFrom;
					$dateOutObject = DateTime::createFromFormat ( 'd/m/Y H:i:s', date('d/m/Y H:i:s',$timeOut/1000) );
					$stringDate = $dateOutObject->format('d/m/Y H:i:s');
					$sortedResult[$row['iduseractivity']] = 'Salida '.$idIn.' '.$row['idconcept'].' '.$stringDate;
					$dateInObject = DateTime::createFromFormat ( 'd/m/Y H:i:s', date('d/m/Y H:i:s',$timeIn/1000));
					$diff = $dateOutObject->diff($dateInObject);
					$inTimeZone = $diff->days.'d '.$diff->h.'h '.$diff->i.'m '.$diff->s.'s ';

					//echo 'Tiempo en zona '.$inTimeZone.'</br>';
					$dateOutGlobal = $dateOutObject;

					$activityIn = array(
							"code" 			=> '',
							"idconcept"		=> '',
							"name" 			=> '',
							"claimcode"		=> '',
							"timezonein"	=> '',
							"timezoneout"	=> '',
							"timezone" 		=> '',
							"claimaddress"	=> '',
							"planaddress"	=> '',
							"statename" 	=> '',
							"stateid"=>'',
							"translate" 	=> '',
							"claimid"=>'',
							"reportedtime" => '',
							"unattended"    => false
					);
					$activityIn['code'] = $row['code'];
					$activityIn['timezoneout'] = $stringDate;
					$activityIn['claimcode'] = $row['claimcode'];
					$activityIn['name'] = $row['name'];
					$activityIn['timezonein'] = "";
					$activityIn['timezone'] = "";
					$activityIn['claimaddress'] = $row['claimaddress'];
					$activityIn['planaddress'] = $row['planaddress'];
					$activityIn['idconcept'] = $row['idconcept'];
					$activityIn['statename'] = $row['statename'];
					$activityIn['stateid'] = $row['stateid'];
					$activityIn['claimid'] = $row['claimid'];
					$activityIn['key'] = "historical_report_".$index;
					$activityIn['reportedtime'] = $row['reportedtime'];
					$activity[] = $activityIn;
				}

			}

			$index++;
		}

		// -------- Agregar los pendientes o No Atendidos -----------------

		
		if($includeUnnatended){			
			
		$filters = array();
		$filter = new NumberFilter('claimsystemuseradr.systemuseradrid', '', 10, 'claimsystemuseradr.systemuseradrid', '');
		$filter->setSelectedValue ($idUser);
		$filters [] = $filter;
		$connectionManager = ConnectionManager::getInstance ();
		$query = ClaimsDB::getAssignedClaimsForUser($filters, null);
		$result = $connectionManager->select ($query);

		for ($i = 0; $i < count($result); $i++) {
			$agregar = true;
			$idClaim = $result[$i]['id'];
			
			for ($j = 0; $j < count($activity); $j++) {
				
				if($activity[$j]['claimcode'] == $result[$i]['code']){
					
					$agregar = false;
					break;
				}
			}
			if ($agregar){
				$activityIn = array(
						"code" 			=> $result[$i]['code'],
						"idconcept"		=> '1',
						"name" 			=> '',
						"claimcode"		=> $result[$i]['code'],
						"timezonein"	=> '',
						"timezoneout"	=> '',
						"timezone" 		=> '',
						"claimaddress"	=> $result[$i]['claimaddress'],
						"planaddress"	=> '',
						"statename" 	=> $result[$i]['statename'],
						"stateid" => $result[$i]['stateid'],
						"translate" 	=> '',
						"claimid"=>$result[$i]['id'],
						"unattended"    => true,
						"reportedtime" =>time() * 1000,
						"key"			=> "id_claim_".$idClaim);

				$activity[] = $activityIn;
			}

		}
		}

		return $activity;
	}

	public function getUnattendedCoordsClaimForUser($filters, $timeFrom, $timeTo, $idUser){

		$query = AdrUsersDB::getUserActivityReport($filters, $timeFrom, $timeTo, $order = 'ASC');
		$connectionManager = ConnectionManager::getInstance ();
		$list = array();
		$claimAttended = $connectionManager->select ( $query );
		// Agregar los pendientes
		$filters = array();
		$filter = new NumberFilter('claimsystemuseradr.systemuseradrid', '', 10, 'claimsystemuseradr.systemuseradrid', '');
		$filter->setSelectedValue ($idUser);
		$filters [] = $filter;
		$connectionManager = ConnectionManager::getInstance ();
		$query = ClaimsDB::getAssignedClaimsForUser($filters, null);
		$claimAssigned = $connectionManager->select ($query);

		for ($i = 0; $i < count($claimAssigned); $i++) {
			$agregar = true;
			for ($j = 0; $j < count($claimAttended); $j++) {

				if($claimAttended[$j]['claimcode'] == $claimAssigned[$i]['code']){
					$agregar = false;
					break;
				}
			}
			if ($agregar){
				$obj =  new Claim($claimAssigned[$i]['id'], $claimAssigned[$i]['code'],'',$claimAssigned[$i]['claimaddress'],'');
				$obj->setLatitude($claimAssigned[$i]['latitude']);
				$obj->setLongitude($claimAssigned[$i]['longitude']);
				$obj->setStateId($claimAssigned[$i]['stateid']);
				$obj->setSubstateid($claimAssigned[$i]['substateid']);
				$list[] = $obj;
			}

		}



		return $list;
	}

	public function getHistoricalReportUserActivity($filters, $timeFrom, $timeTo, $idUser, $includeUnattended = true){
		
		$query = AdrUsersDB::getHistoricalUserActivity($filters, $timeFrom, $timeTo, 'ASC');
		$connectionManager = ConnectionManager::getInstance ();
		$claimAttended = $connectionManager->select ($query);
		$i = 0;
		$milisDateOut = null;
		$list = array();
		$index = 0;
		if(is_array($claimAttended)&& count($claimAttended)>0){

			foreach ($claimAttended as $element) {

				$claim = new Claim($element['idclaim'], $element['reference'],'', $element['address'],'');
				if(!isset($element['state']) ||$element['state'] == "" ){

					$element['state'] = '-';
				}
				$claim->setStateName($element['state']);
				$claim->setStateId($element['stateid']);
				$obj = new AdrSubstateActivityUser();

				if(isset($element['timein'])){
					$timeIn = Util::getDateFromMiliseconds($element['timein'], 'd/m/Y H:i:s');
					$obj->setTimeZoneIn($timeIn->format('d/m/Y H:i:s'));
				}else{

					$obj->setTimeZoneIn("");
				}
				if(isset($element['timeout'])){
					$timeOut = Util::getDateFromMiliseconds($element['timeout'],  'd/m/Y H:i:s');
					$obj->setTimeZoneOut($timeOut->format('d/m/Y H:i:s'));
				}else{
					$obj->setTimeZoneOut("");

				}

				$timeZone = "";

				if((isset($element['timein']))&&(isset($element['timeout']))){
					$timeOutObject = Util::getDateFromMiliseconds($element['timeout'], 'd/m/Y H:i:s');
					$timeInObject = Util::getDateFromMiliseconds($element['timein'], 'd/m/Y H:i:s');
					$timeZone = $timeOutObject->diff($timeInObject);
					$obj->setTimeZone($timeZone->days.'d '.$timeZone->h.'h '.$timeZone->i.'m '.$timeZone->s.'s ');
				}else{

					$obj->setTimeZone("");

				}

				$obj->setClaim($claim);

				if($milisDateOut != null){
					$translate = "";
					$dateIn = Util::getDateFromMiliseconds($element['timein'], 'd/m/Y H:i:s');
					$dateOut = Util::getDateFromMiliseconds($milisDateOut, 'd/m/Y H:i:s');
					if( $milisDateOut < $element['timein']){


						$translate = $dateOut->diff($dateIn);
						$obj->setTranslate($translate->days.'d '.$translate->h.'h '.$translate->i.'m '.$translate->s.'s ');
						
					}else{
						$obj->setTranslate($translate);
						
					}
					
					$obj->setTimereporting($dateIn->format('d/m/Y H:i:s'));

				}
				if(isset($element['timeout'])){

					$milisDateOut = $element['timeout'];
				}

				$obj->setUnattended(false);
				$list ["historical_activity_user_".$index] = $obj;
				$index++;

			}

			//
			if($includeUnattended){
			$filters = array();
			$filter = new NumberFilter('historicalclaimsystemuseradr.systemuseradrid', '', 10, 'historicalclaimsystemuseradr.systemuseradrid', '');
			$filter->setSelectedValue ($idUser);
			$filters [] = $filter;
			$connectionManager = ConnectionManager::getInstance ();
			
			$dateAssignedFrom =  strtotime(date('Y-m-d 00:00', $timeFrom/1000))*1000;
			$dateAssignedTo =  strtotime(date('Y-m-d 23:59', $timeTo/1000))*1000;

			$query = AdrUsersDB::getHistoricalClaimsAssignedUser($filters, $dateAssignedFrom, $dateAssignedTo, 'ASC');

			$result = $connectionManager->select ($query);

			
			for ($i = 0; $i < count($result); $i++) {
				$agregar = true;
				for ($j = 0; $j < count($claimAttended); $j++) {
					if($claimAttended[$j]['idclaim'] == $result[$i]['claimid']){
						$agregar = false;
						break;
					}
				}
				
				if ($agregar){
					$obj = new AdrSubstateActivityUser();
					$idClaim = $result[$i]['claimid'];
					$claim = new Claim($result[$i]['claimid'], $result[$i]['code'],'',$result[$i]['claimaddress'],'');
					$claim->setStateId($result[$i]['stateid']);
					$obj->setTimeZone("");
					$obj->setTimeZoneIn("");
					$obj->setTimeZoneOut("");
					$obj->setTimereporting($result[$i]['datereporting']);
					$obj->setTranslate("");
					$obj->setUnattended(true);
					$obj->setClaim($claim);
					$claim->setStateName($result[$i]['name']);
					$list ["id_claim_".$idClaim] = $obj;

				}
					
			}
				
			}
		}
		
		return $list;

	}

	public function getHistoricalCoordUserActivity($filters, $timeFrom, $timeTo, $order, $idUser){

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/modules/adr/classes/AdrPlan.class.php';
		$list = array ();

		$query = AdrUsersDB::getHistoricalCoordUserActivity($filters, $timeFrom, $timeTo, 'ASC');

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		$claim = null;
		$plan = null;
		$obj = null;
		if (is_array($rs) && count($rs) > 0) {

			foreach($rs as $element) {

				if ($element['idconcept'] == EnumConceptActivityUser::CLAIM){
					$claim = new Claim($element['claimid'],$element['reference'],'',$element['address'],'' );
					$claim->setLatitude($element['claimlatitude']);
					$claim->setLongitude($element['claimlongitude']);
					$claim->setSubstateid($element['substateid']);
					$claim->setStateId($element['stateid']);
					$obj = $claim;

				}else{

					$plan = new AdrPlan();
					$plan->setId($element['idclaim']);
					$plan->setName($element['reference']);
					$plan->setAddress($element['address']);
					$plan->setLatitude($element['planlatitude']);
					$plan->setLongitude($element['planlongitude']);
					$obj = $plan;

				}

				if(!is_null($obj)){

					$list [] = $obj;
				}

			}

			$filters = array();
			$filter = new NumberFilter('historicalclaimsystemuseradr.systemuseradrid', '', 10, 'historicalclaimsystemuseradr.systemuseradrid', '');
			$filter->setSelectedValue ($idUser);
			$filters [] = $filter;
			$connectionManager = ConnectionManager::getInstance ();
			$query = AdrUsersDB::getHistoricalClaimsAssignedUser($filters, $timeFrom, $timeTo, 'ASC');
			$result = $connectionManager->select ($query);

			for ($i = 0; $i < count($result); $i++) {
				$agregar = true;
				for ($j = 0; $j < count($rs); $j++) {
					if($rs[$j]['idclaim'] == $result[$i]['claimid']){
						$agregar = false;
						break;
					}
				}
				if ($agregar){

					$claim = new Claim($result[$i]['claimid'],$result[$i]['code'],'',$result[$i]['claimaddress'],'' );
					$claim->setLatitude($result[$i]['latitude']);
					$claim->setLongitude($result[$i]['longitude']);
					$claim->setSubstateid($result[$i]['substateid']);
					$claim->setStateId($result[$i]['stateid']);
					$obj = $claim;
					$list [] = $obj;
				}
					
			}


		}

		return $list;

	}

	public function generateHistorical(){

		$connectionManager = ConnectionManager::getInstance ();
		$query = 'SELECT claimsystemuseradr.systemuseradrid,
		claimsystemuseradr.claimid,
		claim.substateid,
		claim.stateid
		FROM claimsystemuseradr
		LEFT JOIN claim ON claim.id = claimsystemuseradr.claimid';
		$rs = $connectionManager->select ( $query );

		//generando copia de claimsystemuseradr
		foreach ($rs as $value) {

			echo $value['claimid'].' ';
			echo $value['substateid'].' ';
			echo $value['stateid'].' ';
			echo '</br>';

		}
		//generando reportes de todos los ADR
		$query = 'SELECT systemuseradr.systemuserid FROM systemuseradr';
		$resultAdr = $connectionManager->select ( $query );
		foreach ($resultAdr as $value) {

			echo $value['systemuserid'].' ';

			echo '</br>';

		}


	}
	
	
	public function getHistoricalClaimsUnnatendedByDate($timeFrom, $timeTo, $idUser){
		
		$list = array();
		$timeFromInit =  strtotime(date('Y-m-d 00:00', $timeFrom/1000))*1000;
		$timeToEnd =  strtotime(date('Y-m-d 23:59', $timeTo/1000))*1000;
				
		$connectionManager = ConnectionManager::getInstance ();
		$query = AdrUsersDB::getHistoricalClaimsUnnatendedByDate($timeFromInit, $timeToEnd, $timeFrom, $timeTo, $idUser);
		$result = $connectionManager->select ($query);
		
		for ($i = 0; $i < count($result); $i++) {
			
				$obj = new AdrSubstateActivityUser();
				$idClaim = $result[$i]['claimid'];
				$claim = new Claim($result[$i]['claimid'], $result[$i]['code'],'',$result[$i]['claimaddress'],'');
				$claim->setStateId($result[$i]['stateid']);
				$obj->setTimeZone("");
				$obj->setTimeZoneIn("");
				$obj->setTimeZoneOut("");
				$obj->setTimereporting($result[$i]['datereporting']);
				$obj->setTranslate("");
				$obj->setUnattended(true);
				$obj->setClaim($claim);
				$claim->setStateName($result[$i]['name']);
				$list ["id_claim_".$idClaim] = $obj;
		
			
				
		}
		
		return $list;
		
		
	}
	
	public function getUnnatendedClaim($idUser, $timeFrom, $timeTo){
		
		$connectionManager = ConnectionManager::getInstance ();
		$query = AdrUsersDB::getClaimsUnnatended($timeFrom, $timeTo, $idUser);
		$result = $connectionManager->select ($query);
		$list = array();
		for ($i = 0; $i < count($result); $i++) {
		
				$claim = new Claim($result[$i]['id'],$result[$i]['code'],'',$result[$i]['claimaddress'],'' );
			
				
				$claim->setStateName($result[$i]['statename']);
				$claim->setStateId($result[$i]['stateid']);
				$obj = new AdrSubstateActivityUser();
				$obj->setClaim($claim);
				$obj->setTimeZoneIn('');
				$obj->setTimeZoneOut('');
				$obj->setTranslate('');
				$obj->setTimeZone('');
				$obj->setUnattended('');
				$obj->setTimereporting(time() * 1000);
				$list [] = $obj;
				
		
		}

		return $list;
		
	}
	
	
	
}


