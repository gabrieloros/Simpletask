<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/TreeFilter.class.php';

/**
 * Control for tree 
 * @author gabriel.guzman
 * 
 */
class SelectionTreeControl extends TreeFilter {
    
    private $popupTree;
    
    function __construct($fieldName, $label='', $list, $readonly, $isMandatory = false, $popupTree = false) {
	    
	    parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		parent::setList($list);
		
		parent::setReadonly($readonly);
		
		parent::setIsMandatory($isMandatory);
		
		$this->popupTree = $popupTree;
	
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
	    
	    if($this->getPopupTree()){
	        $containerStyle = 'left: 178px;';
	        $parentContainerStyle = '';
	    }
	    else{
	        $containerStyle = 'left: 149px;';
	        $parentContainerStyle = 'position: relative';
	    }
	    
	    $html = '
	    		<label class="'.$mandatoryLabelClass.'" for="label_control_'.parent::getFieldName().'">
	    			' . parent::getLabel () . '
	    		</label>
	    		';
	    
	    $html .= '
	    		<div style="'.$parentContainerStyle.'">
        	    		
    	    		<div>
    	    			<input type="text"
    	    				   class="text-1 '.$mandatoryClass.'"
    	    				   readonly="readonly" 
    	    				   name="label_control_' . parent::getFieldName () . '" 
    	    				   id="label_control_' . parent::getFieldName () . '" 
    	    				   value="' . parent::getSelectedLabelValue() . '" />
    				   <input type="hidden" 
            				   id="control_' . parent::getFieldName () . '" 
            				   name="control_' . parent::getFieldName () . '" 
            				   value="' . parent::getSelectedValue () . '" 
            				   class="input-number-validate '.$mandatoryClass.'"
            				   maxlength="100" />
    				   ';
	    
	    if(!parent::getReadonly()){
	    
	    $html .= '
    				   <span style="float: left; margin-right: 2px; id="displayLoadingImage_'.parent::getFieldName().'"></span>
    				   
    					<div style="float: left; margin-right: 2px; margin-left: 2px;"
							class="search_icon" 
							id="loadTreeButton_' . parent::getFieldName () . '" 
							onclick="showTree(\'tree_' . parent::getFieldName () . '\', false, \'displayLoadingImage_' . parent::getFieldName () . '\');">
						</div>
    				   
    				   <div style="float: left; margin-right: 2px; margin-left: 1px;" class="cancel_icon"
							onclick="clearSelectionInput(\'label_control_'.parent::getFieldName().'\',\'control_'.parent::getFieldName().'\');">
						</div>
    				  ';
    
        $html .= '
    				</div>
        			<div style="'.$containerStyle.'" class="treeContainer treeContainerServiceControl" id="tree_'.parent::getFieldName().'">
        				';
    
                        $list = parent::getList();
                        
                        $html .= '
                        		<div style="text-align: left; font-size: 12px;">
                        			'.$this->drawTree($list).
                        		'</div>';
        
	    }
        
        $html .= '
    				</div>
    			
    			</div>
    			
    		';
	    
       	return $html;
	    
	}
	
	protected function drawTree($array, $parent = null){
		
		$has_children = false;
		
		$html = '';
			
		foreach ( $array as $value ) {
			
			if ($value->getParentId() == $parent) {
				
				if ($has_children === false) {

					$has_children = true;
					
					$html .= '<ul class="">';
					
				}
				
						$html .= '<li id="element_'.$value->getId().'">';
						
							$html .= '<a href="javascript:updateInputFromTree(\''.$value->getName().'\','.$value->getId().',\'label_control_'.parent::getFieldName().'\',\'control_'.parent::getFieldName().'\',true,\'tree_' . parent::getFieldName () . '\');">';
									
								$html .= $value->getName();
						
							$html .= '</a>';
				
							$html .= $this->drawTree ( $array, $value->getId() );
				
						$html .= '</li>';
			
			}
		
		}
		
		if ($has_children === true)
			$html .= '</ul>';
			
			
		return $html;
		
	}
	
	/**
	 * @return the $popupTree
	 */
	public function getPopupTree() {
		return $this->popupTree;
	}

	/**
	 * @param field_type $popupTree
	 */
	public function setPopupTree($popupTree) {
		$this->popupTree = $popupTree;
	}
		
}