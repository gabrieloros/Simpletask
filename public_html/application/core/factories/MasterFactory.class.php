<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/views/Master.view.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/views/MasterLdr.view.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/views/MasterPublic.view.php';


/**
 * 
 * Factory to split between diferent Master Views.
 * @author Gabriel Guzman
 *
 */

class MasterFactory {
	
	static public function getMaster () {
		return MasterFactory::getMasterView(1);
	}
	
	static public function getMasterLdr () {
		return MasterFactory::getMasterView(2);
	}
	
        static public function getMasterPublic () {
                return MasterFactory::getMasterView(3);
        }

	static private function getMasterView($master) {
		
		if ($master == 1){
			$masterObject = new MasterView();
		}else if($master==3){
			$masterObject = new MasterViewPublic();
		} else{
                        $masterObject = new MasterViewLdr();
                } 
		return $masterObject;

	}
}
