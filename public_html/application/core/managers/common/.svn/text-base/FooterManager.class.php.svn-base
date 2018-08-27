<?php
$configurator = Configurator::getInstance ();

class FooterManager {
	
	protected static $instance;
	
	/**
	 * Get a single instance of HeaderManager
	 *
	 * @return HeaderManager languageManager instance
	 */
	public static function getInstance() {
		if (! isset ( FooterManager::$instance )) {
			FooterManager::$instance = new FooterManager ();
		}
		return FooterManager::$instance;
	}
	
	private function __construct() {
	
	}
	
	/**
	 * Manager encargado de obtener los links del footer.
	 */
	public function getFooterLinks() {
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		if (! isset ( $_SESSION ['s_footerLinks'] ) || $_SESSION ['s_footerLinks'] == '' || $_SESSION ['basicMenuLanguage'] != $_SESSION ['s_languageIso']) {
			
			$_SESSION ['s_footerLinks'] = array ();
			
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $_SESSION ['s_footerLinks'];
	}
}