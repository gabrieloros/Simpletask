<?php
/**
 * Responsible of idiomatic resources
 * @package components
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 14/03/2012
 * UPDATE LIST
 * * UPDATE:
 * PURPOSE: Responsible of idiomatic resources
 * CALLED BY: url.php
 */
class LiteralManager {
	
	private static $instance;
	
	private function __construct() {
	}
	
	/**
	 * Get Literal Manager instance
	 *
	 * @return LiteralManager LiteralManager instance
	 */
	public static function getInstance() {
		if (! isset ( LiteralManager::$instance )) {
			LiteralManager::$instance = new LiteralManager ();
		}
		return LiteralManager::$instance;
	}
	
	/**
	 * Get the idiomatic resource for the specified key
	 *
	 * @param string literal key
	 * 
	 * @return string idiomatic resource
	 */
	public function getLiteral($literalKey) {
		
		$_SESSION ['logger']->debug ( "getLiteral() begin" );
		
		$_SESSION ['logger']->debug ( "requested key: " . $literalKey );
		
		if (isset ( $_SESSION ['s_message'] )) {
			
			$value = getLiteral ( $literalKey );
			
			$_SESSION ['logger']->debug ( "returned value: " . $value );
			$_SESSION ['logger']->debug ( "getLiteral() end" );
			
			return $value;
		}
	}
	
	/**
	 * Get all literals from a language if any value is not definet in the language use defult language
	 *
	 * @param  Language $language The language used to fetch the idiomatics resources
	 * @return array 
	 */
	public function getLiterals(Language $language) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		$_SESSION ['logger']->info ( 'Loading literals for language ' . $language->getIso () );
		
		$literals = array ();
		
		$query = Util::getLiteralsQuery ( $language->getId () );
		
		$connectionManager = ConnectionManager::getInstance();
		
		$rawLiteralsResult = $connectionManager->select($query);
		
		foreach ( $rawLiteralsResult as $rawLiteral ) {
			$literals [strtolower ( $rawLiteral ['literalkey'] )] = $rawLiteral ['literalvalue'];
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
		return $literals;
	}
	
	/**
	 * Load all literals for a language in $_SESSION
	 *
	 * @param  Language $language The language used to fetch the literals
	 * @param  Boolean $force (OPTIONAL)Force to reload all literals
	 */
	public function loadLiterals(Language $language, $force = false) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		if (! isset ( $_SESSION ['s_message'] ) || $force) {
			
			$_SESSION ['s_message'] ['rss_all_categories'] = 'all';
			$_SESSION ['s_message'] ['date_format'] = 'mm-dd-YY';
			$_SESSION ['s_message'] ['date_format_js'] = 'mm-dd-YYYY';
			$_SESSION ['s_message'] = $this->getLiterals ( $language );
			
			$this->createResourcesFile ( $language, $_SESSION ['s_message'] );
			
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
	}
	
	/**
	 * 
	 * Creates a resource file with all literals un JS format.
	 */
	private function createResourcesFile(Language $language, &$literals) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		$fileName = $_SERVER ["DOCUMENT_ROOT"] . '/core/js/resources-' . $language->getIso () . '.js';
		
		$mustCreateResourceFile = true;
		
		$connectionManager = ConnectionManager::getInstance();
		
		if (file_exists ( $fileName )) {
			
			//check database for modifications in the resources
			$query = Util::getLiteralChanges ( $language->getId () );
			
			$rawLiteralModifications = $connectionManager->select($query);
			
			if (is_array ( $rawLiteralModifications ) && $rawLiteralModifications [0] ['haschanges'] > 0)
				$mustCreateResourceFile = true;
			else
				$mustCreateResourceFile = false;
		}
		
		if ($mustCreateResourceFile) {
			
			$fileHandler = fopen ( $fileName, 'w' );
			
			fwrite ( $fileHandler, "//<![cdata[ \n" );
			
			fwrite ( $fileHandler, "var s_message = new Array(); \n" );
			
			$_SESSION ['logger']->info ( "writing file begin" );
			
			foreach ( $literals as $literalKey => $literalValue ) {
				
				$jsLiteral = str_replace ( "\r", "\\", str_replace ( "'", "\'", trim ( strip_tags ( $literalValue ) ) ) );
				
				fwrite ( $fileHandler, "s_message['" . strtolower ( $literalKey ) . "'] = '" . $jsLiteral . "'; \n" );
			}
			
			$_SESSION ['logger']->info ( "writing file end" );
			
			fwrite ( $fileHandler, "//]]>" );
			
			fclose ( $fileHandler );
			
			/**
			 * @todo: crear triggers para postgresql
			 */
			
			//$query = Util::removeLiteralChangesMark ( $language->getId () );
			
			//$result = $connectionManager->exec ( $query );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
	
	}

}