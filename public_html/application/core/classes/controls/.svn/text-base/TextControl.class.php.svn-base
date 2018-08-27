<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/**
 * Control for text values
 * @author gabriel.guzman
 *
 */
class TextControl extends FilterControl {
	
	private $length;
	
	private $isEmail;
	
	function __construct($fieldName, $label='', $length=null, $isMandatory=false, $readonly) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		$this->length = $length;
		
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
        
        if($this->getIsEmail()){
            $inputTypeClass = 'input-mail-validate';
        }
        else{
            $inputTypeClass = 'input-text-validate';
        }
		
		$html = '
				<label class="'.$mandatoryLabelClass.'" for="control_' . parent::getFieldName () . '">
	    			' . parent::getLabel () . '
    	    	</label>
    			<input type="text" 
    				   id="control_' . parent::getFieldName () . '" 
    				   name="control_' . parent::getFieldName () . '" 
    				   value="' . parent::getSelectedValue () . '" 
    				   maxlength="' . $this->getLength () . '" 
    				   ' . $readonly . '
    				   class="text-1 '. $inputTypeClass . ' ' .$mandatoryClass.' ' . $readonlyClass . '" />
	    		';
	    
	    return $html;
	
	}
	
	/**
	 * @return the $length
	 */
	public function getLength() {
		return $this->length;
	}
	
	/**
	 * @param field_type $length
	 */
	public function setLength($length) {
		$this->length = $length;
	}
	
	/**
	 * @return the $isEmail
	 */
	public function getIsEmail() {
		return $this->isEmail;
	}

	/**
	 * @param field_type $isEmail
	 */
	public function setIsEmail($isEmail) {
		$this->isEmail = $isEmail;
	}

}