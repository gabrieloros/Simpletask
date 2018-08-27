<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/../application/util/jsmin.php';

class JsManager{
	
	private $jsFiles;
	
	public function __construct($jsFiles){
		$this->jsFiles = $jsFiles;
	}
	
	public function mergeFiles($directoryToLookup, $filePrefix){
		
		$directory = $directoryToLookup;
		$endFile = $filePrefix."-".time().".js";
		$destination = $directory . $endFile;
			
		// Volver a construir los JS
		$files = scandir($directory);
		foreach($files as $file){
			$namePieces = explode("-", $file);
			if($namePieces[0] == $filePrefix){
				unlink($directory.$file);
			}		
		}
		
		$scriptContent = "";
		
		foreach ($this->jsFiles as $absPath) {

			if(file_exists($absPath)){
				$scriptContent .= file_get_contents($absPath);
				$scriptContent .= "\n";
			}
		}
		
		$scriptContent = JSMin::minify($scriptContent);
		
		file_put_contents($destination, $scriptContent, FILE_APPEND | LOCK_EX);
		
		$includeFile = "/src/js/" . $endFile;
	
	}
	
	public function getJsFile($directoryToLookup, $filePrefix){
		
		//hay que volver a escanear el directorio para actualizar el array
		$files = scandir($directoryToLookup);
		
		$includeFile = "";
		
		foreach($files as $file){
			$namePieces = explode("-", $file);
			
			if($namePieces[0] == $filePrefix){
				$includeFile = $file;
				break;
			}
		}
		
		//si el archivo de javascript no existe
		if($includeFile == '')
			return false;
		else{	
			$masterJsFileLastModification = filemtime($directoryToLookup.$includeFile);
			
			foreach($files as $file){
				$fileFullPath = $directoryToLookup . $file;
				
				if(in_array($fileFullPath, $this->jsFiles)){
					$jsFileModDate = filemtime($fileFullPath);
					
					if($masterJsFileLastModification < $jsFileModDate){
						return false;
					}
				}
			}
			
			return "/core/js/" .$includeFile;
		}
		
		return false;
	}

}