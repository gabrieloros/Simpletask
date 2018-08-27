<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Region.class.php');

class Map {
	
	/**
	 * Map image url
	 * @var string
	 */
	private $imageUrl;
	
	/**
	 * Map regions
	 * @var Region array
	 */
	private $regions;
	
	function __construct($imageUrl, $regions) {
	
		$this->imageUrl = $imageUrl;
		
		$this->regions = $regions;
		
	}
	
	public function draw($mapStyle){
		
		$html = '';
		
		if(isset($this->imageUrl) && $this->imageUrl != null){
			
			//$regionsIds = array_keys($_SESSION['claimsConcepts']['regions']);
		
			$html .= '
					<div id="statsMapContainer" style="' . $mapStyle . ' position: relative;">
						<img src="'.$this->imageUrl.'" alt="" id="imageMap"/>';
			
			//foreach ($this->getRegions() as $region){
			foreach ($_SESSION['claimsConcepts']['regions'] as $regionKey => $regionConcept){
					
				$divPosition = $regionConcept['position'];				
				if(isset($this->regions[$regionKey]) && is_object($this->regions[$regionKey]))
					$divPosition = $this->regions[$regionKey]->getPosition();
				
				$html .= '<div class="regionArea" style="'.$divPosition.'">';
				
				$html .= '<div class="regionName">'.$regionConcept['name'].'</div>';
				
				if(isset($this->regions[$regionKey]) && is_object($this->regions[$regionKey])){
					foreach($this->regions[$regionKey]->getStats() as $stat){
		
						$html .= '<div>' . $stat['state'] . ': ' . $stat['total'] . '</div>';
						
					}
				}
				
				$html .= '</div>';
				
			}
			
			
			$html .='
					</div>
					
					';
		
		}
		
		return $html;
		
	}
	
	/**
	 * @return the $imageUrl
	 */
	public function getImageUrl() {
		return $this->imageUrl;
	}

	/**
	 * @param string $imageUrl
	 */
	public function setImageUrl($imageUrl) {
		$this->imageUrl = $imageUrl;
	}

	/**
	 * @return the $regions
	 */
	public function getRegions() {
		return $this->regions;
	}

	/**
	 * @param array $regions
	 */
	public function setRegions($regions) {
		$this->regions = $regions;
	}
	
	/**
	 * Adds a region to regions array
	 * @param Region $region
	 */
	public function addRegion($region){
		$this->regions [] = $region;
	}

}