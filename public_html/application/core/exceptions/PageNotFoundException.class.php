<?php
/**
 * Custom exception to handle a wrong page request
 * @package components
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION: 13/03/2012
 * UPDATE LIST
 * * UPDATE:
 * PURPOSE: It´s throws when a page doesn´t exist
 * CALLED BY: anyone
 */

class PageNotFoundException extends Exception {
	
	// Redefine the exception so message isn't optional
	public function __construct($message, $code = 0, Exception $previous = null) {
		
		// make sure everything is assigned properly
		parent::__construct ( $message, $code );
	}
	
	// custom string representation of object
	public function __toString() {
		return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
	}
}


