<?php
/**
 * LanguageManager.class.php
 *
 * @package core.managers.common
 * @author Gabriel Guzman
 * DATE OF CREATION: 14/03/2012
 * PURPOSE: Language management
 * 
 */

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/Language.class.php');

class LanguageManager {
	
	private static $instance;
	
	private $defaultLanguageIso;
	
	private $defaultLanguage;
	
	/**
	 * Get a single instance of LanguageManager
	 *
	 * @return LanguageManager languageManager instance
	 */
	public static function getInstance() {
		
		if (! isset ( LanguageManager::$instance )) {
			LanguageManager::$instance = new LanguageManager ();
		}
		
		return LanguageManager::$instance;
	}
	
	private function __construct() {
		
		$this->defaultLanguageIso = 'es';
	}
	
	/**
	 * Get an array with all available languages.
	 * Set the default language in $_SESSION['s_defaultLanguageId']
	 * Set the languages in $_SESSION['s_languages']
	 * @return array collection of available languages
	 */
	public function getLanguages() {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		if (! isset ( $_SESSION ['s_languages'] )) {
			
			$query = Util::getLanguages ();
			
			$connectionManager = ConnectionManager::getInstance();
			
			$rawLanguagesResult = $connectionManager->select($query);
			
			if (!$rawLanguagesResult) {
				$_SESSION ['logger']->fatal ( "Unable to load languages . Query result: " . $rawLanguagesResult );
				throw new Exception ( "Unable to load languages" );
			}
			
			foreach ( $rawLanguagesResult as $rawLanguage ) {
				
				$language = new Language ( $rawLanguage ['lang_name'], $rawLanguage ['lang_iso'], $rawLanguage ['id'] );
				
				$this->languages [] = $language;
				
				$_SESSION ['logger']->info ( "loaded language: " . $language->getName () );
				
				if ((! isset ( $_SESSION ['s_defaultLanguageId'] ) || ! isset ( $_SESSION ['s_defaultLanguageIso'] )) && $rawLanguage ['lang_iso'] == $this->defaultLanguageIso) {
					
					$this->defaultLanguage = $language;
					
					$_SESSION ['s_defaultLanguageId'] = $this->defaultLanguage->getId ();
					$_SESSION ['s_defaultLanguageName'] = $this->defaultLanguage->getName ();
					$_SESSION ['s_defaultLanguageIso'] = $this->defaultLanguage->getIso ();
				}
				
			}
			
			$_SESSION ['logger']->info ( "default language: id: " . $_SESSION ['s_defaultLanguageId'] . " iso: " . $_SESSION ['s_defaultLanguageIso'] );
			
			$_SESSION ['s_languages'] = $this->languages;
			
			$_SESSION ['logger']->info ( "loading languages done" );
			$_SESSION ['logger']->debug ( __METHOD__ . " end" );
			
			return $this->languages;
			
		} else {
			
			$_SESSION ['logger']->debug ( __METHOD__ . " end" );
			
			return $_SESSION ['s_languages'];
			
		}
	}
	
	/**
	 * Get a specific language by ISO
	 *
	 * @param  string $iso ISO of the language to get
	 * @return Language the language
	 */
	public function getLanguageByIso($iso) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		if (is_array ( $_SESSION ['s_languages'] )) {
			
			foreach ( $_SESSION ['s_languages'] as $language ) {
				if ($language->getIso () == $iso) {
					$_SESSION ['logger']->debug ( __METHOD__ . " end" );
					return $language;
				}
			}
			
		} else {
			$_SESSION ['logger']->error ( "The languages are not loaded in session" );
			throw new Exception ( "The languages are not loaded in session" );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
		return null;
	}
	
	/**
	 * Get a specific language by Id
	 *
	 * @param  int $languageId id of the language to get
	 * @return Language the language
	 */
	public function getLanguageById($languageId) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		if (is_array ( $_SESSION ['s_languages'] )) {
			
			foreach ( $_SESSION ['s_languages'] as $language ) {
				if ($language->getId () == $languageId) {
					$_SESSION ['logger']->debug ( __METHOD__ . " end" );
					return $language;
				}
			}
			
		} else {
			$_SESSION ['logger']->error ( "The languages are not loaded in session" );
			throw new Exception ( "The languages are not loaded in session" );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		return null;
		
	}
	
	/**
	 * Set the current language and set it into $_SESSION['s_languageId'] , $_SESSION['s_languageIso']
	 *
	 * @param  Language $newLanguage Object of the language set as default
	 * @return boolean true if the languages was change, otherwise false.
	 */
	public function setLanguage($newLanguage) {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		if ($newLanguage instanceof Language) {
			
			$_SESSION ['logger']->debug ( "iso " . $newLanguage->getIso () );
			
			if (is_array ( $_SESSION ['s_languages'] )) {
				
				foreach ( $_SESSION ['s_languages'] as $language ) {
					
					if ($language->getIso () == $newLanguage->getIso ()) {
						
						$_SESSION ['s_languageName'] = $language->getName ();
						$_SESSION ['s_languageIso'] = $language->getIso ();
						$_SESSION ['s_languageId'] = $language->getId ();
						
						return true;
						
					}
				}
			
			} else {
				$_SESSION ['logger']->error ( "The languages are not loaded in session" );
				$_SESSION ['logger']->debug ( __METHOD__ . " end" );
				throw new Exception ( "The languages are not loaded in session" );
			}
		} else {
			$_SESSION ['logger']->error ( '$newLanguage must by a Language' );
			$_SESSION ['logger']->debug ( __METHOD__ . " end" );
			Throw new InvalidArgumentException ( 'the selected language is not a valid iso' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
		return false;
	}
	
	/**
	 * Get the default language
	 *
	 * @return Language default language
	 */
	public function getDefaultLanguage() {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		if (! isset ( $_SESSION ['s_defaultLanguageIso'] )) {
			$this->getLanguages ();
		}
		
		$returnLanguage = $this->getLanguageByIso ( $_SESSION ['s_defaultLanguageIso'] );
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
		return $returnLanguage;
	}
	
	/*
     * Get the current site language
     *
     * @return Language current language
     */
	public function getCurrentLanguage() {
		
		$_SESSION ['logger']->debug ( __METHOD__ . " begin" );
		
		if (! isset ( $_SESSION ['s_languageIso'] )) {
			$this->getLanguages ();
		}
		
		$currentLanguage = $this->getLanguageByIso ( $_SESSION ['s_languageIso'] );
		
		$_SESSION ['logger']->debug ( __METHOD__ . " end" );
		
		return $currentLanguage;
	}
}