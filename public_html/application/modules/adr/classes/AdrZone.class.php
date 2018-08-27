<?php

class AdrZone {

	/**
	 * AdrZone id
	 * @var int
	 */
	private $id;

	/**
	 * AdrZone name
	 * @var string
	 */
	private $name;

	/**
	 * AdrZone location
	 * @var int
	 */
	private $location;

	/**
	 * AdrZone coordinates
	 * @var string
	 */
	private $coordinates;

	/**
	 * Position in image
	 * @var string
	 */
	private $position;


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