<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/** 
 * @author gabo
 * 
 * 
 */
class TextAreaControl extends FilterControl{
	
	function __construct($fieldName, $label='', $isMandatory=false, $readonly) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		parent::setIsMandatory($isMandatory);
		
		parent::setReadonly($readonly);
	
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
    	    	</label>
    			<textarea 
    				   id="control_' . parent::getFieldName () . '" 
    				   name="control_' . parent::getFieldName () . '" 
    				   ' . $readonly . '
    				   class="text-1 ' .$mandatoryClass.' ' . $readonlyClass . '">'. parent::getSelectedValue () .'</textarea>
	    		';
	    
	    return $html;
	
	}

}