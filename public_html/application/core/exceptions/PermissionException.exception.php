<?php
/**
* Class Exception for Permission.
* @package
* @author Gabriel Guzman
*  @version 1.0
*  DATE OF CREATION: 15/03/2012
*  UPDATE LIST
*  * UPDATE:
*  CALLED BY:
*/
class PermissionException extends Exception {

	// Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        
        // make sure everything is assigned properly
        parent::__construct($message, $code);
        
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}