<?php
class Dependency {

	/**
	 * Dependency id
	 * @var int
	 */
	private $id;
	
	/**
	 * Dependency name
	 * @var string
	 */
	private $name;
	
	/**
	 * Dependency location
	 * @var int
	 */
	private $location;
	
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
}
?>
