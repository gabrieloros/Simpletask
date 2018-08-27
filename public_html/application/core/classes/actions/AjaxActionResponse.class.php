<?php
/**
 * Class to implement the response action Html
 * @package 
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 15/03/2012
 * DATE OF LAST UPDATE:
 * PURPOSE: Class to implement the response action for Ajax
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/ActionResponse.class.php';

abstract class AjaxActionResponse extends ActionResponse {
	
	protected $response;
	
	abstract protected function buildJson();
	
	public function execute() {
		$output = "";
		
		if (! is_array ( $this->response )) {
			$this->buildJson ();
		}
		
		$output = json_encode ( $this->response );
		
		echo $output;
	}
}