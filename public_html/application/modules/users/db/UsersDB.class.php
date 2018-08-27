<?php
/**
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 19/03/2012
 * UPDATE LIST
 * PURPOSE: Common methods and helpers
 * CALLED BY: UserManager
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . "/../application/modules/users/db/UsersMysql.class.php";
require_once $_SERVER ['DOCUMENT_ROOT'] . "/../application/modules/users/db/UsersOracle.class.php";
require_once $_SERVER ['DOCUMENT_ROOT'] . "/../application/modules/users/db/UsersPostgreSQL.class.php";

class UsersDB extends Util {

	private static $logger;

	private static function initializeSession() {
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			self::$logger = $_SESSION ['logger'];
		}
	}

	public static function getUserByLogin($login) {

		$query = '';

		Util::getConnectionType ();

		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUserByLogin ( $login );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getUserByLogin ( $login );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = UsersPostgreSQL::getUserByLogin ( $login );
				break;
		}

		return $query;

	}
	public static function getUserTypeId($login) {

		$query = '';

		Util::getConnectionType ();

		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUserByLogin ( $login );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getUserByLogin ( $login );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = UsersPostgreSQL::getUserTypeId($login);
				break;
		}

		return $query;

	}

	public static function getUserById($userId) {

		$query = '';

		Util::getConnectionType ();

		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUserById ( $userId );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getUserById ( $userId );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}

		return $query;

	}

	public static function getUsers($begin, $count, $filters) {

		$query = '';

		Util::getConnectionType ();

		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :

				$query = UsersMysql::getUsers ( $begin, $count, $filters );
				break;
			case Util::DB_ORACLE :

				$query = UsersOracle::getUsers ( $begin, $count, $filters );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}

		return $query;

	}
	//Diego Saez

	/**
	 * Return a database query to get list of usernames
	 *
	 *
	 * @return $query
	 *
	 * */
	//----------------------------------------------------------------------
	public static function getNameUsers(){

		$query = '';

		Util::getConnectionType ();

		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :

				$query = UsersMysql::getNameUsers();
				
				break;
			case Util::DB_ORACLE :
				
				$query = UsersOracle::getNameUsers();

				break;
			case Util::DB_POSTGRESQL :

				$query = UsersPostgreSQL::getNameUsers();
				
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			default:
				throw new Exception ( "not implemented" );
					
					
					
		}

		return $query;


	}
	
	public static function getUsersCount($filters) {

		$query = '';

		Util::getConnectionType ();

		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUsersCount ( $filters );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getUsersCount ( $filters );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}

		return $query;

	}

	public static function getUserTypes() {

		$query = '';

		Util::getConnectionType ();

		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getUserTypes ();
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getUserTypes ();
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}

		return $query;

	}

	public static function insertUser($fields) {

		$query = '';

		Util::getConnectionType ();

		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::insertUser ( $fields );
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::insertUser ( $fields );
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
			case Util::DB_POSTGRESQL :
				$query = UsersPostgreSQL::insertUser($fields);
				break;
		}

		return $query;

	}

	public static function updateUser($fields) {

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
				$query = UsersPostgreSQL::updateUser($fields);
				break;
		}

		return $query;

	}

	public static function deleteUser($userId) {

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
				$query = UsersPostgreSQL::deleteUser($userId);
				break;
		}

		return $query;

	}

	public static function getFirstAdminUser() {

		$query = '';

		Util::getConnectionType ();

		switch ($_SESSION ['s_dbConnectionType']) {
			case Util::DB_MYSQL :
				$query = UsersMysql::getFirstAdminUser ();
				break;
			case Util::DB_ORACLE :
				$query = UsersOracle::getFirstAdminUser ();
				break;
			case Util::DB_SQLSERVER :
				throw new Exception ( "not implemented" );
				break;
		}

		return $query;

	}

}