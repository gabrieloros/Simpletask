<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

abstract class ModuleActionManager extends ActionManager {
	
	protected $defaultAction = "view";
	protected $manager;
	
	public function getList($maxquantity) {
	}
	
	public function getDetail() {
	}
	
	public function getLinkbox($maxquantity) {
	}
	
	public function getStacked($maxquantity) {
	}
	
	/**
	 * 
	 * @author Gabriel Guzman
	 * Instanciate a module manager
	 * @param ModuleManager $moduleManager
	 */
	public function setModuleManager($moduleManager = '') {
		
		if ($moduleManager == '') {
			
			$className = get_class ( $this );
			
			$moduleName = substr ( $className, 0, - 13 );
			
			$classPath = $_SERVER ['DOCUMENT_ROOT'] . "/../application/modules/" . $moduleName . "/managers/" . $moduleName . "Manager.class.php";
			
			if (file_exists ( $classPath )) {
				require_once ($classPath);
				
				$moduleManagerName = $moduleName . "Manager";
				
				if (method_exists ( $moduleManagerName, "getInstance" )) {
					$myClass = call_user_func ( array ($moduleManagerName, 'getInstance' ) );
					$this->manager = $myClass->getInstance ();
				} else {
					Throw new Exception ( "your module Manager must have a 'getInstance()' static method to allow use the manager autoload. Otherwise set them up manually" );
				}
			} else {
				Throw new Exception ( "Unable to autoload the module Manager. File not found. Check the path: " . $classPath );
			}
		} else {
			$this->manager = $moduleManager;
		}
	
	}
	
	public function view() {
		
		$_SESSION['logger']->debug ( __CLASS__ . __FUNCTION__ . ' start' );
		
		if (isset ( $_REQUEST ['urlargs'] [2] ) && $_REQUEST ['urlargs'] [2] != '') {
			
			$detail = true;
			
			$render = $this->getDetail ();
			
		} else {
			
			$maxQuantity = 20;
			
			$render = $this->getList ( $maxQuantity );
			
		}
		
		$return = '';
		
		if (! is_a ( $render, "ActionResponse" )) {
			
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
			$masterView = MasterFactory::getMaster ();
			
			$view = $masterView->render ( $render );
			
			$myReturn = new RenderActionResponse ( $view );
			
			$return = $myReturn;
			
		} else {
			$return = $render;
		}
		
		$_SESSION['logger']->debug ( __CLASS__ . __FUNCTION__ . ' end' );
		
		return $return;
	}
	
	protected function getTextControl($readonly, $fieldName, $label, $length, $isMandatory){
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/controls/TextControl.class.php';
	    
	    $control = new TextControl($fieldName, $label, $length, $isMandatory, $readonly);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $control;
	    
	}
	
	protected function getNumericControl($readonly, $fieldName, $label, $length, $isMandatory, $decimal){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/controls/NumericControl.class.php';
	    
	    $control = new NumericControl($fieldName, $label, $length, $decimal, $isMandatory, $readonly);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $control;
		
	} 
	
	protected function getPasswordControl($readonly, $fieldName, $length, $isMandatory){
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/controls/PasswordControl.class.php';
	    
	    $control = new PasswordControl($fieldName, $length, $isMandatory, $readonly);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $control;
	    
	}
	
	protected function getSelectControl($fieldName, $label, $isMultiple, $onchangeFunction, $readonly, $isMandatory, $showDefaultEmptyValue){
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/controls/SelectControl.class.php';
	    
	    $control = new SelectControl($fieldName, $label, $isMultiple, $onchangeFunction, $readonly, $isMandatory, $showDefaultEmptyValue);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $control;
	    
	}
	
	protected function getTwoPanelsControl($fieldName, $label, $readonly, $isMandatory){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/controls/TwoPanelsControl.class.php';
	    
	    $control = new TwoPanelsControl($fieldName, $label, $readonly, $isMandatory);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $control;
		
	}
	
	protected function getSelectionTreeControl($fieldName, $label, $list, $readonly, $isMandatory, $popupTree){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/controls/SelectionTreeControl.class.php';
	    
	    $control = new SelectionTreeControl($fieldName, $label, $list, $readonly, $isMandatory, $popupTree); 
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $control;
		
	}
	
	protected function getRichTextControl($fieldName, $label, $readonly, $isMandatory){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/controls/RichTextControl.class.php';
	    
	    $control = new RichTextControl($fieldName, $label, $isMandatory, $readonly); 
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $control;
	    
	}
	
	protected function getCheckboxControl($fieldName, $label, $isMandatory, $readonly){
	    
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/controls/CheckboxControl.class.php';
	    
	    $control = new CheckboxControl($fieldName, $label, $isMandatory, $readonly); 
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $control;
		
	}
	
	protected function getTextAreaControl($readonly, $fieldName, $label, $isMandatory){
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/controls/TextAreaControl.class.php';
	    
	    $control = new TextAreaControl($fieldName, $label, $isMandatory, $readonly);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $control;
		
	}
	
	protected  function getDateControl($fieldName, $label, $isMandatory, $readonly){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/controls/DateControl.class.php';
	    
	    $control = new DateControl($fieldName, $label, $isMandatory, $readonly);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $control;
		
	}
	
	protected function getTextFilter($fieldName, $label, $length, $fieldToSearch, $subConcept){
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/TextFilter.class.php';
	    
	    $filter = new TextFilter ( $fieldName, $label, $length, $fieldToSearch );
	    	
		if (isset ( $_REQUEST ['filter_' . $fieldName] )) {
			$_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] = $_REQUEST ['filter_' . $fieldName];
		}
		
		if (isset ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] ) && $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] != '') {
			$filter->setSelectedValue ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] );
		}
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $filter;
	    
	}
	
	protected function getNumberFilter($fieldName, $label, $length, $fieldToSearch, $subConcept){
		 
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		 
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/NumberFilter.class.php';
		 
		$filter = new NumberFilter( $fieldName, $label, $length, $fieldToSearch );
	
		if (isset ( $_REQUEST ['filter_' . $fieldName] )) {
			$_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] = $_REQUEST ['filter_' . $fieldName];
		}
	
		if (isset ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] ) && $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] != '') {
			$filter->setSelectedValue ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] );
		}
		 
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		 
		return $filter;
		 
	}
	
	
	protected function getValueSelectFilter($fieldName,   $isMultiple, $subConcept){
	
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		 
		
		if($isMultiple){
			if (isset ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] ) && is_array($_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName])) {
				return $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] ;
			}
		}
		else{
			if (isset ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] ) && $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] != '') {
				return  $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] ;
			}
		}
		 
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		 
		return "";
	
	}
	
	
	protected function getSelectFilter($fieldName, $label, $fieldToSearch, $isMultiple, $onchangeFunction, $showDefaultEmptyValue, $isMandatory, $subConcept){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/SelectFilter.class.php';
	    
	    $filter = new SelectFilter ($fieldName, $label, $fieldToSearch, $isMultiple, $onchangeFunction, $showDefaultEmptyValue, $isMandatory);
	    
	    if (isset ( $_REQUEST ['filter_' . $fieldName] )) {
			$_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] = $_REQUEST ['filter_' . $fieldName];
		}
		else {
			if (isset ( $_POST ) && is_array( $_POST ) && count ( $_POST ) > 0 && !isset($_POST['page'])) {
				$_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] = '';
			}
		}
		
		if($isMultiple){
			if (isset ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] ) && is_array($_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName])) {
				$filter->setSelectedValue ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] );
			}		
		}
		else{
			if (isset ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] ) && $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] != '') {
				$filter->setSelectedValue ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] [$fieldName] );
			}
		}
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $filter;
		
	}
	
	protected function getDateFilter($fieldName, $label, $fieldToSearch, $subConcept, $showTypeDateControl = false){
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/DateRangeFilter.class.php';
	    
	    $dateFilter = new DateRangeFilter($fieldName, $label, $fieldToSearch, $showTypeDateControl);
	    
	    //Left Value
	    if(isset($_REQUEST['filter_date_left_' . $fieldName])){
		    $_SESSION[$_REQUEST['currentContent']['modulename']][$subConcept]['filters']['date_left_' . $fieldName] = $_REQUEST['filter_date_left_' . $fieldName]; 
		}
		
		if(isset($_SESSION[$_REQUEST['currentContent']['modulename']][$subConcept]['filters']['date_left_' . $fieldName]) && $_SESSION[$_REQUEST['currentContent']['modulename']][$subConcept]['filters']['date_left_' . $fieldName] != ''){
            $dateFilter->setLeftValue($_SESSION[$_REQUEST['currentContent']['modulename']][$subConcept]['filters']['date_left_' . $fieldName]);
		}
	    
		//Right value
	    if(isset($_REQUEST['filter_date_right_' . $fieldName])){
		    $_SESSION[$_REQUEST['currentContent']['modulename']][$subConcept]['filters']['date_right_' . $fieldName] = $_REQUEST['filter_date_right_' . $fieldName]; 
		}
		
		if(isset($_SESSION[$_REQUEST['currentContent']['modulename']][$subConcept]['filters']['date_right_' . $fieldName]) && $_SESSION[$_REQUEST['currentContent']['modulename']][$subConcept]['filters']['date_right_' . $fieldName] != ''){
            $dateFilter->setRightValue($_SESSION[$_REQUEST['currentContent']['modulename']][$subConcept]['filters']['date_right_' . $fieldName]);
		}
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return $dateFilter;
	    
	}

}