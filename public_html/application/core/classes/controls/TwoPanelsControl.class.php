<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/** 
 * @author gabo
 * 
 * 
 */
class TwoPanelsControl extends FilterControl{
	
    /**
     * List of values
     * @var array
     */
    private $values;
    
    function __construct($fieldName, $label='', $readonly = false, $isMandatory = false) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		parent::setReadonly($readonly);
		
		parent::setIsMandatory($isMandatory);
	
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
		        
		if(parent::getReadonly()){
            $readonly = 'readonly="readonly"';
        }
        else{
            $readonly = '';
        }
        
        $selectedValues = parent::getSelectedValue();
        	    		
	    $html .= '
	    		<select id="unselected_control_' . parent::getFieldName () . '"
    				name="unselected_control_' . parent::getFieldName () . '[]"
    				class="text-1-multiple"
    				multiple="multiple"
    				'.$readonly.'
	    			>
	    		';
	    
	    		if(is_array($this->values)){
	    
	    			foreach ($this->values as $valueId => $value){
	    				
	    				if(!in_array($valueId, $selectedValues)){
	    				
	    					$html .= '<option value="'.$valueId.'">'.$value.'</option>';
	    				
	    				}
	    			}
	    		}
	    
	    $html .= '
	    		</select>
	    		
				<div style="float: left;">
                	<input id="leftMultipleSelectButton" style="display: block; margin: 0px 2px;" type="button" value=" &gt;&gt; " onclick="selectLeftElements(\'unselected_control_' . parent::getFieldName () . '\',\'control_' . parent::getFieldName () . '\');" />
                	<input id="rightMultipleSelectButton" style="margin: 0px 2px;" type="button" value=" &lt;&lt; " onclick="unselectLeftElements(\'unselected_control_' . parent::getFieldName () . '\',\'control_' . parent::getFieldName () . '\');" />
            	</div>
	    
    			<select id="control_' . parent::getFieldName () . '" 
    				   name="control_' . parent::getFieldName () . '[]"
    				   class="text-1-multiple '.$mandatoryClass.'" 
    				   multiple="multiple"
    				   ' . $readonly . '
    				   >';
	    
	    		if(isset($selectedValues) && is_array($selectedValues)){
	    
	    			if(is_array($this->values)){
	            
		            	foreach ($this->values as $valueId => $value){
		                
	    	                if(in_array($valueId,$selectedValues)){
								
	    	                	$selected = 'selected="selected"';
	    	                	
	    	                	$html .= '<option '.$selected.' value="'.$valueId.'">'.$value.'</option>';
	    	                	
	    	                }
		                }
		            }
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
		
		$this->values [$id] = $value;
		
	}

}