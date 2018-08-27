<?php
/**
 * Common methods and helpers
 * @package UtilMySQL
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 10/05/2010
 * UPDATE LIST  
 * PURPOSE: Common methods and helpers
 * CALLED BY: 
 */

class UtilMysql {
	
	protected static $logger;
	
	protected static function initializeSession() {
		
		if (! isset ( self::$session ) || ! isset ( self::$logger )) {
			
			self::$logger = $_SESSION ['logger'];
			
		}
	}
	
	/**
	 * Return SELECT statement to get passport
	 *
	 * @param String userId
	 *
	 * @return String  SELECT statement to get passport
	 */
	public static function getUserPassport($userId) {
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select psspassport from pfwpassport where pssusr = ' . $userId;
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	}
	
	/**
	 * Get SQL Query for getting all languages from database.
	 */
	public static function getLanguages() {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select DISTINCT id, lang_iso, lang_name
        		from language ORDER BY lang_name';

		self::$logger->debug ( 'query: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	/**
	 * Get SQL Query for literals.
	 * 
	 * @param int $languageId if false, use session language
	 * this brings one language literals and if not defined de default values
	 */
	public static function getLiteralsQuery($languageId = false) {
		
		self::initializeSession ();
		
		if (! $languageId) {
			$languageId = $_SESSION ['s_defaultLanguageId'];
		}
		
		$query = 'SELECT defaultlanguage.lit_key literalkey,
                   		COALESCE(requiredLanguage.lit_text, defaultlanguage.lit_text) literalvalue
                  FROM literal defaultlanguage
                  	LEFT JOIN literal requiredlanguage
                    	ON defaultlanguage.lit_key = requiredlanguage.lit_key 
                        	AND requiredlanguage.lit_lang =' . $languageId . '
                  WHERE defaultlanguage.lit_lang = ' . $_SESSION ['s_defaultLanguageId'];
		
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
		
	}
	
	/**
	 * Return SELECT statement to get all modules configuration
	 * @return String  SELECT statement to get all modules information
	 */
	public static function getContentsQuery($languageIso, $contentURL, $error = false) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'SELECT menu.id
			        ,menu.menukey
			        ,menu.menuorder
			        ,menu.menulevel
			        ,menu.parentid
			        ,menu.moduleid
			        ';
		
		if (! $error) {
			$query .= ',urlmapping.url
						';
		}
		else{
			$query .= ',\'\' url
						';
		}
		
		$query .= ',menu_translation.title
					,menu_translation.body
			       ';
		
		foreach ( $_SESSION ['s_languages'] as $lang ) {
			$langIso = $lang->getIso ();
			$query .= '
        				,urlmapping_' . $langIso . '.url url_' . $langIso . ' ';
		
		}
		
		$query .= ',module.modulename
			        FROM  menu';
		
		if (! $error) {
			$query .= ' 
					LEFT JOIN  urlmapping
        			on menu.id = urlmapping.menuid ';
		}
		
		$query .= '
     			LEFT join menu_translation
        			on menu.id = menu_translation.menuid 
    			LEFT join module 
        			on module.id = menu.moduleid
        		LEFT join language
        			on language.id = menu_translation.languageid ';
		
		foreach ( $_SESSION ['s_languages'] as $lang ) {
			$langIso = $lang->getIso ();
			$langId = $lang->getId ();
			$query .= '
						LEFT JOIN urlmapping urlmapping_' . $langIso . '
           			 		ON menu.id = urlmapping_' . $langIso . '.menuid AND urlmapping_' . $langIso . '.languageid = ' . $langId;		
		}
        			
		$query .= '
					WHERE 1
        				AND language.lang_iso = \'' . $languageIso.'\'
        				AND menu.menutypeid = 1';
			
		if (! $error) {		
			$query .= ' AND urlmapping.url = \'' . $contentURL . '\'';
		}
		else {
			$query .= ' AND menu.menukey = \'' . $contentURL . '\'';
		}
		
		$query .= '
        	GROUP BY menu.id
        	ORDER BY menu.menulevel,menu.menuorder,menu_translation.title,menu.id';
		
		self::$logger->debug ( 'query: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	/**
	 * Return SELECT statement to get one content's categories
	 * @return String  SELECT statement to get one content's page in the specific language
	 */
	public static function getContentCategories($contentId) {
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select *
        		from ' . Util::getTableName ( 'corp.content_category' ) . ' content_category
        		where idcontent=' . $contentId . ' ' . Util::getTableEnvironmentFilter ( 'content_category' );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	}
	
	/**
	 * Return SELECT statement to get one content's page in the specific language
	 * @return String
	 */
	public static function getContentsLanguageResource($contentId, $languageId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = '
					select 
						menu_translation.title,
						menu_translation.body
						from menu_translation
						where menu_translation.menuid = '.$contentId.'
						and menu_translation.languageid = ' . $languageId;
		
		self::$logger->debug ( 'query: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	/**
	 * Get SQL Query for getting all params from database.
	 */
	public static function getParameters() {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = "SELECT paramname param_key, paramvalue param_value FROM parameters params";
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		self::$logger->debug ( 'query: ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	public static function getLanguageUrlmapping($url) {
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select language.lang_iso
					from language
					inner join urlmapping
					on urlmapping.languageid = language.id
					where urlmapping.url = \''.$url.'\'';
		
		self::$logger->debug ( __METHOD__ . ' query ' . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	public static function getModule($idModule) {
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		$siteEnvironmentFilter = Util::getTableEnvironmentFilter ( 'module' );
		$query = 'SELECT * FROM ' . Util::getTableName ( 'corp.module' ) . ' module
    		 WHERE pfwid=' . $idModule . '  ' . $siteEnvironmentFilter;
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	}
	
	/**
	 * Get SQL query to get specific content with concrete Lang and SiteId..
	 * @param $contentArray: Array with content key's required.
	 * @param $siteId: Site Identification
	 * @param $lanId: Language Identification
	 */
	public static function getDefaultContentsInfo($contentArray, $langId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$contentArray = str_replace ( "'", "''", $contentArray );
		
		$contentString = "'" . implode ( '\',\'', $contentArray ) . "'";
		
		$query = '
					select
						menu.id,
						menu.menukey,
						urlmapping.url
						from menu
						inner join urlmapping
						on menu.id = urlmapping.menuid
						where menu.menukey in
						('.$contentString.')
						and urlmapping.languageid = ' . $langId;
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	/**
	 * Return SELECT statement to specific content with concrete Lang and SideId.
	 * @param int $starLevel start level for the menu
	 * @param int $endLevel: last level for the menu
	 */
	public static function getMenuContents($languageId, $userTypeId, $startLevel, $endLevel = null) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select 
					distinct menu.id,
					menu.menulevel,
					menu.parentid,
					menu.menuorder,
					menu.menukey,
					menu_translation.title,
					urlmapping.url
					from
						menu
					inner join
						menu_translation
						on menu_translation.menuid = menu.id and menu_translation.languageid = '.$languageId.'
					inner join
						urlmapping
						on urlmapping.menuid = menu.id and urlmapping.languageid = '.$languageId.'
					inner join
						usertypeaccess
						on usertypeaccess.menuid = menu.id and usertypeaccess.usertypeid = '.$userTypeId.'
					
					where menu.menulevel >= '.$startLevel.'
						and menu.visible = 1
						and menu.menutypeid = 1
				';
		
		if($endLevel != null){
			
			$query .= 'and menu.menulevel <= ' . $endLevel;
			
		}
		
		$query .= ' order by menu.menulevel ASC, menu.menuorder ASC, menu_translation.title';
		
		
		self::$logger->debug ( "query: " . $query );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	/**
	 * Return SELECT content information from content id
	 * @param int $idSite site to search in
	 * @param int $idContent: content to search in
	 * @param int $languageIso: language to show
	 */
	public static function getCrumb($idContent, $languageId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select
					distinct
					menu.id,
					menu.menukey,
					menu.parentid,
					menu.menulevel,
					menu_translation.title,
					urlmapping.url
					from 
					menu
					inner join menu_translation
					on menu_translation.menuid = menu.id and menu_translation.languageid = '.$languageId.'
					inner join urlmapping
					on urlmapping.menuid = menu.id and urlmapping.languageid = '.$languageId.'
					
					where menu.id = ' . $idContent;
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	}
	
	/**
	 * Return SELECT statement to get content categories.
	 * @param int $idcontent content id
	 */
	public static function getUserValues($usrId, $keyValues) {
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'SELECT ';
		$count = 0;
		foreach ( $keyValues as $columnName ) {
			$query .= $count == 0 ? ' user.' . $columnName : ' ,user.' . $columnName;
			$count ++;
		}
		$query .= '	FROM pfwuser user
					WHERE usrid=' . $usrId;
		
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	}
	
	public static function getModuleId($moduleName) {
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'SELECT pfwid FROM ' . Util::getTableName ( "corp.module" ) . ' module	WHERE name=\'' . $moduleName . '\' ' . Util::getTableEnvironmentFilter ( 'module' );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	}
	
	public static function getLiteralChanges($languageId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'SELECT count(languageid) haschanges 
						FROM literalchanges 
						where languageid = ' . $languageId ;
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	public static function removeLiteralChangesMark($languageId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'DELETE FROM literalchanges where languageid = ' . $languageId ;
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
		
	}
	
	/**
	 *Get the query of Active Modules in given Site.
	 */
	public static function getActiveModules($siteId) {
		self::initializeSession ();
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = '	SELECT  
         					module.name
        					,module.pfwid 
        						FROM ' . Util::getTableName ( "corp.module" ) . ' module
            						INNER JOIN ' . Util::getTableName ( "corp.content" ) . ' content
                						ON content.idmodule=module.pfwid ' . Util::getTableEnvironmentFilter ( 'content' ) . '
                					LEFT JOIN ' . Util::getTableName ( "corp.content_site" ) . ' content_site	
                					  	ON content.pfwid=content_site.idcontent ' . Util::getTableEnvironmentFilter ( 'content_site' ) . '
        					WHERE content.idsite=' . $siteId . ' OR content_site.idsite=' . $siteId . ' ' . Util::getTableEnvironmentFilter ( 'module' );
		
		self::$logger->debug ( __METHOD__ . ' end' );
		return $query;
	
	}
	
	/**
	 * Get the query for content check permissions.
	 */
	public static function getCheckPermissions($userTypeId, $menuId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = '
				select 1 result
					from menu
					inner join usertypeaccess
					on menu.id = usertypeaccess.menuid
					where usertypeaccess.usertypeid = '.$userTypeId.'
					and menu.id = ' . $menuId;
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}
	
	/**
	 * Get the query for first child of content.
	 */
	public static function getChild($contentId, $languageId) {
		
		self::initializeSession ();
		
		self::$logger->debug ( __METHOD__ . ' begin' );
		
		$query = 'select 
					menu.id,
					menu.menukey,
					menu.menuorder,
					menu.menulevel,
					menu.parentid,
					menu.moduleid,
					urlmapping.url,
					menu_translation.title,
					menu_translation.body,
					module.modulename
					from menu
					inner join urlmapping
					on menu.id = urlmapping.menuid
					inner join menu_translation
					on menu.id = menu_translation.menuid
					left join module 
					on menu.moduleid = module.id
					where menu.parentid = ' . $contentId . '
					and urlmapping.languageid = ' . $languageId;
		
		self::$logger->debug ( __METHOD__ . ' end' );
		
		return $query;
	
	}

}
?>