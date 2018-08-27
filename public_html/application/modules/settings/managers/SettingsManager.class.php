<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php');

class SettingsManager implements ModuleManager {
	
	private static $instance;
	private static $logger;
	public static function getInstance() {
		if (! isset ( SettingsManager::$instance )) {
			self::$instance = new SettingsManager ();
		}
	
		return SettingsManager::$instance;
	}	
	
	private function __construct() {
		self::$logger = $_SESSION ['logger'];
	}
	
	public function setOptions(){
		
			
		
		
	}
	
	public function uploadFile($file) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	
		if (! isset ( $file ) || $file == null || ! is_array ( $file )) {
			$_SESSION ['logger']->error ( "Error uploading file" );
			throw new InvalidArgumentException ( "Error uploading file" );
		}
	
		$validFileTypes = unserialize ( VALIDLAYERFILETYPES );		
		$fileData = pathinfo ( $file ['name'] );
	
		if (! in_array ( $fileData ['extension'], $validFileTypes )) {
			$_SESSION ['logger']->error ( "The selected file has an invalid extension" );
			throw new InvalidArgumentException ( "The selected file has an invalid extension" );
		}
	
		$file = $file ['tmp_name'];
		$newfile = $_SERVER ['DOCUMENT_ROOT'] . '/maps/' . $fileData ['basename'];
	
		if (! copy ( $file, $newfile )) {
			$_SESSION ['logger']->error ( "Error uploading file" );
			throw new Exception ( "Error uploading file" );
		}
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	
		return $fileData ['basename'];
	}
	
	
	public function getParameter($parameter){
		
		$param = $_SESSION ['s_parameters'] [$parameter];
		
		return $param;		
		
	}
		
	public function deleteLayer($layer){
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$path = $_SERVER ['DOCUMENT_ROOT'] .EnumCommon::PATH_LAYERS;
		$file = $path.$layer;
		$deleted = false;
		if(file_exists($file))
		{
			if(unlink($file)){
				$_SESSION ['logger']->info('file deleted');
				$deleted = true;
			}
		}else{
			
			$_SESSION ['logger']->error('file not exits');
			
		}
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		return $deleted;
	}
}