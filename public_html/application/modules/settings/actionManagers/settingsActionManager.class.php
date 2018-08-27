<?php

require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/actions/ModuleActionManager.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/settings/views/Settings.view.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/settings/managers/SettingsManager.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/settings/enums/settings.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/common/EnumCommon.class.php';

class settingsActionManager extends ModuleActionManager {
	
	
	protected $manager;
	
	function __construct() {
	
		$this->manager = SettingsManager::getInstance();
	
	
	}
	
		
	public function setOptions(){
	$extensions = array(EnumCommon::KML, EnumCommon::GIF, EnumCommon::JPG, EnumCommon::PNG);
	$path = $_SERVER ['DOCUMENT_ROOT'] .EnumCommon::PATH_LAYERS;
	$settings = array();	
	$layers = array();
	$layers = Util::getFileNames($path, $extensions);
	
	$html = Settings::render($layers,$settings);
	
	require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
	$masterView = MasterFactory::getMaster ();
		
	$view = $masterView->render ( $html );
		
	$render = new RenderActionResponse ( $view );
	
	$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
	
	return $render;
		
	}
	
	/**
	 * upload and import file
	 * @return AjaxRender
	 */
	public function uploadLayer(){
	
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
	
		ignore_user_abort(true);
		set_time_limit(0);
	
		try {
	
			$html = '0#'.$this->manager->uploadFile($_FILES['layerFile']);
	
		} catch (Exception $e) {
	
			$html = '1#'.$html = $e->getMessage();			
		
		}
	
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';
	
		$render = new AjaxRender($html);
	
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
	
		return $render;
	
	}
	
	public function getLayers(){
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		$extensions = array(EnumCommon::KML);
		$path = $_SERVER ['DOCUMENT_ROOT'] .EnumCommon::PATH_LAYERS;
		$layers = Util::getFileNames($path, $extensions);		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		return new AjaxRender(json_encode($layers));
	}
	
	public function getLatLongCenter(){
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		$lat = $this->manager->getParameter('lat_center');
		$long = $this->manager->getParameter('long_center');		
		$latLong = array('latitude'=>$lat, 'longitude'=>$long);		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		return new AjaxRender(json_encode($latLong));	
	}
	
	public function deleteLayer(){
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		$layer=$_REQUEST['layer'];
		$deleted = $this->manager->deleteLayer($layer);
		$response='1';
		if($deleted){
			$response = '0';
			
		}		
				
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		$render = new AjaxRender($response);
		return $render;
	}
}