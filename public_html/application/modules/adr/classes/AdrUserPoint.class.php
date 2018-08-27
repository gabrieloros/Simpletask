<?php

/**
 * AdrUserPoint entity
 * @author mmogrovejo
 *
 */
class AdrUserPoint {

	/**
	 * AdrUserPoint userId
	 * @var int
	 */
	private $userId;

	/**
	 * AdrUserPoint latitude 
	 * @var int
	 */
	private $latitude;

	/**
	 * AdrUserPoint longitude
	 * @var int
	 */
	private $longitude;

	/**
	 * AdrUserPoint reportedTime
	 * @var int
	 */
	private $reportedTime;
	
	/**
	 * AdrUserPoint name
	 * @var string
	 */
	private $name;
	
	private $id;
	    
	public function getId() 
	{
	  return $this->id;
	}
	
	public function setId($value) 
	{
	  $this->id = $value;
	}
	/**
	 * @return the $userId
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId($userId) {
		$this->userId = $userId;
	}

	/**
	 * @return the $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * @param int $latitude
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	/**
	 * @return the $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * @param int $longitude
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}
	
	/**
	 * @return the $reportedTime
	 */
	public function getReportedTime() {
		return $this->reportedTime;
	}

	/**
	 * @param int $reportedTime
	 */
	public function setReportedTime($reportedTime) {
		$this->reportedTime = $reportedTime;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * @param string $name
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
}