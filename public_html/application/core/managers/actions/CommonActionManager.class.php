<?php
/**
 * Implements Login actions
 *
 * @package core.managers.actions
 * @author Gabriel Guzman
 * @version 1.0
 *
 * DATE OF CREATION: 16/03/2012
 * UPDATE LIST
 * UPDATE: 
 * CALLED BY: ActionManager execute
 */

$configurator = Configurator::getInstance ();

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/CommonActionManagerActions.enum.php');

class CommonActionManager extends ActionManager {
	
	protected $defaultAction = "view";
	
	protected static $instance;
	
	protected $contentManager;
	
	public function __construct() {
		
	}
	
	public function view() {
		
		$_SESSION['logger']->debug ( __METHOD__ . ' begin' );
		
		$render = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMaster ();
		
		$view = $masterView->render ( $render );
		
		$_SESSION['logger']->debug ( __METHOD__ . ' end' );
		
		return new RenderActionResponse ( $view );
	
	}
	
	public function followexternallink() {
		
		return new RedirectActionResponse ( $_REQUEST ['currentContent'] ['content_external_link'] );
	
	}
	
	public function printPage() {
		
		require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/views/PopupPrint.view.php');
		
		return new RenderActionResponse ( PopupPrintView::render () );
	}
	
	public function errorMessage() {
		
		require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/views/ErrorMessage.view.php');
		
		$errorMessage = isset ( $_REQUEST ['errorMessage'] ) ? $_REQUEST ['errorMessage'] : '';
		$errorTitle = isset ( $_REQUEST ['errorTitle'] ) ? $_REQUEST ['errorTitle'] : Util::getLiteral ( 'error' );
		
		return new AjaxMessageBox ( ErrorMessageView::render ( $errorMessage ), null, $errorTitle );
	
	}

}