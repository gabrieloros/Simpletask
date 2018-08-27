<?php
$configurator = Configurator::getInstance ();

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/ContentResource.class.php');

/*
 * Manager to obtain the Content information.
 */

class ContentManager {
	
	private $home = 'inicio';
	
	/**
	 * Loads in $_SESSION['currentContent'] the data for the content we need 
	 * and $_SESSION['currentContentResource'] with the information in the content in specific language
	 * 
	 * @param string $language the first argument of url
	 * @param string $contentURL the second argument of url
	 * 
	 * @return void
	 */
	public function __construct($languageIso = null, $contentURL = null, $error = false) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . 'begin' );
		
		$this->setCurrentContent ( $languageIso, $contentURL, $error );
		
		$contentArray = array ('webmap', 'contact', 'rss', 'legal', 'search' );
		
		$this->setDefaultContentsInfo ( $contentArray, $_SESSION ['s_languageId'] );
		
// 		$permissionOk = $this->checkPermission ();
		$permissionOk = TRUE;
		
		if (! $permissionOk) {
			require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/PermissionException.exception.php');
			throw new PermissionException ( 'The current user doesn\'t have permission for requested content (' . $contentURL . ').' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
	}
	
	/**
	 * Load the requested content in $contentId into $_REQUEST['currentContent'].
	 * If it doesn´t exist load 404 content in $_REQUEST['currentContent'].
	 * If no $contentName is specified the Main Content is returned, this should be the home content.
	 *
	 * @param string $contentId requested content
	 * @return void
	 */
	public function setCurrentContent($languageIso, $contentURL, $error = false) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		$_SESSION ['logger']->info ( "requested content: " . $contentURL );
		
		$contentURL = (isset ( $contentURL ) && $contentURL != '') ? $contentURL : $this->home;
		
		$languageManager = LanguageManager::getInstance ();
		
		$_SESSION ['logger']->info ( 'loading contents started...' );
		
		$query = Util::getContentsQuery ( $languageIso, $contentURL, $error );
		
		$connectionManager = ConnectionManager::getInstance();
		
		$content = $connectionManager->select($query);
		
		if (is_array ( $content )) {
			
			if (count ( $content ) > 0) {
				
				foreach ($_SESSION['s_languages'] as $lang) {
		        	
		        	$contentKey = 'url_'.$lang->getIso();
		        	
		        	$content[0]['url_lang'][$lang->getIso()] = $content[0][$contentKey];
		        }
				
				$_REQUEST ['currentContent'] = $content [0];
				
			} else {
				
				$_SESSION ['logger']->info ( "content not found" );
				
				require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/PageNotFoundException.class.php');
				
				throw new PageNotFoundException ( 'The requested content (' . $contentURL . ') doesn\'t exist.' );
				
			}
		} else {
			throw new Exception ( "Unexpected error retriving content. Posible database query error" );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
	}
	
	/**
	 * returns the content_lang information 
	 *
	 * @param int $contentId requested content
	 * @param int $languageId requested language 
	 * @return strint the table info
	 */
	public function getContentByLanguage($contentId, $languageId) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		$_SESSION ['logger']->info ( "requested content: " . $contentId );
		
		$query = Util::getContentsLanguageResource ( $contentId, $languageId );
		
		$connectionManager = ConnectionManager::getInstance();
		
		$result = $connectionManager->exec($query);
		
		$contentResource = $connectionManager->fetch ( $result, true );
		
		if (! is_array ( $contentResource )) {
			$_SESSION ['logger']->fatal ( "contentId: " . $contentId );
			$_SESSION ['logger']->fatal ( "languageId: " . $languageId );
			throw new Exception ( "Error retriving content. Posible language error" );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
		return new ContentResource ( $contentId, $contentResource ['title'], $contentResource ['body'] );
	
	}
	
	/**
	 * Set on $_SESSION['s_defaultcontent'] the desired content
	 * @param $contentArray: Array with content key's required
	 * @param $siteId: Site Identification
	 * @param $lanId: Language Identification
	 */
	public function setDefaultContentsInfo($contentArray, $langId) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		if (! isset ( $_SESSION ['s_defaultcontent'] ) || $_SESSION ['s_defaultcontent'] ['language'] != $langId) {
			
			$query = Util::getDefaultContentsInfo ( $contentArray, $langId );
			
			$_SESSION ['logger']->debug ( 'content query: ' . $query );
			
			$connectionManager = ConnectionManager::getInstance();
			
			$result = $connectionManager->exec($query);
			
			while ( $contentResource = $connectionManager->fetch ( $result ) ) {
				$_SESSION ['s_defaultcontent'] [$contentResource ['menukey']] = $contentResource;				
			}
			
			$_SESSION ['s_defaultcontent'] ['language'] = $langId;
			
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
	}
	
	/**
	 * 
	 * Check if user have permission to access in X site to Y content.
	 * @param string $userId
	 * @param integer $contentId
	 * @param integer $siteId
	 */
	private function checkPermission($userTypeId = '', $menuId = '') {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		$userTypeId = $userTypeId == '' ? $_SESSION ['loggedUser']->getUserTypeId() : $userTypeId;
		$menuId = $menuId == '' ? $_REQUEST ['currentContent'] ['id'] : $menuId;
				
		$query = Util::getCheckPermissions ( $userTypeId, $menuId );
		
		$connectionManager = ConnectionManager::getInstance();
		
		$result = $connectionManager->select ( $query );
				
		if (isset($result [0] ['result']) && $result [0] ['result'] > 0) {
			$return = true;
		} else {
			$return = false;
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
		return $return;
	}

}