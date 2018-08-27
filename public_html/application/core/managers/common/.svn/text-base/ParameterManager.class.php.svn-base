<?php
/**
 * Responsible of parameters managements
 * @package components
 * @author Gabriel Guzmán
 * @version 1.0
 * DATE OF CREATION: 15/03/2012 
 * UPDATE LIST
 * * UPDATE: 
 * PURPOSE: Responsible of parameters management
 * CALLED BY: url.php
 */
class ParameterManager {
	
	private static $instance;
	
	private static $parameters;
	
	/**
	 * Get the current ParameterManager instance
	 *
	 * @return ParameterManager ParameterManager instance
	 */
	public static function getInstance($force = false) {
		if (! isset ( ParameterManager::$instance ) || ($force)) {
			ParameterManager::$instance = new ParameterManager ();
		}
		return ParameterManager::$instance;
	}
	
	private function __construct() {
		
		ParameterManager::$parameters = array ();
	
	}
	
	/**
	 * Load application parameters
	 *
	 * @param boolean $force forces to reload the parameters
	 * @param integer $siteId forces to load parameters of given site.
	 * @return void. Parameters into $_SESSION['s_parameters']
	 */
	public function loadParameters($force = false) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		if (! isset ( $_SESSION ['s_parameters'] ) or $_SESSION ['s_parameters'] = '' or $force) {
			
			//setup default parameters            
			$_SESSION ['s_parameters'] ['filesMailto'] = "gabriel@josoft.com.ar";
			$_SESSION ['s_parameters'] ['dateFormat'] = "d/m/Y";
			$_SESSION ['s_parameters'] ['timeFormat'] = "H:I";
			$_SESSION ['s_parameters'] ['dateFormatSql'] = "%d/%m/%Y %H:%i:%s";
			$_SESSION ['s_parameters'] ['onlyDateFormatSql'] = "%d/%m/%Y";
			
			//load parameters from DB
			$query = Util::getParameters ();
			
			$_SESSION ['logger']->debug ( "get parameters query: " . $query );
			$_SESSION ['logger']->info ( "parameters load start..." );
			
			$connectionManager = ConnectionManager::getInstance ();
			
			$rawParametersResult = $connectionManager->select ( $query );
			
			foreach ( $rawParametersResult as $parameter ) {
				$_SESSION ['s_parameters'] [strtolower($parameter ['param_key'])] = $parameter ['param_value'];
			}
			
			$_SESSION ['logger']->info ( "parameters load done" );
		
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
	
	}
}