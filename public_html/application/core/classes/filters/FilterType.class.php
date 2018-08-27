<?php
/**
 * Abstract class to create the different filter types (i.e: contains, equals, etc.), according to the filter control.
 * @author gabriel.guzman
 *
 */
abstract class FilterType {
	
	/**
	 * Values of the filter
	 * @var array
	 */
	private $values;
	
	/**
	 * @return the $values
	 */
	public function getValues() {
		return $this->values;
	}
	
	/**
	 * @param array $values
	 */
	public function setValues($values) {
		$this->values = $values;
	}
	
	public function addValue($id, $value) {
		
		$this->values [$id] = $value;
	
	}
	
	public function getValue($id) {
		
		return $this->values [$id];
	
	}

}