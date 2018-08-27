<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/**
 * filter control for dates range inputs
 * @author gabriel.guzman
 *
 */
class DateRangeFilter extends FilterControl{
    
    /**
     * Left input value
     * @var string (date formatted)
     */
    private $leftValue;
    
    /**
     * Right input value
     * @var string (date formatted)
     */
    private $rightValue;
	
    
    private $showTypeDateControl;
	function __construct($fieldName, $label='', $fieldToSearch='', $showTypeDateControl=false){
	    
	    parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		parent::setFieldToSearch($fieldToSearch);
	
		$this->showTypeDateControl = $showTypeDateControl;
	}
		
    public function drawHtml() {
		

    	if($this->showTypeDateControl){
    		$typeDateSelected = $_SESSION['type_date'];    		
    		$entryDateSelected = ($typeDateSelected=='entry_date')?'selected="selected"':' ';    		
    		$closeDateSelected = ($typeDateSelected=='close_date')?'selected="selected"':' ';    		
    		$html='<select class="btn btn-default dropdown-toggle" id="type_date" name="type_date">';
        	$html.='<option '.$entryDateSelected.' value="entry_date">Fecha entrada</option>';
        	$html.=	'<option '.$closeDateSelected.' value="close_date">Fecha cierre</option>';
        	$html.= '</select>';
    		
    	}else{
    		$html = '
				<div class="textEntryDate">
        	    	' . parent::getLabel () . '
        	    </div>';    		
    	}
    	   	    	
        	    $html .= '
        	    		<div class="date-range-container">
   
            	    		<input type="text"
            	    			   id="filter_date_left_' . parent::getFieldName () . '" 
            	    			   name="filter_date_left_' . parent::getFieldName () . '" 
            	    			   value="' . $this->leftValue . '" 
            	    			   class="input-date-range-validate datepicker"
            	    			   readonly="readonly" />
    	    				   
    	    			    <input type="text"
            	    			   id="filter_date_right_' . parent::getFieldName () . '" 
            	    			   name="filter_date_right_' . parent::getFieldName () . '" 
            	    			   value="' . $this->rightValue . '" 
            	    			   class="input-date-range-validate datepicker"
            	    			   readonly="readonly" />
	    				</div>
	    				
	    			
	    				   
	    				   <script type="text/javascript">
	    				   
	    				
		
		
	
                    				
                    			$(document).ready(function(){
                    
                    				/*
                    				$(\'#filter_date_left_' . parent::getFieldName () . '\').datepicker({
                    					showOn: \'button\',
                    					buttonImageOnly: true,
                    					buttonImage: \'/core/img/calendar.gif\',
                    					dateFormat: \''.Util::getLiteral("date_format_js").'\',
                    					defaultDate: \''.$this->leftValue.'\'
                    				});
                    				
                    				$(\'#filter_date_right_' . parent::getFieldName () . '\').datepicker({
                    					showOn: \'button\',
                    					buttonImageOnly: true,
                    					buttonImage: \'/core/img/calendar.gif\',
                    					dateFormat: \''.Util::getLiteral("date_format_js").'\',
                    					defaultDate: \''.$this->rightValue.'\'
                    				});
                    				*/
                    				
                    				$.datepicker.regional[\'es\'] = {
								closeText: \'Cerrar\',
								prevText: \'< Ant\',
								nextText: \'Sig >\',
								currentText: \'Hoy\',
								monthNames: [\'Enero\', \'Febrero\', \'Marzo\', \'Abril\', \'Mayo\', \'Junio\', \'Julio\', \'Agosto\', \'Septiembre\', \'Octubre\', \'Noviembre\', \'Diciembre\'],
								monthNamesShort: [\'Ene\',\'Feb\',\'Mar\',\'Abr\', \'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\', \'Oct\',\'Nov\',\'Dic\'],
								dayNames: [\'Domingo\', \'Lunes\', \'Martes\', \'Miércoles\', \'Jueves\', \'Viernes\', \'Sábado\'],
								dayNamesShort: [\'Dom\',\'Lun\',\'Mar\',\'Mié\',\'Juv\',\'Vie\',\'Sáb\'],
								dayNamesMin: [\'Do\',\'Lu\',\'Ma\',\'Mi\',\'Ju\',\'Vi\',\'Sá\'],
								weekHeader: \'Sm\',
								dateFormat: \'dd/mm/yy\',
								firstDay: 1,
								isRTL: false,
								showMonthAfterYear: false,
								yearSuffix: \'\'
								};
								
                    				
                    				var dates = $( \'#filter_date_left_'.parent::getFieldName().', #filter_date_right_'.parent::getFieldName().'\' ).datepicker({
                    					
                    					defaultDate: "+0d",
                    					dateFormat: \''.Util::getLiteral("date_format_js").'\',
                    					showOn: \'button\',
                    					buttonImageOnly: true,
                    					buttonImage: \'/core/img/calendar.gif\',
                    					maxDate: null,
                            			onSelect: function( selectedDate ) {
                            				var option = this.id == "filter_date_left_'.parent::getFieldName().'" ? "minDate" : "maxDate",
                            					instance = $( this ).data( "datepicker" ),
                            					date = $.datepicker.parseDate(
                            						instance.settings.dateFormat ||
                            						$.datepicker._defaults.dateFormat,
                            						selectedDate, instance.settings );
                            				dates.not( this ).datepicker( "option", option, date );
                            				
                            				otherDate = dates.not( this ).datepicker( "getDate" );
                            				
                            				if(otherDate == \'\' || otherDate == null){
                            					otherDate = dates.not( this ).datepicker( "setDate", date );
                            				}
                            				$.datepicker.setDefaults($.datepicker.regional[\'es\'])
                            			} 
                            			
                            		});
                            		
                            		//Default Values
                            		$(\'#filter_date_left_' . parent::getFieldName () . '\').datepicker("setDate", \''.$this->leftValue.'\');
                            		
                            		$(\'#filter_date_right_' . parent::getFieldName () . '\').datepicker("setDate", \''.$this->rightValue.'\');
                            		
                            		';
        	    
        	                        //Range validations
            	                    if($this->leftValue != ''){
            	                        $html .= '	$(\'#filter_date_right_' . parent::getFieldName () . '\').datepicker("option", "minDate", \''.$this->leftValue.'\');';        	                        
            	                    }
        	                    
            	                    if($this->rightValue != ''){
            	                        $html .= '$(\'#filter_date_left_' . parent::getFieldName () . '\').datepicker("option", "maxDate", \''.$this->rightValue.'\');';
            	                    }
                                    else{
                                        $html .= '$(\'#filter_date_left_' . parent::getFieldName () . '\').datepicker();';
                                    }
                            		
                            		$html .= '
                    				
                    			});
                    		</script>
	    				   
        	    		</td>
    	    		</tr>
	    		</table>
	    		';
	    
	    return $html;
	
	}
	
	public function getCriteriaQuery(){
	    
	    $criteriaQuery = '';
	    
	    if($this->leftValue != '' && $this->rightValue != ''){
	        
            $leftValue = str_replace('/', '-', $this->leftValue);
	        $rightValue =  str_replace('/', '-', $this->rightValue);
	        
			if (parent::getFieldToSearch () != '') {
				$fieldToSearch = parent::getFieldToSearch ();
			} else {
				$fieldToSearch = parent::getFieldName ();
			}
	        
	        $criteriaQuery .= '
	        					AND ( ' . $fieldToSearch . ' between \'' . $leftValue . '\' and \'' . $rightValue . '\' )
        					';
	        
	    }
	    
	    return $criteriaQuery;
	    
	}
	
	/**
	 * @return the $leftValue
	 */
	public function getLeftValue() {
		return $this->leftValue;
	}

	/**
	 * @param string $leftValue
	 */
	public function setLeftValue($leftValue) {
		$this->leftValue = $leftValue;
	}

	/**
	 * @return the $rightValue
	 */
	public function getRightValue() {
		return $this->rightValue;
	}

	/**
	 * @param string $rightValue
	 */
	public function setRightValue($rightValue) {
		$this->rightValue = $rightValue;
	}

}

?>