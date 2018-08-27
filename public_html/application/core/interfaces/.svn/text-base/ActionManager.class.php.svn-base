<?php
/**
 * Abstract class that defines methods used over all ActionManager's and shared among
 * them to easy rendering task by using always the same methods
 *
 * @package core.interfaces
 * @author Gabriel Guzman
 * @version 1.0
 *
 * DATE OF CREATION: 15/03/2012
 * UPDATE LIST
 * CALLED BY: Every class that implements it, generally located at core.managers
 */
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/RenderActionResponse.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/RedirectActionResponse.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRedirect.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxMessageBox.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxConfirmBox.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxActionResponse.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/AjaxResponseType.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/MessageBoxType.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/PermissionException.exception.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/ReadPermission.exception.php';

abstract class ActionManager {
	
	protected $defaultAction = "";
	
	/**
	 * Returns the defaultAction
	 */
	public function getDefaultAction() {
		return $this->defaultAction;
	}
	
	/**
	 * @param $defaultAction the $defaultAction to set
	 */
	public function setDefaultAction($defaultAction) {
		$this->defaultAction = $defaultAction;
	}
	
	/**
	 * Method to execute the action
	 * Returns ResponseAction for GUI usage
	 * @return Response Action Instance of ResponseAction that implements the ResponseAction.
	 */
	public function execute() {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		if (! isset ( $_REQUEST ['returnAction'] )) {
			$_REQUEST ['returnAction'] = '';
		}
		
		if (! isset ( $_REQUEST ['returnUrl'] ) || $_REQUEST ['returnUrl'] == null) {
			if (isset ( $_REQUEST ['urlargs'] ) && $_REQUEST ['urlargs'] != null) {
				$_REQUEST ['returnUrl'] = '';
			} else {
				$_REQUEST ['returnUrl'] = '/' . $_SESSION ['s_languageIso'];
			}
		}
		
		$action = "";
		
		if (isset ( $_REQUEST ["action"] ) && trim ( $_REQUEST ["action"] ) != "" && $_REQUEST ["action"] != 'undefined') {
			$action = $_REQUEST ["action"];
		} else if (trim ( $this->defaultAction ) != "") {
			$action = $this->defaultAction;
		}
		
		$_SESSION ['logger']->debug ( 'executing action: ' . $action );
		
		if ($action != "" && method_exists ( $this, $action )) {
			try {
				return $this->$action ();
			} catch ( Exception $e ) {
				throw $e;
			}
		} else {
			throw new Exception ( Util::getLiteral ( 'actionnotfound' ) . ' (' . $action . ')' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
	}
	
	protected function logout() {
		
		$loginActionManager = new LoginActionManager ();
		
		return $loginActionManager->execute ();
		
	}
	
	protected function viewChangePassword() {
		
		$loginActionManager = new LoginActionManager ();
		
		return $loginActionManager->execute ();
		
	}
	
	protected function changePassword() {
		
		$loginActionManager = new LoginActionManager ();
		
		return $loginActionManager->execute ();
	
	}

}