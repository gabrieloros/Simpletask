<?php
$configurator = Configurator::getInstance ();

class HeaderManager {
	
	protected static $instance;
	
	/**
	 * Get a single instance of HeaderManager
	 *
	 * @return HeaderManager languageManager instance
	 */
	public static function getInstance() {
		if (! isset ( HeaderManager::$instance )) {
			HeaderManager::$instance = new HeaderManager ();
		}
		return HeaderManager::$instance;
	}
	
	private function __construct() {
	
	}

}