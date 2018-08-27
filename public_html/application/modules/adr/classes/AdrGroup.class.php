<?php

/**
 * AdrGroup entity
 * @author gabriel Oros
 *
 */
class AdrGroup {

	/**
	 * AdrGroup id
	 * @var int
	 */
	private $id;

	/**
	 * AdrGroup name 
	 * @var string
	 */
	private $name;

	
	
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
	 * @param String $name
	 */
	public function setName($name) {
		$this->name = $name;
    }
    

	
	
	
}