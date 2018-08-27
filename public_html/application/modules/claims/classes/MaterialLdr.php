<?php
class MaterialLdr {
	
	private $id;
	private $name;
	private $description;
	
	function __construct($id, $name,$description){
		
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		
	}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
			
}