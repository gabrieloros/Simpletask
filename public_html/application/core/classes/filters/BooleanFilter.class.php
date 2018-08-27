<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

class BooleanFilter extends FilterControl{

	function __construct($fieldName, $label='', $fieldToSearch) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		parent::setFieldToSearch($fieldToSearch);
		
	}
	
	public function drawHtml() {
    		
		$html = '
	    		<table width="100%">
    				<tr>
        	    		<td width="25%">
        	    			' . parent::getLabel () . '
        	    		</td>';

				$htmlClass = "input-boolean-validate";

				$checked = '';
				if(parent::getSelectedValue ())
					$checked = "checked=checked";
		
        	    $html .= '
        	    		<td align="left" width="75%">
        	    			<input type="checkbox" 
        	    				   id="flt_bool_' . parent::getFieldName () . '" 
        	    				   name="flt_bool_' . parent::getFieldName () .'" 
        	    				   ' . $checked . '
        	    				   onchange="
        	    				   			if(parseInt($(\'#filter_\' + \''.parent::getFieldName ().'\').val()) == 1){
        	    				   				$(\'#filter_\' + \''.parent::getFieldName ().'\').val(0);
											}
											else{
												$(\'#filter_\' + \''.parent::getFieldName ().'\').val(1);
											}" 
        	    				   class="'.$htmlClass.'" />
        	    			
							<input type="hidden"
									id="filter_' . parent::getFieldName () . '" 
									name="filter_' . parent::getFieldName () . '"
									value = "'.(int)parent::getSelectedValue ().'"/> 
        	    		</td>
        	    	</tr>
        	    </table>
	    		';
	    
	    return $html;
	
	}
	
	public function getCriteriaQuery(){
	
		$criteriaQuery = '';
		
	    if(parent::getFieldToSearch() != ''){	        
            $fieldToSearch = parent::getFieldToSearch(); 
        }
        else{
            $fieldToSearch = parent::getFieldName();
        }
	    
	    if(parent::getSelectedValue()){
	        $selectedValue = "1";
	    }
	    else{
	        $selectedValue = "0";
	    }
	    
	    $criteriaQuery .= '
        					AND '.$fieldToSearch.' = '.$selectedValue.'
            	        ';
	    
	    return $criteriaQuery;
	}
}