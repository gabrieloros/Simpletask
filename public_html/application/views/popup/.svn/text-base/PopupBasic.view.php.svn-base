<?php
/**
 * @author Gabriel Guzman
 * 
 * DATE OF CREATION: 15/03/2012
 * 
 * @description Create a simple HTML canvas with title and body.
 */

class PopupBasic extends Popup {
	
	private $html;
	
	/**
	 * 
	 * Constructor
	 * @param string $html
	 */
	public function __construct($html, $title) {
		
		$this->html = $html;
		
		$this->title = $title;
	
	}
	
	/**
	 * @see Popup::draw()
	 */
	public function draw() {
		
		$output = "<div class='basic-popup'>";	
		$output .= $this->html;
		$output .= "<div class=\"botton-aligment\"><input type=\"button\" value=\"".$_SESSION ['s_message'] ['close_claim']."\" onclick=\"PopupManager.getActive().close();\" onkeypress=\"PopupManager.getActive().close();\" class=\"confirm_icon action_button\"> <div>";
		$output .= "</div>";
		
		return $output;
	}

}