<?php
$time_start = microtime ( true );

/**
 * Site url parsing and site core inclusion
 * @package 
 * @author Gabriel Guzman
 * @version 1.0
 * DATE OF CREATION:
 */
try {

	//$_SERVER ['DOCUMENT_ROOT'].='/gdr_godoy_new/public_html/public';
	//var_dump($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/MyLogger.class.php');
	//die();

	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/PageNotFoundException.class.php';
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/exceptions/LoginException.exception.php';
	
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Configurator.class.php';
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/Util.class.php';
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/CommonFunctions.php';
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/common.enum.php';

	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/UrlParser.class.php';
	
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ModuleManager.class.php';
	
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/LanguageManager.class.php';
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/LiteralManager.class.php';
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/ParameterManager.class.php';
	
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/interfaces/ActionManager.class.php';
	
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/actions/ErrorActionManager.class.php';
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/actions/LoginActionManager.class.php';
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/enums/LoginActionManagerActions.enum.php';
	
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/StringDecoder.class.php';
	
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/actions/CommonActionManager.class.php';
	
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/MyLogger.class.php';
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/common/db/ConnectionManager.class.php';
	
	$configurator = Configurator::getInstance ();

	
	session_start();

	//Logger
	$_SESSION ['logger'] = MyLogger::getInstance ();

	//var_dump($_SESSION);
	//die();
	
	$_SESSION ['logger']->debug ( $_SERVER ["REQUEST_URI"] . " begin" );


	$_SESSION ['logger']->debug ( 'QUERY_STRING: ' . $_SERVER ['QUERY_STRING'] . ' ' );

	$_REQUEST ['REQUEST_URI'] = StringDecoder::forceUTF8 ( urldecode ( $_SERVER ['REQUEST_URI'] ) );
	$_REQUEST ['QUERY_STRING'] = StringDecoder::forceUTF8 ( urldecode ( $_SERVER ['QUERY_STRING'] ) );
	
	$_SESSION ['logger']->debug ( $_REQUEST ['REQUEST_URI'] . ' begin' );
	$_SESSION ['logger']->debug ( 'QUERY_STRING: ' . $_REQUEST ['QUERY_STRING'] );
	
	/* Parsing URL */
	$urlParser = new UrlParser ();
	$rawArgs = $urlParser->ParseUrl ( $_REQUEST ["REQUEST_URI"] );

	/* Adding the language to args */
	$_REQUEST ['urlargs'] = $urlParser->addLanguageToArgs ( $rawArgs );
	
	/* Get Languages */
	$languageManager = LanguageManager::getInstance ();
	$languageManager->getLanguages ();
	
	$tmpurlargs = $_REQUEST ['urlargs'];
	
	$proposedUrl = '/' . implode ( '/', $tmpurlargs );
	$request_uri = explode ( '?', $_REQUEST ['REQUEST_URI'] );
	
	//load parameters 
	$parameterManager = ParameterManager::getInstance ();


	if (! isset ( $_SESSION ['s_parameters'] )) {
		$parameterManager->loadParameters ();
	}
	
	if (($proposedUrl != $request_uri [0]) && ($proposedUrl . '/' != $request_uri [0])) {
		
		$_SESSION ['logger']->debug ( 'Redirecting from \'' . $_REQUEST ['REQUEST_URI'] . '\' to \'' . $proposedUrl );
		
		if (trim ( $_REQUEST ['QUERY_STRING'] ) != '') {
			$proposedUrl = $proposedUrl . '?' . $_REQUEST ['QUERY_STRING'];
		}
		
		$responseAction = new RedirectActionResponse ( $proposedUrl );
	
	} else {
		
		$literalManager = LiteralManager::getInstance ();
		
		if (! isset ( $_SESSION ['s_languageIso'] ) or $_SESSION ['s_languageIso'] != $_REQUEST ['urlargs'] [0]) {
			
			$newLanguage = $languageManager->getLanguageByIso ( $_REQUEST ['urlargs'] [0] );
			
			// set current language
			if ($languageManager->setLanguage ( $newLanguage )) {
				//load literals for the selected languages
				$literalManager->loadLiterals ( $languageManager->getCurrentLanguage (), true );
			}
		}
		
		$_SESSION ['s_languageIsoUrl'] = $_SESSION ['s_languageIso'];
		
		$literalManager->loadLiterals ( $languageManager->getDefaultLanguage () ); // not forced so if exist wont do nothing		
		
		if (isset ( $_REQUEST ['action'] ) and $_REQUEST ['action'] == LoginActionManagerActions::LOGOUT) {
			
			$actionManager = new LoginActionManager ();
		
		} elseif (! isset ( $_SESSION ['loggedUser'] ) ) {
			
			$actionManager = new LoginActionManager ();
			
			if (! isset ( $_REQUEST ['logout'] ) && isset ( $_REQUEST ['login_user'] )) {
				
				$actionManager->setDefaultAction ( LoginActionManagerActions::LOGIN );
			
			}
			else{
				$_REQUEST ["action"] = '';
			}
		
		} else {
			
			$lang = isset ( $_REQUEST ['urlargs'] [0] ) ? $_REQUEST ['urlargs'] [0] : null;
			
			$content = isset ( $_REQUEST ['urlargs'] [1] ) ? $_REQUEST ['urlargs'] [1] : null;
			
			$contentManager = new ContentManager ( $lang, $content );
			
			// Check if it's module or simple content
			if ($_REQUEST ['currentContent'] ['moduleid'] != '') {
				
				//module
				$name = $_REQUEST ['currentContent'] ['modulename'];
				
				$actionClassName = $name . 'ActionManager';
				
				$actionManagerPath = $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/' . $name . '/actionManagers/' . $actionClassName . '.class.php';
				
				if (file_exists ( $actionManagerPath )) {
					require_once ($actionManagerPath);
				} else {
					throw new Exception ( "Action manager not found: " . $actionManagerPath );
				}
				
				$actionManager = new $actionClassName ();
			
			} else {
				
				// Simple content
				if ($_REQUEST ['currentContent'] ['body'] == '' && (! isset ( $_REQUEST ['contentredirect'] )) || ($_REQUEST ['currentContent'] ['body'] == '' && $_REQUEST ['contentredirect'] != 0)) {
					
					// IF CONTENT DOESN'T HAVE CONTENT_TEXT REDIRECT TO FIRST CHILD.
					$url = Util::getUrlChild ( $_REQUEST ['currentContent'] ['id'], $_SESSION ['s_languageId'] );
					
					if ($url) {
						$actionManager = new RedirectActionResponse ( '/' . $_SESSION ['s_languageIsoUrl'] . '/' . $url );
					} else {
						$actionManager = new CommonActionManager ();
					}
				
				} else {
					$actionManager = new CommonActionManager ();
				}
			}
		}
		
		$_SESSION ['logger']->debug ( "executing action from : " . get_class ( $actionManager ) );
		$responseAction = $actionManager->execute ();
	}

	//valida login con passport
	$postPosition = strpos ( $_SERVER ["REQUEST_URI"], '?' );
	$strlenURL = strlen($_SERVER ["REQUEST_URI"]);
	$passportArray = split("&",substr ( $_SERVER ["REQUEST_URI"], $postPosition+1,strlen($_SERVER ["REQUEST_URI"])));
		//si es publicClaim hace login con usuario public
		var_dump( $_GET ['action']);
		//var_dump($_SESSION ['loggedUser'] );
		
	//	var_dump(strcmp($_GET ['action'],"getPublicClaims"));  $_GET ['action'] != NULL && $_GET ['action'] != 'undefined'&& 

	if(strcmp($_GET ['action'],"getPublicClaims") == 0 && ! isset($_SESSION ['loggedUser'] ) )
        {
                 $actionManager = new LoginActionManager ();
                 $actionManager->setDefaultAction ( LoginActionManagerActions::NOLOGIN );
		 $responseAction = $actionManager->execute ();
        }
        elseif
	(isset($passportArray) && strpos($passportArray[0],"user")!== FALSE && strpos($passportArray[1],"passport")!==FALSE){
		$userLogin = substr($passportArray[0], strpos ($passportArray[0],'=')+1,strlen($passportArray[0]));
		$password = substr($passportArray[1], strpos ($passportArray[1],'=')+1,strlen($passportArray[1])); 
		
		$actionManager = new LoginActionManager ();
		
		//TODO acá hay q desencriptar lo que manda el telefono 
		
		$_REQUEST ['login_user'] =$userLogin;
		$_REQUEST['login_password'] = $password;
		
		if (! isset ( $_REQUEST ['logout'] ) && isset ( $_REQUEST ['login_user'] )) {
		
			$actionManager->setDefaultAction ( LoginActionManagerActions::LOGINPASSPORT );
				
		}
		else{
			$_REQUEST ["action"] = '';
		}
		
		$responseAction = $actionManager->execute ();
		
	
}	
	$_SESSION ['logger']->debug ( "executing response of : " . get_class ( $responseAction ) );
	$responseAction->execute ();
		
	$_SESSION ['logger']->debug ( $_SERVER ["REQUEST_URI"] . " end" );

} catch ( PageNotFoundException $error ) {
	
	$_SESSION ['logger']->error ( "Page not found: " . $error->getMessage () );
	$_SESSION ['logger']->error ( "Stack Trace: " . $error->getTraceAsString () );

	try {
		
		$lang = isset ( $_REQUEST ['urlargs'] [0] ) ? $_REQUEST ['urlargs'] [0] : null;
		
		$contentManager = new ContentManager ( $lang, '404', true );
		
		$errorActionManager = new CommonActionManager ();
		
		$responseAction = $errorActionManager->execute ();
	
		$responseAction->execute ();
	
	} catch ( PageNotFoundException $e ) {
		
		$_SESSION ['logger']->fatal ( $e->getMessage () . " trace: " . $e->getTraceAsString () );
		
		require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");
		
		echo ErrorMessageView::render ( $e->getMessage () );
	
	} catch ( PermissionException $e ) {
		
		$_SESSION ['logger']->fatal ( $e->getMessage () . " trace: " . $e->getTraceAsString () );
		
		require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");
		
		echo ErrorMessageView::render ( $e->getMessage () );
	
	}

} catch ( PermissionException $error ) {
	
	$_SESSION ['logger']->error ( "Permission error: " . $error->getMessage () );
	$_SESSION ['logger']->error ( "Stack Trace: " . $error->getTraceAsString () );
	
	try {
		
		$lang = isset ( $_REQUEST ['urlargs'] [0] ) ? $_REQUEST ['urlargs'] [0] : null;
		
		$contentManager = new ContentManager ( $lang, '401', true );
		
		$errorActionManager = new CommonActionManager ();
	
	} catch ( PermissionException $e ) {
		
		$_SESSION ['logger']->fatal ( $e->getMessage () . " trace: " . $e->getTraceAsString () );
		
		require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");
		
		echo ErrorMessageView::render ( $e->getMessage () );
	
	}
	
	$responseAction = $errorActionManager->execute ();
	
	$responseAction->execute ();

} catch ( Exception $e ) {

	
	$_SESSION ['logger']->fatal ( $e->getMessage () . " trace: " . $e->getTraceAsString () );



	require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");



	echo ErrorMessageView::render ( $e->getMessage () );

}

$time_end = microtime ( true );

$diff = $time_end - $time_start;

$_SESSION ['logger']->debug ( $_REQUEST ["REQUEST_URI"] . " end in: " . $diff );

ob_end_flush ();
