<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/GoogleMaps.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/GoogleAPIException.class.php';

/** 
 * @author Gabriel Guzman
 * Class for retrieve geolocation information from Google API 
 * 
 */
class GeoLocation {
	
	function __construct() {
	
	}
	
	/**
	 * Get latitude and longitude for a given address
	 * @param string $address
	 * @throws InvalidArgumentException
	 * @return array:
	 * 		$geogodes ['lat']
	 * 		$geogodes ['lon']
	 */
	public function getGeoLocationFromAddress($address){
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		if(!isset($address) || $address == null){
			$_SESSION ['logger']->error("Address shouldn'\t be empty");
			throw new InvalidArgumentException("Address shouldn'\t be empty");
		}
		
		$mapObject = new GoogleMapAPI(); 

		$mapObject->_minify_js = true;
		
		$geoCodes = $mapObject->getGeoCode($address);
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $geoCodes;
		
	}

	/**
	 * Draws a map for ajax popup
	 * @param string $address
	 * @param string $targetElementId
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public function getSelectorMapAjax($address, $fullAddress, $targetElementId){
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		if(!isset($address) || $address == null){
			$address = '';
		}
		
		if(!isset($fullAddress) || $fullAddress == null){
			$fullAddress = '';
		}
		
		if(!isset($targetElementId) || $targetElementId == null){
			$_SESSION ['logger']->error("Target Element shouldn'\t be empty");
			throw new InvalidArgumentException("Target Element shouldn'\t be empty");
		}

		$html = '';
			
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/SelectorMap.view.php';
			
		$html = SelectorMap::render($address, $fullAddress, $targetElementId);
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $html;
		
	}
	
	/**
	 * Draws a map embedded in html
	 * @param string $address
	 * @param string $targetElementId
	 * @param string $mapWidth
	 * @param string $mapHeight
	 * @throws InvalidArgumentException
	 * @throws GoogleAPIException
	 * @return string
	 */
	public function getSelectorMap($address, $targetElementId, $mapWidth, $mapHeight){
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		if(!isset($address) || $address == null){
			$_SESSION ['logger']->error("Address shouldn'\t be empty");
			throw new InvalidArgumentException("Address shouldn'\t be empty");
		}
		
		if(!isset($targetElementId) || $targetElementId == null){
			$_SESSION ['logger']->error("Target Element shouldn'\t be empty");
			throw new InvalidArgumentException("Target Element shouldn'\t be empty");
		}
		
		$mapObject = new GoogleMapAPI(); 
		
		//Minify JS
		$mapObject->_minify_js = true;
		
		//Map width
		if(isset($mapWidth) && $mapWidth != null){
			$mapObject->setWidth($mapWidth);
		}
		
		//Map height
		if(isset($mapHeight) && $mapHeight != null){
			$mapObject->setHeight($mapHeight);
		}
		
		//Retrieve Geo Code
		$geoCodes = $mapObject->getGeoCode($address);
		
		if(!$geoCodes){
			$_SESSION ['logger']->error(Util::getLiteral('error_retrieving_geocode'));
			throw new GoogleAPIException(Util::getLiteral('error_retrieving_geocode'));
		}
		
		$html = '';
		
		//Map drawing
		if($geoCodes && is_array($geoCodes) && count($geoCodes) > 0){
			
			$action = $address . '<br />';
			
			$action .= '<a href="javascript:updateLocation(\''.$geoCodes['lat'].'\',\''.$geoCodes['lon'].'\', '.$targetElementId.');">'.Util::getLiteral('select').'</a>';
			
			$mapObject->addMarkerByCoords($geoCodes['lon'], $geoCodes['lat'], '', $action);
			
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/LocationSelector.view.php';
			
			$html = LocationSelector::render($mapObject);
			
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/SelectorMap.view.php';
			
			$html = SelectorMap::render($address, $targetElementId);
			
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $html;
		
	}
	
}