<?php

/**
 * Claim entity
 * @author Gabriel Oros
 *
 */
class Group {
	
	/**
	 * Claim id
	 * @var int
	 */
	private $id;
	
	/**
	 * Claim code
	 * @var string
	 */
	private $name;
	
	
	/**
	 * Claim latitude
	 * @var string
	 */
	private $icon;
	
	//----------------------------------------------------------------------------------
	function __construct($id, $name, $icon ) {
		
		$this->id = $id;
		
        $this->name = $name;
        $this->icon = $icon;
	
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
	 * @return the $icon
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * @param string $latitude
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}

	

			
}
