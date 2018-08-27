<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/ldr/db/ClosureClaimDB.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/common/ConceptDetailGeneric.class.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/State.class.php');

/**
 * Maneja los cierre de los reclamos del telefono
 *
 * @author pdavid.romero
 *        
 */
class ClosureClaimManager implements ModuleManager {
	private static $instance;
	private static $logger;
	public static function getInstance() {
		if (! isset ( ClosureClaimManager::$instance )) {
			self::$instance = new ClosureClaimManager ();
		}
		
		return ClosureClaimManager::$instance;
	}
	private function __construct() {
		self::$logger = $_SESSION ['logger'];
	}
	
	/**
	 * Returns a list of claims causes
	 * 
	 * @return array
	 */
	public function getCauses() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$list = array ();
		
		$query = ClosureClaimDB::getCauses ();
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		foreach ( $rs as $element ) {
			$list [$element ["id"]] = array (
					"name" => Util::cleanString ( $element ["name"] ),
					"subjectId" => $element ["subjectid"] 
			);
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	}
	
	public function getWithoutFixing() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$query = ClosureClaimDB::getWithoutFixing ();
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		$list = array ();
		
		if (is_array ( $rs )) {
			
			foreach ( $rs as $element ) {
				
				$obj = new ConceptDetailGeneric ();
				$obj->setId ( $element ['id'] );
				$obj->setDescription ( $element ['description'] );
				$obj->setName ( $element ['name'] );
				$list [] = $obj;
			}
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	}
	
	public function getMaterials() {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$query = ClosureClaimDB::getMaterial();
		
		$connectionManager = ConnectionManager::getInstance ();
		
		$rs = $connectionManager->select ( $query );
		
		$list = array ();
		
		if (is_array ( $rs )) {
			
			foreach ( $rs as $element ) {
				
				$obj = new ConceptDetailGeneric ();
				$obj->setId ( $element ['id'] );
				$obj->setDescription ( $element ['description'] );
				$obj->setName ( $element ['name'] );
				$list [] = $obj;
			}
		}
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $list;
	}
	
	public function saveClosureClaim($claimClosure,$stateCliamId) {
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	
		$query = ClosureClaimDB::saveClosureClaim($claimClosure,$stateCliamId);
		
		$connectionManager = ConnectionManager::getInstance ();
			
		$rs = $connectionManager->executeTransaction($query);
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $rs;
	}
	
	
	
}
?>