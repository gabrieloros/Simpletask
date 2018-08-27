<?php
/**
 * @author Gabriel Guzman
 * 
 * DATE OF CREATION: 15/03/2012
 * 
 * @description Add scrollbars to popup
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/popup/PopupDecorator.class.php';

class PopupScrollBars extends PopupDecorator {
	
	/**
	 * Create scroll bars
	 * @param Popup $popup
	 */
	public function __construct(&$popup) {
		
		$this->popup = $popup;
	}
	
	/**
	 * @see Popup::draw()
	 */
	public function draw() {
		
		$parent = $this->popup->draw ();
		
		return "<div class='popup-scroll'>" . $parent . "</div>";
	}

}