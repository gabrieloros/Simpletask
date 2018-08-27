<?php
/**
 * Class to implement the response action Ajax Popup
 * @package 
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 15/03/2012
 * DATE OF LAST UPDATE:
 * PURPOSE: Class to implement the response action for Ajax Popup
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxActionResponse.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/AjaxResponseType.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/InvalidParametersException.exception.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/popup/Popup.view.php';

class AjaxMessageBox extends AjaxActionResponse {
	
	protected $messageBoxType;
	
	protected $message;
	
	protected $buttonsAction;
	
	protected $formId;
	
	/**
	 * 
	 * Error title
	 * @var string
	 */
	private $title;
	
	public function __construct($message, $formId = null, $title) {
		
		if (! isset ( $message ) || ! is_string ( $message )) {
			throw new InvalidParameters ( $_SESSION ['s_message'] ['errorparameters'] );
		} else {
			
			$this->message = $message;
			
			$this->title = $title;
			
			$this->formId = isset ( $formId ) ? $formId : '';
		
		}
	}
	
	protected function buildJson() {
		
		$basic = new PopupBasic ( $this->message, $this->title );
		
		$scroll = new PopupScrollBars ( $basic );
		
		$popup = new PopupBorders ( $scroll );
		
		$this->response = array (AjaxResponseType::MESSAGEBOX, array ($popup->draw (), $this->formId ) );
	
	}
}