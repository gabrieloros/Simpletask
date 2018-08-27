<?php
/**
* Class to implement the response action for Html
* @package 
* @author Gabriel Guzmán
* @version 1.0
* DATE OF CREATION: 14/03/2012
* DATE OF LAST UPDATE:
* PURPOSE: Class to implement the response action for Redirect
*/

require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/core/classes/actions/ActionResponse.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/core/exceptions/InvalidParametersException.exception.php';
 
class RedirectActionResponse extends ActionResponse {
	
	protected $url;

	public function __construct($url)
	{
		if (!isset($url) || trim($url)=='') {
			$url='/'.$_SESSION['s_languageCode'];
		}
		
 		$this->url =$url;
	}
	
	public function execute() {
		
		
		if (isset($_REQUEST['returnUrl']) && $_REQUEST['returnUrl']!='' && $_REQUEST['returnUrl']!='undefined') {
			$separator = strpos($this->url, '?')===false ? '?' : '&';			
			$this->url .= $separator . 'returnUrl=' . $_REQUEST['returnUrl'];
		}
		
		header ('Content: "text/html" charset="UTF-8"');
		header('Location:'.$this->url);
			
	}
}