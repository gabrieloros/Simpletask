<?php
class BreadcrumbManager {
	
	public static $BANNER_PATH = '/files/banners/';
	
	private static function initializeSession() {
	
	}
	
	public static function getBreadcrum() {
		
		$_SESSION ['logger']->debug ( __METHOD__ . 'begin' );
		
		$breadCrumb = array ();
		
		if ($_REQUEST ['currentContent'] ['id'] > 0) {
			
			$breadCrumb [] = array ('content_title' => $_REQUEST ['currentContent'] ['title'], 'content_url' => $_REQUEST ['currentContent'] ['url'], 'idcontent' => $_REQUEST ['currentContent'] ['id'] );
			
			if (! isset ( $_REQUEST ['breadcrumb'] ) || $_REQUEST ['breadcrumb'] == '') {
				if ($_REQUEST ['currentContent'] ['parentid'] != '') {
					self::addCrumb ( $breadCrumb, $_REQUEST ['currentContent'] ['parentid'] );
				}
				
				$_REQUEST ['breadcrumb'] = $breadCrumb;
				
			}
		} else {
			$_REQUEST ['breadcrumb'] = $breadCrumb;
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $_REQUEST ['breadcrumb'];
	
	}
	
	private static function addCrumb(&$breadCrumb, $idContent, $duplicateTracking = array()) {
		
		$query = Util::getCrumb ( $idContent, $_SESSION ['s_languageId'] );
		
		$connectionManager = ConnectionManager::getInstance();
		
		$row = $connectionManager->select ( $query );
		
		array_unshift ( $breadCrumb, array ('content_title' => $row [0] ['title'], 'content_url' => $row [0] ['url'], 'idcontent' => $row [0] ['id'] ) );
		
		if ($row [0] ['parentid'] != '' && ! in_array ( $row [0] ['id'], $duplicateTracking )) {
			
			$duplicateTracking [] = $row [0] ['id'];
			
			self::addCrumb ( $breadCrumb, $row [0] ['parentid'], $duplicateTracking );
			
		} elseif (in_array ( $row [0] ['id'], $duplicateTracking )) {
			
			require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/BreadcrumbException.class.php');
			
			throw new BreadcrumbException ( 'Unexpected error creating breadcrumb or menu with  content name ' . $row [0] ['title'] . '(' . $row [0] ['id'] . '): Recursiviy error.' );
			
		}
		
	}
}