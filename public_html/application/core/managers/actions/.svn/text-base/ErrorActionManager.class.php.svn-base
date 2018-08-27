<?php
/**
 * Implements error actions
 *
 * @package core.managers.actions
 * @author Gabriel Guzman
 * @version 1.0
 *
 * DATE OF CREATION: 15/03/2012
 * UPDATE LIST * 
 * CALLED BY: ActionManager execute
 */

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/ErrorActionManagerActions.enum.php';

class ErrorActionManager extends ActionManager {
	
	protected $defaultAction = ErrorActionManagerActions::ERROR404;
	
	protected function error404() {
		
		session_start();
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/Master.view.php");
		require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/404.view.php");
		
		$errorView = Error404View::render ( Util::getLiteral ( 'error404' ), Util::getLiteral ( 'pagenotfound' ) );
		
		$view = MasterView::render ( $errorView );
		
		$actionResponse = new RenderActionResponse ( $view );
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
		return $actionResponse;
	
	}
	
	protected function errorMessage() {
		
		session_start();
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/Master.view.php");		
		require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");
		
		$errorMessage = isset ( $_REQUEST ['errorMessage'] ) ? $_REQUEST ['errorMessage'] : '';
		
		$errorAction = isset ( $_REQUEST ['errorAction'] ) ? $_REQUEST ['errorAction'] : '';
		
		$errorView = ErrorMessageView::render ( $errorMessage, $errorAction );
		
		$view = MasterView::render ( $errorView );
		
		$actionResponse = new RenderActionResponse ( $view );
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
		return $actionResponse;
	
	}
}