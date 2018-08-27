<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/../application/util/cssmin-v2.0.2.2.php';

class CssManager{

	/**
	 * 
	 * css files to work on
	 * @var array
	 */
	private $cssFiles;
	
	public function __construct($cssFiles){
		$this->cssFiles = $cssFiles;
	}
	
	/**
	 * 
	 * @author Gabriel Guzman
	 * Merge all css file in one
	 * @param string $destinationFilePath. Phisical path of the new file
	 * @param boolean $overwrite. overwrite if the file arleady exist
	 */
	public function mergeFiles($directoryToLookup, $filePrefix){

		$directory = $directoryToLookup;
		$endFile = $filePrefix."-".time().".css";
		
		// Volver a construir los CSS
		$files = scandir($directory);	
		foreach($files as $file){
			$namePieces = explode("-", $file);
			if($namePieces[0] == $filePrefix){
				unlink($directory.$file);
			}		
		}
		
		$styleContent = "";
		
		foreach ($this->cssFiles as $styleFile) {
			$absPath =  $styleFile;
			
			if(file_exists($absPath)){
				$styleContent .= file_get_contents($absPath);
				$styleContent .= "\n";
			}
			
		}
		
		$styleContent = CssMin::minify($styleContent, array(
													        "remove-empty-blocks"           => true,
													        "remove-empty-rulesets"         => true,
													        "remove-last-semicolons"        => true,
													        "convert-css3-properties"       => true,
													        "convert-font-weight-values"    => true, 
													        "convert-named-color-values"    => true,
													        "convert-hsl-color-values"      => true,
													        "convert-rgb-color-values"      => true,
													        "compress-color-values"         => true,
													        "compress-unit-values"          => true,
													        "emulate-css3-variables"        => true
													        ));
		$destination = $directory . $endFile;		
			
		file_put_contents($destination, $styleContent, FILE_APPEND | LOCK_EX);
	
	}

	/**
	 * 
	 * @author Gabriel Guzman
	 * 
	 * @param string $directoryToLookup
	 * @param string $filePrefix
	 * @return css path or false if the file doesn´t exist
	 */
	public function getCssFile($directoryToLookup, $filePrefix){
		
		$files = scandir($directoryToLookup);
		
		$includeFile = "";

		foreach($files as $file){
			$namePieces = explode("-", $file);
			if($namePieces[0] == $filePrefix){
				$includeFile = $file;
			}
		}
		
		if($includeFile == ''){
			return false;
		}
		else{
			$masterCssFileLastModification = filemtime($directoryToLookup.$includeFile);
			
			foreach($files as $file){
				$fileFullPath = $directoryToLookup . $file;
				
				if(in_array($fileFullPath, $this->cssFiles)){
					$cssFileModDate = filemtime($fileFullPath);
					
					if($masterCssFileLastModification < $cssFileModDate){
						return false;
					}
				}
			}
			
			return "/core/css/" .$includeFile;
		}
		
		return false;
		
	}
	/**
	 * @return the $cssFiles
	 */
	public function getCssFiles() {
		return $this->cssFiles;
	}

	/**
	 * @param array $cssFiles
	 */
	public function setCssFiles($cssFiles) {
		$this->cssFiles = $cssFiles;
	}

}