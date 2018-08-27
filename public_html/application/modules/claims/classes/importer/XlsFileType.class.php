<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/importer/FileType.class.php';
set_include_path(get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'] . '/../application/util/importer/PHPExcel/PHPExcel/');

require_once 'IOFactory.php';

/**
 * 
 * Defines the loader for XLS filetype (Excel until 2003 version)
 * @author Gabriel Guzman
 *
 */
class XlsFileType extends FileType{
	
	function __construct() {
	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see FileType::load()
	 * Loads a XLS file
	 * @return array $fileData
	 */
	public function load($fileName){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if(!isset($fileName) || $fileName == null || !file_exists($fileName)){
			$_SESSION ['logger']->error("Invalid file name or file doesn't exists");
			throw new FileNotFoundException("Invalid file name or file doesn't exists");
		}
		
		try{
			$objPHPExcel = PHPExcel_IOFactory::load($fileName);

			$fileData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			
		}
		catch (Exception $e){
			throw $e;
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $fileData;
		
	}
	
}

?>