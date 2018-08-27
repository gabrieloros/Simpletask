<?php

class Region {
	
	/**
	 * Region id
	 * @var int
	 */
	private $id;
	
	/**
	 * Region name
	 * @var string
	 */
	private $name;
	
	/**
	 * Region location
	 * @var int
	 */
	private $location;
	
	/**
	 * Region coordinates
	 * @var string
	 */
	private $coordinates;
	
	/**
	 * Region claim stats
	 * @var RegionStat array
	 */
	private $stats;
	
	/**
	 * Position in image
	 * @var string
	 */
	private $position;
	
	function __construct($id=0, $name = '', $location = 0, $coordinates=''){
		
		$this->id = $id;
		
		$this->name = $name;
		
		$this->location = $location;
		
		$this->coordinates = $this->coordinates;
		
	}
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
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

	/**
	 * @return the $location
	 */
	public function getLocation() {
		return $this->location;
	}

	/**
	 * @param int $location
	 */
	public function setLocation($location) {
		$this->location = $location;
	}

	/**
	 * @return the $coordinates
	 */
	public function getCoordinates() {
		return $this->coordinates;
	}

	/**
	 * @param string $coordinates
	 */
	public function setCoordinates($coordinates) {
		$this->coordinates = $coordinates;
	}
	
	/**
	 * @return the $stats
	 */
	public function getStats() {
		return $this->stats;
	}

	/**
	 * @param array $stats
	 */
	public function setStats($stats) {
		$this->stats = $stats;
	}

	public function addStat($stat){
		$this->stats [] = $stat;
	}

	/**
	 * @return the $position
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * @param string $position
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

}