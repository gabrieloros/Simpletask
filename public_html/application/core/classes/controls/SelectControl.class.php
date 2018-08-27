<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/**
 * Control for select values (combo box)
 * @author gabriel.guzman
 *
 */
class SelectControl extends FilterControl {
    
    /**
     * List of values
     * @var array
     */
    private $values;
   
    /**
     * Is multiple select?
     * @var boolean
     */
    private $isMultiple;
    
    /**
     * Function to execute when select value changes
     * @var string
     */
    private $onchangeFunction;
    
    /**
     * If the 'select an option' value must be shown in the combo box
     * @var boolean
     */
    private $showDefaultEmptyValue;
    
    function __construct($fieldName, $label='', $isMultiple, $onchangeFunction, $readonly = false, $isMandatory = false, $showDefaultEmptyValue) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		$this->isMultiple = $isMultiple;
		
		$this->onchangeFunction = $onchangeFunction;
		
		parent::setReadonly($readonly);
		
		parent::setIsMandatory($isMandatory);
		
		$this->showDefaultEmptyValue = $showDefaultEmptyValue;
	
	}
	
	public function drawHtml() {
	    
	    if(parent::getIsMandatory()){
	        $mandatoryClass = 'mandatory-input';
	        $mandatoryLabelClass = 'mandatory-label';
	    }
	    else{
	        $mandatoryClass = '';
	        $mandatoryLabelClass = '';
	    }
		
		$html = '
				<label class="'.$mandatoryLabelClass.'" for="control_' . parent::getFieldName () . '">
	    			' . parent::getLabel () . '
    	    	</label>';
		        
        if($this->isMultiple){
            $isMultiple = 'multiple="multiple"';
            $controlName = 'control_' . parent::getFieldName () . '[]';
        }
        else{
            $isMultiple = '';
            $controlName = 'control_' . parent::getFieldName ();
        }
        
        if(parent::getReadonly()){
            $readonly = 'readonly="readonly"';
        }
        else{
            $readonly = '';
        }
        	    		
	    $html .= '
    			<select id="control_' . parent::getFieldName () . '" 
    				   name="'.$controlName.'"
    				   onchange="'.$this->onchangeFunction.'" 
    				   class="text-1 '.$mandatoryClass.'" 
    				   '.$isMultiple.'
    				   '.$readonly.' 
    				   >';
	    
	            if($this->isMultiple){
                    $selectedValues = parent::getSelectedValue();
	            }
	            else{
	                
	                if(!parent::getReadonly() && $this->showDefaultEmptyValue && count($this->values) > 0){
	                    $html .= '<option value="">'.$_SESSION['s_message']['select_an_option'].'</option>';
	                }
	                
	                $selectedValues = array(parent::getSelectedValue());
	            }
    
	            foreach ($this->values as $valueId => $value){
	                
	                if(isset($selectedValues) && is_array($selectedValues)){
	                
    	                if(in_array($valueId,$selectedValues)){
    	                    $selected = 'selected="selected"';
    	                }
    	                else{
    	                    $selected = '';
    	                }
	                }
	                else{
                        $selected = '';
                    }
	                
	                $html .= '<option '.$selected.' value="'.$valueId.'">'.$value.'</option>';
	                
	            }        
    
        $html .= '
			   	</select>
    		';
	    
	    return $html;
	    
	}
	
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
	
	public function addValue($id, $value){
	    $this->values[$id] = $value;
	}
	
	/**
	 * @return the $isMultiple
	 */
	public function getIsMultiple() {
		return $this->isMultiple;
	}

	/**
	 * @param boolean $isMultiple
	 */
	public function setIsMultiple($isMultiple) {
		$this->isMultiple = $isMultiple;
	}

	/**
	 * @return the $onchangeFunction
	 */
	public function getOnchangeFunction() {
		return $this->onchangeFunction;
	}

	/**
	 * @param string $onchangeFunction
	 */
	public function setOnchangeFunction($onchangeFunction) {
		$this->onchangeFunction = $onchangeFunction;
	}
	
	/**
	 * @return the $showDefaultEmptyValue
	 */
	public function getShowDefaultEmptyValue() {
		return $this->showDefaultEmptyValue;
	}

	/**
	 * @param boolean $showDefaultEmptyValue
	 */
	public function setShowDefaultEmptyValue($showDefaultEmptyValue) {
		$this->showDefaultEmptyValue = $showDefaultEmptyValue;
	}
	
}