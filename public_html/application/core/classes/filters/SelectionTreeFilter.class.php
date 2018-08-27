<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/TreeFilter.class.php';

/** 
 * @author gabriel.guzman
 * 
 * 
 */
class SelectionTreeFilter extends TreeFilter {

	private $actionManagerAction;
	
	function __construct($fieldName, $label = '', $fieldToSearch = '', $list, $selectableGroups, $actionManagerAction) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		parent::setFieldToSearch ( $fieldToSearch );
		
		parent::setList ( $list );
		
		parent::setSelectableGroups ( $selectableGroups );
		
		$this->setActionManagerAction ( $actionManagerAction );
	}
	
	/**
	 * @return the $actionManagerAction
	 */
	public function getActionManagerAction() {
		return $this->actionManagerAction;
	}
	
	/**
	 * @param field_type $actionManagerAction
	 */
	public function setActionManagerAction($actionManagerAction) {
		$this->actionManagerAction = $actionManagerAction;
	}
	
	public function drawHtml() {
		
		$html = '
	    		<table width="100%">
    				<tr>
        	    		<td width="25%" style="vertical-align: top;">
        	    			' . parent::getLabel () . '
        	    		</td>';
		
		$html .= '
        	    		<td align="left" width="75%" style="position: relative; vertical-align: top;">
    	    			
    	    				<input type="text"
    	    				   style="float: left; margin-right: 1px;" 
    	    				   readonly="readonly" 
    	    				   name="label_filter_' . parent::getFieldName () . '" 
    	    				   id="label_filter_' . parent::getFieldName () . '" 
    	    				   value="' . parent::getSelectedLabelValue () . '" />
    	    				   
    	    				<span style="float: left; margin-right: 1px;" id="displayLoadingImage_' . parent::getFieldName () . '"></span>

	    				    <div style="float: left; margin-right: 1px;"
                    	    	class="search_icon" 
								id="loadTreeButton_' . parent::getFieldName () . '" 
								onclick="showTree(\'FilterTree_' . parent::getFieldName () . '\', false, \'displayLoadingImage_' . parent::getFieldName () . '\');">
							</div>
							<div style="float: left; margin-right: 1px;" class="cancel_icon"
								onclick="clearSelectionInput(\'label_filter_' . parent::getFieldName () . '\',\'filter_' . parent::getFieldName () . '\');">
							</div>
						';
		
		$html .= '    			
							<div class="treeContainer treeContainerGeneric" id="FilterTree_' . parent::getFieldName () . '">
								';
		
		$elementsList = parent::getList ();
		
		$html .= '
                        		<div style="max-height: 200px; width: 200px; text-align: left; font-size: 12px;">
                        			'.$this->drawTree($elementsList).
                        		'</div>';
		
		$html .= '		
           					</div>
            	    			
        	    			<input type="hidden" 
        	    				   id="filter_' . parent::getFieldName () . '" 
        	    				   name="filter_' . parent::getFieldName () . '" 
        	    				   value="' . parent::getSelectedValue () . '" 
        	    				   class="input-number-validate"
        	    				   maxlength="100" />
        	    				   
        	    		</td>
        	    		
    	    		</tr>
    	    		
        		</table>
        		';
		
		return $html;
	
	}
	
	public function getCriteriaQuery() {
		
		$criteriaQuery = '';
		
		if (parent::getSelectedValue () != '') {
			
			if (parent::getFieldToSearch () != '') {
				$fieldToSearch = parent::getFieldToSearch ();
			} else {
				$fieldToSearch = parent::getFieldName ();
			}
				
			$criteriaQuery .= '
                					AND ' . $fieldToSearch . ' = ' . parent::getSelectedValue () . '
                    	        ';
		
		}
		
		return $criteriaQuery;
	
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
						
							$html .= '<a href="javascript:updateInputFromTree(\''.$value->getName().'\','.$value->getId().',\'label_filter_'.parent::getFieldName().'\',\'filter_'.parent::getFieldName().'\',true,\'FilterTree_' . parent::getFieldName () . '\');">';
									
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

}