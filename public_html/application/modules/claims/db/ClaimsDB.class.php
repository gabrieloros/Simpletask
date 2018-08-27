<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/db/ClaimsPostgreSQL.class.php');

class ClaimsDB extends Util {
	
	private static $logger;
	
	private static function initializeSession() {
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			self::$logger = $_SESSION ['logger'];
		}
	}
	
	public static function getCauses() {
		
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
				$query = ClaimsPostgreSQL::getCauses ();
				break;
		}
		
		return $query;
	
	}
	
	public static function getCausesBySubject($subjectId) {
	
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
				$query = ClaimsPostgreSQL::getCausesBySubject($subjectId);
				break;
		}
	
		return $query;
	
	}
	
	public static function getDependencies() {
		
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
				$query = ClaimsPostgreSQL::getDependencies ();
				break;
		}
		
		return $query;
	
	}
	
	public static function getInputTypes() {
		
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
				$query = ClaimsPostgreSQL::getInputTypes ();
				break;
		}
		
		return $query;
	
	}
	
	public static function getOrigins() {
		
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
				$query = ClaimsPostgreSQL::getOrigins ();
				
				break;
		}
		
		return $query;
	
	}
	
	public static function getStates() {
		
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
				$query = ClaimsPostgreSQL::getStates ();
				break;
		}
		
		return $query;
	
	}
	
	public static function getSubjects() {
		
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
				$query = ClaimsPostgreSQL::getSubjects ();
				break;
		}
		
		return $query;
	
	}
	
	public static function getTelepromCauses() {
		
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
				$query = ClaimsPostgreSQL::getTelepromCauses ();
				break;
		}
		
		return $query;
	
	}
	
	public static function insertClaim($claimData) {
		
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
				$query = ClaimsPostgreSQL::insertClaim ( $claimData );
				break;
		}
		
		return $query;
	
	}
	
	public static function insertTelepromClaim($claimData) {
		
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
				$query = ClaimsPostgreSQL::insertTelepromClaim ( $claimData );
				break;
		}
		
		return $query;
	
	}
	
	public static function checkExistenceInDB($claimData) {
		
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
				$query = ClaimsPostgreSQL::checkExistenceInDB ( $claimData );
				break;
		}
		
		return $query;
	
	}
	
	public static function getTelepromCount() {
		
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
				$query = ClaimsPostgreSQL::getTelepromCount ();
				break;
		}
		
		return $query;
	
	}
	
	public static function getClaims($begin, $count, $filters, $order) {
		
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
				$query = ClaimsPostgreSQL::getClaims ( $begin, $count, $filters, $order );
				break;
		}
	
		return $query;
	
	}
	
	public static function getClaim($id) {
	
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
				$query = ClaimsPostgreSQL::getClaim ( $id );
				break;
		}
	
		return $query;
	
	}
	
	public static function getClaimsCount($filters) {
		
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
				$query = ClaimsPostgreSQL::getClaimsCount ( $filters );
				break;
		}
		
		return $query;
	
	}

	public static function getAllClaimsCount() {
	
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
				$query = ClaimsPostgreSQL::getAllClaimsCount();
				break;
		}
	
		return $query;
	
	}
	
	public static function getPendingTelepromClaims($begin, $count, $filters) {
		
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
				$query = ClaimsPostgreSQL::getPendingTelepromClaims ( $begin, $count, $filters );
				break;
		}
		
		return $query;
	
	}
	
	public static function getPendingTelepromClaimsCount($filters) {
		
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
				$query = ClaimsPostgreSQL::getPendingTelepromClaimsCount ( $filters );
				break;
		}
		
		return $query;
	
	}
	
	public static function changeClaimState($stateId, $claims) {
		
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
				$query = ClaimsPostgreSQL::changeClaimState ( $stateId, $claims );
				break;
		}
		
		return $query;
	
	}
	
	
	public static function changeStateClaim($claimId, $stateId) {
	
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
				$query = ClaimsPostgreSQL::changeStateClaim($claimId, $stateId);
				break;
		}
	
		return $query;
	
	}
	
	
	
	
	public static function updateClaim($claimId, $claimData) {
		
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
				$query = ClaimsPostgreSQL::updateClaim ( $claimId, $claimData );
				break;
		}
		
		return $query;
	
	}
	
	public static function updateTelepromClaim($claimId, $claimData) {
		
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
				$query = ClaimsPostgreSQL::updateTelepromClaim ( $claimId, $claimData );
				break;
		}
		
		return $query;
	
	}
	
	public static function updateTelepromClaimRequesterAddress($claimId, $claimData) {
	
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
				$query = ClaimsPostgreSQL::updateTelepromClaimRequesterAddress ( $claimId, $claimData );
				break;
		}
	
		return $query;
	
	}
	
	
	public static function getDataFromPhoneDirectory($phone) {
		
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
				$query = ClaimsPostgreSQL::getDataFromPhoneDirectory ( $phone );
				break;
		}
		
		return $query;
	
	}
	
	public static function getNullCodeCauCount() {
		
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
				$query = ClaimsPostgreSQL::getNullCodeCauCount ();
				break;
		}
		
		return $query;
	
	}
	
	public static function insertStreetLightsClaimData($claimData) {
		
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
				$query = ClaimsPostgreSQL::insertStreetLightsClaimData ( $claimData );
				break;
		}
		
		return $query;
	
	}
	
	public static function getClaimsForExport($begin, $count, $filters, $order) {
		
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
				$query = ClaimsPostgreSQL::getClaimsForExport ( $begin, $count, $filters, $order );
				break;
		}
		
		return $query;
	
	}
	
	public static function getClaimsCountForExport($filters) {
		
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
				$query = ClaimsPostgreSQL::getClaimsCountForExport ( $filters );
				break;
		}
		
		return $query;
	
	}
	
	public static function getCounters($filters) {
		
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
				$query = ClaimsPostgreSQL::getCounters ( $filters );
				break;
		}
		
		return $query;
	
	}
	
	public static function updateStreetLightsClaimData($claimId, $claimData) {
		
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
				$query = ClaimsPostgreSQL::updateStreetLightsClaimData ( $claimId, $claimData );
				break;
		}
		
		return $query;
	
	}
	
	public static function getRegions($locationId) {
		
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
				$query = ClaimsPostgreSQL::getRegions ($locationId);
				break;
		}
		
		return $query;
	
	}
	
	public static function getRegionById($regionId) {
	
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
				$query = ClaimsPostgreSQL::getRegionById ($regionId);
				break;
		}
	
		return $query;
	
	}

	public static function getRegionsStats($dependencyId, $filters) {
		
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
				$query = ClaimsPostgreSQL::getRegionsStats($dependencyId, $filters);
				break;
		}
		
		return $query;
	
	}
	
	/**
	 * Obtiene la estadistica por region con un filtro especifico
	 * 
	 * @param integer $regionId
	 * @param filter $filters
	 * @throws Exception
	 * @return string
	 */
	public static function getStatsByRegion($regionId, $filters) {

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
				$query = ClaimsPostgreSQL::getStatsByRegion($regionId, $filters);
				break;
		}

		return $query;

	}

	public static function getTelepromStats($dependencyId, $filters) {
		
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
				$query = ClaimsPostgreSQL::getTelepromStats($dependencyId, $filters);
				break;
		}
		
		return $query;
	
	}
	
	public static function insertPhoneDirectory($claimId, $claimData) {

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
				$query = ClaimsPostgreSQL::insertPhoneDirectory($claimId, $claimData);
				break;
		}

		return $query;

	}

	public static function getAdrClaimCoords($filters) {
	
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
				$query = ClaimsPostgreSQL::getAdrClaimCoords($filters);
				break;
		}
	
		return $query;
	
	}

	public static function getPublicClaimCoords($filters) {
	
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
			case UTIL::DB_POSTGRESQL :
				$query = ClaimsPostgreSQL::getPublicClaimCoords($filters);
				break;
		}
	
		return $query;
	
	}

        public static function getPublicClaim($filters) {

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
                        case UTIL::DB_POSTGRESQL :
                                $query = ClaimsPostgreSQL::getPublicClaim($filters);
                                break;
                }

                return $query;

        }


	public static function getAllStates($adrClaimStates, $order) {

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
				$query = ClaimsPostgreSQL::getAllStates($adrClaimStates, $order);
				break;
		}

		return $query;

	}

	public static function getAdrUnassignedClaimsCoords($groupId) {
	
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
				$query = ClaimsPostgreSQL::getAdrUnassignedClaimsCoords($groupId);
				break;
		}
	
		return $query;

		
	}
	
	public static function getAssignedClaimsForUser($filters,$groupId,$orderField) {
	
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
				$query = ClaimsPostgreSQL::getAssignedClaimsForUser($filters,$groupId,$orderField);
				break;
		}
	
		return $query;
	
	}


	public static function getClaimsMapGroup() {
	
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
				$query = ClaimsPostgreSQL::getClaimsMapGroup();
				break;
		}
	
		return $query;
	
	}
	public static function getClaimByCode($filters, $order) {
	
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
				$query = ClaimsPostgreSQL::getClaimByCode($filters, $order);
				break;
		}
	
		return $query;
	
	}
	
	public static function getClaimsByUser($userId, $groupId) {
	
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
				$query = ClaimsPostgreSQL::getClaimsByUser($userId, $groupId);
				break;
		}
	
		return $query;
	
	}
	public static function getClaimsByGroup($groupId) {
	
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
				$query = ClaimsPostgreSQL::getClaimsByGroup($groupId);
				break;
		}
	
		return $query;
	
	}
	public static function getGroupInfo($groupId) {
	
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
				$query = ClaimsPostgreSQL::getGroupInfo($groupId);
				break;
		}
	
		return $query;
	
	}
	public static function unassignUserByClaims($claims) {

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
				$query = ClaimsPostgreSQL::unassignUserByClaims($claims);
				break;
		}

		return $query;

	}
	public static function unassignGroupByClaims($claims) {

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
				$query = ClaimsPostgreSQL::unassignGroupByClaims($claims);
				break;
		}

		return $query;

	}
	
	public static function removeClaimFromList($claimData) {
	
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
				$query = ClaimsPostgreSQL::removeClaimFromList($claimData);
				break;
		}
	
		return $query;
	
	}
	
	public static function assignClaimsToUser($userId, $claimData) {

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
				$query = ClaimsPostgreSQL::assignClaimsToUser($userId, $claimData);
				break;
		}

		return $query;

	}
	public static function assignClaimsToGroup($groupId, $claimData) {

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
				$query = ClaimsPostgreSQL::assignClaimsToGroup($groupId, $claimData);
				break;
		}

		return $query;

	}
	
	public static function setListPlace($userId, $claimId, $placeNum) {

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
				$query = ClaimsPostgreSQL::setListPlace($userId, $claimId, $placeNum);
				break;
		}

		return $query;

	}
	

	public static function getAllClaimStreet($filters, $order){
	
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
				$query = ClaimsPostgreSQL::getAllClaimStreet($filters, $order);
				break;
		}
	
		return $query;
	
	}
	
	public static function getAllNumberStreet($filters, $order){
	
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
				$query=ClaimsPostgreSQL::getAllNumberStreet($filters, $order);
				break;
		}
	
		return $query;
	
	}
	
	public static function getLatLong($filters){
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
				$query=ClaimsPostgreSQL::getLatLong($filters);
				break;
		}
	
		return $query;
	
	}
	
	public static function getAllDistrict($filters, $order){
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
				$query=ClaimsPostgreSQL::getAllDistrict($filters, $order);
				break;
		}
	
		return $query;
	
	
	}
	
	public static function getAllBlockDistrict($filters, $order){
	
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
				$query=ClaimsPostgreSQL::getAllBlockDistrict($filters, $order);
				break;
		}
	
		return $query;
	
	}
	
	
	public static function getAllHomeBlock($filters, $order){
	
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
				$query=ClaimsPostgreSQL::getAllHomeBlock($filters, $order);
				break;
		}
	
		return $query;
	
	}
	
	public static function getTypeAddress($filters){
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
				$query=ClaimsPostgreSQL::getTypeAddress($filters);
				break;
		}
	
		return $query;
	}
	
	public static function getCountMapCity(){
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
				$query=ClaimsPostgreSQL::getCountMapCity();
				break;
		}
		
		return $query;
		
	}
	
	public static function getTypeAddressConceptById($id){
		
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
				$query=ClaimsPostgreSQL::getTypeAddressConceptById($id);
				break;
		}
		
		return $query;	
		
	}
	
	public static function getTypeAddressById($id){
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
				$query=ClaimsPostgreSQL::getTypeAddressById($id);
				break;
		}
		
		return $query;
			
	}
	
	public static function getMaterialsByClaim($id){
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
				$query=ClaimsPostgreSQL::getMaterialsByClaim($id);
				break;
		}
		
		return $query;
			
	}
	
	public static function getWithoutFixingByClaim($id){
		
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
				$query=ClaimsPostgreSQL::getWithoutFixingByClaim($id);
				break;
		}
		
		return $query;
			
	}
	
	public static function getClosedDescription($id){
		
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
				$query=ClaimsPostgreSQL::getClosedDescription($id);
				break;
		}
		
		return $query;
		
		
	}
	
}
