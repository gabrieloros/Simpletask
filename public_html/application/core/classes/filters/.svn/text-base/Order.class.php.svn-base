<?php

/** 
 * @author Gabriel Guzman
 * Used to define the order in queryes
 * 
 */
class Order {
	
	/**
	 * Order field
	 * @var string
	 */
	private $field;
	
	/**
	 * Order type (ASC - DESC)
	 * @var string
	 */
	private $type;
	
	/**
     * Flag to define if there's more orders
     * @var boolean
     */
    private $uniqueOrder;
	
	function __construct($field, $type, $uniqueOrder) {
		
		$this->field = $field;
		
		$this->type = $type;
		
		$this->uniqueOrder = $uniqueOrder;
	
	}
	
	public function drawSql(){
		
		$sql = '';
		
		if($this->uniqueOrder){
			$sql .= ' ORDER BY ' .$this->field . ' ' . $this->type;
		}
		else{
			$sql .= ' ,' .$this->field . ' ' . $this->type;
		}
		
		return $sql;
		
	}
	
	/**
	 * @return the $field
	 */
	public function getField() {
		return $this->field;
	}

	/**
	 * @param string $field
	 */
	public function setField($field) {
		$this->field = $field;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
	}
	
	/**
	 * @return the $uniqueOrder
	 */
	public function getUniqueOrder() {
		return $this->uniqueOrder;
	}

	/**
	 * @param boolean $uniqueOrder
	 */
	public function setUniqueOrder($uniqueOrder) {
		$this->uniqueOrder = $uniqueOrder;
	}

}