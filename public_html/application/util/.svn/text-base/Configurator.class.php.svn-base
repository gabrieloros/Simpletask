<?php
/**
 * Load Site configuration
 * @package util
 * @author Gabriel Guzmán 
 * @version 
 * DATE OF CREATION: 13-03-2012
 * UPDATE LIST
 * * UPDATE: 
 * CALLED BY: url.php
 */
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Filesystem.class.php';

class Configurator {
	
	private static $instance;
	
	private $configuration;
	
	/**
	 * Get an instance of Configurator
	 *
	 * @return Configurator configurator instance
	 */
	public static function getInstance() {
		
		if (! isset ( self::$instance )) {
			self::$instance = new Configurator ();
			$configPath = $_SERVER ['DOCUMENT_ROOT'] . "/../application/configs/config.ini";
			if (! is_array ( self::$instance->loadConfiguration ( $configPath ) )) {
				self::$instance = null;
				throw new Exception ( "unable to load config file in: " . $configPath );
			}
		
		}
		return self::$instance;
	}
	
	/**
	 * Read the config file and get the application configuration
	 */
	private function loadConfiguration($configPath) {
		
		$result = $this->configuration = parse_ini_file ( $configPath );
		
		//true if configuration load process OK
		return $result;
	}
	
	/**
	 * Get the Dev / Prod file mapping directory
	 * @param   int     environment
	 * @return  string  PfwFileMappingDirectory
	 */
	public function getPfwFileMappingDirectory() {
		
		if (isset ( $this->configuration ['app.fileMappingDirectory'] ) && $this->configuration ['app.fileMappingDirectory'] != '') {
			
			$pfwFileMappingDirectory = $this->configuration ['app.fileMappingDirectory'];
			
			$result = $this->removeLastSlash ( $pfwFileMappingDirectory );
			
			if (! Filesystem::is_dir ( $result )) {
				throw new Exception ( "app.fileMappingDirectory must exist whit the real location of the folder" );
			}
			
			return $result;
		
		} else {
			throw new Exception ( "app.fileMappingDirectory must be present in the config.ini file" );
		}
	}
	
	private function removeLastSlash($path) {
		
		if ($path [strlen ( $path ) - 1] == "/" or $path [strlen ( $path ) - 1] == "\\") {
			return substr ( $path, 0, - 1 );
		}
		
		return $path;
	}
	
	/**
	 * Get the Minimice Css option
	 * @return boolean.
	 */
	public function getMinimiceCss() {
		
		if (isset ( $this->configuration ['minimice.css'] ) && $this->configuration ['minimice.css'] != '') {
			if ($this->configuration ['minimice.css'] == 1) {
				$minimiceCss = true;
			} elseif ($this->configuration ['minimice.css'] == 0) {
				$minimiceCss = false;
			} else {
				throw new Exception ( "minimice.css must be 1(true) or 0(false)" );
			}
		} else {
			throw new Exception ( "minimice.css must be filled" );
		}
		return $minimiceCss;
	
	}
	
	/**
	 * Get the Minimice Js option
	 * @return boolean.
	 */
	public function getMinimiceJs() {
		
		if (isset ( $this->configuration ['minimice.js'] ) && $this->configuration ['minimice.js'] != '') {
			if ($this->configuration ['minimice.js'] == 1) {
				$minimiceCss = true;
			} elseif ($this->configuration ['minimice.js'] == 0) {
				$minimiceCss = false;
			} else {
				throw new Exception ( "minimice.js must be 1(true) or 0(false)" );
			}
		} else {
			throw new Exception ( "minimice.js must be filled" );
		}
		return $minimiceCss;
	
	}
}
