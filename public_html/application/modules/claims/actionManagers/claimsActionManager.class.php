<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/actions/ModuleActionManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/enums/claims.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/managers/ClaimsManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterGroup.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/managers/AdrUsersManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ClaimRequestPush.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/push/ClaimNotificationPush.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/managers/AdrTasksManager.class.php';


/**
 * @author Gabriel Guzman
 *
 *file claimsActionManager.class.php
 *
 */
class claimsActionManager extends ModuleActionManager {



	protected $manager;
	protected $userManager;
	protected $adrUserManager;
	protected $managerTask;
	function __construct() {


		$this->manager = ClaimsManager::getInstance();
		$this->userManager = UserManager::getInstance();
		$this->managerTask = AdrTasksManager::getInstance ();
		//Load the claims concepts in session
		$this->manager->getClaimsConcepts($_SESSION['loggedUser']->getLocationid());
		$this->userManager->getUsersConcepts();
		$this->adrUserManager = AdrUsersManager::getInstance();
	}


	/* (non-PHPdoc)
	 * @see ModuleActionManager::getList()
	* Claims List
	*/
	public function getList($maxQuantity) {


		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$subConcept = 'claimsList';

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

		// Code filter
		$filters ['code'] = $this->getTextFilter('code', Util::getLiteral('claim_code'), 50, 'claim.code', $subConcept);

		// Phone filter

		$filters ['phone'] = $this->getNumberFilter('requesterphone', Util::getLiteral('requester_phone'), 50, 'claim.requesterphone', $subConcept);
		
		//Entry Date
		/*
		$state = '';
		if(isset($_REQUEST ['filter_state'])){
			
			$state =  $_REQUEST ['filter_state'];
			
		}
		*/
		
		$dateName = 'claim.entrydate';
		$label ='entryDate';	
		$typeDate = 'entry_date';
		
		
		if(isset($_REQUEST['type_date'])){
			
			$typeDate = $_REQUEST['type_date'];
			$_SESSION['type_date'] = $_REQUEST['type_date'];
		}else{
			
			$_SESSION['type_date'] = $typeDate;			
			
		}
		
		
		if($typeDate=='entry_date'){
			$dateName = 'claim.entrydate';
			$label ='entryDate';						
		}else{
			$dateName = 'claim.closedate';
			$label='closeDate';
		}
		

		$filters [$label] = $this->getDateFilter($label, Util::getLiteral('date_between'), $dateName, $subConcept, true);
	
		//States filter
		
		$filters ['state'] = $this->getSelectFilter('state', Util::getLiteral('state'), 'claim.stateid', false, '', true, false, $subConcept);


		//content loading states list
		if(is_array($_SESSION['claimsConcepts']['states'])){
			foreach ($_SESSION['claimsConcepts']['states'] as $key => $element){

				$filters ['state']->addValue($key,Util::getLiteral($element));
			}
		}
		$filters ['state']->addValue(10,"Cerrado despues de 48hs");
		// Region filter
		$regionFilter = new NumberFilter('claim.regionid','',null, 'claim.regionid');
		$regionFilter->setSearchNull(false);
		$filters['region'] = $regionFilter;

		//--------------------------------------------------------------------------|
		//Add new filter field														|
		//modify by Diego Saez														|
		//--------------------------------------------------------------------------|
		//--------------------------------------------------------------------------|

		$filters['systemuser'] = $this->getSelectFilter('systemuser',Util::getLiteral('operator'),'claim.systemuserid',false,'',true,false,$subConcept);

		if(is_array($_SESSION ['usersConcepts']['names'])){
			foreach ($_SESSION ['usersConcepts']['names'] as $key => $element){

				$filters ['systemuser']->addValue($key,$element);
			}
		}
		//sendFilters

		//------------------------------------------------------------------------------------
		//------------------------------------------------------------------------------------

		//$claimPic = $this->manager->getClaimPic();

		$dataUser =  $_SESSION ['userType'];	
		$dataUser = $dataUser ['usertypeid'];
	


		//Count
		$numrows = $this->manager->getClaimsCount($filters);

		$list = array();
		$counters = array();

		if($numrows > 0){
			//List
			$list = $this->manager->getClaims($begin, $count, $filters);

			//Counters
			$counters = $this->manager->getCounters($filters);
		}



		
		//Pager
		$pager = Util::getPager ( $numrows, $begin, $page, $count );

		// Para que no dibuje el filtro en el html
		unset($filters['region']);

		//Filter Group (Form)
		$filterGroup = new FilterGroup ( 'claimsFilter', '', '', '');
		$filterGroup->setFiltersList ( $filters );

		$html = '';
		// $list1 = $this->manager->getExportClaims($filters);

		// var_dump($list1);
		//  die();
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/ClaimsActions.view.php';

		$actions = ClaimsActions::render();

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/ClaimsList.view.php';

		$html .= ClaimsList::render($list, $filterGroup, $pager, $actions, $counters, $dataUser);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

		$masterView = MasterFactory::getMaster ();
			
		$view = $masterView->render ( $html );
			
		$render = new RenderActionResponse ( $view );

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}
	
	/**
	 * Initial import action: show form
	 * @throws UnexpectedValueException
	 * @return RenderActionResponse
	 */
	public function import(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/views/Import.view.php';

		try {

			$origins = $this->manager->getOrigins();

			

			if(count($origins) < 1){
				$_SESSION ['logger']->error("Origins array doesn't contain values");
				throw new UnexpectedValueException("Origins array doesn't contain values");

			}

			$html = Import::render($origins);

		} catch (Exception $e) {

			require_once ($_SERVER ["DOCUMENT_ROOT"] . "/../application/views/ErrorMessage.view.php");

			$html = ErrorMessageView::render ( $e->getMessage () );

		}

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
	public function uploadFile(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		ignore_user_abort(true);
		set_time_limit(0);

		try {

			$html = '0-'.urlencode($this->manager->uploadFile($_FILES['claimsFile']));

		} catch (Exception $e) {

			$html = '1-'.$html = $e->getMessage();

		}

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';

		$render = new AjaxRender($html);

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	/**
	 * Pending Teleprom Claims list
	 * @return RenderActionResponse
	 */
	public function getPendingTelepromClaimsList() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$subConcept = 'pendingTelepromClaimsList';

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

		//Date range filter
		$filters [] = $this->getDateFilter('entryDate', Util::getLiteral('date_between'), 'claim.entrydate', $subConcept);

		//Count
		$numrows = $this->manager->getPendingTelepromClaimsCount($filters);

		//List
		$list = array();

		if($numrows > 0){
			$list = $this->manager->getPendingTelepromClaims($begin, $count, $filters);
		}

		//Pager
		$pager = Util::getPager ( $numrows, $begin, $page, $count );

		//Filter Group (Form)
		$filterGroup = new FilterGroup ( 'pendingTelepromClaimsFilter', '', '', '' );
		$filterGroup->setFiltersList ( $filters );

		$html = '';

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/PendingTelepromClaimsList.view.php';

		$html .= PendingTelepromClaimsList::render($list, $filterGroup, $pager);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

		$masterView = MasterFactory::getMaster ();
			
		$view = $masterView->render ( $html );
			
		$render = new RenderActionResponse ( $view );

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	/**
	 * Updates claim state
	 * @return RenderActionResponse
	 */
	public function changeClaimState(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try {
			if(isset($_REQUEST['claimId']) && !isset($_REQUEST['massiveActions'])){
				$_REQUEST['massiveActions'] = array($_REQUEST['claimId']);
			}

			$result = $this->manager->changeClaimState($_REQUEST['stateId'], $_REQUEST['massiveActions']);
			
			if($result){			
							
					
				//Verificamos que el reclamo tenga un usuario asignado para enviarle la notificación
				$claims = $_REQUEST['massiveActions'];
				foreach ( $claims as $claimId ) {
					
					$claim = $this->manager->getClaim($claimId);
					
				if($claim->getAssigned() && $claim->getUserId() != null && $claim->getStateId()){
				
					$user  = $this->adrUserManager->getUser($claim->getUserId());
					$registrationId = $user->getRegistrationId();
					$command = '';
					$send = false;
					if($_REQUEST['stateId'] == claimsConcepts::CLOSEDSTATE || $_REQUEST['stateId'] == claimsConcepts::CANCELLEDSTATE){
						$command = claimsConcepts::PUSH_ACTION_DELETE;	
						$send = true;					
					}
					
					if(isset($registrationId) && $send){
						$crp = new ClaimRequestPush(array($registrationId), $claim, $command);
						$cnp = new ClaimNotificationPush();
						$cnp->sendClaimNotificationPush($crp);
					}else{
							
						$_SESSION ['logger']->info('No se envió notificacion push debido a que el usuario '.$claim->getUserId(). ' no tiene registrationid o el cambio de estado no es el correcto');
							
					}
				}				

				}			
				
			}			
			
			
		}
		catch (Exception $e) {
			$result = false;
		}

		
		
		
		if($result){
			$message = 'Se actualizaron los estados correctamente.';
		}
		else{
			$message = 'Error al actualizar los estados.';
		}

		$message .= '<br /><br /><a href="/'.$_REQUEST['urlargs'][0].'/'.$_REQUEST['urlargs'][1].'">'.Util::getLiteral('back').'</a> ';

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/ActionMessage.view.php';

		$html = ActionMessage::render($message);

		$masterView = MasterFactory::getMaster();

		$view = $masterView->render($html);
			
		$render = new RenderActionResponse ( $view );

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	/**
	 * Updates state for not geolocated claims
	 * @return RenderActionResponse
	 */
	public function changeClaimStateNoGeo(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try {
			if(isset($_REQUEST['claimId']) && !isset($_REQUEST['massiveActions'])){
				$_REQUEST['massiveActions'] = array($_REQUEST['claimId']);
			}

			$result = $this->manager->changeClaimState($_REQUEST['stateId'], $_REQUEST['massiveActions']);
		}
		catch (Exception $e) {
			$result = false;
		}

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';

		$html = BasicAjaxMessageResponse::render($message, $result);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';

		$render = new AjaxRender($html);

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}


	/**
	 * Updates Teleprom Claim data
	 * @return AjaxRender
	 */
	public function updateTelepromClaim(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try {
			$result = $this->manager->updateTelepromClaim($_REQUEST['claimId'], $_POST);
			$message = 'Se actualizó el reclamo correctamente';
		}
		catch (Exception $e) {
			$message = $e->getMessage();
			$result = false;
		}

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';

		$html = BasicAjaxMessageResponse::render($message, $result);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';

		$render = new AjaxRender($html);

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	/**
	 * Export process
	 * @return RenderActionResponse
	 */
	public function export(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try{

			set_time_limit(0);

			$subConcept = 'claimsList';

			$filters = array ();

			// Code filter
			$filters ['code'] = $this->getTextFilter('code', Util::getLiteral('claim_code'), 50, 'claim.code', $subConcept);

			// Phone filter
			$filters ['phone'] = $this->getNumberFilter('requesterphone', Util::getLiteral('requester_phone'), 50, 'claim.requesterphone', $subConcept);
/*
			if (count($this->getValueSelectFilter('state',   false, $subConcept))>0){
					
				$state = $this->getValueSelectFilter('state',   false, $subConcept);
				
				// si se filtro por estado pendiente, baja o baja sin georreferencia aplicará sobre fecha de entrada
				if($state== claimsConcepts::PENDINGSTATE || $state == claimsConcepts::CANCELLEDSTATE || $state == claimsConcepts::CLOSEDSTATENOGEO){
					//Date range filter date close
					
					$filters ['entryDate'] = $this->getDateFilter('entryDate', Util::getLiteral('date_between'), 'claim.entrydate', $subConcept);
				}else{
					//Date range filter date register
					
					$filters ['entryDate'] = $this->getDateFilter('closeDate', Util::getLiteral('date_between'), 'claim.closedate', $subConcept);
				}		
				
			}else{
				//Date range filter date register
				$filters ['entryDate'] = $this->getDateFilter('entryDate', Util::getLiteral('date_between'), 'claim.entrydate', $subConcept);
			}
*/
			$dateName = 'claim.entrydate';
			$label ='entryDate';
			$typeDate = 'entry_date';
			
			/*
			if(isset($_REQUEST['type_date'])){
					
				$typeDate = $_REQUEST['type_date'];
				$_SESSION['type_date'] = $_REQUEST['type_date'];
			}else{
					
				$_SESSION['type_date'] = $typeDate;
					
			}
			*/
			
			if(isset($_SESSION['type_date'])){
				$typeDate = $_SESSION['type_date'];
				
			}
			
			
			if($typeDate=='entry_date'){
				$dateName = 'claim.entrydate';
				$label ='entryDate';
			}else{
				$dateName = 'claim.closedate';
				$label='closeDate';
			}
				
			$filters [$label] = $this->getDateFilter($label, Util::getLiteral('date_between'), $dateName, $subConcept);
			
			
			
			//States filter

			$filters ['states'] = $this->getSelectFilter('state', Util::getLiteral('state'), 'claim.stateid', false, '', true, false, $subConcept);

			if(is_array($_SESSION['claimsConcepts']['states'])){
				foreach ($_SESSION['claimsConcepts']['states'] as $key => $element){
					echo 'Clave'.$key.' Valor'.$element;
					$filters ['states']->addValue($key,Util::getLiteral($element));
				}
			}
			$filters['systemuser'] = $this->getSelectFilter('systemuser',Util::getLiteral('operator'),'claim.systemuserid',false,'',true,false,$subConcept);

			if(is_array($_SESSION ['usersConcepts']['names'])){
				foreach ($_SESSION ['usersConcepts']['names'] as $key => $element){

					$filters ['systemuser']->addValue($key,$element);
				}
			}

			//List
			$list = $this->manager->getExportExcelClaims($filters);
		
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/ExportXLS.view.php';

			$export = new ExportXLS();

			$headerTitle = array('','Reclamos');
			$headerReportofDate = array('','FECHA DE INFORME:');
			$headerDate =  array('','FECHA:');
			$headerCounts = array('','PENDIENTE','','CERRADO','','BAJA','','BAJA SIN GEO','');
			$headerTable =array('','IDENTIFICADOR','FECHA DE INGRESO','FECHA DE CIERE','TERMINADO HACE','ESTADO','SOLICITANTE','TELEFONO','DIRECCION RECLAMO','DETALLE DE INGRESO','ORIGEN DE INGRESO','OPERARIO','MATERIAL 1','MATERIAL 2','MATERIAL 3','MATERIAL 4','MATERIAL 5','DETALLE DE CIERRE');
	
			$html = $export->export($headerTitle,$headerReportofDate,$headerDate,$headerCounts,$headerTable, $list);

			$render = new RenderActionResponse ( $html );

		}
		catch (Exception $e){

			$html = $e->getMessage();

			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

			$masterView = MasterFactory::getMaster ();

			$view = $masterView->render ( $html );

			$render = new RenderActionResponse ( $view );

		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}
	
	/**
	 * Get streets information through ajax
	 * @return AjaxRender
	 */
	public function getStreetFromAutoComplete(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$streets = array();

		try{

			$fieldValue = html_entity_decode(str_replace('%amp;', '&', $_REQUEST['fieldValue']), ENT_NOQUOTES);

			//Filters
			$filters = array ();
			$filter = $this->getTextFilter('street', '', 100, 'street', '');
			$filter->setSelectedValue ( $fieldValue );
			$filters [] = $filter;

			//Order
			$orders = array();
			$order = new Order('street', 'ASC', true);
			$orders [] = $order;

			//Get List
			$results = Util::loadPhoneDirectoryData($filters, $orders);

			$streetRef = null;
			$counter = 1;

			foreach ($results as $result){

				if($counter <= 10){
					if(trim($result['street']) != $streetRef){
						$streets [] = array("id"=>$result['id'], "value" => htmlentities(trim($result['street']), ENT_NOQUOTES, 'UTF-8'));
						$streetRef = trim($result['street']);
						$counter ++;
					}
				}
				else{
					break;
				}

			}
		}
		catch (Exception $e){
			$streets [] = array("id"=>"", "value" => "Error al obtener las calles");
		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return new AjaxRender(json_encode($streets));

	}

	/**
	 * Get Street Numbers through ajax
	 * @return AjaxRender
	 */
	public function getStreetNumbers(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$numbers = array();

		try{

			$fieldValue = html_entity_decode(str_replace('%amp;', '&', $_REQUEST['fieldValue']), ENT_NOQUOTES);

			//Filters
			$filters = array ();
			$filter = $this->getTextFilter('street', '', 100, 'street', '');
			$filter->setSelectedValue ( $fieldValue );
			$filters [] = $filter;

			//Order
			$orders = array();
			$order = new Order('street_number', 'ASC', true);
			$orders [] = $order;

			//Get List
			$results = Util::loadPhoneDirectoryData($filters, $orders);

			$numberRef = null;
			$additionalAddressRef = null;

			foreach ($results as $result){

				if(trim($result['street_number']) != $numberRef && trim($result['street_number']) != null){
					$numbers [] = array("id"=>$result['id'], "value" => trim($result['street_number']));
					$numberRef = trim($result['street_number']);
				}
				if(trim($result['additional_address']) != $additionalAddressRef && trim($result['additional_address']) != null){
					$numbers [] = array("id"=>$result['id'], "value" => trim($result['additional_address']));
					$additionalAddressRef = trim($result['additional_address']);
				}

			}
		}
		catch (Exception $e){
			$numbers [] = array("id"=>"", "value" => "Error al obtener los números de calle");
		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return new AjaxRender(json_encode($numbers));

	}

	/**
	 * Loads a google map though ajax
	 * @return AjaxMessageBox
	 */
	public function loadMapAjax(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try{

			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/GeoLocation.class.php';

			$geoLocation = new GeoLocation();

			$address = trim($_REQUEST['address']);

			$fullAddress = $address . ' ' . $_SESSION['loggedUser']->getLocationname() . ' ' . $_SESSION['loggedUser']->getProvincename();

			$html = $geoLocation->getSelectorMapAjax($address, $fullAddress, $_REQUEST['elementId']);

		}
		catch (Exception $e){
			$html = $e->getMessage();
		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return new AjaxMessageBox ( $html, null, Util::getLiteral('select_location') );

	}

	/**
	 * Get the list of claims that are pendig of geolocation
	 * @return RenderActionResponse
	 */
	public function getGeoLocationPendingList() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$subConcept = 'pengingGeoLocationList';

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

		// Region filter
		$regionFilter = new NumberFilter('claim.regionid','',null, 'claim.regionid');
		$regionFilter->setSearchNull(true);
		$filters['region'] = $regionFilter;

		//Count
		$numrows = $this->manager->getClaimsCount($filters);

		$list = array();

		if($numrows > 0){
			//List
			$list = $this->manager->getClaims($begin, $count, $filters);
		}

		$regions = $this->manager->getRegionsStatsForClaims($_SESSION['loggedUser']->getDependencyid(), null);

		//Pager
		$pager = Util::getPager ( $numrows, $begin, $page, $count );

		$html = '';

		//Map selector
		if($numrows > 0){
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/EmbeddedSelectorMap.view.php';
			$html .= EmbeddedSelectorMap::render($regions);
		}

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/GeoLocationClaimsList.view.php';

		$html .= GeoLocationClaimsList::render($list, $pager);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

		$masterView = MasterFactory::getMaster ();
			
		$view = $masterView->render ( $html );
			
		$render = new RenderActionResponse ( $view );

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	/**
	 * Updates claim geo location through ajax
	 * @return AjaxRender
	 */
	public function updateClaimGeoLocation(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try{
			$result = $this->manager->updateClaim($_REQUEST['elementId'], $_POST);
			$message = 'Se actualizó el reclamo correctamente';
		}
		catch (Exception $e){
			$message = $e->getMessage();
			$result = false;
		}

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';

		$html = BasicAjaxMessageResponse::render($message, $result);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';

		$render = new AjaxRender($html);

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	/**
	 * Claim stats group by dependency
	 * @return RenderActionResponse
	 */
	public function getClaimsStats(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try{
			$subConcept = 'claimsStatsList';

			$filters = array();

			//Date range filter
			$filters [] = $this->getDateFilter('entryDate', Util::getLiteral('date_between'), 'claim.entrydate', $subConcept);

			$regions = $this->manager->getRegionsStatsForClaims($_SESSION['loggedUser']->getDependencyid(), null);

			//Filter Group (Form)
			$filterGroup = new FilterGroup ( 'claimsStatsFilter', '', '', '');
			$filterGroup->setFiltersList ( $filters );

			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/Stats.view.php';
			$html = Stats::render($regions, $filterGroup);

		} catch (Exception $e){
			$html = $e->getMessage();
		}

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

		$masterView = MasterFactory::getMaster ();

		$view = $masterView->render ( $html );

		$render = new RenderActionResponse ( $view );

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	/**
	 * Get the stats by region for a date.
	 * @param integer $regionId
	 * @param Date $initDate
	 * @param Date $endDate
	 * @return html
	 */
	public function getStatsByRegion() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try{

			$regionId = $_REQUEST['regionid'];
			$initDate = $_REQUEST['initdate'];
			$endDate = $_REQUEST['enddate'];

			$filters = array ();

			//Date range filter
			if((isset($initDate) && $initDate != null) || (isset($endDate) && $endDate != null)) {
				$betweenDateFilter = new DateRangeFilter('claim.entrydate');
				$betweenDateFilter->setLeftValue($initDate);
				$betweenDateFilter->setRightValue($endDate);
				$filters [] = $betweenDateFilter;
			}

			$stateFilter = new NumberFilter('claim.stateid','',null, 'claim.stateid');
			/* Pending */
			$stateFilter->setSelectedValue(1);
			$filters [] = $stateFilter;
			$cantPending = $this->manager->getCountStatsByRegion($regionId, $filters);

			/* Closed */
			$stateFilter->setSelectedValue(2);
			$cantClosed = $this->manager->getCountStatsByRegion($regionId, $filters);

			/* Cancelled */
			$stateFilter->setSelectedValue(3);
			$cantCancelled = $this->manager->getCountStatsByRegion($regionId, $filters);

			/* Region Name */
			$region = $this->manager->getRegionById($regionId);

			$data = array(
					'name'		=> $region->getName(),
					'pending'	=> $cantPending,
					'closed'	=> $cantClosed,
					'cancelled'	=> $cantCancelled
			);

			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/InfoWindows.view.php';
			$html = InfoWindows::render($data);

		} catch (Exception $e){
			$html = $e->getMessage();
		}

		return new AjaxMessageBox ( $html, null, null );

	}

	/**
	 * Get the list of claims shown in a map
	 * @return AjaxMessageBox
	 */
	public function mapClaims(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try{

			$subConcept = 'claimsList';

			$filters = array ();

			// Code filter
			$filters ['code'] = $this->getTextFilter('code', Util::getLiteral('claim_code'), 50, 'claim.code', $subConcept);

			// Phone filter
			$filters ['phone'] = $this->getNumberFilter('requesterphone', Util::getLiteral('requester_phone'), 50, 'claim.requesterphone', $subConcept);

			$dateName = 'claim.entrydate';
			$label ='entryDate';
			$typeDate = 'entry_date';
			
			
			if(isset($_REQUEST['type_date'])){
					
				$typeDate = $_REQUEST['type_date'];
				$_SESSION['type_date'] = $_REQUEST['type_date'];
			}else{
					
				$_SESSION['type_date'] = $typeDate;
					
			}
			
			
			if($typeDate=='entry_date'){
				$dateName = 'claim.entrydate';
				$label ='entryDate';
			}else{
				$dateName = 'claim.closedate';
				$label='closeDate';
			}
			
			
			$filters [$label] = $this->getDateFilter($label, Util::getLiteral('date_between'), $dateName, $subConcept, true);
				
			
			//Date range filter
// 			$filters [] = $this->getDateFilter('entryDate', Util::getLiteral('date_between'), 'claim.entrydate', $subConcept);

			//States filter
			$filters ['states'] = $this->getSelectFilter('state', Util::getLiteral('state'), 'claim.stateid', false, '', true, false, $subConcept);

			$filters['systemuser'] = $this->getSelectFilter('systemuser',Util::getLiteral('operator'),'claim.systemuserid',false,'',true,false,$subConcept);

			if(is_array($_SESSION['claimsConcepts']['states'])){
				foreach ($_SESSION['claimsConcepts']['states'] as $key => $element){
					$filters ['states']->addValue($key,Util::getLiteral($element));
				}
			}

			//List
			$list = $this->manager->getExportClaims($filters);

			// var_dump($list);
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/MapClaims.view.php';

			$html = MapClaims::render($list);

		}
		catch (Exception $e){

			$html = $e->getMessage();

		}
			
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return new AjaxMessageBox ( $html, null, Util::getLiteral('claims_map') );

	}

	/**
	 * Get the teleprom stats
	 * @return RenderActionResponse
	 */
	public function getTelepromStats(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try {

			$subConcept = 'pendingTelepromClaimsList';

			$filters = array ();

			//Date range filter
			$filters [] = $this->getDateFilter('entryDate', Util::getLiteral('date_between'), 'claim.entrydate', $subConcept);

			$stats = $this->manager->getTelepromStats($_SESSION['loggedUser']->getDependencyid(), $filters);

			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/TelepromStatsXLS.view.php';

			$export = new TelepromStatsXLS();

			$header = array("DATUM", "Causa", "TOTAL");

			$html = $export->export($header, $stats);

			$render = new RenderActionResponse ( $html );

		}
		catch (Exception $e){

			$html = $e->getMessage();

			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

			$masterView = MasterFactory::getMaster ();

			$view = $masterView->render ( $html );

			$render = new RenderActionResponse ( $view );

		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	public function getClaimPic(){

		$claimPic = $this->manager->getClaimPic($_REQUEST['claimId']);


		if ($claimPic !=  null){
			$pic=$claimPic->getPhoto();


			$response = array('pic'=>$pic);

		}

		return new AjaxRender(json_encode($response));

	}


	/**
	 * Edit or add a claim
	 * @return RenderActionResponse
	 */
	
	  public function claimPic() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		//Causes
		$causeList = array();

		if(!isset($_REQUEST['claimId']) || $_REQUEST['claimId'] == 'undefined') {
			$claim = new Claim(null, null);

			$claimPic = new ClaimPic(null,null);

			$claim->setTypeAddress(null);

		} else {
			
			
			$claimPic = $this->manager->getClaimPic($_REQUEST['claimId']);

			$claim = $this->manager->getClaim($_REQUEST['claimId']);
			
			
		}



		//Subject
		$subjectList = $this->manager->getSubjectsList();

		//Input types
		$inputTypeList = $this->manager->getInputTypesList();

		//Dependencies
		$dependencyList = $this->manager->getDependenciesList();

		//States
		$stateList = $this->manager->getStatesList();

		$html = '';

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/ClaimViewPic.view.php';

		$countMapCity = $this->manager->getCountMapCity();
		$typeAddress = $countMapCity > 0;

		$html .= ClaimPicView::render($claimPic,$claim, $subjectList, $inputTypeList, $causeList, $dependencyList, $stateList, $typeAddress);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

		$masterView = MasterFactory::getMaster ();

		$view = $masterView->render ( $html );

		$render = new RenderActionResponse ( $view );

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}
	 


	/**
	 * Edit or add a claim
	 * @return RenderActionResponse
	 */
	public function editClaim() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		//Causes
		$causeList = array();

		if(!isset($_REQUEST['claimId']) || $_REQUEST['claimId'] == 'undefined') {
			$claim = new Claim(null, null);
			$claim->setTypeAddress(null);
			
		} else {
			$claim = $this->manager->getClaim($_REQUEST['claimId']);
			$typeAddress = null;
			if($claim->getTypeAddressId() != null){
				$typeAddress = $this->manager->getTypeAddressById($claim->getTypeAddressId());
				
			}
			
			$claim->setTypeAddress($typeAddress);
			
			
			//Causes by subject
			$causeList = $this->manager->getCausesBySubject($claim->getSubjectId());
		}

		//Subject
		$subjectList = $this->manager->getSubjectsList();

		//Input types
		$inputTypeList = $this->manager->getInputTypesList();

		//Dependencies
		$dependencyList = $this->manager->getDependenciesList();

		//States
		$stateList = $this->manager->getStatesList();

		$html = '';

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/ClaimNewEdit.view.php';

		$countMapCity = $this->manager->getCountMapCity();
		$typeAddress = $countMapCity > 0;
		//var_dump($claim);
		//die();
		$html .= ClaimNewEdit::render($claim, $subjectList, $inputTypeList, $causeList, $dependencyList, $stateList, $typeAddress);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

		$masterView = MasterFactory::getMaster ();
			
		$view = $masterView->render ( $html );
			
		$render = new RenderActionResponse ( $view );

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	
	/**
	 * Crear claims Multiple
	 * @return RenderActionResponse
	 */
	public function newClaims() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		//Causes
		$causeList = array();

		if(!isset($_REQUEST['claimId']) || $_REQUEST['claimId'] == 'undefined') {
			$claim = new Claim(null, null);
			$claim->setTypeAddress(null);
			
		} else {
			$claim = $this->manager->getClaim($_REQUEST['claimId']);
			$typeAddress = null;
			if($claim->getTypeAddressId() != null){
				$typeAddress = $this->manager->getTypeAddressById($claim->getTypeAddressId());
				
			}
			
			$claim->setTypeAddress($typeAddress);
			
			
			//Causes by subject
			$causeList = $this->manager->getCausesBySubject($claim->getSubjectId());
		}

		//Subject
		$subjectList = $this->manager->getSubjectsList();

		//Input types
		$inputTypeList = $this->manager->getInputTypesList();

		//Dependencies
		$dependencyList = $this->manager->getDependenciesList();

		//States
		$stateList = $this->manager->getStatesList();
		$groupsList=$this->managerTask->getListGroups();
		$usersList = $this->adrUserManager->getListUsers();

		$html = '';

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/ClaimsNewMultiple.view.php';

		$countMapCity = $this->manager->getCountMapCity();
		$typeAddress = $countMapCity > 0;
		// var_dump($usersList);
		// die();
		$html .= ClaimsNewMultiple::render($claim, $subjectList, $inputTypeList, $causeList, $dependencyList, $stateList, $typeAddress, $usersList,$groupsList);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

		$masterView = MasterFactory::getMaster ();
			
		$view = $masterView->render ( $html );
			
		$render = new RenderActionResponse ( $view );

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	/**
	 * Save the claim content
	 * @return AjaxRender
	 */
	public function saveClaim() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try {
			//Check required fields
			if (! isset ( $_POST['subjectId'] ) || $_POST['subjectId'] == null) {
				self::$logger->error ( 'subject parameter expected' );
				throw new InvalidArgumentException ( 'subject parameter expected' );
			}

			if (! isset ( $_POST['inputTypeId'] ) || $_POST['inputTypeId'] == null) {
				self::$logger->error ( 'inputTypeId parameter expected' );
				throw new InvalidArgumentException ( 'inputTypeId parameter expected' );
			}

			if (! isset ( $_POST['causeId'] ) || $_POST['causeId'] == null) {
				self::$logger->error ( 'causeId parameter expected' );
				throw new InvalidArgumentException ( 'causeId parameter expected' );
			}

			//hidden field
			// 			if (! isset ( $_POST['originId'] ) || $_POST['originId'] == null) {
			// 				self::$logger->error ( 'originId parameter expected' );
			// 				throw new InvalidArgumentException ( 'originId parameter expected' );
			// 			}

			if (! isset ( $_POST['dependencyId'] ) || $_POST['dependencyId'] == null) {
				self::$logger->error ( 'dependencyId parameter expected' );
				throw new InvalidArgumentException ( 'dependencyId parameter expected' );
			}

			if (! isset ( $_POST['stateId'] ) || $_POST['stateId'] == null) {
				self::$logger->error ( 'stateId parameter expected' );
				throw new InvalidArgumentException ( 'stateId parameter expected' );
			}

			if (! isset ( $_POST['entryDate'] ) || $_POST['entryDate'] == null) {
				self::$logger->error ( 'entryDate parameter expected' );
				throw new InvalidArgumentException ( 'entryDate parameter expected' );
			}

			if (! isset ( $_POST['requesterName'] ) || $_POST['requesterName'] == null) {
				self::$logger->error ( 'requesterName parameter expected' );
				throw new InvalidArgumentException ( 'requesterName parameter expected' );
			}

			if (! isset ( $_POST['requesterPhone'] ) || $_POST['requesterPhone'] == null) {
				self::$logger->error ( 'requesterPhone parameter expected' );
				throw new InvalidArgumentException ( 'requesterPhone parameter expected' );
			}

			if (! isset ( $_POST['claimAddress'] ) || $_POST['claimAddress'] == null) {
				self::$logger->error ( 'claimAddress parameter expected' );
				throw new InvalidArgumentException ( 'claimAddress parameter expected' );
			}

		//	if (!isset($_FILES["imagen"]) || $_FILES["imagen"]["error"] > 0)
		//	{
			//	self::$logger->error ( 'imagen no se recibio ninguna imagen' );

		//	}
	
			
			$result = $this->manager->saveManualClaim($_REQUEST['id'], $_POST);
			$message = 'Se actualizó el reclamo correctamente';
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != null && $_REQUEST['id'] != 0 && $_REQUEST['id'] !='' && ! empty($_REQUEST['id'])){
				
			$claim = $this->manager->getClaim($_REQUEST['id']);

			
			//Verificamos que el reclamo tenga un usuario asignado para enviarle la notificación y el estado sea pendiente
			
			if($claim->getAssigned() && $claim->getUserId() != null && $claim->getStateId() == claimsConcepts::PENDINGSTATE){
				
				$user  = $this->adrUserManager->getUser($claim->getUserId());
				$registrationId = $user->getRegistrationId();
				
				if(isset($registrationId)){
				$crp = new ClaimRequestPush(array($registrationId), $claim, claimsConcepts::PUSH_ACTION_UPDATE);
				$cnp = new ClaimNotificationPush();
				$cnp->sendClaimNotificationPush($crp);					
				}else{
					
					$_SESSION ['logger']->info('No se envió notificacion push debido a que el usuario '.$claim->getUserId(). ' no tiene registrationid');
					
				}
												
			}
			}
			
		}
		catch (Exception $e) {
			$message = $e->getMessage();
			$result = false;
		}

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';

		$html = BasicAjaxMessageResponse::render($message, $result);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';

		$render = new AjaxRender($html);

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}
	/**
	 * Save the claim content
	 * @return AjaxRender
	 */
	public function saveClaims() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try {
			//Check required fields
			if (! isset ( $_POST['subjectId'] ) || $_POST['subjectId'] == null) {
				self::$logger->error ( 'subject parameter expected' );
				throw new InvalidArgumentException ( 'subject parameter expected' );
			}

			if (! isset ( $_POST['inputTypeId'] ) || $_POST['inputTypeId'] == null) {
				self::$logger->error ( 'inputTypeId parameter expected' );
				throw new InvalidArgumentException ( 'inputTypeId parameter expected' );
			}

			if (! isset ( $_POST['causeId'] ) || $_POST['causeId'] == null) {
				self::$logger->error ( 'causeId parameter expected' );
				throw new InvalidArgumentException ( 'causeId parameter expected' );
			}

			if (! isset ( $_POST['dependencyId'] ) || $_POST['dependencyId'] == null) {
				self::$logger->error ( 'dependencyId parameter expected' );
				throw new InvalidArgumentException ( 'dependencyId parameter expected' );
			}

			if (! isset ( $_POST['stateId'] ) || $_POST['stateId'] == null) {
				self::$logger->error ( 'stateId parameter expected' );
				throw new InvalidArgumentException ( 'stateId parameter expected' );
			}

			if (! isset ( $_POST['entryDate'] ) || $_POST['entryDate'] == null) {
				self::$logger->error ( 'entryDate parameter expected' );
				throw new InvalidArgumentException ( 'entryDate parameter expected' );
			}

			if (! isset ( $_POST['requesterName'] ) || $_POST['requesterName'] == null) {
				self::$logger->error ( 'requesterName parameter expected' );
				throw new InvalidArgumentException ( 'requesterName parameter expected' );
			}

			if (! isset ( $_POST['requesterPhone'] ) || $_POST['requesterPhone'] == null) {
				self::$logger->error ( 'requesterPhone parameter expected' );
				throw new InvalidArgumentException ( 'requesterPhone parameter expected' );
			}

			
			$result = $this->manager->saveManualClaim($_REQUEST['id'], $_POST);
			$message = 'Se actualizó el reclamo correctamente';
			if(isset($_REQUEST['id']) && $_REQUEST['id'] != null && $_REQUEST['id'] != 0 && $_REQUEST['id'] !='' && ! empty($_REQUEST['id'])){
				
			$claim = $this->manager->getClaim($_REQUEST['id']);

			
			//Verificamos que el reclamo tenga un usuario asignado para enviarle la notificación y el estado sea pendiente
			
			if($claim->getAssigned() && $claim->getUserId() != null && $claim->getStateId() == claimsConcepts::PENDINGSTATE){
				
				$user  = $this->adrUserManager->getUser($claim->getUserId());
				$registrationId = $user->getRegistrationId();
				
				if(isset($registrationId)){
				$crp = new ClaimRequestPush(array($registrationId), $claim, claimsConcepts::PUSH_ACTION_UPDATE);
				$cnp = new ClaimNotificationPush();
				$cnp->sendClaimNotificationPush($crp);					
				}else{
					
					$_SESSION ['logger']->info('No se envió notificacion push debido a que el usuario '.$claim->getUserId(). ' no tiene registrationid');
					
				}
												
			}
			}
			
		}
		catch (Exception $e) {
			$message = $e->getMessage();
			$result = false;
		}

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';

		$html = BasicAjaxMessageResponse::render($message, $result);

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';

		$render = new AjaxRender($html);

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return $render;

	}

	public function getCausesBySubject() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$causes = array();
		try{
			if (! isset ($_REQUEST['subjectId']) || $_REQUEST['subjectId'] == null) {
				self::$logger->error ( 'subjectId parameter expected' );
				throw new InvalidArgumentException ( 'subjectId parameter expected' );
			}

			//Get List
			$list = $this->manager->getCausesBySubject($_REQUEST['subjectId']);

			/* @var $cause Cause */
			foreach ($list as $cause) {

				$causes [] = array(
						"id"	=> $cause->getId(),
						"name"  => $cause->getName()
				);

			}
			
		} catch (Exception $e){
			$causes = array();
		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return new AjaxRender(json_encode($causes));

	}
	/**
	 * @return AjaxMessageBox
	 */
	public function mapGeoPositioningForMultipleClaims(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try{

			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/MapNewMultipleClaims.view.php';

			$html = MapNewMultipleClaims::render($_REQUEST['lat'],$_REQUEST['lon'],$_REQUEST['title']);

		}
		catch (Exception $e){

			$html = $e->getMessage();

		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return new AjaxConfirmBox( $html, null, Util::getLiteral('claims_map') );

	}
	/**
	 * Get a map for showing the current claim position to re positioning or to defining a new position
	 * @return AjaxMessageBox
	 */
	public function mapGeoPositioningClaims(){

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		try{

			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/views/MapNewEditClaim.view.php';

			$html = MapNewEditClaim::render($_REQUEST['lat'],$_REQUEST['lon'],$_REQUEST['title']);

		}
		catch (Exception $e){

			$html = $e->getMessage();

		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );

		return new AjaxConfirmBox( $html, null, Util::getLiteral('claims_map') );

	}

	//TODO:
	function getClaimDetail() {

	}

	
	//---- Nueva interfaz de editar/crear nuevo reclamo
	public function getClaimStreetForAutoComplete(){
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		$streets = array();
		try {
			$fieldValue = $_REQUEST['fieldValue'];
			$filters = array();
			$filter = $this->getTextFilter('map_city.street', '', 100, 'map_city.street', '');
			$filter->setSelectedValue($fieldValue);
			$filters[]=$filter;
			$results= $this->manager->getAllClaimStreet($filters);
			$counter = 1;
			foreach ($results as $result) {
				if($counter <= 10) {
					$streets [] = array(
							"value" => $result['street']
					);
					$counter ++;
				} else{
					break;
				}
			}
		} catch (Exception $e) {
			$_SESSION ['logger']->debug ( $e->getMessage());
		}
		return new AjaxRender(json_encode($streets));
	}
	
	public function getNumberStreetForAutoComplete(){
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		$numbers = array();
		try {
			$fieldValue =  $_REQUEST['fieldValue'];
			$streetName = $_REQUEST['dependencyValue'];
			$filters = array();
			$filterValue = $this->getTextFilter('map_city.number', '', 100, 'map_city.number', '');
			$filterStreet = $this->getSelectFilter('map_city.street', '', 'map_city.street', false, '', false, true, 'map_city.street');
			$filterValue->setSelectedValue($fieldValue);
			$filterStreet->setSelectedValue("'".$streetName."'");
			$filters[]=$filterValue;
			$filters[]=$filterStreet;
			$results = $this->manager->getAllNumberStreet($filters);
			$counter = 1;
			foreach ($results as $result) {
				if($counter <= 10) {
					$numbers [] = array(
							"value" => $result['number']
					);
					$counter ++;
				} else{
					break;
				}
			}
	
		} catch (Exception $e) {
			$_SESSION ['logger']->debug ( $e->getMessage());
		}
			
		return new AjaxRender(json_encode($numbers));
	
	}
	public function getDistrictForAutoComplete(){
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		$districts= array();
		try {
			$fieldValue =  $_REQUEST['fieldValue'];
			$filters = array();
			$filterValue = $this->getTextFilter('map_city.district', '', 100, 'map_city.district', '');
			$filterValue->setSelectedValue($fieldValue);
			$filters[]=$filterValue;
			$results = $this->manager->getAllDistrict($filters);
			$counter = 1;
			foreach ($results as $result) {
				if($counter <= 10) {
					$districts [] = array(
							"value" => $result['district']
					);
					$counter ++;
				} else{
					break;
				}
			}
	
		} catch (Exception $e) {
			$_SESSION ['logger']->debug ( $e->getMessage());
		}
		return new AjaxRender(json_encode($districts));
	
	}
	
	public function getAllBlockDistrictForAutoComplete(){
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		$blocks = array();
		try {
			$fieldValue =  $_REQUEST['fieldValue'];
			$districtName = $_REQUEST['dependencyValue'];
			$filters = array();
			$filterValue = $this->getTextFilter('map_city.block', '', 100, 'map_city.block', '');
			$filterStreet = $this->getSelectFilter('map_city.district', '', 'map_city.district', false, '', false, true, 'map_city.district');
			$filterValue->setSelectedValue($fieldValue);
			$filterStreet->setSelectedValue("'".$districtName."'");
			$filters[]=$filterValue;
			$filters[]=$filterStreet;
			$results = $this->manager->getAllBlockDistrict($filters);
			$counter = 1;
			foreach ($results as $result) {
				if($counter <= 10) {
					$blocks [] = array(
							"value" => $result['block']
					);
					$counter ++;
				} else{
					break;
				}
			}
	
		} catch (Exception $e) {
			$_SESSION ['logger']->debug ( $e->getMessage());
		}
			
		return new AjaxRender(json_encode($blocks));
	
	}
	
	public function getAllHomeBlockForAutoComplete(){
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		$homes = array();
		$parameters = $_REQUEST['dependencyValue'];
		$fieldValue =  $_REQUEST['fieldValue'];
		if(is_array($parameters) && count($parameters) > 0){
			try {
				//index=0 district
				//index=1 block
				$district = $parameters[0];
				$block = $parameters[1];
				$filters = array();
				$filterValue = $this->getTextFilter('map_city.home', '', 100, 'map_city.home', '');
				$filterDistrict = $this->getSelectFilter('map_city.district', '', 'map_city.district', false, '', false, true, 'map_city.district');
				$filterBlock = $this->getSelectFilter('map_city.block', '', 'map_city.block', false, '', false, true, 'map_city.block');
				$filterValue->setSelectedValue($fieldValue);
				$filterDistrict->setSelectedValue("'".$district."'");
				$filterBlock->setSelectedValue("'".$block."'");
				$filters[]=$filterValue;
				$filters[]=$filterDistrict;
				$filters[]=$filterBlock;
				$counter = 1;
				$results = $this->manager->getAllHomeBlock($filters);
				foreach ($results as $result) {
					if($counter <= 10) {
						$homes [] = array(
								"value" => $result['home']
						);
						$counter ++;
					} else{
						break;
					}
				}
			} catch (Exception $e) {
				$_SESSION ['logger']->debug ( $e->getMessage());
			}
				
				
		}
		return new AjaxRender(json_encode($homes));
	}
	public function getLatLongForStreet(){
		$street = $_REQUEST['street'];
		$number = $_REQUEST['number'];
		$filters = array();
		$filterStreet = $this->getSelectFilter('map_city.street', '', 'map_city.street', false, '', false, true, 'map_city.street');
		$filterStreet->setSelectedValue("'".$street."'");
		$filterNumber = $this->getSelectFilter('map_city.number', '', 'map_city.number', false, '', false, true, 'map_city.number');
		$filterNumber->setSelectedValue("'".$number."'");
		$filters[] = $filterStreet;
		$filters[] = $filterNumber;
		$results = $this->manager->getLatLong($filters);
		$coords = array();
		foreach ($results as $result){
			$coords[] = array( 'id'=>$result['id'],'latitude'=>$result['latitude'], 'longitude'=>$result['longitude']);
		}
	
		return new AjaxRender(json_encode($coords));
	}
	
	public function getLatLongForHome(){
		$home = $_REQUEST['home'];
		$block = $_REQUEST['block'];
		$district = $_REQUEST['district'];
		$coords = array();
		$filters = array();
		$filterHome = $this->getSelectFilter('map_city.home', '', 'map_city.home', false, '', false, true, 'map_city.home');
		$filterHome->setSelectedValue("'".$home."'");
		$filterBlock = $this->getSelectFilter('map_city.block', '', 'map_city.block', false, '', false, true, 'map_city.block');
		$filterBlock->setSelectedValue("'".$block."'");
		$filterDistrict = $this->getSelectFilter('map_city.district', '', 'map_city.district', false, '', false, true, 'map_city.district');
		$filterDistrict->setSelectedValue("'".$district."'");
		$filters[] = $filterHome;
		$filters[] = $filterBlock;
		$filters[] = $filterDistrict;
		$results = $this->manager->getLatLong($filters);
		foreach ($results as $result){
			$coords[] = array( 'id'=>$result['id'], 'latitude'=>$result['latitude'], 'longitude'=>$result['longitude']);
		}
	
		return new AjaxRender(json_encode($coords));
	}
	
	public function getTypeAddressById(){
	
		$idType = $_REQUEST['id'];
		$filters = array();
		$filter = $this->getSelectFilter('map_city.id', '', 'map_city.id', false, '', false, true, 'map_city.id');
		$filter->setSelectedValue($idType);
		$filters[] = $filter;
		$types = array();
		$results = $this->manager->getTypeAddress($filters);
		foreach ($results as $result){
				
			$types[] = array('id'=>$result['id'],
					'street'=>$result['street'],
					'number'=>$result['number'],
					'district'=>$result['district'],
					'block'=>$result['block'],
					'home'=>$result['home'],
					'latitude'=>$result['latitude'],
					'longitude'=>$result['longitude'],
					'type'=>$result['type']);
				
		}
	
		return new AjaxRender(json_encode($types));
	}
	
	public function getGeolocationData(){
		$locality = $_SESSION ['loggedUser']->getLocationname();
		$province = $_SESSION ['loggedUser']->getProvincename();
		$country = $_SESSION ['loggedUser']->getCountryname();
		$response = array('locality'=>$locality,
				'province'=>$province,
				'country'=>$country);
		return new AjaxRender(json_encode($response));
	}

}
