<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/db/AdrPlansPostgreSQL.class.php');

/**
 * distinc implement for sql motor
 * @author promero
 *        
 */
class AdrPlansDB extends Util {
	private static $logger;
	private static function initializeSession() {
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			self::$logger = $_SESSION ['logger'];
		}
	}
	
	/**
	 *
	 * @param unknown $filters        	
	 * @throws Exception
	 * @return string
	 */
	public static function getAdrPlansCount($filters) {
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = AdrPlansPostgreSQL::getAdrPlansCount ( $filters );
				break;
		}
		
		return $query;
	}
	
	/**
	 *
	 * @param unknown $begin        	
	 * @param unknown $count        	
	 * @param unknown $filters        	
	 * @param unknown $order        	
	 * @throws Exception
	 * @return string
	 */
	public static function getAdrPlans($begin, $count, $filters, $order) {
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = AdrPlansPostgreSQL::getAdrPlans ( $begin, $count, $filters, $order );
				break;
		}
		
		return $query;
	}
	

	public static function getAdrPlansAll($order) {
		$query = '';
	
		Util::getConnectionType ();
	
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = AdrPlansPostgreSQL::getAdrPlansAll ( $order );
				break;
		}
	
		return $query;
	}
	
	/**
	 *
	 * @param int $planId
	 * @throws Exception
	 * @return string
	 */
	public static function deleteAdrPlan($planId) {
		$query = '';
		
		Util::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = AdrPlansPostgreSQL::deleteAdrPlan($planId);
				break;
		}
		
		return $query;
	}
	
	/**
	 * 
	 * @param int $planId
	 * @throws Exception
	 * @return string
	 */
	public static function getPlanById($planId) {
		$query = '';
	
		Util::getConnectionType ();
	
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = AdrPlansPostgreSQL::getPlanById($planId);
				break;
		}
	
		return $query;
	}

	public static function addAdrPlan($planData) {
	
		$query = '';
	
		Util::getConnectionType ();
	
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = AdrPlansPostgreSQL::addAdrPlan($planData);
				break;
		}
	
		return $query;
	
	}

	public static function updatePlan($planData) {
	
		$query = '';
	
		Util::getConnectionType ();
	
		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_ORACLE :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = AdrPlansPostgreSQL::updatePlan($planData);
				break;
		}
	
		return $query;
	
	}
	
}