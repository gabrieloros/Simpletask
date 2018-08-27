<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/db/AdrUsersPostgreSQL.class.php');

/**
 *
 * @author mmogrovejo
 *
 */
class AdrUsersDB extends Util {

	private static $logger;

	private static function initializeSession() {
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			self::$logger = $_SESSION ['logger'];
		}
	}

	public static function getAdrUsersCount($filters) {

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
				$query = AdrUsersPostgreSQL::getAdrUsersCount($filters);
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
				$query = AdrUsersPostgreSQL::getAdrUsers($begin, $count, $filters, $order);
				break;
		}

		return $query;

	}

	public static function deleteAdrUser($userId) {

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
				$query = AdrUsersPostgreSQL::deleteAdrUser($userId);
				break;
		}

		return $query;

	}

	public static function getUserById($userId) {

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
				$query = AdrUsersPostgreSQL::getUserById($userId);
				break;
		}

		return $query;

	}

	public static function updateAdrUser($userData) {

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
				$query = AdrUsersPostgreSQL::updateAdrUser($userData);
				break;
		}

		return $query;

	}

	public static function addAdrUser($id, $userData) {

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
				$query = AdrUsersPostgreSQL::addAdrUser($id, $userData);
				break;
		}

		return $query;

	}

	public static function getAdrUserByLoggin($loggin) {

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
				$query = AdrUsersPostgreSQL::getAdrUserByLoggin($loggin);
				break;
		}

		return $query;

	}

	public static function getAdrUserStates($order) {

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
				$query = AdrUsersPostgreSQL::getAdrUserStates($order);
				break;
		}

		return $query;

	}

	public static function getAllAdrUsers($filters, $order) {

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
				$query = AdrUsersPostgreSQL::getAllAdrUsers($filters, $order);
				break;
		}

		return $query;

	}

	public static function getAdrUserCoords($filters) {

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
				$query = AdrUsersPostgreSQL::getAdrUserCoords($filters);
				break;
		}

		return $query;

	}

	public static function getCompanyCoordsByUser($filters) {

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
				$query = AdrUsersPostgreSQL::getCompanyCoordsByUser($filters);
				break;
		}

		return $query;

	}

	public static function getAdrUserCoordsLast($userId) {

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
				$query = AdrUsersPostgreSQL::getAdrUserCoordsLast($userId);
				break;
		}

		return $query;

	}

	public static function getHistoricalRouteByUser($filters) {

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
				$query = AdrUsersPostgreSQL::getHistoricalRouteByUser($filters);
				break;
		}

		return $query;

	}

	public static function getAdrUserPositionDetail($filters) {

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
				$query = AdrUsersPostgreSQL::getAdrUserPositionDetail($filters);
				break;
		}

		return $query;

	}

	public static function getAdrZones($order) {

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
				$query = AdrUsersPostgreSQL::getAdrZones($order);
				break;
		}

		return $query;

	}

	public static function getUserHistoryReport($filters, $timeFrom, $timeTo, $order) {

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
				$query = AdrUsersPostgreSQL::getUserHistoryReport($filters, $timeFrom, $timeTo, $order);
				break;
		}

		return $query;

	}

	public static function getUserActivityReport($filters, $timeFrom, $timeTo, $order) {

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
				$query = AdrUsersPostgreSQL::getUserActivityReport($filters, $timeFrom, $timeTo, $order);
				break;
		}

		return $query;

	}

	public static function getCoordsUserActivity($filters,$timeFrom,$timeTo,$order){
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
				$query = AdrUsersPostgreSQL::getCoordsUserActivity($filters, $timeFrom, $timeTo, $order);
				break;
		}

		return $query;


	}
	public static function getHistoricalUserActivity($filters,$timeFrom,$timeTo,$order){

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
				$query = AdrUsersPostgreSQL::getHistoricalUserActivity($filters, $timeFrom, $timeTo, $order);
				break;
		}

		return $query;
	}

	public static function getHistoricalClaimsAssignedUser($filters, $timeFrom, $timeTo, $order){
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
				$query = AdrUsersPostgreSQL::getHistoricalClaimsAssignedUser($filters, $timeFrom, $timeTo, $order);
				break;
		}

		return $query;


	}
	
	public static function getHistoricalClaimsUnnatendedByDate($timeFromInit, $timeToEnd, $timeFrom, $timeTo, $iduser){
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
				$query = AdrUsersPostgreSQL::getHistoricalClaimsUnnatendedByDate($timeFromInit, $timeToEnd, $timeFrom, $timeTo, $iduser);
				break;
		}
		
		return $query;
		
		
	}
	
	public static function getClaimsUnnatended($timeFrom, $timeTo, $idUser){
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
				$query = AdrUsersPostgreSQL::getClaimsUnnatended($idUser, $timeFrom, $timeTo);
				break;
		}
	
		return $query;
	
	
	}
	
	
	public static function getHistoricalCoordUserActivity($filters, $timeFrom, $timeTo, $order){
		
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
				$query = AdrUsersPostgreSQL::getHistoricalCoordUserActivity($filters, $timeFrom, $timeTo, $order);
				break;
		}
		
		return $query;
		
		
	}
	
	
	
}