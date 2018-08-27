<?php
/**
 * Generic filter control entity. All the filters inherits from this class
 * @author gabriel.guzman
 *
 */
abstract class FilterControl {
	
	/**
	 * Field name
	 * @var string
	 */
	private $fieldName;
	
	/**
	 * Field label
	 * @var string
	 */
	private $label;
	
	/**
	 * Selected filter type value
	 * @var string
	 */
	private $selectedType;
	
	/**
	 * Selected value
	 * @var multitype (string, array, int)
	 */
	private $selectedValue;
	
	/**
	 * List of filter types
	 * @var FilterType
	 */
	private $filterType;
	
	/**
	 * Field name used to search in the criteria
	 * @var string
	 */
	private $fieldToSearch;
	
	/**
	 * If control is mandatory
	 * @var boolean
	 */
	private $isMandatory;
	
	/**
	 * If is only readable
	 * @var boolean
	 */
	private $readonly;
	
	public function draw() {
		
		$this->html = $this->drawHtml ();
		
		return $this->html;
	
	}
	
	protected function drawHtml() {
	
	}
	
	/**
	 * @return the $fieldName
	 */
	public function getFieldName() {
		return $this->fieldName;
	}

	/**
	 * @param string $fieldName
	 */
	public function setFieldName($fieldName) {
		$this->fieldName = $fieldName;
	}

	/**
	 * @return the $label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param string $label
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * @return the $selectedType
	 */
	public function getSelectedType() {
		return $this->selectedType;
	}

	/**
	 * @param string $selectedType
	 */
	public function setSelectedType($selectedType) {
		$this->selectedType = $selectedType;
	}

	/**
	 * @return the $selectedValue
	 */
	public function getSelectedValue() {
		return $this->selectedValue;
	}

	/**
	 * @param multitype $selectedValue
	 */
	public function setSelectedValue($selectedValue) {
		$this->selectedValue = $selectedValue;
	}
	
	/**
	 * @return the $filterType
	 */
	public function getFilterType() {
		return $this->filterType;
	}

	/**
	 * @param FilterType $filterType
	 */
	public function setFilterType($filterType) {
		$this->filterType = $filterType;
	}
	
	/**
	 * @return the $fieldToSearch
	 */
	public function getFieldToSearch() {
		return $this->fieldToSearch;
	}

	/**
	 * @param string $fieldToSearch
	 */
	public function setFieldToSearch($fieldToSearch) {
		$this->fieldToSearch = $fieldToSearch;
	}
	
	/**
	 * @return the $isMandatory
	 */
	public function getIsMandatory() {
		return $this->isMandatory;
	}

	/**
	 * @param boolean $isMandatory
	 */
	public function setIsMandatory($isMandatory) {
		$this->isMandatory = $isMandatory;
	}
	
	/**
	 * @return the $readonly
	 */
	public function getReadonly() {
		return $this->readonly;
	}

	/**
	 * @param boolean $readonly
	 */
	public function setReadonly($readonly) {
		$this->readonly = $readonly;
	}
	
}