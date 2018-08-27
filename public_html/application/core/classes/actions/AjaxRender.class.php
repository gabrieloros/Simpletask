<?php
/**
 * Class to implement the response action Ajax Html
 * @package 
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 15/03/2012
 * DATE OF LAST UPDATE:
 * PURPOSE: Class to implement the response action for Ajax Html
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxActionResponse.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/AjaxResponseType.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/InvalidParametersException.exception.php';

class AjaxRender extends AjaxActionResponse {
	
	protected $html;
	
	public function __construct($html) {
		
		if (! isset ( $html ) || ! is_string ( $html )) {
			throw new InvalidParameters ( Util::getLiteral ( 'errorparameters' ) );
		} else {
			$this->html = $html;
			
			$this->buildJson ();
		}
		
	}
	
	protected function buildJson() {
		
		$this->response = array (AjaxResponseType::RENDER, $this->html );
		
	}

}