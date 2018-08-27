<?php

/**
 * This class manages the loading an parsing of claims files. Is responsible for invoking file loaders and array parsers.
 * @author Gabriel Guzman
 *
 */
class Importer {
	
	private $claimType;
	
	private $fileType;
	
	function __construct($fileType, $claimType) {
		
		if(!is_a($fileType, "FileType") || !is_a($claimType, "ClaimType")){
			$_SESSION ['logger']->error("Expected FileType and ClaimType objects");
			throw new InvalidArgumentException("Expected FileType and ClaimType objects");
		}
		
		$this->fileType = $fileType;
		
		$this->claimType = $claimType;
	
	}
	
	/**
	 * Invokes the file loader and the array parser
	 * @param string $fileName
	 * @throws Exception
	 * @return array $parsedData
	 */
	public function import($fileName){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try {
			
			$data = $this->fileType->load($fileName);
			
			$parsedData = $this->claimType->parse($data);
			
		} catch (Exception $e) {
			throw $e;	
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $parsedData;
		
	}
	
}

?>