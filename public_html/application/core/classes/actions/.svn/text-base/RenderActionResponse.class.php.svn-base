<?php
/**
* Class to implement the response action for Html
* @package 
* @author Gabriel Guzmán
* @version 1.0
* DATE OF CREATION: 15/03/2012
* DATE OF LAST UPDATE:
* PURPOSE: Class to implement the response action for Html
*/

require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/core/classes/actions/ActionResponse.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/core/exceptions/InvalidParametersException.exception.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/views/Master.view.php';

class RenderActionResponse extends ActionResponse {
	
	protected $html;

	public function __construct (&$html) {
		
		if (!isset($html) || !is_string($html)) {
			throw new InvalidParameters(Util::getLiteral('errorparameters'));
		}
		else {
			$this->html = $html;
		}
	}

	public function execute() {
		
		if(ob_get_contents()){
			
			ob_clean();
		}
		
		
		ob_start();
	    
		echo trim($this->html, ' ');
		 
	}
}