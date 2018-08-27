<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/NumberFilterType.class.php';

/**
 * Filter control for numeric values
 * @author gabriel.guzman
 *
 */
class NumberFilter extends FilterControl {
	
	/**
	 * Field length
	 * @var int
	 */
	private $length;
	
	/**
	 * Search null value
	 * @var boolean
	 */
	private $searchNull;

	/**
	 * If filter supports decimal values
	 * @var boolean
	 */
	protected $decimal;
	
	function __construct($fieldName, $label = '', $length = null, $fieldToSearch) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		$filterTypes = new NumberFilterType ();
		
		parent::setFilterType ( $filterTypes );
		
		$this->length = $length;
		
		parent::setFieldToSearch ( $fieldToSearch );
		
		$this->decimal = true;
	
	}
	
	public function drawHtml() {
		
		$html = '
	    		<div class="phone">
        	    	' . parent::getLabel () . '
        	    </div>';
		
		$htmlClass = "input-number-validate";
		
		if (! $this->decimal)
			$htmlClass = "input-naturalNumber-validate";
		
		$html .= '
        	    		<div class="inputPhone">
        	    			<input type="text" 
        	    				   id="filter_' . parent::getFieldName () . '" 
        	    				   name="filter_' . parent::getFieldName () . '" 
        	    				   value="' . parent::getSelectedValue () . '" 
        	    				   maxlength="' . $this->getLength () . '" 
        	    				   class="' . $htmlClass . '" />
        	    		</div>
	    		';
		
		return $html;
	
	}
	
	/**
	 * Criteria query for web service
	 * @author gabriel.guzman
	 * @return string
	 */
	public function getCriteriaQuery() {
		
		$criteriaQuery = '';

		if (parent::getFieldToSearch () != '') {
			$fieldToSearch = parent::getFieldToSearch ();
		} else {
			$fieldToSearch = parent::getFieldName ();
		}
				
		if (parent::getSelectedValue () != '') {
			
			/**
			 * @todo: hacer un switch con los tipos de filtros: Fase 2
			 */
			$selectedValue = parent::getSelectedValue ();
			
			if (! $this->decimal)
				$selectedValue = floor ( parent::getSelectedValue () );
			
			$criteriaQuery .= '
		        				AND ' . $fieldToSearch . ' = ' . $selectedValue . '
       						';
		}
		else {
			//Search where the value is null
			if($this->searchNull){
				$criteriaQuery .= '
									AND ' . $fieldToSearch . ' IS NULL
									';
			} 
			else {
				$criteriaQuery .= '
									AND ' . $fieldToSearch . ' IS NOT NULL
									';
			}

		}

		return $criteriaQuery;
	
	}
	
	/**
	 * @return the $length
	 */
	public function getLength() {
		return $this->length;
	}
	
	/**
	 * @param int $length
	 */
	public function setLength($length) {
		$this->length = $length;
	}

	/**
	 * @return the $searchNull
	 */
	public function getSearchNull() {
		return $this->searchNull;
	}
	
	/**
	 * @param boolean $searchNull
	 */
	public function setSearchNull($searchNull) {
		$this->searchNull = $searchNull;
	}

	/**
	 * @return the $decimal
	 */
	public function getDecimal() {
		return $this->decimal;
	}

	/**
	 * @param boolean $decimal
	 */
	public function setDecimal($decimal) {
		$this->decimal = $decimal;
	}

}