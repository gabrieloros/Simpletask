<?php
/**
 * URL sintactic analyzer
 * @package components
 * @author Gabriel Guzmán
 * @version 1.0
 * DATE OF CREATION: 14/03/2012
 * UPDATE LIST
 * PURPOSE: Parse the url
 * CALLED BY: url.php
 */

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/RedirectActionResponse.class.php');

class UrlParser {
	
	private $url;
	
	private $separator;
	
	private $languageManager;
	
	public function __construct() {
	}
	
	/**
	 * Parse the url and split it using a separator. Default separator criteria "/"
	 * if the URL doesn´t contain an ISO code as first parameter, this method asumes
	 * the default language
	 * 
	 * @param  string $url URL to split
	 * @param  string $separator string used for URL spliting
	 * @return array array with url values
	 */
	public function ParseUrl($url, $separator = "/") {
		
		$_SESSION ['logger']->debug ( __METHOD__." begin" );
		$_SESSION ['logger']->debug ( "url " . $url );
		
		$dns = $_SERVER ['SERVER_NAME'];
		
		$subsiteName = '';
		
		$this->url = urldecode ( $url );
		$this->separator = $separator;
		
		if ($url [0] == $separator) {
			$url = mb_substr ( $url, 1 );
		}
		
		$rawArgs = array ();
		$postPosition = strpos ( $this->url, '?' );
		
		if ($postPosition !== false) {
			$this->url = substr ( $this->url, 0, $postPosition );
		}
		
		$args = explode ( $separator, $this->url );
		
		foreach ( $args as $arg ) {
			
			if (trim ( $arg ) != '') {
				
				$subsite = $dns . "/" . $arg;
				$rawArgs [] = $arg;
				
			}
		}
			
		unset ( $_SESSION ['s_parameters'] );
		unset ( $_SESSION ['basicMenu'] );
		unset ( $_SESSION ['s_defaultcontent'] );
		unset ( $_SESSION ['s_headerLinks'] );
		unset ( $_SESSION ['s_footerLinks'] );
		
		$_SESSION ['logger']->debug ( __METHOD__." end" );
		
		return $rawArgs;
	}
	
	public function addLanguageToArgs($rawArgs) {
		
		$_SESSION ['logger']->debug ( __METHOD__." begin" );
		
		$this->languageManager = LanguageManager::getInstance ();
		
		//if url omits the language iso code as first argument
		if (! isset ( $rawArgs [0] ) || strlen ( $rawArgs [0] ) != 2) {
			
			if (isset ( $_SESSION ['s_languageCode'] )) {
				$defaultLanguage = $_SESSION ['s_languageCode'];
				$_SESSION ['logger']->debug ( "asumed default language: " . $defaultLanguage );
			} else {
				
				/** Check if the url exists in semantic url mapping table in order to set the default language */
				if (isset($rawArgs [0]) && $rawArgs [0] != '') {
					
					$query = Util::getLanguageUrlmapping ( $rawArgs [0] );
					
					$connectionManager = ConnectionManager::getInstance();
					
					$rs = $connectionManager->exec ( $query );
					
					while ( $row = $connectionManager->fetch ( $rs ) ) {
						$defaultLanguage = $row ['lang_iso'];
					}
				}
				
				if (! isset ( $defaultLanguage ) || $defaultLanguage == '') {
					$defaultLanguage = $this->languageManager->getDefaultLanguage ()->getIso ();
				}
				
				$_SESSION ['logger']->debug ( "asumed default language: " . $defaultLanguage );
				
			}
			
			if (count ( $rawArgs ) > 0 and $rawArgs [0] != '') {
				$rawArgs = array_merge ( ( array ) $defaultLanguage, ( array ) $rawArgs );
			} else {
				$rawArgs = ( array ) $defaultLanguage;
			}
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
		return $rawArgs;
	}
}

