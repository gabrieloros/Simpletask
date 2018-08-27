<?php
/**
 * Common methods and helpers
 * @package util
 * @author Gabriel Guzmán
 * @version 1.0
 * DATE OF CREATION: 13/03/2012
 * UPDATE LIST
 * * UPDATE: 
 */

require_once 'UtilMysql.class.php';
require_once 'UtilOracle.class.php';
require_once 'UtilPostgreSQL.class.php';

class Util {
	
	const DB_ORACLE = 'oracle';
	const DB_MYSQL = 'mysql';
	const DB_SQLSERVER = 'sqlserver';
	const DB_POSTGRESQL = 'postgresql';
	
	private static $logger;
	
	private static function initializeSession() {
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			
			self::$logger = $_SESSION ['logger'];
		}
	}
	
	/**
	 * Assign the PFW Connection ID to a session variable s_dbConnectionId
	 *
	 * @param String $connectionName Connection name to determinate the connection id.
	 *
	 * @return Integer Connection identity number.
	 */
	public static function getConnectionType() {
		
		self::initializeSession ();
			
		if (! isset ( $_SESSION ['s_dbConnectionType'] ) || $_SESSION ['s_dbConnectionType'] == '') {
			
			$_SESSION ['s_dbConnectionType'] = 'postgresql';
			
			self::$logger->debug ( 'DBConnectionType loaded:  ' . $_SESSION ['s_dbConnectionType'] );
			
		}
		
		return $_SESSION ['s_dbConnectionType'];
	}
	
	/**
	 * Return SELECT statement to get passport
	 *
	 * @param String userId
	 *
	 * @return String  SELECT statement to get passport
	 */
	public static function getUserPassport($userId) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getUserPassport ( $userId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getUserPassport ( $userId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getUserPassport ( $userId );
				break;
		}
		
		return $query;
	}
	
	/**
	 * Get SQL Query for literals.
	 * 
	 * @param int $languageId if false, use session language
	 * this brings one language literals and if not defined de default values
	 */
	public static function getLiteralsQuery($languageId = false) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getLiteralsQuery ( $languageId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getLiteralsQuery ( $languageId );
				break;
			case self::DB_SQLSERVER :
				/** @todo: Add SQL Server Method */
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getLiteralsQuery ( $languageId );
				break;
		}
		return $query;
	}
	
	/**
	 * Return SELECT statement to get all modules configuration
	 * @return String  SELECT statement to get all modules information
	 */
	public static function getContentsQuery( $languageIso, $contentURL, $error) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getContentsQuery ( $languageIso, $contentURL, $error );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getContentsQuery ( $languageIso, $contentURL, $error );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getContentsQuery ( $languageIso, $contentURL, $error );
				break;
		}
		return $query;
	}
	
	/**
	 * Get SQL Query for getting all languages from database.
	 */
	public static function getLanguages() {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getLanguages ();
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getLanguages ();
				break;
			case self::DB_SQLSERVER :
				/** @todo: Add SQL Server Method */
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getLanguages();
				break;
		}
		return $query;
	}
	
	/**
	 * Get SQL Query for getting all params from database.
	 */
	public static function getParameters() {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getParameters ();
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getParameters ();
				break;
			case self::DB_SQLSERVER :
				/** @todo: Add SQL Server Method */
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getParameters();
				break;
		}
		return $query;
	}
	
	/**
	 * Return SELECT statement to get one content's page in the specific language
	 * @return String  SELECT tatement to get one content's page in the specific language
	 */
	public static function getContentsLanguageResource($contentId, $languageId) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getContentsLanguageResource ( $contentId, $languageId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getContentsLanguageResource ( $contentId, $languageId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getContentsLanguageResource ( $contentId, $languageId );
				break;
		}
		return $query;
	}
	
	public static function getModuleUrlmapping($siteId, $languageId, $moduleName) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getModuleUrlmapping ( $siteId, $languageId, $moduleName );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getModuleUrlmapping ( $siteId, $languageId, $moduleName );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getModuleUrlmapping ( $siteId, $languageId, $moduleName );
				break;
		}
		return $query;
	}
	
	public static function getLanguageUrlmapping($url) {
		
		$query = '';
		
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getLanguageUrlmapping ( $url );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getLanguageUrlmapping ( $url );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getLanguageUrlmapping ( $url );
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getLanguageUrlmapping ( $url );
				break;
		}
		
		return $query;
		
	}
	
	public static function getModule($idModule) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getModule ( $idModule );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getModule ( $idModule );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getModule ( $idModule );
				break;
		}
		return $query;
	}
	
	/**
	 * Return SELECT statement to specific content with concrete Lang and SideId.
	 * @param $contentArray: Array with content key's required.
	 * @param $siteId: Site Identification
	 * @param $lanId: Language Identification
	 */
	public static function getDefaultContentsInfo($contentArray, $langId) {
		
		$query = '';
		
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getDefaultContentsInfo ( $contentArray, $langId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getDefaultContentsInfo ( $contentArray, $langId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getDefaultContentsInfo ( $contentArray, $langId );
				break;
		}
		return $query;
	}
	
	/**
	 * Return SELECT statement to specific content with concrete Lang and SideId.
	 * @param int $starLevel start level for the menu
	 * @param int $endLevel: last level for the menu
	 */
	public static function getMenuContents($languageId, $userTypeId, $startLevel, $endLevel = null) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getMenuContents ( $languageId, $userTypeId, $startLevel, $endLevel );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getMenuContents ( $languageId, $userTypeId, $startLevel, $endLevel );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getMenuContents ( $languageId, $userTypeId, $startLevel, $endLevel );
				break;
		}
		return $query;
	}
	
	/**
	 * Return SELECT content information from content id
	 * @param int $idSite site to search in
	 * @param int $idContent: content to search in
	 * @param int $languageIso: language to show
	 */
	public static function getCrumb( $idContent, $languageIso) {
		
		$query = '';
		
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getCrumb ( $idContent, $languageIso );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getCrumb ( $idContent, $languageIso );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getCrumb ( $idContent, $languageIso );
				break;
		}
		
		return $query;
		
	}
	
	/**
	 * Return SELECT statement to get content categories.
	 * @param int $idcontent content id
	 */
	public static function getContentCategories($idContent) {
		$query = '';
		self::getConnectionType ();
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getContentCategories ( $idContent );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getContentCategories ( $idContent );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getContentCategories ( $idContent );
				break;
		}
		return $query;
	}
	
	/**
	 * Returns the wanted values from an User.
	 * @param int userid
	 * @param @array with wanted columns
	 * @return @array with all the wanted values.
	 */
	public static function getUserValues($usrId, $keyValues) {
		
		$filter = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$filter = UtilMysql::getUserValues ( $usrId, $keyValues );
				break;
			case self::DB_ORACLE :
				$filter = UtilOracle::getUserValues ( $usrId, $keyValues );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getUserValues ( $usrId, $keyValues );
				break;
		}
		return $filter;
	}
	
	public static function getModuleId($moduleName) {
		
		$filter = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$filter = UtilMysql::getModuleId ( $moduleName );
				break;
			case self::DB_ORACLE :
				$filter = UtilOracle::getModuleId ( $moduleName );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getModuleId ( $moduleName );
				break;
		}
		return $filter;
	}
	
	/**
	 * 
	 * Checks if the literals changed
	 * @param int $languageId
	 */
	public static function getLiteralChanges($languageId) {
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getLiteralChanges ( $languageId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getLiteralChanges ( $languageId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getLiteralChanges ( $languageId );
				break;
		}
		
		return $query;
	
	}
	
	/**
	 * 
	 * Remove the mark of literals changed for a specific language
	 * @param int $languageId
	 */
	public static function removeLiteralChangesMark($languageId) {
		
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::removeLiteralChangesMark ( $languageId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::removeLiteralChangesMark ( $languageId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::removeLiteralChangesMark ( $languageId );
				break;
		}
		
		return $query;
	
	}
	
	/**
	 * 
	 *Get the query fo Active Modules in given Site.
	 */
	public static function getActiveModules($siteId) {
		
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getActiveModules ( $siteId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getActiveModules ( $siteId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getActiveModules ( $siteId );
				break;
		}
		
		return $query;
	}
	
	/**
	 * this function is responsible for getting provided literal, if not found, return the same literal
	 * betwen doublecolons, if default given return default.
	 * @param literalS string defines the name of the literal
	 * @param default  string defines the default literal if no literal found
	 * @return String
	 */
	public static function getLiteral($literal, $default = '') {
		
		if (isset ( $_SESSION ['s_message'] [$literal] )) {
			$literal_to_return = $_SESSION ['s_message'] [$literal];
		} else {
			$literal_to_return = $default != '' ? $default : '[' . $literal . ']';
		}
		
		return $literal_to_return;
	}
	
	/**
	 * 
	 * Devuelve la URL actual.
	 */
	function getCurrenProtocol() {
		$pageURL = 'http';
		if (isset ( $_SERVER ["HTTPS"] ) && $_SERVER ["HTTPS"] == "on") {
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER ["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER ["SERVER_NAME"] . ":" . $_SERVER ["SERVER_PORT"]; //.$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER ["SERVER_NAME"]; //.$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	
	/**
	 * 
	 * Get the query for content check permissions.
	 * @param unknown_type $userId
	 * @param unknown_type $contentId
	 * @param unknown_type $siteId
	 */
	public static function getCheckPermissions($userTypeId, $menuId) {
		
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getCheckPermissions ( $userTypeId, $menuId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getCheckPermissions ( $userTypeId, $menuId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getCheckPermissions ( $userTypeId, $menuId );
				break;
		}
		
		return $query;
	}
	
	/**
	 * 
	 * Check if current content have a child with content and return his url in current language.
	 * @param unknown_type $userId
	 * @param unknown_type $contentId
	 * @param unknown_type $siteId
	 */
	public static function getUrlChild($content, $language = "") {
		
		self::$logger->debug ( __METHOD__ . ' start' );
		
		$language = $language == '' ? $_SESSION ['s_languageIso'] : $language;
		
		$query = self::getChild ( $content, $language );
		
		$connectionManager = ConnectionManager::getInstance();
		
		$child = $connectionManager->select ( $query );
		
		//SI EL CONTENIDO NO TIENE CONTENIDOS CHILD, RETURN SU PROPIA URL.
		if (isset ( $child ) && count ( $child ) <= 0) {
			$return_url = false;
		} else {
			$return_url = $child [0] ['content_url'];
		}
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $return_url;
	}
	
	/**
	 * 
	 * Get the query for first child of content
	 * @param unknown_type $content
	 * @param unknown_type $language
	 * @return string
	 */
	public static function getChild($contentId, $languageId) {
		
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				$query = UtilMysql::getChild ( $contentId, $languageId );
				break;
			case self::DB_ORACLE :
				$query = UtilOracle::getChild ( $contentId, $languageId );
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getChild ( $contentId, $languageId );
				break;
		}
		
		return $query;
	}
	
	/**
	 * This method performs an automatic mapping of any class using data from array
	 * checks if the object attributes exists as index of the array and invokes the setter to assign the value.
	 * @author gabriel.guzman
	 * @param object $entityObject
	 * @param array $entityData
	 * @throws Exception
	 * @throws InvalidArgumentException
	 */
	public static function autoMapEntity(&$entityObject, $entityData) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		if (is_array ( $entityData ) && count ( $entityData ) > 0) {
		    
		    if(is_object($entityObject)){
			
			    $entityType = get_class ( $entityObject );	
    				
				$reflectionClass = new ReflectionClass ( $entityType );
				
				$entityProperties = $reflectionClass->getDefaultProperties ();
				
				if (is_array ( $entityProperties ) && count ( $entityProperties ) > 0) {
					
					foreach ( $entityProperties as $property => $propertyValue ) {
						
						if (isset ( $entityData [$property] ) && $entityData [$property] != '') {
							
							$valueForSetter = ucfirst ( $property );
							
							$reflectionMethod = new ReflectionMethod ( $entityType, "set" . $valueForSetter );
							
							$invokeResult = $reflectionMethod->invoke ( $entityObject, $entityData [$property] );
							
							self::$logger->debug ( __METHOD__ . ' end' );
						
						}
					}
				} else {
					self::$logger->error ( "The object passed doesn't have attributes" );
					throw new Exception ( "The object passed doesn't have attributes" );
				}
		    }
		    else{
                self::$logger->error ( "Object expected" );
			    throw new InvalidArgumentException ( "Object expected" ); 
		    }
		} else {
			self::$logger->error ( "The entity array must content data" );
			throw new Exception ( "The entity array must content data" );
		}
	
	}
	
    /**
     * Returns a pager
     * @author Gabriel Guzman
     * @param int $numrows
     * @param int $begin
     * @param int $page
     * @param int $count
     * @return string
     */
    public static function getPager($numrows, $begin, $page, $count) {
				
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
				
		$pager = '';
		
		if ($count < $numrows) {
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/PagerManager.class.php';
			$pagerManager = PagerManager::getInstance ();
			$pager = $pagerManager->setPager($count,$numrows,$page);
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $pager;
	
	}
	
	/**
	 * Cleans a string
	 * @param string $string
	 * @return string
	 */
	public static function cleanString($string){
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$string = strtolower(trim($string));
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $string;
		
	}
	
	public static function getAssignedDate($refDate){
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$now = new DateTime(date("Y-m-d"));
		$ref = new DateTime($refDate);
		$diff = $now->diff($ref);
		
		$years = $diff->y;
		$months = $diff->m;
		$days = $diff->d;
		
		$html = '';
		
		if($years == 0 && $months == 0 && $days == 0){
			$html .= 'Hoy';	
		}
		else{
			$html .= 'Hace: ';
			
			if(isset($years) && $years != 0){
				$html .= $years . ' ' . ($years == 1? 'año ' : 'años ');
			}
			if(isset($months) && $months != 0){
				$html .= $months . ' ' . ($months == 1? 'mes ' : 'meses ');
			}
			if(isset($days) && $days != 0){
				$html .= $days . ' ' . ($days == 1? 'día' : 'días');
			}
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $html;
	
	}
	
	/**
	 * Load data from phone directory
	 * @param array $filters
	 * @param array $orders
	 * @return array
	 */
	public static function loadPhoneDirectoryData($filters, $orders) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$query = self::getPhoneDirectoryData ($filters, $orders);
		
		$connectionManager = ConnectionManager::getInstance();
		
		$rs = $connectionManager->select ( $query );
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $rs;
		
	}
	
	/**
	 * Query to load data from phone directory
	 * @param array $filters
	 * @param array $orders
	 * @return string
	 */
	public static function getPhoneDirectoryData($filters, $orders) {
		
		$query = '';
		self::getConnectionType ();
		
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				break;
			case self::DB_ORACLE :
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getPhoneDirectoryData ($filters, $orders);
				break;
		}
		
		return $query;
	}

	/**
	 * Defines whether or not a point belongs to a polygon
	 * @param string $point
	 * @param array $polygon
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public static function isWithinBoundary($point,$polygon) {
		
		$result = false;
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if(!isset($point) || $point == null){
			self::$logger->error ( "Point parameter expected" );
			throw new InvalidArgumentException( "Point parameter expected" );
		}
		
		if(!isset($polygon) || $polygon == null || !is_array($polygon) || count($polygon) <= 3){
			self::$logger->error ( "Polygon parameter expected or invalid polygon passed" );
			throw new InvalidArgumentException ( "Polygon parameter expected or invalid polygon passed" );
		}
		
		$point = self::pointStringToCoordinates($point);

		$vertices = array();

		foreach ($polygon as $vertex) {
			$vertices[] = self::pointStringToCoordinates($vertex);
		}
		
		// Check if the point is inside the polygon or on the boundary
		$intersections = 0;
		$vertices_count = count($vertices);
		
		for ($i=1; $i < $vertices_count; $i++) {
			$vertex1 = $vertices[$i-1];
			$vertex2 = $vertices[$i];
			if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) {
				// This point is on an horizontal polygon boundary
				$result = true;
				// set $i = $vertices_count so that loop exits as we have a boundary point
				$i = $vertices_count;
			}

			if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) {
				$xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
				
				// This point is on the polygon boundary (other than horizontal)
				if ($xinters == $point['x']) { 
					$result = true;
					// set $i = $vertices_count so that loop exits as we have a boundary point
					$i = $vertices_count;
				}
				if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
					$intersections++;
				}
			}
		}
		// If the number of edges we passed through is even, then it's in the polygon.
		// Have to check here also to make sure that we haven't already determined that a point is on a boundary line
		if ($intersections % 2 != 0 && $result == false) {
			$result = true;
		}
		return $result;
	}
	
	/**
	 * Convert a string in a 2 elements array with coordinates
	 * @param string $point
	 * @throws InvalidArgumentException
	 * @throws Exception
	 * @return array 
	 */
	private static function pointStringToCoordinates($point) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if(!isset($point) || $point == null){
			self::$logger->error ( "Point parameter expected" );
			throw new InvalidArgumentException( "Point parameter expected" );
		}
		
	    $coordinates = explode(",", $point);
	    
	    if(!isset($coordinates[0]) || $coordinates[0] == null || !isset($coordinates[1]) || $coordinates[1] == null){
	    	self::$logger->error ( "Error parsing coordinates, point string malformed. Please, verify data" );
			throw new Exception( "Error parsing coordinates, point string malformed. Please, verify data" );
	    }
	    
	    self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return array("x" => trim($coordinates[0]), "y" => trim($coordinates[1]));
	    
	}
	
	/**
	 * Defines the region where a claim belongs to
	 * @param string $latitude
	 * @param string $longitude
	 * @return number
	 */
	public static function getClaimRegion($latitude, $longitude){
		
		self::initializeSession ();
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$regionId = 0;
		
		if (! isset ( $latitude ) || $latitude == null || ! isset ( $longitude ) || $longitude == null) {
			return $regionId;
		}
		
		$coordinates = $latitude.','.$longitude;
		
		foreach ($_SESSION['claimsConcepts']['regions'] as $key => $region){
			
			if(self::isWithinBoundary($coordinates, $region ['coordinates'])){
				$regionId = $key;
				break;
			}
			
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $regionId;
		
	}
	
	/**
	 * Get the distance and time between two points through google 
	 * @param string $originCoords
	 * @param string $targetCoords
	 * @return array
	 */
	public static function getDistanceByRoutes($originCoords, $targetCoords) {
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$data = null;
	
		$query = "http://maps.googleapis.com/maps/api/distancematrix/json?origins=".$originCoords."&destinations=".$targetCoords."&mode=driving&sensor=false";
	
		$json = file_get_contents($query);
	
		$result = json_decode($json, TRUE);

		if($result['status'] == 'OK') {
				
			if($result['rows'][0]['elements'][0]['status'] != 'ZERO_RESULTS') {
				// in metres
				$data = $result['rows'][0]['elements'][0];
			}

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	
		return $data;
	
	}

	/**
	 * Get the direct distance between two points 
	 * @param string $originCoords
	 * @param string $targetCoords
	 * @return array
	 */
	public static function getDirectDistance($originCoords, $targetCoords) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		require_once 'DistanceCalculator/Navigator-1.0.0/lib/Treffynnon/Navigator.php';

// 		use Treffynnon\Navigator as N;

		N::autoloader();

		$data = null;

		list($originLat, $originLong) = explode(',', $originCoords);
		list($targetLat, $targetLong) = explode(',', $targetCoords);
		
		$coord1 = new N\LatLong(
				new N\Coordinate($originLat),
				new N\Coordinate($originLong)
		);

		$coord2 = new N\LatLong(
				new N\Coordinate($targetLat),
				new N\Coordinate($targetLong)
		);

		$Distance = new N\Distance($coord1, $coord2);

// 		use Treffynnon\Navigator\Distance as D;
		$distance = $Distance->get(new D\Calculator\Haversine, new D\Converter\MetreToMetre);

		if($distance != '') {
			$data = $distance;
		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $data;

	}

	/**
	 * Get the distance between two points
	 * @param string $originCoords
	 * @param string $targetCoords
	 * @return string
	 */
	public static function getDistanceBetweenTwoPoints($originCoords, $targetCoords) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$distance = self::getDistanceByRoutes($originCoords, $targetCoords);
		
		if($distance == null) {

			$distance1 = getDirectDistance($originCoords, $targetCoords);
			
			if($distance1 != null) {
				$distance = $distance1;
			}

		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
 		return $distance;

	}
	
	/**
	 * Get the submenu title
	 * @param int $menuId
	 * @return int
	 */
	public static function getSubmenuTitle($menuId) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$title = '';
		
		$query = self::getMenuTitle($menuId);
		
		$connectionManager = ConnectionManager::getInstance();
		
		$rs = $connectionManager->select ( $query );
		
		if(is_array($rs)) {
			
			$title = $rs[0]['title'];

		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $title;

	}
	
	public static function getMenuTitle($menuId) {
	
		$query = '';
		self::getConnectionType ();
	
		switch ($_SESSION ['s_dbConnectionType']) {
			case self::DB_MYSQL :
				break;
			case self::DB_ORACLE :
				break;
			case self::DB_SQLSERVER :
				break;
			case self::DB_POSTGRESQL :
				$query = UtilPostgreSQL::getSubmenuTitle($menuId);
				break;
		}
	
		return $query;
	}
	

	public static function getDateFromMiliseconds($miliseconds, $format){		
		
		return DateTime::createFromFormat($format, date($format,$miliseconds/1000));		
	}
	
	
	public static function getFileNames($path, $extensions){
		$fileNames = array();
		if(!empty($path) && is_array($extensions)){
			$patternExtensions = '{';
			for ($i=0; $i<count($extensions); $i++){
				$patternExtensions .= $extensions[$i];
				if($i<count($extensions)-1){
	
					$patternExtensions.= ',';
	
				}
			}
			$patternExtensions.='}';
			$listFiles = glob ( $path . '*.'.$patternExtensions, GLOB_BRACE);
			if(is_array($listFiles)){
				foreach ( $listFiles as $fileName ) {
					$pos = strrpos($fileName, '/');
					$file = substr($fileName, $pos + 1);
					$fileNames[] = $file;
				}
			}
		}else{
			throw new InvalidArgumentException("Invalid params");
		}
		return $fileNames;
	}
	
	
	
	/**
	 * Recibe un string con el formato xd xh xm xs y lo convierte en horas
	 * @param string $string
	 */
	public static function getSecondsFromString($string){
		
		$seconds = 0.0;
		$stringSplit = split(' ',$string); 	
		$daysString = trim($stringSplit[0]);//días
		$hoursString = trim($stringSplit[1]);
		$minString = trim($stringSplit[2]);
		$secondsString = trim($stringSplit[3]);		
		$daysInt = (int)str_replace('d', '', $daysString);
		$hoursInt = (int)str_replace('h', '', $hoursString);
		$minInt = (int)str_replace('m', '', $minString);
		$secondsInt = (int)str_replace('s', '', $secondsString);
		$daysToSeconds= ($daysInt * 24) * 3600;
		$hoursToSeconds = $hoursInt*3600;
		$minToSeconds = $minInt * 60;					
		$seconds = $daysToSeconds + $hoursToSeconds + $minToSeconds + $secondsInt;			
		return  $seconds;
	}
	
	public static function  getHoursStringFromSeconds($seconds){
		
		$horas = floor($seconds/3600); 
		$minutos = floor(($seconds-($horas*3600))/60);
		$segundos = $seconds-($horas*3600)-($minutos*60);		
		$horaString =  $horas.'h '.$minutos.'m '.$segundos.' s';		
		return $horaString;
	}
	
}