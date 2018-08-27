<?php
/** 
 * @author Gabriel Guzman
 * Location selector map drawer
 * 
 */
class LocationSelector extends Render{
	
	public function render(&$mapObject){
		
		ob_start();
		
		//Javascript Headers
		$headerJs = $mapObject->getHeaderJS(); 
		
		if(!isset($headerJs) || $headerJs == ''){
			$_SESSION ['logger']->error("Error loading Google API Javascripts");
			throw new GoogleAPIException("Error loading Google API Javascripts");
		}
		
		echo $mapObject->printHeaderJS();
		
		//Javascript Map
		echo $mapObject->printMapJS();
		
		//Map loading
		echo $mapObject->printOnLoad(); 
		
		//Map displaying
		echo $mapObject->printMap();
		
		return ob_get_clean();
		
	}
	
}