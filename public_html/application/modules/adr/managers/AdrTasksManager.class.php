<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/db/AdrGroupDB.class.php';
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Group.class.php');

/**
 * Handles all the assign tasks operations
 * @author mmogrovejo
 * @author gabriel oros
 */
class AdrTasksManager implements ModuleManager {

	private static $instance;

	private static $logger;

	public static function getInstance() {

		if (! isset ( AdrTasksManager::$instance )) {
			self::$instance = new AdrTasksManager();
		}

		return AdrTasksManager::$instance;
	}

	private function __construct() {

		self::$logger = $_SESSION ['logger'];

	}

	/**
	 * Checks if one point is inside a polygon
	 * @param string $point
	 * @param array $polygon
	 * @return boolean
	 */
	public function checkPointWithinPolygon($point, $polygon) {

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		if(!is_array($polygon) || count($polygon) <= 3) {
			self::$logger->error ( 'polygon paramenter must be an array or it is invalid' );
			throw new InvalidArgumentException ( 'polygon paramenter must be an array or it is invalid' );
		}
		
		$result = Util::isWithinBoundary($point, $polygon);

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		return $result;

	}

	/**
	 * Get the ordered list by shortes path
	 * @param array $claimsList
	 * @param array $company
	 * @return multitype:array
	 */
	public function getOrderedListByDistance($claimsList, $company) {
		
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$origin = null;
		$target = null;
		$orderedList = array();
		$tmpClaimList = array();
		$y = 0;
		 
		
		$origin = $company;
		$orderedList[0] = $origin;
		
		$tmpClaimsList = $claimsList;
		
		for($i = 0; $i < count($claimsList); $i++) {

			
			for($j = 0; $j < count($tmpClaimsList); $j++) {
				
				$originPosition = $origin['pos']['ob'].', '.$origin['pos']['pb'];
				$targetPosition = $tmpClaimsList[$j]['pos']['ob'].', '.$tmpClaimsList[$j]['pos']['pb'];
				
				$x = Util::getDistanceBetweenTwoPoints($originPosition, $targetPosition);

				if(($x['distance']['value'] < $y && $x['distance']['value'] > 0 ) || $j == 0) {
					$y = $x['distance']['value'];
					$index = $j;
					
				}

			}
			
			$origin = $tmpClaimsList[$index];

			$orderedList[$i+1] = $origin;
			
			unset($tmpClaimsList[$index]); 
			$tmpClaimsList = array_values($tmpClaimsList);
			
			$y = 0;

		}

		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $orderedList;

	}

	public function getListGroups() {

	
		$list = array ();

		$query = AdrGroupDB::getListGroup();

		$connectionManager = ConnectionManager::getInstance ();

		$rs = $connectionManager->select ( $query );
		

		if(is_array($rs)){
			foreach ( $rs as $element ) {
				$obj = new Group ( $element ['id'], $element ['name'], $element ['icon']);
				$list [] = $obj;
			}
		}
	
		self::$logger->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		

		return $list;
		
	}

}
?>