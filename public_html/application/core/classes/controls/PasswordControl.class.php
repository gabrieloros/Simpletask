<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/**
 * Control for text values
 * @author gabriel.guzman
 *
 */
class PasswordControl extends FilterControl {
	
	private $length;
	
	private $mustValidate;
	
	function __construct($fieldName, $length=null, $isMandatory=false, $readonly) {
		
		parent::setFieldName ( $fieldName );
		
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
        }
        else{
            $readonly = '';
        }
        
        if($this->getMustValidate()){
        	$validateAttribute = 'validate="1"';
        }
        else{
        	$validateAttribute = 'validate="0"';
        }
		
		$html = '
				<label class="'.$mandatoryLabelClass.'" for="control_' . parent::getFieldName () . '">
	    			' . $_SESSION['s_message']['password'] . '
    	    	</label>
    			<input type="password" 
    				   id="control_' . parent::getFieldName () . '" 
    				   name="control_' . parent::getFieldName () . '" 
    				   maxlength="' . $this->getLength () . '" 
    				   ' . $readonly . '
    				   ' . $validateAttribute . '
    				   class="text-1 input-password-validate input-text-validate '.$mandatoryClass.'" />
    				   
    			<div style="margin-bottom: 16px;" class="clear"></div>
    				   
			   	<label class="'.$mandatoryLabelClass.'" for="control_' . parent::getFieldName () . '_2">
	    			' . $_SESSION['s_message']['repeat_password'] . '
    	    	</label>
    			<input type="password" 
    				   id="control_' . parent::getFieldName () . '_2" 
    				   name="control_' . parent::getFieldName () . '_2" 
    				   maxlength="' . $this->getLength () . '"
    				   ' . $readonly . '
    				   ' . $validateAttribute . '
    				   class="text-1 input-password-validate input-text-validate '.$mandatoryClass.'" />
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
	 * @param int $length
	 */
	public function setLength($length) {
		$this->length = $length;
	}

	/**
	 * @return the $mustValidate
	 */
	public function getMustValidate() {
		return $this->mustValidate;
	}

	/**
	 * @param boolean $mustValidate
	 */
	public function setMustValidate($mustValidate) {
		$this->mustValidate = $mustValidate;
	}

}