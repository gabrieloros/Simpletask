<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Configurator.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Util.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/CommonFunctions.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/common.enum.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/MyLogger.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/db/ConnectionManager.class.php';

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/importer/ImporterFactory.class.php';

$configurator = Configurator::getInstance ();

session_start ();

//Logger
$_SESSION ['logger'] = MyLogger::getInstance ();

/**
 * This class imports the claims into database
 * Is called outside the core of the application, because the default responses doesn't allow the whished responses
 * @todo improve the action responses, and put this methods in ClaimsManager Class
 * @author Gabriel Guzman
 *
 */
class PublicImporter {
	
	private $extension;
	
	private $fileName;
	
	private $originName;
	
	private static $logger;
	
	function __construct($extension, $fileName, $originName) {
		
		$this->extension = $extension;
		
		$this->fileName = $fileName;
		
		$this->originName = $originName;
		
		self::$logger = $_SESSION ['logger'];
	
	}
	
	public function import() {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		ignore_user_abort ( true );
		set_time_limit ( 0 );
		
		$logFile = $_SERVER ['DOCUMENT_ROOT'] . '/../log/import.log';
		
		if (! $handle = fopen ( $logFile, 'a+' )) {
			self::$logger->error("Cannot open file ($logFile)");
			die();
		}
		
		fwrite ( $handle, date("d/m/Y H:i:s") . " - Proceso de importación del archivo " . $this->fileName . " comenzado.\n");
		
		try{
		
			$factory = new ImporterFactory ();
			
			$importer = $factory->create ( $this->extension, $this->originName );
			
			$records = $importer->import ( $this->fileName );
			
			$result = "Se importaron los reclamos correctamente";
			
		
		}
		catch (Exception $e){
			
			$records = $e->getCode();
			
			$result = $e->getMessage();
			
		}
		
		fwrite ( $handle, "Resultado: " . $result . "\n");
		fwrite ( $handle, $records . " reclamos importados.\n");
		fwrite ( $handle, date("d/m/Y H:i:s") . " - Proceso de importación del archivo " . $this->fileName . " finalizado.\n\n");
		
		fclose ( $handle );
		
		//Delete file
		unlink($this->fileName);
		
		echo $result;
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	
	}

}

$publicImporter = new PublicImporter ( $_REQUEST ['extension'], urldecode($_REQUEST ['fileName']), $_REQUEST ['originName'] );

$publicImporter->import ();