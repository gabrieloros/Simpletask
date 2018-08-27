<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

class CheckboxControl extends FilterControl{
	
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
	    
        if(parent::getReadonly()){
            $readonly = 'readonly="readonly"';
            $readonlyClass = 'input-readonly';
        }
        else{
            $readonly = '';
            $readonlyClass = '';
        }
    		
		$html = '
	    		<label class="'.$mandatoryLabelClass.'" for="control_' . parent::getFieldName () . '">
	    			' . parent::getLabel () . '
    	    	</label>';

				$htmlClass = "input-boolean-validate";

				$checked = '';
				if(parent::getSelectedValue ())
					$checked = "checked=checked";
		
        	    $html .= '
        	    		<input type="checkbox" 
							id="label_control_' . parent::getFieldName () . '" 
							name="label_control_' . parent::getFieldName () .'" 
							' . $checked . '
							onchange="
								if(parseInt($(\'#control_\' + \''.parent::getFieldName ().'\').val()) == 1){
									$(\'#control_\' + \''.parent::getFieldName ().'\').val(0);
								}
								else{
									$(\'#control_\' + \''.parent::getFieldName ().'\').val(1);
								}" 
							class="'.$htmlClass.' '.$mandatoryClass.'"
							'.$readonly.'
							 />
        	    			
							<input type="hidden"
								id="control_' . parent::getFieldName () . '" 
								name="control_' . parent::getFieldName () . '"
								value = "'.(int)parent::getSelectedValue ().'"/>
	    		';
	    
	    return $html;
	
	}

}