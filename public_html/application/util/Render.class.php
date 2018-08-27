<?php
/**
 * Render Content Class
 *  
 * @author Gabriel Guzmán
 * @version 1.0
 * DATE OF CREATION: 15/03/2012
 * UPDATE LIST
 * * UPDATE:
 * PURPOSE: This class allows to draw content according to security and encoding politics.
 * CALLED BY: url.php
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Configurator.class.php';

$configurator = Configurator::getInstance ();

class Render {
	
	private static $charset = 'UTF-8';
	
	private static $validCharsets = array ('UTF-8', 'ISO-8859-1', 'ISO-8859-15' );
	
	/**
	 * Get currrent charset value
	 * 
	 * @return string with the value of the charset
	 */
	static public function getCharset() {
		return self::$charset;
	}
	
	/**
	 * Set the currrent charset value
	 * @param String $charset value of the character set. The value must be in the list of valid charsets.
	 * @return void
	 */
	static public function setCharset($charset) {
		
		if (in_array ( $charset, self::$validCharsets, true )) {
			self::$charset = $charset;
		} else {
			throw new Exception ( "The chosen charset is not valid" );
		}
		
	}
	
	/**
	 * Display safe content
	 * @param String $input content to render
	 * @return Encoded and safe from xss String
	 */
	static public function renderContentWithStrip($input) {
		
		$text = '';
		
		if (isset ( $input ) && $input != '') {
			$text = htmlspecialchars ( strip_tags ( html_entity_decode ( $input, ENT_NOQUOTES, self::$charset ) ), ENT_NOQUOTES, self::$charset );
		}
		
		return $text;
	}
	
	/**
	 * Display safe content
	 * @param String $input content to render
	 * @return encoded String
	 */
	static public function renderContent($input) {
		
		$text = '';
		
		if (isset ( $input ) && $input != '') {
			$text = htmlspecialchars ( html_entity_decode ( $input, ENT_QUOTES, self::$charset ), ENT_QUOTES, self::$charset );
		}
		
		return $text;
		
	}
	
	/**
	 * Display safe content special for javascript
	 * @param String $input content to render
	 * @return encoded String
	 */
	static public function renderContentJavascript($input) {
		
		$text = '';
		
		if (isset ( $input ) && $input != '') {
			$str = str_replace ( array ("\n", "\r", "'", '"' ), array ("", "", "\\'", '\\"' ), urldecode ( $input ) );
			$text = htmlentities ( $str, ENT_NOQUOTES, 'UTF-8' );
		}
		
		return $text;
		
	}
	
	/**
	 * Display safe content special for javascript
	 * @param String $input content to render
	 * @return encoded String
	 */
	static public function renderContentJavascriptNoEntities($input, $doubleEscape = false) {
		
		$text = '';
		$double = '';
		
		if ($doubleEscape) {
			$double = '\\';
		}
		
		$str = '';
		
		if (isset ( $input ) && $input != '') {
			$str = str_replace ( array ("\n", "\r", "'", '"' ), array ("", "", $double . "\\'", '&#34;' ), urldecode ( $input ) );
		}
		
		return $str;
		
	}
	
	/**
	 * Display safe content special for url
	 * @param String $input content to render
	 * @return encoded String
	 */
	static public function renderUrlDecode($input) {
		
		if (isset ( $input ) && $input != '') {
			$str = urldecode ( $input );
		}
		
		return $str;
		
	}
	
	/**
	 * Display safe content special for url
	 * @param String $input content to render
	 * @return encoded String to UTF 8
	 */
	static public function renderUrlUtf8($input) {
		
		$arrayReturnUlr = explode ( '/', $input );
		$urlUtf8 = '';
		
		for($i = 1; $i < count ( $arrayReturnUlr ); $i ++) {
			$urlUtf8 = $urlUtf8 . '/' . urlencode ( $arrayReturnUlr [$i] );
		}
		
		return $urlUtf8;
		
	}
}