<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/TextFilterType.class.php';

/**
 * Filter control for text values
 * @author gabriel.guzman
 *
 */
class TextFilter extends FilterControl {
	
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
	 * Search only null values
	 * @var boolean
	 */
	private $searchOnlyNull;
	
	
	function __construct($fieldName, $label = '', $length = null, $fieldToSearch = '') {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		$filterTypes = new TextFilterType ();
		
		parent::setFilterType ( $filterTypes );
		
		$this->length = $length;
		
		parent::setFieldToSearch ( $fieldToSearch );
	
	}
	
	public function drawHtml() {
		
		$html = '
				<div class="id">	
        	    	' . parent::getLabel () . '
        	    </div>';
		$html .= '
        	    <div class="idInput">
        	    	<input type="text" 
        	    		   id="filter_' . parent::getFieldName () . '" 
        	    		   name="filter_' . parent::getFieldName () . '" 
        	    		   value="' . parent::getSelectedValue () . '" 
        	    		   maxlength="' . $this->getLength () . '" 
        	    		   class="input-text-validate form_control"/>
	    		</div>
	    		';
		
		return $html;
	
	}
	
	/**
	 * Criteria query for Web service
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
			
			$textToSearch = parent::getSelectedValue();
			
			switch ($_SESSION ['s_dbConnectionType']) {
				case Util::DB_MYSQL :
					break;
				case Util::DB_ORACLE :
					break;
				case Util::DB_SQLSERVER :
					break;
				case Util::DB_POSTGRESQL :
					
					$textToSearch = str_replace('\'', '\'\'', $textToSearch);
					$textToSearch = str_replace('"', '""', $textToSearch);
					
					$criteriaQuery .= '
	        				AND ( lower(' . $fieldToSearch . ') LIKE \'%' . strtolower($textToSearch) . '%\')
					        ';
					break;
				default:
					$criteriaQuery .= '
	        				AND ( ' . $fieldToSearch . ' LIKE \'%' . $textToSearch . '%\')
					        ';
					break;
			}
		
		} 
		else{
			//Search where the value is null
			if($this->searchNull){
				
				$criteriaQuery .= '
									AND ( ' . $fieldToSearch . ' IS NULL OR ' . $fieldToSearch . ' = \'\')
									';
				
			} 

		}
		
		return $criteriaQuery;
	
	}

	/**
	 * Criteria query for Web service
	 * @author gabriel.guzman
	 * @return string
	 */
	public function getCriteriaQueryExact() {
		
		$criteriaQuery = '';
		
		if (parent::getFieldToSearch () != '') {
			$fieldToSearch = parent::getFieldToSearch ();
		} else {
			$fieldToSearch = parent::getFieldName ();
		}
		
		if (parent::getSelectedValue () != '') {
			
			$textToSearch = parent::getSelectedValue();
			
			switch ($_SESSION ['s_dbConnectionType']) {
				case Util::DB_MYSQL :
					break;
				case Util::DB_ORACLE :
					break;
				case Util::DB_SQLSERVER :
					break;
				case Util::DB_POSTGRESQL :
					
					$textToSearch = str_replace('\'', '\'\'', $textToSearch);
					$textToSearch = str_replace('"', '""', $textToSearch);
					
					$criteriaQuery .= '
	        				AND ( lower(' . $fieldToSearch . ') LIKE \'' . strtolower($textToSearch) . '\')
					        ';
					break;
				default:
					$criteriaQuery .= '
	        				AND ( ' . $fieldToSearch . ' LIKE \'' . $textToSearch . '\')
					        ';
					break;
			}
		
		} 
		else{
			//Search where the value is null
			if($this->searchNull){
				
				$criteriaQuery .= '
									AND ( ' . $fieldToSearch . ' IS NULL OR ' . $fieldToSearch . ' = \'\')
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
	 * Gets the searchOnlyNull state.
	 *
	 * @return the $searchOnlyNull
	 */
	public function getSearchOnlyNull() {
		return $this->searchOnlyNull;
	}
	
	/**
	 * Search only null values, doesn't look for empty strings like searchNull().
	 *
	 * @param boolean $searchOnlyNull
	 */
	public function setSearchOnlyNull($searchOnlyNull) {
		$this->searchOnlyNull = $searchOnlyNull;
	}
}
