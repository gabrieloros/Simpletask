<?php
/**
 * @author Gabriel Guzman
 * 
 * DATE OF CREATION: 15/03/2012
 * 
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/views/popup/PopupBasic.view.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/views/popup/PopupScrollBars.view.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/views/popup/PopupBorders.view.php';

abstract class Popup extends AjaxMessageBox{
	
	protected $title;
		
	/**
	 * 
	 * Draw the popup
	 */
	public abstract function draw();
	
	/**
	 * 
	 * Popup title
	 * @return string popup title
	 */
	protected function getTitle(){
		return $this->title;
	}	

}