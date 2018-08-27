<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/common.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/TextFilter.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/NumberFilter.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/SelectionPopupFilterGeneric.class.php';

/**
 * This class creates the different filter controls, according to the xml data passed
 * @author gabriel.guzman
 *
 */
class FilterFactory {
	
	function __construct() {
	}
	
	public function createFilter($filter, $filterValues) {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$controlType = ( string ) $filter ['controlType'];
		
		if (isset ( $controlType ) && $controlType != '') {
			
			//Filter type
			$filterType = constant ( ( string ) $filter ['controlType'] );
			
			//Class to build: used in reflection
			$classToBuild = ( string ) $filter ['type'];
			
			if (isset ( $classToBuild ) && $classToBuild != '') {
				
				//Number and text control
				if ($filterType == searchFilters::TEXT || $filterType == searchFilters::NUMBER) {
					
					$filterObj = new $classToBuild ( ( string ) $filter ['name'], $_SESSION ['s_message'] [strtolower ( $filter ['name'] )], ( int ) $filter ['length'], ( string ) $filter ['fieldToSearch'] );
				} 

				//Selection popup control
				else if ($filterType == searchFilters::SELECTION_LIST) {
					
					$submitFunction = 'loadSelectionListPopup( 
                    											1,
                    											\'filter_' . ( string ) $filter ['name'] . '\',
                    											\'label_filter_' . ( string ) $filter ['name'] . '\',
                    											\'' . ( string ) $filter ['wsName'] . '\',
                    											\'' . ( string ) $filter ['listMethod'] . '\',
                    											\'' . ( string ) $filter ['countMethod'] . '\',
                    											\'\',
                    											' . ( string ) $filter ['actionManagerAction'] . ',
                    											\'\'
                    										);';
					
					$filterObj = new $classToBuild ( ( string ) $filter ['name'], $_SESSION ['s_message'] [strtolower ( $filter ['name'] )], ( string ) $filter ['fieldToSearch'] );
					
					$filterObj->setSubmitFunction ( $submitFunction );
					
					$labelInputVal = 'label_filter_' . ( string ) $filter ['name'];
					
					//Selected visible control value (hidden value is setted below)
					if (array_key_exists ( $labelInputVal, $filterValues )) {
						
						$filterObj->setSelectedLabelValue ( $filterValues [$labelInputVal] );
					
					}
				
				}
				
				if (is_object ( $filterObj )) {
					
					//Selected control value
					$indexVal = 'filter_' . ( string ) $filter ['name'];
					
					if (array_key_exists ( $indexVal, $filterValues )) {
						
						$filterObj->setSelectedValue ( $filterValues [$indexVal] );
					
					}
				}
			} else {
				$_SESSION ['logger']->debug ( 'Filter class is null' );
				throw new Exception ( 'Filter class is null' );
			}
		} else {
			$_SESSION ['logger']->debug ( 'Filter control type is null' );
			throw new Exception ( 'Filter control type is null' );
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return $filterObj;
	
	}

}