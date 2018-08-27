<?php
/**
 * @author Gabriel Guzman
 * 
 * DATE OF CREATION: 15/03/2012
 * 
 * @description Add borders for popup
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/popup/PopupDecorator.class.php';

class PopupBorders extends PopupDecorator {
	
	/**
	 * 
	 * Create scroll bars
	 * @param Popup $popup
	 */
	public function __construct(&$popup) {
		
		$this->popup = $popup;
	}
	
	public function draw() {
		
		$output = "<div class='basic-popup-border'>";
		
			$output .= $this->popup->draw ();
		
		$output .= "</div>";
		
		return $output;
	}

}