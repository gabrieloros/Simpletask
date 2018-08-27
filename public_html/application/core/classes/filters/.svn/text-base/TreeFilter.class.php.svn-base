<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/** 
 * Generic tree filter. The different html implementations inherits from this class
 * @author gabriel.guzman
 * 
 */
class TreeFilter extends FilterControl{
    
    /**
     * elements list
     * @var array
     */
    private $list;
    
    /**
     * If groups are selectable
     * @var boolean
     */
    private $selectableGroups;
    
    /**
     * Selected value label
     * @var string
     */
    private $selectedLabelValue;
    
    /**
     * If is recursive tree
     * @var boolean
     */
    private $isRecursive;
    
    /**
     * Checked input for recursive option
     * @var boolean
     */
    private $recursiveSelectedValue;
	
	function __construct() {
	    
	}
	
	/**
	 * @return the $list
	 */
	public function getList() {
		return $this->list;
	}

	/**
	 * @param array $list
	 */
	public function setList($list) {
		$this->list = $list;
	}

	/**
	 * @return the $selectableGroups
	 */
	public function getSelectableGroups() {
		return $this->selectableGroups;
	}

	/**
	 * @param boolean $selectableGroups
	 */
	public function setSelectableGroups($selectableGroups) {
		$this->selectableGroups = $selectableGroups;
	}
	
	/**
	 * @return the $selectedLabelValue
	 */
	public function getSelectedLabelValue() {
		return $this->selectedLabelValue;
	}

	/**
	 * @param string $selectedLabelValue
	 */
	public function setSelectedLabelValue($selectedLabelValue) {
		$this->selectedLabelValue = $selectedLabelValue;
	}
	
	/**
	 * @return the $isRecursive
	 */
	public function getIsRecursive() {
		return $this->isRecursive;
	}

	/**
	 * @param boolean $isRecursive
	 */
	public function setIsRecursive($isRecursive) {
		$this->isRecursive = $isRecursive;
	}
	
	/**
	 * @return the $recursiveSelectedValue
	 */
	public function getRecursiveSelectedValue() {
		return $this->recursiveSelectedValue;
	}

	/**
	 * @param boolean $recursiveSelectedValue
	 */
	public function setRecursiveSelectedValue($recursiveSelectedValue) {
		$this->recursiveSelectedValue = $recursiveSelectedValue;
	}
	
}