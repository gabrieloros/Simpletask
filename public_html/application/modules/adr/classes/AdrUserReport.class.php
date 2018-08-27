<?php

/**
 * AdrUserReport entity
 * @author mmogrovejo
 *
 */
class AdrUserReport {

	/**
	 * AdrUserReport zoneIn
	 * @var int
	 */
	private $zoneIn;
	
	/**
	 * AdrUserReport zoneOut
	 * @var int
	 */
	private $zoneOut;
	
	/**
	 * AdrUserReport zoneName
	 * @var string
	 */
	private $zoneName;

	/**
	 * AdrUserReport zoneInTime
	 * @var int
	 */
	private $zoneInTime;

	/**
	 * AdrUserReport zoneInFormated
	 * @var date
	 */
	private $zoneInFormated;
	
	/**
	 * AdrUserReport zoneOutFormated
	 * @var date
	 */
	private $zoneOutFormated;
	
	
	
	/**
	 * @return the $zoneIn
	 */
	public function getZoneIn() {
		return $this->zoneIn;
	}
	
	/**
	 * @param int $zoneIn
	 */
	public function setZoneIn($zoneIn) {
		$this->zoneIn = $zoneIn;
	}
	
	/**
	 * @return the $zoneOut
	 */
	public function getZoneOut() {
		return $this->zoneOut;
	}
	
	/**
	 * @param int $zoneOut
	 */
	public function setZoneOut($zoneOut) {
		$this->zoneOut = $zoneOut;
	}
	
	/**
	 * @return the $zoneName
	 */
	public function getZoneName() {
		return $this->zoneName;
	}
	
	/**
	 * @param string $zoneName
	 */
	public function setZoneName($zoneName) {
		$this->zoneName = $zoneName;
	}

	/**
	 * @return the $zoneInTime
	 */
	public function getZoneInTime() {
		return $this->zoneInTime;
	}
	
	/**
	 * @param int $zoneInTime
	 */
	public function setZoneInTime($zoneInTime) {
		$this->zoneInTime = $zoneInTime;
	}

	/**
	 * Format the zone in time
	 * @return the $zoneInFormated
	 */
	public function getZoneInFormated() {
		$zoneInFormated = date('d/m/Y H:i:s', ($this->getZoneIn()/1000));
		return $zoneInFormated;
	}
	
	/**
	 * Format the zone out time
	 * @return date
	 */
	public function getZoneOutFormated() {
		$zoneOutFormated = date('d/m/Y H:i:s', ($this->getZoneOut()/1000));
		return $zoneOutFormated;
	}
	
}
?>