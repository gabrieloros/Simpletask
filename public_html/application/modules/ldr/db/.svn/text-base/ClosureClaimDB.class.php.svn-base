<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/ldr/db/ClosureClaimPostgreSQL.class.php');

class ClosureClaimDB extends Util {
	
	private static $logger;
	
	private static function initializeSession() {
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			self::$logger = $_SESSION ['logger'];
		}
	}
	
	/**
	 * @throws Exception
	 * @return string
	 */
	public static function getWithoutFixing() {
	
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
				$query = ClosureClaimPostgreSQL::getWithoutFixing();
				break;
		}
	
		return $query;
	
	}
	
	/**
	 * @throws Exception
	 * @return string
	 */
	public static function getMaterial() {
	
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
				$query = ClosureClaimPostgreSQL::getMaterial();
				break;
		}
	
		return $query;
	
	}
	
	/**
	 * @throws Exception
	 * @return string
	 */
	public static function saveClosureClaim($claimClosure,$stateCliamId) {
	
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
				$query = ClosureClaimPostgreSQL::saveClosureClaim($claimClosure,$stateCliamId);
				break;
		}
	
		return $query;
	
	}
	
	
	
}