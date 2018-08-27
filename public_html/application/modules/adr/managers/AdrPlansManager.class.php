<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/db/AdrPlansDB.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrPlan.class.php');
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/common/EnumCommon.class.php';

/**
 * Handles all the adr plans operations
 * @author promero
 *
*/
class AdrPlansManager implements ModuleManager {

	private static $instance;

	private static $logger;

	public static function getInstance() {

		if (! isset ( AdrPlansManager::$instance)) {
			self::$instance = new AdrPlansManager();
		}

		return AdrPlansManager::$instance;

	}

	private function __construct() {

		self::$logger = $_SESSION ['logger'];

	}

	/**
	 * Loads all the adr plans concepts stored in DB
	 */
	public function getAdrPlansConcepts($locationId){
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	
		unset($_SESSION['adrPlansConcepts']);

		$_SESSION['adrPlansConcepts'] = array();

		$_SESSION['adrPlansConcepts']['plans'] = $this->getPlansForConcept();
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	
	}
	
	/**
	 * Returns a list of adr plans
	 * @return array
	 */
	public function getPlansForConcept(){
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	
		$list = array();
			
		$query = AdrPlansDB::getAdrPlansAll($order = 'DESC');
	
		$connectionManager = ConnectionManager::getInstance ();
	
		$rs = $connectionManager->select ( $query );
	
		foreach ( $rs as $element ) {
			$list [$element["id"]] = array(
					"name"=>Util::cleanString($element["name"]),
					"coordinateupdatetime"=>$element["coordinateupdatetime"]
			);
		}
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	
		return $list;
	
	}

	/**
	 * Return the adr plans count
	 * @param array $filters
	 * @return number
	 */
	public function getAdrPlansCount($filters) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$count = 0;
		
		$query = AdrPlansDB::getAdrPlansCount($filters);
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$countRS = $connectionManager->select ( $query );
		
		if (isset ( $countRS [0] ['numrows'] ))
			$count = ( int ) $countRS [0] ['numrows'];
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $count;
	
	}
	
	
	/**
	 * Returns a list of adr plans
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
	
		$query = AdrPlansDB::getAdrPlans($begin, $count, $filters, $order);
	
		$connectionManager = ConnectionManager::getInstance ();
	
		$rs = $connectionManager->select ( $query );
	
		if(is_array($rs)){
	
			foreach ( $rs as $element ) {
	
				$obj = new AdrPlan();
				
				$obj->setId($element['id']);
				$obj->setName($element['name']);
				$obj->setCoordinateUpdateTime($element['coordinateupdatetime'] / 1000);
				$obj->setClaimMinutesToCloseTime($element['minutestoclose']);
				$obj->setClaimMinutesForCancellation($element['minutesforcancellation']);
				$obj->setHasUser($element['hasuser']);

				$list [] = $obj;
			}
	
		}
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	
		return $list;
	
	}
	
	/**
	 * Deletes an adr plan
	 * @param int $planId
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function deleteAdrPlan($planId){
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	
		if( $planId == null ) {
			self::$logger->error ( 'planId parameter expected ' );
			throw new InvalidArgumentException ( 'planId parameter expected ' );
		} 
		
		$query = AdrPlansDB::deleteAdrPlan($planId);
	
		$connectionManager = ConnectionManager::getInstance ();
	
		$rs = $connectionManager->executeTransaction($query);
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	
		return $rs;
	
	}

	/**
	 * Gets a adr Plan
	 * @param int $planId
	 * @return array plans
	 */
	public function getPlan($planId) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$query = AdrPlansDB::getPlanById($planId);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			$plan = new AdrPlan();

			$plan->setId($rs[0]['id']);
			$plan->setName($rs[0]['name']);
			$plan->setCoordinateUpdateTime($rs[0]['coordinateupdatetime'] / 1000);
			$plan->setClaimMinutesToCloseTime($rs[0]['minutestoclose']);
			$plan->setClaimMinutesForCancellation($rs[0]['minutesforcancellation']);
			$plan->setLatitude($rs[0]['latitude']);
			$plan->setLongitude($rs[0]['longitude']);

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $plan;

	}

	/**
	 * Gets all plans
	 * @param strin $order
	 * @return multitype:AdrPlan
	 */
	public function getAllPlans($order = 'desc') {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$plansList = array ();

		$query = AdrPlansDB::getAdrPlansAll($order);

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );

		if(is_array($rs)){

			foreach ( $rs as $element ) {

				$obj = new AdrPlan();

				$obj->setId($element['id']);
				$obj->setName($element['name']);

				$plansList [] = $obj;

			}

		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $plansList;

	}

	/**
	 * Saves an adr plan
	 * @param AdrPlan $planData
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function saveAdrPlan($planData) {
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	
		$result = false;
	
		$connectionManager = ConnectionManager::getInstance ();
		
		if( $planData['id'] == '' ) {
			// Insert the new plan
			$query = AdrPlansDB::addAdrPlan($planData);
			$rs = $connectionManager->executeTransaction($query);

		} else {
			// Update the existing plan
			$query = AdrPlansDB::updatePlan($planData);
			$rs = $connectionManager->executeTransaction($query);

		}
	
		if(!$rs) {
			$this->logger->error("Error saving the new plan");
			throw new UnexpectedValueException("Error saving the new plan");
		} else {
			$result = $rs;
		}
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	
		return $result;
	
	}
	
}