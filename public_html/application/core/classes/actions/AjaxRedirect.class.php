<?php
/**
 * Class to implement the response action Ajax redirect
 * @package 
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 15/03/2012
 * DATE OF LAST UPDATE:
 * PURPOSE: Class to implement the response action for Ajax Redirect
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxActionResponse.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/AjaxResponseType.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/InvalidParametersException.exception.php';

class AjaxRedirect extends AjaxActionResponse {
	
	protected $url;
	
	public function __construct($url, $extraparametersArray = array()) {
		
		if (! isset ( $url ) || ! is_string ( $url )) {
			throw new InvalidParameters ( Util::getLiteral ( 'errorparameters' ) );
		} else {
			$extraString = implode ( '&', $extraparametersArray );
			$this->url = $url;
			
			if (isset ( $extraString ) && $extraString != '') {
				$separator = strpos ( $this->url, '?' ) === false ? '?' : '&';
				$this->url .= $separator . $extraString;
			}
			
			$this->buildJson ();
		}
		
	}
	
	protected function buildJson() {
		
		$this->response = array (AjaxResponseType::REDIRECT, $this->url );
		
	}
}