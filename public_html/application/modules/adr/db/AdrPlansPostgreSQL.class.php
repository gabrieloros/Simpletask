<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/UtilPostgreSQL.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/common/EnumUserType.class.php';

/**
 * Querys for Postgre 
 * @author promero
 *        
 */
class AdrPlansPostgreSQL extends UtilPostgreSQL {
	/**
	 * count the plans
	 * @param unknown $filters
	 * @return string
	 */
	public static function getAdrPlansCount($filters) {
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "SELECT 
						COUNT(*) numrows
					FROM plan p
					WHERE 1 = 1
				";
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			}
		}
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	/**
	 * get plans
	 * @param int $begin
	 * @param int $count
	 * @param array $filters
	 * @param int $order
	 * @return string
	 */
	public static function getAdrPlans($begin, $count, $filters, $order) {
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "SELECT 
						p.id AS id,
						p.name AS name,
						p.coordinateupdatetime AS coordinateupdatetime,
						p.minutestoclose AS minutestoclose,
						p.minutesforcancellation AS minutesforcancellation,
						(
							SELECT COUNT(*) 
							FROM systemuseradr u 
							WHERE u.planid = p.id
						) hasuser
					FROM plan p
					WHERE 1=1
				";
		
		if (is_array ( $filters ) && count ( $filters ) > 0) {
			
			foreach ( $filters as $filter ) {
				
				$query .= $filter->getCriteriaQuery ();
			}
		}
		
		$query .= '
					ORDER BY p.id ' . $order . '
					LIMIT ' . $count . ' OFFSET ' . $begin . '
					';
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	public static function getAdrPlansAll($order, $filters = null) {
		self::initializeSession ();
	
		self::$logger->debug ( __METHOD__ . ' begin' );
	
		$query = 'SELECT 
						id, 
						name, 
						coordinateupdatetime 
					FROM plan WHERE 1=1';
	
		if (is_array ( $filters ) && count ( $filters ) > 0) {
				
			foreach ( $filters as $filter ) {
	
				$query .= $filter->getCriteriaQuery ();
			}
		}
	
		$query .= '
					ORDER BY id ' . $order ;
					;
	
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
	
		self::$logger->debug ( __METHOD__ . ' end' );
	
		return $query;
	}
	
	
	
	/**
	 *
	 * @param Long $planId        	
	 * @return string
	 */
	public static function deleteAdrPlan($planId) {

		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'DELETE 
					FROM plan
					WHERE id = ' . $planId
				;
		
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;

	}
	
	public static function getPlanById($planId) {
	
		self::initializeSession ();
	
		self::$logger->debug ( __METHOD__ . ' begin' );
	
		$query = "SELECT
						id, 
						name, 
						posturl, 
						coordinateupdatetime,
						minutestoclose,
						minutesforcancellation,
					    latitude,
						longitude
					FROM plan
					WHERE id = ".$planId
				;
	
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
	
		self::$logger->debug ( __METHOD__ . ' end' );
	
		return $query;

	}

	public static function addAdrPlan($planData) {
	
		self::initializeSession ();
	
		self::$logger->debug ( __METHOD__ . ' begin' );
	
		$query = "INSERT INTO plan(
						name,
						coordinateupdatetime,
						minutestoclose,
						minutesforcancellation,
						latitude,
						longitude
					) VALUES(
						'".$planData['name']."',
						".($planData['coordinateUpdateTime'] * 1000).",
						".$planData['claimMinutesToCloseTime'].",
						".$planData['claimMinutesForCancellation'].",
						".$planData['claimLatitude'].",
						".$planData['claimLongitude']."
					)";
	
		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );
	
		self::$logger->debug ( __METHOD__ . ' end' );
	
		return $query;
	
	}

	public static function updatePlan($planData) {

		self::initializeSession ();

		self::$logger->debug ( __METHOD__ . ' begin' );

		$query = "UPDATE plan SET
						name = '".$planData['name']."',
						coordinateupdatetime = ".($planData['coordinateUpdateTime'] * 1000).",
						minutestoclose = ".$planData['claimMinutesToCloseTime'].",
						minutesforcancellation = ".$planData['claimMinutesForCancellation'].",
						latitude = ".$planData['claimLatitude'].",
						longitude = ".$planData['claimLongitude']."
					WHERE id = ".$planData['id']
				;

		self::$logger->debug ( __METHOD__ . ' QUERY: ' . $query );

		self::$logger->debug ( __METHOD__ . ' end' );

		return $query;

	}

}