<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/** 
 * @author gabo
 * 
 * 
 */
class DateControl extends FilterControl{
	
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
    			<input type="text" 
    				   id="control_' . parent::getFieldName () . '" 
    				   name="control_' . parent::getFieldName () . '" 
    				   value="' . parent::getSelectedValue () . '" 
    				   ' . $readonly . '
    				   class="text-1 ' .$mandatoryClass.' ' . $readonlyClass . '" />
			';
		
		if(!parent::getReadonly()){
		
			$html .= '
					 <style type="text/css">
					 
						 .ui-datepicker-trigger{
						 	float: left;
						 	margin-left: 2px;
						 }
					 
					 </style>
	    			 <script type="text/javascript">
						$(document).ready(function(){
	                    
							$(\'#control_' . parent::getFieldName () . '\').datepicker({
								showOn: \'button\',
								buttonImageOnly: true,
								buttonImage: \'/core/img/calendar.gif\',
								dateFormat: \''.$_SESSION["s_message"]["date_format_js"].'\',
								defaultDate: \''.parent::getSelectedValue().'\',
								/*showButtonPanel: true,*/
								changeMonth: true,
								changeYear: true,
								yearRange: \'c-99:c+0\',
								buttonText: s_message[\'date\']
							});
						});
					</script>
	    				   
		    		';
		}
		
	    return $html;
	
	}
	
}