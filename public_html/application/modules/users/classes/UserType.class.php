<?php
/** 
 * @author Gabriel Guzman
 * 
 * 
 */
class UserType {

	/**
	 * Usertype id
	 * @var int
	 */
	private $id;
	
	/**
	 * Usertype name
	 * @var string
	 */
	private $typename;
	
	public function __construct($userTypeData = null){
		
		if ($userTypeData != null) {
			$this->autoLoad ( $userTypeData );
		}
	
	}
	
	/**
	 * Auto load of the object with existent data
	 * @author Gabriel Guzman
	 * @param array $userTypeData
	 */
	private function autoLoad($userTypeData) {
		
		Util::autoMapEntity ( $this, $userTypeData );
	
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
	 * @return the $typename
	 */
	public function getTypename() {
		return $this->typename;
	}

	/**
	 * @param string $typename
	 */
	public function setTypename($typename) {
		$this->typename = $typename;
	}
	
	public function getName(){
	    return $this->typename;
	}
	
}