<?php

/**
 * @author mmogrovejo
 */
class AdrUserState {
	
	/**
	 * @var int
	 */
	private $id;
	
	/**
	 * @var string
	 */
	private $description;
	
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
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * @param int $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}
	
}