<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/db/AdrGroupPostgreSQL.class.php');

/**
 *
 * @author mmogrovejo
 *
 */
class AdrGroupDB extends Util {

	private static $logger;

	private static function initializeSession() {
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			self::$logger = $_SESSION ['logger'];
		}
	}

    public static function getListGroup() {

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
				$query = AdrGroupPostgreSQL::getAdrListGroups();
				break;
		}

		return $query;

	}


	public static function getAdrUsers($begin, $count, $filters, $order) {

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
				$query = AdrGroupPostgreSQL::getAdrUsers($begin, $count, $filters, $order);
				break;
		}

		return $query;

	}


	
	
	
}