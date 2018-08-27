<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/../application/util/log4php/Logger.php';

/** 
 * @author gabriel guzman
 * 
 * 
 */


//var_dump(require_once $_SERVER['DOCUMENT_ROOT'].'/../application/util/log4php/Logger.php');
//die();


class MyLogger extends Logger{
    static private $instance = NULL;

    static public function getInstance() {
        if (self::$instance == NULL ) {
        		Logger::configure($_SERVER['DOCUMENT_ROOT'].'/../application/configs/log4php.properties');
                self::$instance = Logger::getRootLogger();
   
        }

        return self::$instance;
        
    }

}
//var_dump($instance);
//die();
?>