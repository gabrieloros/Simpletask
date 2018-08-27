<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Render.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/**
 * Selection popup Filter Control. It draws an input and a icon to select the according values
 * @author gabriel.guzman
 *
 */
class SelectionPopupFilterGeneric extends FilterControl {
    
    /**
     * Selected visible input value
     * @var string
     */
    private $selectedLabelValue;
    
    /**
     * Javascript function which will launch popup
     * @var string
     */
    private $submitFunction;
    
    /**
     * Order field for specific javascript launch function
     * @var string
     */
    private $orderField;
    
    /**
     * Order type for specific javascript launch function
     * @var string
     */
    private $orderType;
    
    /**
     * Module in which the popup is called
     * @var string
     */
    private $module;
    
    /**
     * Module where the filter's xml is
     * @var string
     */
    private $moduleForXml;
    
    /**
     * Action manager for specific javascript launch function 
     * @var string
     */
    private $actionManager;
    
    /**
     * Concept that will be loaded in the popup
     * @var string
     */
    private $concept;
    
    /**
     * Dependencies: must be separated by a semicolon (;)
     * @var string
     */
    private $fieldsToCheck;
    
    /**
     * Additional fields to send in the javascript function (which doesn't have to be validated)
     * @var string
     */
    private $additionalFields;
    
    /**
     * Specific fields to send in the javascript function (which doesn't have to be validated)
     * @var array
     */
    private $specificData;
    
    function __construct($fieldName, $label, $fieldToSearch) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		parent::setFieldToSearch($fieldToSearch);
	
	}
	
	public function drawHtml() {
		
		$html = '
				<table width="100%">
    				<tr>
        	    		<td width="25%" style="vertical-align: top;">
        	    			' . parent::getLabel () . '
        	    		</td>
        	    	';
		
		        if($this->submitFunction != ''){
		            $submitFunction = $this->submitFunction;
		        }
		        else{
		            $submitFunction = 'loadGenericPopup(
		            									1, 
		            									\''.$this->orderField.'\',
		            									\''.$this->orderType.'\',
		            									\'filter_' . parent::getFieldName () . '\',
		            									\'label_filter_' . parent::getFieldName () . '\',
		            									\''.$this->module.'\', 
		            									\''.$this->moduleForXml.'\', 
		            									\''.$this->actionManager.'\', 
		            									\''.$this->concept.'\', 
		            									\''.$this->fieldsToCheck.'\', 
		            									\'true\',
		            									\''.$this->additionalFields.'\'
		            								);
		            					';
		            
		        }
        	    			
        	    $html .= '
        	    		<td align="left" width="75%" style="vertical-align: top;">';
        	    
        	    if(isset($this->specificData) && is_array($this->specificData)){
        	        
        	        $html .= '
        	        		<div id="specificDataContainer_'.parent::getFieldName().'">
        	        ';
        	        
        	        foreach ($this->specificData as $specificField){
        	            
        	            //inputValue attr used because value attribute is cleaned when the filter's 'clean' button is clicked
        	            $html .= '
        	            		<input type="hidden" name="'.$specificField['name'].'" inputValue="'.$specificField['value'].'" />
        	            		';
        	            
        	        }
        	        
        	        $html .= '
        	        		</div>
        	        ';
        	        
        	    }
        	    		
	    		$html .= '
        	    			<input type="text"
        	    				   style="float: left; margin-right: 2px;" 
        	    				   id="label_filter_' . parent::getFieldName () . '" 
        	    				   name="label_filter_' . parent::getFieldName () . '" 
        	    				   value="' . $this->selectedLabelValue . '" 
        	    				   class="selection_popup_filter_input"
        	    				   readonly="readonly" />
        	    				   
	    				  	<input type="hidden"
	    				  			id="filter_' . parent::getFieldName() . '"
	    				  			name="filter_' . parent::getFieldName() . '"
	    				  			value="' . parent::getSelectedValue () . '"
	    				  			class="input-number-validate"
	    				  			maxlength="100"
	    				  			/>
	    				  	<span style="float: left; margin-right: 2px;" id="displayLoadingImage_'.parent::getFieldName().'"></span>
	    				  	
	    				  	<div style="float: left; margin-right: 2px;"
                    	    	class="search_icon" 
            					id="loadSelectionListButton_'.parent::getFieldName().'" 
            					onclick="'.$submitFunction.'">
            				</div>
            				
            				<div style="float: left; margin-right: 2px;" class="cancel_icon"
            					onclick="clearSelectionInput(\'label_filter_'.parent::getFieldName().'\',\'filter_'.parent::getFieldName().'\');">
            				</div>
				  			
        	    		</td>
    	    		</tr>
	    		</table>
	    		';
	    
	    return $html;
	
	}
	
	/**
	 * Criteria query for Web Service
	 * @author gabriel.guzman
	 * @return string
	 */
	public function getCriteriaQuery(){
	    
	    $criteriaQuery = '';
	    
	    if(parent::getSelectedValue() != ''){
	        
	        /**
	         * @todo: hacer un switch con los tipos de filtros: Fase 2
	         */
    	        
	        $criteriaQuery .= '
	        				AND '.parent::getFieldToSearch().' = '.parent::getSelectedValue().'
                	        ';
        }
	    
	    return $criteriaQuery;
	    
	}
	
	/**
	 * @return the $selectedLabelValue
	 */
	public function getSelectedLabelValue() {
		return $this->selectedLabelValue;
	}

	/**
	 * @param string $selectedLabelValue
	 */
	public function setSelectedLabelValue($selectedLabelValue) {
		$this->selectedLabelValue = $selectedLabelValue;
	}

	/**
	 * @return the $submitFunction
	 */
	public function getSubmitFunction() {
		return $this->submitFunction;
	}

	/**
	 * @param string $submitFunction
	 */
	public function setSubmitFunction($submitFunction) {
		$this->submitFunction = $submitFunction;
	}

	/**
	 * @return the $orderField
	 */
	public function getOrderField() {
		return $this->orderField;
	}

	/**
	 * @param string $orderField
	 */
	public function setOrderField($orderField) {
		$this->orderField = $orderField;
	}

	/**
	 * @return the $orderType
	 */
	public function getOrderType() {
		return $this->orderType;
	}

	/**
	 * @param string $orderType
	 */
	public function setOrderType($orderType) {
		$this->orderType = $orderType;
	}

	/**
	 * @return the $module
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 * @param string $module
	 */
	public function setModule($module) {
		$this->module = $module;
	}

	/**
	 * @return the $moduleForXml
	 */
	public function getModuleForXml() {
		return $this->moduleForXml;
	}

	/**
	 * @param string $moduleForXml
	 */
	public function setModuleForXml($moduleForXml) {
		$this->moduleForXml = $moduleForXml;
	}

	/**
	 * @return the $actionManager
	 */
	public function getActionManager() {
		return $this->actionManager;
	}

	/**
	 * @param string $actionManager
	 */
	public function setActionManager($actionManager) {
		$this->actionManager = $actionManager;
	}

	/**
	 * @return the $concept
	 */
	public function getConcept() {
		return $this->concept;
	}

	/**
	 * @param string $concept
	 */
	public function setConcept($concept) {
		$this->concept = $concept;
	}

	/**
	 * @return the $fieldsToCheck
	 */
	public function getFieldsToCheck() {
		return $this->fieldsToCheck;
	}

	/**
	 * @param string $fieldsToCheck
	 */
	public function setFieldsToCheck($fieldsToCheck) {
		$this->fieldsToCheck = $fieldsToCheck;
	}
	
	/**
	 * @return the $additionalFields
	 */
	public function getAdditionalFields() {
		return $this->additionalFields;
	}

	/**
	 * @param string $additionalFields
	 */
	public function setAdditionalFields($additionalFields) {
		$this->additionalFields = $additionalFields;
	}
	
	/**
	 * @return the $specificData
	 */
	public function getSpecificData() {
		return $this->specificData;
	}

	/**
	 * @param array $specificData
	 */
	public function setSpecificData($specificData) {
		$this->specificData = $specificData;
	}

}