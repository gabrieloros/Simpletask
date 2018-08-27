<?php

class MenuManager {
	
	private static function initializeSession() {
	}
	
	public static function getFullMenu($startLevel = 0, $forceAllLevels = false) {
		
		$_SESSION['logger']->debug ( __METHOD__ . ' begin' );
		
		if (! isset ( $startLevel ) || $startLevel != '') {
			$startLevel = $_SESSION ['s_parameters'] ['menu_split_level_2'] > 0 ? $_SESSION ['s_parameters'] ['menu_split_level_2'] - 1 : $_SESSION ['s_parameters'] ['menu_split_level_2'];
		}
		
		$menuLevel2Root = null;
		
		if (! $forceAllLevels) {
			
			$breadcrumb = BreadcrumbManager::getBreadcrum ();
					
			$menuLevel2Root = isset ( $breadcrumb [$startLevel] ) ? $breadcrumb [$startLevel] : '';
			
			$_REQUEST ['BreadcrumbParent'] = $menuLevel2Root;
			
			foreach ( $breadcrumb as $key => $value ) {
				$_REQUEST ['section_selected'] [$key] = $value ['idcontent'];
			}
			
		}
		
		$menuArray = self::getSubMenu ( $startLevel, null, $menuLevel2Root ['idcontent'] );
		
		$_SESSION['logger']->debug ( __METHOD__ . ' end' );
		
		return $menuArray;
	}
	
	public static function setDefaultMenu() {
		
		$_SESSION['logger']->debug ( __METHOD__ . ' begin' );
		
		if (! isset ( $_SESSION ['basicMenu'] ) || $_SESSION ['basicMenu'] == '' || $_SESSION ['basicMenuLanguage'] != $_SESSION ['s_languageIso']) {
			
			$_SESSION ['basicMenuLanguage'] = $_SESSION ['s_languageIso'];
			
			//$endLevel = max ( $_SESSION ['s_parameters'] ['menu_split_level_1'], $_SESSION ['s_parameters'] ['menu_split_level_footer'] );
			
			$startLevel = 0;
			
			$_SESSION ['basicMenu'] = self::getSubMenu ( $startLevel, $_SESSION ['s_parameters'] ['menu_split_level_1'] );
			
		}
		
		$_SESSION['logger']->debug ( __METHOD__ . ' end' );
		
	}
	
	private static function getSubMenu($starLevel, $endLevel = null, $menuLevel2Root = null) {

		$_SESSION['logger']->debug ( __METHOD__ . ' begin' );
		
		$query = Util::getMenuContents ( $_SESSION ['s_languageId'], $_SESSION['loggedUser']->getUserTypeId(), $starLevel, $endLevel );
		
		$connectionManager = ConnectionManager::getInstance();
		
		$rs = $connectionManager->exec($query);
		
		$firstLevel = null;
		
		$toShow = array ($menuLevel2Root );
		
		$subMenu = array ();
		
		while ( $row = $connectionManager->fetch ( $rs ) ) {
			
			if (! isset ( $menuLevel2Root ) || (in_array ( $row ['parentid'], $toShow ) && $menuLevel2Root != '')) {
				
				array_push ( $toShow, $row ['id'] );
				
				if (! isset ( $firstLevel )) {
					$firstLevel = $row ['menulevel'];
				}
				
				if ($row ['menulevel'] == $firstLevel) {
					$subMenu [$row ['id']] = self::setArrayValuesFromRow ( $row );
				} else if ($row ['menulevel'] == $firstLevel + 1) {
					$subMenu [$row ['parentid']] ['submenu'] [$row ['id']] = self::setArrayValuesFromRow ( $row );
				} else {
					$exit = 0;
					$subMenu = self::recursiveArrayCreation ( $subMenu, $row, $exit, $firstLevel );
				}
			}
		}
		
		$_SESSION['logger']->debug ( __METHOD__ . ' end' );
		
		return $subMenu;
		
	}
	
	private static function recursiveArrayCreation($array, $row, &$exit = 0, $count = 0) {
		
		$count ++;
		
		foreach ( $array as $key => $value ) {
			
			if ($exit) {
				break;
			}
			
			if (is_array ( $value )) {
				
				if ($count == $row ['menulevel']) {
					if (array_key_exists ( $row ['parentid'], $array ['submenu'] )) {
						$array ['submenu'] [$row ['parentid']] ['submenu'] [$row ['id']] = self::setArrayValuesFromRow ( $row );
						$exit = 1;
						break;
					}
				} else {
					if ($key == 'submenu') {
						$array [$key] = self::recursiveArrayCreation ( $value, $row, $exit, $count - 1 );
					} else {
						$array [$key] = self::recursiveArrayCreation ( $value, $row, $exit, $count );
					}				
				}
			}
		}
		
		return $array;
		
	}
	
	private static function setArrayValuesFromRow($row) {
		
		$array ['id'] = $row ['id'];
		$array ['menukey'] = $row ['menukey'];
		$array ['title'] = $row ['title'];
		$array ['parentid'] = $row ['parentid'];
		$array ['url'] = $row ['url'];		
		$array ['submenu'] = array ();
		
		return $array;
		
	}

}