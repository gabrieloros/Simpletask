<?php
/** 
 * @author Gabriel Guzman
 * 
 * 
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/managers/UserManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterGroup.class.php';

class usersActionManager extends ModuleActionManager {
	
	protected $manager;
	
	public function __construct() {
		
		$this->manager = UserManager::getInstance ();
	
	}
	
	protected function getUserTypesFilter($subConcept) {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$userTypesList = $this->manager->getUserTypes ();
		
		$userTypesFilter = new SelectFilter ( 'userTypeId', $_SESSION ['s_message'] ['usertype'], 'usertypeid', false, '', true, false );
		
		foreach ( $userTypesList as $userType ) {
			$userTypesFilter->addValue ( $userType->getId (), $userType->getTypename () );
		}
		
		if (isset ( $_REQUEST ['filter_userTypeId'] )) {
			$_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] ['userTypeId'] = $_REQUEST ['filter_userTypeId'];
		} else {
			if (isset ( $_POST ['filter_name'] )) {
				$_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] ['userTypeId'] = '';
			}
		}
		
		if (isset ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] ['userTypeId'] ) && $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] ['userTypeId'] != '') {
			$userTypesFilter->setSelectedValue ( $_SESSION [$_REQUEST ['currentContent'] ['modulename']] [$subConcept] ['filters'] ['userTypeId'] );
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		return $userTypesFilter;
	
	}
	
	public function getList($maxQuantity) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$subConcept = 'usersList';
		
		//Pager variables
		$count = $_SESSION ['s_parameters'] ['page_size'];
		
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] != '' && is_numeric ( $_REQUEST ['page'] )) {
			$page = $_REQUEST ['page'];
		} else {
			$page = '';
		}
		
		if ($page == '') {
			$begin = 0;
			$page = 1;
		} else {
			$begin = ($page - 1) * $count;
		}
		
		$filters = array ();
		
		//name filter
		$filters [] = $this->getTextFilter('name', $_SESSION ['s_message'] ['name'], 50, 'username', $subConcept);
		
		//surname filter
		$filters [] = $this->getTextFilter('surname', $_SESSION ['s_message'] ['surname'], 50, 'usersurname', $subConcept);
		
		//e-mail filter
		$filters [] =  $this->getTextFilter('email', $_SESSION ['s_message'] ['email'], 255, 'useremail', $subConcept);
		
		//usertypes filter
		$filters [] = $this->getUserTypesFilter ( $subConcept );
		
		//List
		$usersList = $this->manager->getUsersList ( $begin, $count, $filters );
		
		//Count
		$numrows = $this->manager->getUsersCount ( $filters );
		
		//Pager
		$pager = Util::getPager ( $numrows, $begin, $page, $count );
		
		//Filter Group (Form)
		$filterGroup = new FilterGroup ( 'usersFilter', '', '', '' );
		$filterGroup->setFiltersList ( $filters );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/usersList.view.php';
		
		$render = usersList::render ( $usersList, $filterGroup, $pager );
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $render;
	
	}
	
	public function delete() {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$userId = $_REQUEST ['userId'];
		
		try {
			$result = $this->manager->deleteUser ( $userId );
			
			if ($result) {
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxRedirect ( $_SERVER ['REQUEST_URI'] );
			} else {
				$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_deleting_user'] );
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxMessageBox ( $_SESSION ['s_message'] ['error_deleting_user'], null, $_SESSION ['s_message'] ['error'] );
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_deleting_user'] );
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
			return new AjaxMessageBox ( $_SESSION ['s_message'] ['error_deleting_user'], null, $_SESSION ['s_message'] ['error'] );
		}
	
	}
	
	public function create() {
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		try {

			foreach ($_POST as $key => $val){
				$_POST[$key] = htmlentities($val,ENT_NOQUOTES,'UTF-8');
			}
			
			//update
			if (isset ( $_REQUEST ['userId'] ) && $_REQUEST ['userId'] != '') {
				
				$result = $this->manager->updateUser ( $_REQUEST ['userId'], $_POST );
				
				if ($result) {
					$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					return new AjaxRedirect ( $_SERVER ['REQUEST_URI'] );
				} else {
					$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_updating_user'] );
					$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					return new AjaxMessageBox ( '<br />' . $_SESSION ['s_message'] ['error_updating_user'], null, $_SESSION ['s_message'] ['error'] );
				}
			
			} //insert
			else {
				
				$result = $this->manager->insertUser ( $_POST );
				
				if ($result) {
					$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					return new AjaxRedirect ( $_SERVER ['REQUEST_URI'] );
				} else {
					$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_inserting_user'] );
					$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
					return new AjaxMessageBox ( '<br />' . $_SESSION ['s_message'] ['error_inserting_user'], null, $_SESSION ['s_message'] ['error'] );
				}
			
			}
		
		} catch ( Exception $e ) {
			
			if (isset ( $_REQUEST ['userId'] ) && $_REQUEST ['userId'] != '') {
				$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_updating_user'] );
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxMessageBox ( '<br />' . $_SESSION ['s_message'] ['error_updating_user'] . '<br />' . $e->getMessage(), null, $_SESSION ['s_message'] ['error'] );
			} else {
				$_SESSION ['logger']->error ( $_SESSION ['s_message'] ['error_inserting_user'] );
				$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
				return new AjaxMessageBox ( '<br />' . $_SESSION ['s_message'] ['error_inserting_user'] . '<br />' . $e->getMessage(), null, $_SESSION ['s_message'] ['error'] );
			}
		}
	
	}
	
	public function createUser(){
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    $fields = array();
	    
	    //Name field
	    $fields ['name'] = $this->getTextControl(false, 'userName', $_SESSION['s_message']['name'], 50, true);
	    
	    //Surname field
	    $fields ['surname'] = $this->getTextControl(false, 'userSurname', $_SESSION['s_message']['surname'], 50, true);
	    
	    //Email field
	    $fields ['email'] = $this->getTextControl(false, 'userEmail', $_SESSION['s_message']['email'], 255, true);
	    $fields ['email']->setIsEmail(true);
	    
	    //Login field
	    $fields ['login'] = $this->getTextControl(false, 'userLogin', $_SESSION['s_message']['user'], 50, true);
	    
	    //Password field
	    $fields ['password'] = $this->getPasswordControl(false, 'userPassword', 50, true);
	    $fields ['password']->setMustValidate(true);
	    
	    //Usertype field
	    $fields ['usertype'] = $this->getSelectControl('userTypeId', $_SESSION['s_message']['usertype'], false, '', false, true, true);
	    
	    $userTypes = $this->manager->getUserTypes();
	    
	    foreach ($userTypes as $userType){
	    	$fields ['usertype']->addValue($userType->getId(), $userType->getTypeName());
	    }
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/createUser.view.php';
	    
	    $render = createUser::render($fields, null, false);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return new AjaxMessageBox ( $render, null, $_SESSION ['s_message'] ['create_user'] );
	    
	}
	
	public function editUser(){
		
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
	    
	    require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/users/views/createUser.view.php';
	    
	    $fields = array();
	    
	    //Name field
	    $fields ['name'] = $this->getTextControl(false, 'userName', $_SESSION['s_message']['name'], 50, true);
	    
	    //Surname field
	    $fields ['surname'] = $this->getTextControl(false, 'userSurname', $_SESSION['s_message']['surname'], 50, true);
	    
	    //Email field
	    $fields ['email'] = $this->getTextControl(false, 'userEmail', $_SESSION['s_message']['email'], 255, true);
	    $fields ['email']->setIsEmail(true);
	    
	    //Login field
	    $fields ['login'] = $this->getTextControl(true, 'userLogin', $_SESSION['s_message']['user'], 50, true);
	    
	    //Password field
	    $fields ['password'] = $this->getPasswordControl(false, 'userPassword', 50, true);
	    $fields ['password']->setMustValidate(false);
	    
	    //Usertype field
	    $fields ['usertype'] = $this->getSelectControl('userTypeId', $_SESSION['s_message']['usertype'], false, '', false, true, true);
	    
	    $userTypes = $this->manager->getUserTypes();
	    
	    foreach ($userTypes as $userType){
	    	$fields ['usertype']->addValue($userType->getId(), $userType->getTypeName());
	    }
	    
	    //getUserData
	    $user = $this->manager->getUserById($_REQUEST['userId']);
	    
	    $render = createUser::render($fields, $user[0], false);
	    
	    $_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
	    
	    return new AjaxMessageBox ( $render, null, $_SESSION ['s_message'] ['edit_user'] );
		
	}

}