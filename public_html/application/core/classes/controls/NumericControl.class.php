<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/** 
 * @author gabo
 * 
 * 
 */
class NumericControl extends FilterControl {
	
	/**
	 * Field length
	 * @var int
	 */
	private $length;
	
	/**
	 * If filter supports decimal values
	 * @var boolean
	 */
	protected $decimal;
	
	function __construct($fieldName, $label = '', $length = null, $decimal = true, $isMandatory = false, $readonly) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		$this->length = $length;
		
		$this->decimal = $decimal;
		
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
        
		$htmlClass = "input-number-validate";
		
//		if (! $this->decimal)
//			$htmlClass = "input-naturalNumber-validate";
		
		$html = '<label class="'.$mandatoryLabelClass.'" for="control_' . parent::getFieldName () . '">
	    			' . parent::getLabel () . '
    	    	</label>
    	    	<input type="text" 
					id="control_' . parent::getFieldName () . '" 
					name="control_' . parent::getFieldName () . '" 
					value="' . parent::getSelectedValue () . '" 
					maxlength="' . $this->getLength () . '" 
					class="text-1 ' . $htmlClass . ' ' . $mandatoryClass . '" />
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