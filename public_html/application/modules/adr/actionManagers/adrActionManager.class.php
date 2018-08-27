<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/actions/ModuleActionManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/managers/AdrUsersManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/managers/AdrPlansManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/managers/AdrTasksManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/managers/ClaimsManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterGroup.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/common/EnumCommon.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/EnumAdrUserHistory.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/enums/claims.enum.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrUserReport.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/EnumSubstateActivityUser.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ClaimRequestPush.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/push/ClaimNotificationPush.php';
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/MaterialLdr.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/WithoutFixing.php');

/**
 *
 * @author mmogrovejo
 *        
 *        
 */
class adrActionManager extends ModuleActionManager {
	protected $managerUser;
	protected $managerPlan;
	protected $managerClaim;
	protected $managerTask;
	protected $logger;
	function __construct() {
		$this->managerUser = AdrUsersManager::getInstance ();
		$this->managerPlan = AdrPlansManager::getInstance ();
		$this->managerClaim = ClaimsManager::getInstance ();
		$this->managerTask = AdrTasksManager::getInstance ();
		$this->logger = $_SESSION ['logger'];
		
		// Load the claims concepts in session
		$this->managerPlan->getAdrPlansConcepts ( $_SESSION ['loggedUser']->getLocationid () );
	}
	
	/**
	 * Draws the adr users list
	 *
	 * @param int $maxQuantity        	
	 */
	public function getListUser() {
		$this->logger->debug ( __METHOD__ . ' begin' );
		
		$subConcept = 'adrUsersList';
		// Subtitle section
		$_REQUEST ['currentContent'] ['subtitle'] = Util::getSubmenuTitle ( $_REQUEST ['id'] );
		
		// Pager variables
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
		
		// ID filter
		$filters ['id'] = $this->getNumberFilter ( 'id', Util::getLiteral ( 'user_id' ), 50, 'su.id', $subConcept );
		
		// User Login filter
		$filters ['userLogin'] = $this->getTextFilter ( 'userlogin', Util::getLiteral ( 'user_loggin' ), 50, 'su.userlogin', $subConcept );
		
		// User firstname filter
		$filters ['userFirstName'] = $this->getTextFilter ( 'name', Util::getLiteral ( 'user_firstname' ), 50, 'su.name', $subConcept );
		
		// User lastname filter
		$filters ['userLastName'] = $this->getTextFilter ( 'surname', Util::getLiteral ( 'user_lastname' ), 50, 'su.surname', $subConcept );
		
		// User phone filter
		$filters ['userPhoneNumber'] = $this->getTextFilter ( 'phone', Util::getLiteral ( 'user_phone_number' ), 50, 'sua.phone', $subConcept );
		
		// User plan filter
		$filters ['plan'] = $this->getSelectFilter ( 'plan', Util::getLiteral ( 'adr_plan_name' ), 'sua.planid', false, '', true, false, $subConcept );
		if (is_array ( $_SESSION ['adrPlansConcepts'] ['plans'] )) {
			foreach ( $_SESSION ['adrPlansConcepts'] ['plans'] as $key => $element ) {
				$filters ['plan']->addValue ( $key, $element ['name'] );
			}
		}
		
		// Count
		$numrows = $this->managerUser->getAdrUsersCount ( $filters );
		
		$list = array ();
		
		if ($numrows > 0) {
			//List
			$list = $this->managerUser->getAdrUsers ( $begin, $count, $filters );
		}
		
		// Pager
		$pager = Util::getPager ( $numrows, $begin, $page, $count );
		
		// Filter Group (Form)
		$filterGroup = new FilterGroup ( 'adrUsersFilter', '', '', '' );
		$filterGroup->setFiltersList ( $filters );
		
		$html = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrUsersActions.view.php';
		
		$actions = AdrUsersActions::render ();
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrUsersList.view.php';
		
		$html .= AdrUsersList::render ( $list, $filterGroup, $pager, $actions, $numrows );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMaster ();
		
		$view = $masterView->render ( $html );
		
		$render = new RenderActionResponse ( $view );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	/**
	 * Deletes adr user
	 */
	public function deleteUser() {
		$this->logger->debug ( __METHOD__ . ' begin' );
		
		try {
			$result = $this->managerUser->deleteAdrUser ( $_REQUEST ['userId'] );
			$message = 'El usuario adr se eliminó satisfactoriamente.';
		} catch ( Exception $e ) {
			$message = $e->getMessage ();
			$result = false;
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';
		
		$html = BasicAjaxMessageResponse::render ( $message, $result );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';
		
		$render = new AjaxRender ( $html );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	/**
	 * Edits or Adds an adr user
	 */
	public function newEditUser() {
		$this->logger->debug ( __METHOD__ . ' begin' );
		
		if (! isset ( $_REQUEST ['userId'] ) || $_REQUEST ['userId'] == 'null') {
			$user = new AdrUser ();
		} else {
			$user = $this->managerUser->getUser ( $_REQUEST ['userId'] );
		}
		
		$plans = $this->managerPlan->getAllPlans ();
		
		$phoneComapanies = $this->managerUser->getAdrPhoneCompanies ();
		
		$html = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrUserNewEdit.view.php';
		
		$html .= AdrUserNewEdit::render ( $user, $plans, $phoneComapanies );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMaster ();
		
		$view = $masterView->render ( $html );
		
		$render = new RenderActionResponse ( $view );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	/**
	 * Save the adr users
	 */
	public function saveUser() {
		$this->logger->debug ( __METHOD__ . ' begin' );
		
		try {
			
			// Field Validations
			if ($_POST ['id'] == null) {
				if (! isset ( $_POST ['loggin'] ) || $_POST ['loggin'] == '') {
					$this->logger->error ( "loggin parameter expected" );
					throw new UnexpectedValueException ( "loggin parameter expected" );
				}
				
				if (! isset ( $_POST ['password'] ) || $_POST ['password'] == '') {
					$this->logger->error ( "password parameter expected" );
					throw new UnexpectedValueException ( "password parameter expected" );
				}
				
				if (! isset ( $_POST ['confirmPassword'] ) || $_POST ['confirmPassword'] == '') {
					$this->logger->error ( "confirmPassword parameter expected" );
					throw new UnexpectedValueException ( "confirmPassword parameter expected" );
				}
			}
			
			if ((isset ( $_POST ['password'] ) && $_POST ['password'] != '') && (isset ( $_POST ['confirmPassword'] ) && $_POST ['confirmPassword'] != '')) {
				if ($_POST ['confirmPassword'] != $_POST ['password']) {
					$this->logger->error ( "password and confirmPassword parameters must have the same value" );
					throw new UnexpectedValueException ( "password and confirmPassword parameters must have the same value" );
				}
				
				if (strlen ( $_POST ['password'] ) < EnumCommon::USER_PASSWORD_LENGTH) {
					$this->logger->error ( "password must be " . EnumCommon::USER_PASSWORD_LENGTH . " or more characters" );
					throw new UnexpectedValueException ( "password must be " . EnumCommon::USER_PASSWORD_LENGTH . " or more characters" );
				}
				
				if (strlen ( $_POST ['confirmPassword'] ) < EnumCommon::USER_PASSWORD_LENGTH) {
					$this->logger->error ( "password must be " . EnumCommon::USER_PASSWORD_LENGTH . " or more characters" );
					throw new UnexpectedValueException ( "password must be " . EnumCommon::USER_PASSWORD_LENGTH . " or more characters" );
				}
			}
			
			if (! isset ( $_POST ['firstname'] ) || $_POST ['firstname'] == '') {
				$this->logger->error ( "firstname parameter expected" );
				throw new UnexpectedValueException ( "firstname parameter expected" );
			}
			
			if (! isset ( $_POST ['lastname'] ) || $_POST ['lastname'] == '') {
				$this->logger->error ( "lastname parameter expected" );
				throw new UnexpectedValueException ( "lastname parameter expected" );
			}
			
			if (! isset ( $_POST ['phoneNumber'] ) || $_POST ['phoneNumber'] == '') {
				$this->logger->error ( "phoneNumber parameter expected" );
				throw new UnexpectedValueException ( "phoneNumber parameter expected" );
			}
			
			if (! isset ( $_POST ['phoneCompanyId'] ) || $_POST ['phoneCompanyId'] == '') {
				$this->logger->error ( "phoneCompanyId parameter expected" );
				throw new UnexpectedValueException ( "phoneCompanyId parameter expected" );
			}
			
			if (isset ( $_POST ['planId'] ) && $_POST ['planId'] == '') {
				$this->logger->error ( "plan parameter expected" );
				throw new UnexpectedValueException ( "plan parameter expected" );
			}
			
			$result = $this->managerUser->saveAdrUser ( $_POST );
			$message = 'El usuario adr se guardó satisfactoriamente.';
		} catch ( Exception $e ) {
			$message = $e->getMessage ();
			$result = false;
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';
		
		$html = BasicAjaxMessageResponse::render ( $message, $result );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';
		
		$render = new AjaxRender ( $html );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	public function getListPlan() {
		$this->logger->debug ( __METHOD__ . ' begin' );
		
		$subConcept = 'adrPlanList';
		// Subtitle section
		$_REQUEST ['currentContent'] ['subtitle'] = Util::getSubmenuTitle ( $_REQUEST ['id'] );
		
		// Pager variables
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
		
		// ID filter
		$filters ['id'] = $this->getNumberFilter ( 'id', Util::getLiteral ( 'plan_id' ), 50, 'p.id', $subConcept );
		
		// Plan filter
		$filters ['name'] = $this->getTextFilter ( 'name', Util::getLiteral ( 'plan_name' ), 50, 'p.name', $subConcept );
		
		// Count
		$numrows = $this->managerPlan->getAdrPlansCount ( $filters );
		$list = array ();
		
		if ($numrows > 0) {
			// List
			$list = $this->managerPlan->getAdrPlans ( $begin, $count, $filters );
		}
		
		// Pager
		$pager = Util::getPager ( $numrows, $begin, $page, $count );
		
		// Filter Group (Form)
		$filterGroup = new FilterGroup ( 'adrPlansFilter', '', '', '' );
		$filterGroup->setFiltersList ( $filters );
		
		$html = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrPlansActions.view.php';
		
		$actions = AdrPlansActions::render ();
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrPlansList.view.php';
		
		$html .= AdrPlansList::render ( $list, $filterGroup, $pager, $actions, $numrows );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMaster ();
		
		$view = $masterView->render ( $html );
		
		$render = new RenderActionResponse ( $view );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	/**
	 * Edits or Adds a plan
	 */
	public function newEditPlan() {
		$this->logger->debug ( __METHOD__ . ' begin' );
		
		if (! isset ( $_REQUEST ['planId'] ) || $_REQUEST ['planId'] == 'null') {
			$plan = new AdrPlan ();
		} else {
			$plan = $this->managerPlan->getPlan ( $_REQUEST ['planId'] );
		}
		
		$html = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrPlanNewEdit.view.php';
		
		$html .= AdrPlanNewEdit::render ( $plan );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMaster ();
		
		$view = $masterView->render ( $html );
		
		$render = new RenderActionResponse ( $view );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	/**
	 * Save the adr users
	 */
	public function savePlan() {
		$this->logger->debug ( __METHOD__ . ' begin' );
		
		try {
			
			// Field Validations
			if (! isset ( $_POST ['name'] ) || $_POST ['name'] == '') {
				$this->logger->error ( "name parameter expected" );
				throw new UnexpectedValueException ( "name parameter expected" );
			}
			
			if (! isset ( $_POST ['coordinateUpdateTime'] ) || $_POST ['coordinateUpdateTime'] == '') {
				$this->logger->error ( "coordinateUpdateTime parameter expected" );
				throw new UnexpectedValueException ( "coordinateUpdateTime parameter expected" );
			}
			
			if (! isset ( $_POST ['claimMinutesToCloseTime'] ) || $_POST ['claimMinutesToCloseTime'] == '') {
				$this->logger->error ( "claimMinutesToCloseTime parameter expected" );
				throw new UnexpectedValueException ( "claimMinutesToCloseTime parameter expected" );
			}
			
			if (! isset ( $_POST ['claimMinutesForCancellation'] ) || $_POST ['claimMinutesForCancellation'] == '') {
				$this->logger->error ( "claimMinutesForCancellation parameter expected" );
				throw new UnexpectedValueException ( "claimMinutesForCancellation parameter expected" );
			}
			
			if (! isset ( $_POST ['claimLatitude'] ) || $_POST ['claimLatitude'] == '') {
				$this->logger->error ( "claimLatitude parameter expected" );
				throw new UnexpectedValueException ( "claimLatitude parameter expected" );
			}
			
			if (! isset ( $_POST ['claimLongitude'] ) || $_POST ['claimLongitude'] == '') {
				$this->logger->error ( "claimLongitude parameter expected" );
				throw new UnexpectedValueException ( "claimLongitude parameter expected" );
			}
			
			$result = $this->managerPlan->saveAdrPlan ( $_POST );
			$message = 'El plan adr se guardó satisfactoriamente.';
		} catch ( Exception $e ) {
			$message = $e->getMessage ();
			$result = false;
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';
		
		$html = BasicAjaxMessageResponse::render ( $message, $result );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';
		
		$render = new AjaxRender ( $html );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	/**
	 * Deletes adr plan
	 */
	public function deletePlan() {
		$this->logger->debug ( __METHOD__ . ' begin' );
		
		try {
			if (! isset ( $_REQUEST ['planId'] ) || $_REQUEST ['planId'] == '') {
				self::$logger->error ( 'planId parameter expected ' );
				throw new InvalidArgumentException ( 'planId parameter expected ' );
			}
			
			$result = $this->managerPlan->deleteAdrPlan ( $_REQUEST ['planId'] );
			$message = 'El plan adr se eliminó satisfactoriamente.';
		} catch ( Exception $e ) {
			$message = $e->getMessage ();
			$result = false;
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';
		
		$html = BasicAjaxMessageResponse::render ( $message, $result );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';
		
		$render = new AjaxRender ( $html );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	public function checkUserLoggin() {
		$this->logger->debug ( __METHOD__ . ' begin' );
		
		try {
			if (! isset ( $_REQUEST ['logginName'] ) || $_REQUEST ['logginName'] == '') {
				self::$logger->error ( 'logginName parameter expected ' );
				throw new InvalidArgumentException ( 'logginName parameter expected ' );
			}
			
			$result = $this->managerUser->checkAdrUserLoggin ( $_REQUEST ['logginName'] );
			$message = '';
		} catch ( Exception $e ) {
			$message = $e->getMessage ();
			$result = false;
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';
		
		$html = BasicAjaxMessageResponse::render ( $message, $result );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';
		
		$render = new AjaxRender ( $html );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	/**
	 * Get the claims track map
	 *
	 * @return RenderActionResponse
	 */
	public function getClaimsTrack() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		// Subtitle section+
		$_REQUEST ['currentContent'] ['subtitle'] = Util::getSubmenuTitle ( $_REQUEST ['id'] );
		
		// States
		$adrClaimStates = array (
				"pending" => claimsConcepts::PENDINGSTATE,
				"closed" => claimsConcepts::CLOSEDSTATE,
				"cancelled" => claimsConcepts::CANCELLEDSTATE 
		);
		
		$claimStates = $this->managerUser->getAdrClaimStates ( $adrClaimStates );
		
		$html = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrClaimsTrack.view.php';
		
		$html .= AdrClaimsTrack::render ( $claimStates );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMaster ();
		
		$view = $masterView->render ( $html );
		
		$render = new RenderActionResponse ( $view );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		// return $render;
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $render;
	}

/**
	 * Get the claims track map
	 * @return RenderActionResponse
	 */
	public function getPublicClaims() {
	
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		// Subtitle section
		$_REQUEST['currentContent']['subtitle'] = Util::getSubmenuTitle($_REQUEST['id']);
		
		// States
		$adrClaimStates = array (
								"pending"	=> claimsConcepts::PENDINGSTATE,
								"closed"	=> claimsConcepts::CLOSEDSTATE,
								"cancelled"	=> claimsConcepts::CANCELLEDSTATE
				);
		
		$claimStates = $this->managerUser->getAdrClaimStates($adrClaimStates);
		
		$html = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrPublicClaims.view.php';
		
		$html .= AdrPublicClaims::render($claimStates);
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMasterPublic ();
			
		$view = $masterView->render ( $html );
			
		$render = new RenderActionResponse ( $view );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		//return $render;
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
	
		return $render;
	
	}

	
	/**
	 * Get an adr user for autocomplete through ajax
	 *
	 * @return AjaxRender
	 */
	public function getAdrUserFromAutoComplete() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$names = array ();
		$streets = array ();
		try {
			$fieldValue = $_REQUEST ['fieldValue'];
			
			// Filters
			$filters = array ();
			$filter = $this->getTextFilter ( 'systemuser.name || \' \' || systemuser.surname', '', 100, 'systemuser.name || \' \' || systemuser.surname', '' );
			$filter->setSelectedValue ( $fieldValue );
			$filters [] = $filter;
			
			// Get List
			$results = $this->managerUser->getAllAdrUsers ( $filters );
			
			$counter = 1;
			
			foreach ( $results as $result ) {
				
				$fullName = $result ['firstname'] . ' ' . $result ['lastname'];
				
				if ($counter <= 10) {
					$names [] = array (
							"id" => $result ['userid'],
							"value" => $fullName 
					);
					$counter ++;
				} else {
					break;
				}
			}
		} catch ( Exception $e ) {
			$streets [] = array (
					"id" => "",
					"value" => Util::getLiteral ( 'adr_users_get_user_error' ) 
			);
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $names ) );
	}
	
	/**
	 * Get a claim for autocomplete through ajax
	 *
	 * @return AjaxRender
	 */
	public function getAdrClaimFromAutoComplete() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$codes = array ();
		try {
			$fieldValue = $_REQUEST ['fieldValue'];
			
			// Filters
			$filters = array ();
			$filter = $this->getTextFilter ( 'code', '', 50, 'code', '' );
			$filter->setSelectedValue ( $fieldValue );
			$filters [] = $filter;
			
			// Get List
			$results = $this->managerClaim->getClaimByCode ( $filters );
			
			$counter = 1;
			
			foreach ( $results as $result ) {
				
				if ($counter <= 10) {
					$codes [] = array (
							"id" => $result ['id'],
							"value" => $result ['code'] 
					);
					$counter ++;
				} else {
					break;
				}
			}
		} catch ( Exception $e ) {
			$streets [] = array (
					"id" => "",
					"value" => Util::getLiteral ( 'claims_get_code_error' ) 
			);
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $codes ) );
	}
	
	/**
	 * Get the coordinates for an adr user
	 *
	 * @return AjaxRender
	 */
	public function getAdrUserCoords() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$coords = array ();
		
		try {
			$filters = array ();
			
			if ($_REQUEST ['userId'] != '') {
				// Filters
				$filter = $this->getNumberFilter ( 'iduser', '', 10, 't.iduser', '' );
				$filter->setSelectedValue ( $_REQUEST ['userId'] );
				$filters [] = $filter;
			}
			
			$results = $this->managerUser->getAdrUserCoords ( $filters );
			
			if (empty ( $results )) {
				$coords [] = array (
						"id" => "no_data_found",
						"lat" => Util::getLiteral ( 'adr_claims_latitude_error' ),
						"long" => Util::getLiteral ( 'adr_claims_longitude_error' ),
						"state" => "no_data_found" 
				);
			} else {
				foreach ( $results as $result ) {
					$coords [] = array (
							"id" => $result ['iduser'],
							"lat" => $result ['latitude'],
							"long" => $result ['longitude'],
							"state" => $result ['stateid'] 
					);
				}
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $coords ) );
	}

		/**
	 * Get the data for a group
	 *
	 * @return AjaxRender
	 */
	public function getDataGroup() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$group = array ();
		
		try {
			$groupId = $_REQUEST ['groupId'];
			
			$results = $this->managerClaim->getGroupInfo ( $groupId );	
			if (empty ( $results )) {
				$group [] = array (
						"id" => "no_data_found",
						"name" => "no_data_found",
						"icon" => "no_data_found"
				);
			} else {
				foreach ( $results as $result ) {
					$group [] = array (
				
							"id" => $result->getId(),
							"name" => $result->getName(),
							"icon" => $result->getIcon() 
					);
				}
				
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $group ) );
	}

	/**
	 * Get claim coords applying filters
	 * @return AjaxRender
	 */
	public function getPublicClaimsCoords() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array();
		
		try{
			$filters = array ();
	
			if(isset($_REQUEST['adrClaimCode']) && $_REQUEST['adrClaimCode'] != '') {
				$filter = $this->getTextFilter('claim.code', '', 10, 'claim.code', '');
				$filter->setSelectedValue ( $_REQUEST['adrClaimCode'] );
				$filters [] = $filter;
			}

			$results = $this->managerClaim->getPublicClaimCoords($filters);

			if(empty($results)) {
				$data [] = array(
							"id"		=> "",
							"code"		=> "no_data_found",
							"stateId"	=> "",
							"isCritical"	=> "",
							"lat"		=> Util::getLiteral('adr_claims_latitude_error'), 
							"long"		=> Util::getLiteral('adr_claims_longitude_error')
				);
			} else {

				/* @var $result Claim */
				foreach ($results as $result) {
						
					$isCritical = $this->managerClaim->getCheckCriticalPendingClaim($result->getId());
						
					$data [] = array(
							"id"			=> $result->getId(),
							"code"			=> $result->getCode(),
							"state"		=> $result->getStateId(),
							"isCritical"	=> $isCritical,
							"lat"			=> $result->getLatitude(),
							"long"			=> $result->getLongitude()
					);
						
				}

			}

		} catch (Exception $e){
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender(json_encode($data));

	}


        public function getPublicClaim() {

                $_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

                $data = array();

                try{
                        $filters = array ();

                        if(isset($_REQUEST['adrClaimCode']) && $_REQUEST['adrClaimCode'] != '') {
                                $filter = $this->getTextFilter('claim.code', '', 10, 'claim.code', '');
                                $filter->setSelectedValue ( $_REQUEST['adrClaimCode'] );
                                $filters [] = $filter;
                        }

                        $results = $this->managerClaim->getPublicClaim($filters);

                        if(empty($results)) {
                                $data [] = array(
                                                        "id"            => "",
                                                        "code"          => "no_data_found",
                                                        "stateId"       => "",
                                                        "isCritical"    => "",
							"closedate"	=> "",
                                                        "lat"           => Util::getLiteral('adr_claims_latitude_error'),
                                                        "long"          => Util::getLiteral('adr_claims_longitude_error')
                                );
                        } else {

                                /* @var $result Claim */
                                foreach ($results as $result) {

                                        $isCritical = $this->managerClaim->getCheckCriticalPendingClaim($result->getId());

                                        $data [] = array(
                                                        "id"                    => $result->getId(),
                                                        "code"                  => $result->getCode(),
                                                        "state"         => $result->getStateId(),
                                                        "isCritical"    => $isCritical,
							"closedate"     => $result->getCloseddate(),
                                                        "lat"                   => $result->getLatitude(),
                                                        "long"                  => $result->getLongitude()
                                        );

                                }

                        }

                } catch (Exception $e){
                        $_SESSION ['logger']->debug ( 'No data found.' );
                }

                $_SESSION ['logger']->debug ( __METHOD__ . ' end' );

                return new AjaxRender(json_encode($data));

        }
	
	/**
	 * Get the coordinates for an adr user company
	 *
	 * @return AjaxRender
	 */
	public function getAdrUserCompanyCoords() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$coords = array ();
		
		try {
			$filters = array ();
			
			if ($_REQUEST ['userId'] != '') {
				// Filters
				$filter = $this->getNumberFilter ( 'systemuserid', '', 10, 'u.systemuserid', '' );
				$filter->setSelectedValue ( $_REQUEST ['userId'] );
				$filters [] = $filter;
			}
			
			$results = $this->managerUser->getCompanyCoordsByUser ( $filters );
			
			if (empty ( $results )) {
				$coords [] = array (
						"id" => "no_data_found",
						"lat" => Util::getLiteral ( 'adr_claims_latitude_error' ),
						"long" => Util::getLiteral ( 'adr_claims_longitude_error' ) 
				);
			} else {
				/* @var $result AdrPlan */
				foreach ( $results as $result ) {
					$coords [] = array (
							"id" => $result->getId (),
							"lat" => $result->getLatitude (),
							"long" => $result->getLongitude () 
					);
				}
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $coords ) );
	}
	
	/**
	 * Get claim coords applying filters
	 *
	 * @return AjaxRender
	 */
	public function getClaimsTrackFilterData() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		
		try {
			$filters = array ();
			
			if (isset ( $_REQUEST ['adrUserId'] ) && $_REQUEST ['adrUserId'] != '') {
				$filter = $this->getNumberFilter ( 'claimsystemuseradr.systemuseradrid', '', 10, 'claimsystemuseradr.systemuseradrid', '' );
				$filter->setSelectedValue ( $_REQUEST ['adrUserId'] );
				$filters [] = $filter;
			}
			
			if (isset ( $_REQUEST ['adrClaimId'] ) && $_REQUEST ['adrClaimId'] != '') {
				$filter = $this->getNumberFilter ( 'claim.id', '', 10, 'claim.id', '' );
				$filter->setSelectedValue ( $_REQUEST ['adrClaimId'] );
				$filters [] = $filter;
			}
			
			if (isset ( $_REQUEST ['adrClaimStateId'] ) && $_REQUEST ['adrClaimStateId'] != '') {
				$filter = $this->getNumberFilter ( 'claim.stateid', '', 10, 'claim.stateid', '' );
				$filter->setSelectedValue ( $_REQUEST ['adrClaimStateId'] );
				$filters [] = $filter;
			}
			
			if (isset ( $_REQUEST ['adrClaimDateFrom'] ) && $_REQUEST ['adrClaimDateFrom'] != '' && isset ( $_REQUEST ['adrClaimDateTo'] ) && $_REQUEST ['adrClaimDateTo'] != '') {
				$_REQUEST ['filter_date_left_entryDate'] = $_REQUEST ['adrClaimDateFrom'];
				$_REQUEST ['filter_date_right_entryDate'] = $_REQUEST ['adrClaimDateTo'];
				$filter = $this->getDateFilter ( 'entryDate', Util::getLiteral ( 'date_between' ), 'claim.entrydate', '' );
				$filters [] = $filter;
			}
			
			$results = $this->managerClaim->getAdrClaimCoords ( $filters );
			
			if (empty ( $results )) {
				$data [] = array (
						"id" => "",
						"code" => "no_data_found",
						"stateId" => "",
						"isCritical" => "",
						"lat" => Util::getLiteral ( 'adr_claims_latitude_error' ),
						"long" => Util::getLiteral ( 'adr_claims_longitude_error' ) 
				);
			} else {
				
				/* @var $result Claim */
				foreach ( $results as $result ) {
					
					$isCritical = $this->managerClaim->getCheckCriticalPendingClaim ( $result->getId () );
					
					$data [] = array (
							"id" => $result->getId (),
							"code" => $result->getCode (),
							"stateId" => $result->getStateId (),
							"isCritical" => $isCritical,
							"lat" => $result->getLatitude (),
							"long" => $result->getLongitude () 
					);
				}
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	/**
	 * Get the assign claims map page
	 *
	 * @return RenderActionResponse
	 */
	public function getAssignTasks() {
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$_REQUEST ['currentContent'] ['subtitle'] = Util::getSubmenuTitle ( $_REQUEST ['id'] );
		$listGroup = $this->managerTask->getListGroups();
		$list = $this->managerUser->getAdrUsers ();

		$html = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrAssignTasks.view.php';
		
		$html .= AdrAssignTasks::render ($list,$listGroup);
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMaster();
		
		$view = $masterView->render ( $html );
		
		$render = new RenderActionResponse ( $view );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	public function getGroupAssignTasks() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();		
		// Subtitle section

		$listGroup = $this->managerTask->getListGroups();
		//$list = $this->managerUser->getAdrUsers ();
		
		
   
		$html = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrAssignGroup.view.php';
		$html .= AdrAssignGroup::render ($listGroup);
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMaster();
		
		$view = $masterView->render ( $html );
		
		$render = new RenderActionResponse ( $view );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $render;
		

	}
	public function getShowUnassignedClaimsByGroups() {

 $results = $this->managerClaim->getClaimsMapGroup ();
		
		 if (empty ( $results )) {
			$data [] = array (
		 			"id" => "",
		 			"code" => "no_data_found",
		 			"lat" => Util::getLiteral ( 'adr_claims_latitude_error' ),
					 "long" => Util::getLiteral ( 'adr_claims_longitude_error' ), 
					 "groupid"=>"",
					 "namegroup"=>"",
					 "icon"=>""
		 	);
		 } else {
			
		 	/* @var $result Claim */
		 	foreach ( $results as $result ) {
				
				
		 		$data [] = array (
		 				"id" => $result->getId (),
		 				"code" => $result->getCode (),
		 				"lat" => $result->getLatitude (),
						 "long" => $result->getLongitude (), 
						 "groupid" => $result->getGroupid(),
						 "namegroup"=> $result->getNamegroup(),
						 "icon"=> $result->getIcon()

		 		);
		 	}
	 }
	
		
		 $_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		 
		 return new AjaxRender ( json_encode ( $data ) );
	}

	/**
	 * Get the unassigned claims coordiantes
	 *
	 * @return AjaxRender
	 */
	public function getUnassignedClaimsCoords() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		$groupId = $_REQUEST ['groupId'];
		try {
			// Unassigned claims list
		
			$unassignedList = $this->managerClaim->getAdrUnassignedClaimsCoords ($groupId);


			
			if (empty ( $unassignedList )) {
				$data [] = array (
						"id" => "no_data_found",
						"priority"=> "no_data_found",
						"dependency"=> "no_data_found",
						"code" => "no_data_found",
						"address" => "no_data_found",
						"stateId" => "no_data_found",
						"isCritical" => "no_data_found",
						"lat" => Util::getLiteral ( 'adr_claims_latitude_error' ),
						"long" => Util::getLiteral ( 'adr_claims_longitude_error' ) 
				);
			} else {
				
				/* @var $unassignedClaim Claim */
				foreach ( $unassignedList as $unassignedClaim ) {
					
					//$isCritical = $this->managerClaim->getCheckCriticalPendingClaim ( $unassignedClaim->getId () );



					$data [] = array (
							"id" => $unassignedClaim->getId (),
							"priority"=>$unassignedClaim->getPriority(),
							"causeId"=>$unassignedClaim->getCauseId(),
							"code" => $unassignedClaim->getCode (),
							"address" => $unassignedClaim->getClaimAddress (),
							"stateId" => $unassignedClaim->getStateId (),
							"isCritical" => 0,
							"lat" => $unassignedClaim->getLatitude (),
							"long" => $unassignedClaim->getLongitude () 
					);
				}
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
	
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	/**
	 * Get claims coordinates inside a polygon
	 *
	 * @throws InvalidArgumentException
	 * @return AjaxRender
	 */
	public function getPointsInsidePolygon() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		
		try {
			// FIXME: de ahora en mas vendran todas las claims en una cadena json, hacer el for del js aca y adentro meter el isWithin
			if (! isset ( $_REQUEST ['polygon'] ) || $_REQUEST ['polygon'] == '') {
				//self::$logger->error ( 'polygon parameter expected ' );
				throw new InvalidArgumentException ( 'polygon parameter expected ' );
			}
			
			if (! isset ( $_REQUEST ['claims'] ) || $_REQUEST ['claims'] == '') {
				//self::$logger->error ( 'claims parameter expected ' );
				throw new InvalidArgumentException ( 'claims parameter expected ' );
			}
		
			foreach ( $_REQUEST ['claims'] as $claim ) {
				
				$claimId = $claim [0];
				$claimCode = $claim [1];
				$point = $claim [2] . ', ' . $claim [3];
				
				$isWithin = $this->managerTask->checkPointWithinPolygon ( $point, $_REQUEST ['polygon'] );
				
				// if($isWithin == false) {
				// $data [] = array(
				// "id" => "no_data_found",
				// "code" => "no_data_found",
				// "isWithin" => "no_data_found"
				// );
				// } else {
				if ($isWithin == true) {
					$data [] = array (
							"id" => $claimId,
							"code" => $claimCode,
							"isWithin" => $isWithin 
					);
				}
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	/**
	 * Get claim coords applying filters
	 *
	 * @return AjaxRender
	 */
	public function getAssignedClaimsForUser() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		
		try {
			$filters = array ();
				
				if (isset ( $_REQUEST ['userId'] ) && $_REQUEST ['userId'] != '') {
					$filter = $this->getNumberFilter ( 'claimsystemuseradr.systemuseradrid', '', 10, 'claimsystemuseradr.systemuseradrid', '' );
					$filter->setSelectedValue ( $_REQUEST ['userId'] );
					
					$filters [] = $filter;
				
				} else {
					$_SESSION ['logger']->debug ( 'userId parameter expected.' );
					throw new InvalidArgumentException ( 'userId parameter expected.' );
				}
				$groupId = $_REQUEST ['groupId'];
				$results = $this->managerClaim->getAssignedClaimsForUser ( $filters,$groupId);
		
			if (empty ( $results )) {
				$data [] = array (
						"id" => "",
						"code" => "no_data_found",
						"stateId" => "",
						"isCritical" => "",
						"lat" => Util::getLiteral ( 'adr_claims_latitude_error' ),
						"long" => Util::getLiteral ( 'adr_claims_longitude_error' ) 
				);
			} else {
				
				/* @var $result Claim */
				foreach ( $results as $result ) {
					
					$isCritical = $this->managerClaim->getCheckCriticalPendingClaim ( $result->getId () );
					
					$data [] = array (
							"id" => $result->getId (),
							"code" => $result->getCode (),
							"stateId" => $result->getStateId (),
							"isCritical" => "",
							"lat" => $result->getLatitude (),
							"long" => $result->getLongitude () 
					);
				}
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	/**
	 * Check the status of a pending claim
	 *
	 * @param Claim $claim        	
	 * @throws InvalidArgumentException
	 * @return number
	 */
	public function getCheckClaimIsCritical($claimId) {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$isCritical = 0;
		
		try {
			if (! isset ( $claimId ) || $claimId == '') {
				self::$logger->error ( 'claimId parameter expected ' );
				throw new InvalidArgumentException ( 'claimId parameter expected ' );
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $isCritical;
	}
	
	/**
	 * Get claim detail
	 *
	 * @throws InvalidArgumentException
	 * @return AjaxRender
	 */
	public function getAdrClaim() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		
		try {
			if (! isset ( $_REQUEST ['claimId'] ) || $_REQUEST ['claimId'] == '') {
				self::$logger->error ( 'claimId parameter expected ' );
				throw new InvalidArgumentException ( 'claimId parameter expected ' );
			}
			
			$claim = $this->managerClaim->getClaim ( $_REQUEST ['claimId'] );
			
			if (! is_object ( $claim )) {
				$data [] = array (
						"id" => "no_data_found",
						"code" => "no_data_found",
						"state" => "no_data_found",
						"address" => "no_data_found",
						"requestername" => "no_data_found",
						"requesterphone" => "no_data_found",
						"claimaddress" => "no_data_found",
						"subjectname" => "no_data_found",
						"closedate" => "no_date_found",
						"date" => "no_data_found",
						"detail" => "no_data_found",
						"namegroup" => "no_data_found" 
				);
			} else {
				$state = '';
				$closeddate = null;
				if ($claim->getStateId () == 1) {
					$state = Util::getLiteral ( "pending" );
				}
				if ($claim->getStateId () == 2) {
					$state = Util::getLiteral ( "closed" );
					$closeddate = new DateTime ( $claim->getClosedDateFormated () );
	                                $closeddate = $closeddate->format ( 'd/m/Y' );
				}
				if ($claim->getStateId () == 3) {
					$state = Util::getLiteral ( "cancelled" );
				}
				
				$date = new DateTime ( $claim->getEntryDateForDB () );
				$date = $date->format ( 'd/m/Y' );
				
				$data [] = array (
						"id" => $claim->getId (),
						"code" => $claim->getCode (),
						"state" => $state,
						"requestername" => $claim->getRequesterName (),
						"requesterphone" => $claim->getRequesterPhone (),
						"claimaddress" => $claim->getClaimAddress (),
						"subjectname" => $claim->getSubjectName (),
						"closedate" => $closeddate,
						"date" => $date,
						"namegroup" => $claim->getNamegroup() 
				);
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	/**
	 * Get the user detail
	 *
	 * @throws InvalidArgumentException
	 * @return AjaxRender
	 */
	public function getAdrUserById() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		
		try {
			if (! isset ( $_REQUEST ['userId'] ) || $_REQUEST ['userId'] == '') {
				self::$logger->error ( 'userId parameter expected ' );
				throw new InvalidArgumentException ( 'userId parameter expected ' );
			}
			
			$user = $this->managerUser->getUser ( $_REQUEST ['userId'] );
			
			if (! is_object ( $user )) {
				$data [] = array (
						"id" => "no_data_found",
						"firstname" => "no_data_found",
						"lastname" => "no_data_found",
						"state" => "no_data_found" 
				);
			} else {
				$data [] = array (
						"id" => $user->getId (),
						"firstname" => $user->getFirstName (),
						"lastname" => $user->getLastName (),
						"state" => $user->getStateName () 
				);
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	/**
	 * Get the plan detail
	 *
	 * @throws InvalidArgumentException
	 * @return AjaxRender
	 */
	public function getAdrPlanById() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		
		try {
			if (! isset ( $_REQUEST ['planId'] ) || $_REQUEST ['planId'] == '') {
				self::$logger->error ( 'planId parameter expected ' );
				throw new InvalidArgumentException ( 'planId parameter expected ' );
			}
			
			$plan = $this->managerPlan->getPlan ( $_REQUEST ['planId'] );
			
			if (! is_object ( $plan )) {
				$data [] = array (
						"id" => "no_data_found",
						"name" => "no_data_found" 
				);
			} else {
				$data [] = array (
						"id" => $plan->getId (),
						"name" => $plan->getName () 
				);
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	/**
	 * Save the claims assignment
	 *
	 * @return AjaxRender
	 */
	public function assignClaims() {
		$this->logger->debug ( __METHOD__ . ' begin' );
		
		try {
			if (! isset ( $_REQUEST ['adrUserId'] ) || $_REQUEST ['adrUserId'] == '') {
				self::$logger->error ( 'adrUserId parameter expected ' );
				throw new InvalidArgumentException ( 'adrUserId parameter expected ' );
			}
			
			$claimData = null;
			
			if (isset ( $_REQUEST ['claimIds'] )) {
				$claimData = $_REQUEST ['claimIds'];
			}
			
			
			$beforeClaims = $this->managerClaim->getClaimsByUser ( $_REQUEST ['adrUserId'], $_REQUEST ['adrGroupId'] );
			
			$result = $this->managerClaim->assignClaimsToAdrUser ( $_REQUEST ['adrUserId'], $claimData, $_REQUEST ['adrGroupId'] );
			$message = Util::getLiteral ( 'adr_assign_tasks_assign_ok' );
			
			$afterClaims = $this->managerClaim->getClaimsByUser ( $_REQUEST ['adrUserId'], $_REQUEST ['adrGroupId'] );
			
			// comparamos los reclamos que tenía anteriormente antes de modificar la asignación para
			// poder distinguir los nuevos reclamos de los desasignados como así también de los que ya poseía
			
			$deleteClaims = array ();
			$newClaims = array ();
			
			foreach ( $beforeClaims as $beforeClaim ) {
				$exists = false;
				
				foreach ( $afterClaims as $afterClaim ) {
					
					if ($beforeClaim->getId () == $afterClaim->getId ()) {
						$exists = true;
						break;
					}
				}
				if (! $exists) {
					
					$deleteClaims [] = $beforeClaim;
				}
			}
			
			foreach ( $afterClaims as $afterClaim ) {
				$exists = false;
				
				foreach ( $beforeClaims as $beforeClaim ) {
					
					if ($afterClaim->getId () == $beforeClaim->getId ()) {
						$exists = true;
						break;
					}
				}
				
				if (! $exists) {
					
					$newClaims [] = $afterClaim;
				}
			}
			
			// Obteniendo los reclamos desasignados
			foreach ( $deleteClaims as $claimDelete ) {
				
				$user = $this->managerUser->getUser ( $claimDelete->getUserId () );
				$registrationId = $user->getRegistrationId ();
				$claimDelete = $this->managerClaim->getClaim ( $claimDelete->getId () );
				if (isset ( $registrationId )) {
					$crp = new ClaimRequestPush ( array (
							$registrationId 
					), $claimDelete, claimsConcepts::PUSH_ACTION_DELETE );
					$cnp = new ClaimNotificationPush ();
					$cnp->sendClaimNotificationPush ( $crp );
				} else {
					
					$_SESSION ['logger']->info ( 'No se envió notificacion push debido a que el usuario ' . $claimDelete->getUserId () . ' no tiene registrationid' );
				}
			}
			
			// Obteniendo los nuevos reclamos asignados
			foreach ( $newClaims as $claimNew ) {
				
				$user = $this->managerUser->getUser ( $claimNew->getUserId () );
				$registrationId = $user->getRegistrationId ();
				$claimAdd = $this->managerClaim->getClaim ( $claimNew->getId () );
				
				if (isset ( $registrationId )) {
					$crp = new ClaimRequestPush ( array (
							$registrationId 
					), $claimAdd, claimsConcepts::PUSH_ACTION_ADD );
					$cnp = new ClaimNotificationPush ();
					$cnp->sendClaimNotificationPush ( $crp );
				} else {
					
					$_SESSION ['logger']->info ( 'No se envió notificacion push debido a que el usuario ' . $claimNew->getUserId () . ' no tiene registrationid' );
				}
			}
		} catch ( Exception $e ) {
			$message = $e->getMessage ();
			$result = false;
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';
		
		$html = BasicAjaxMessageResponse::render ( $message, $result );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';
		
		$render = new AjaxRender ( $html );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	

		/**
	 * Save the claims assignment
	 *
	 * @return AjaxRender
	 */
	public function assignClaimsGroup() {
		//$this->logger->debug ( __METHOD__ . ' begin' );
		
		try {
			if (! isset ( $_REQUEST ['adrGroupId'] ) || $_REQUEST ['adrGroupId'] == '') {
				//self::$logger->error ( 'adrUserId parameter expected ' );
				throw new InvalidArgumentException ( 'adrUserId parameter expected ' );
			}
			
			$claimData = null;
			
			if (isset ( $_REQUEST ['claimIds'] )) {
				$claimData = $_REQUEST ['claimIds'];
			}
			//programar la asignacion de usuario ...
			$beforeClaims = $this->managerClaim->getClaimByGroup ( $_REQUEST ['adrGroupId'] );
			
			$result = $this->managerClaim->assignClaimsToGroupId ( $_REQUEST ['adrGroupId'], $claimData );
			$message = Util::getLiteral ( 'adr_assign_tasks_assign_ok' );
			
			$afterClaims = $this->managerClaim->getClaimsByGroup ( $_REQUEST ['adrGroupId'] );
			
			// comparamos los reclamos que tenía anteriormente antes de modificar la asignación para
			// poder distinguir los nuevos reclamos de los desasignados como así también de los que ya poseía
			
			$deleteClaims = array ();
			$newClaims = array ();
			
			foreach ( $beforeClaims as $beforeClaim ) {
				$exists = false;
				
				foreach ( $afterClaims as $afterClaim ) {
					
					if ($beforeClaim->getId () == $afterClaim->getId ()) {
						$exists = true;
						break;
					}
				}
				if (! $exists) {
					
					$deleteClaims [] = $beforeClaim;
				}
			}
			
			foreach ( $afterClaims as $afterClaim ) {
				$exists = false;
				
				foreach ( $beforeClaims as $beforeClaim ) {
					
					if ($afterClaim->getId () == $beforeClaim->getId ()) {
						$exists = true;
						break;
					}
				}
				
				if (! $exists) {
					
					$newClaims [] = $afterClaim;
				}
			}
			
			// // Obteniendo los reclamos desasignados
			// foreach ( $deleteClaims as $claimDelete ) {
				
			// 	$user = $this->managerUser->getUser ( $claimDelete->getUserId () );
			// 	$registrationId = $user->getRegistrationId ();
			// 	$claimDelete = $this->managerClaim->getClaim ( $claimDelete->getId () );
			// 	if (isset ( $registrationId )) {
			// 		$crp = new ClaimRequestPush ( array (
			// 				$registrationId 
			// 		), $claimDelete, claimsConcepts::PUSH_ACTION_DELETE );
			// 		$cnp = new ClaimNotificationPush ();
			// 		$cnp->sendClaimNotificationPush ( $crp );
			// 	} else {
					
			// 		$_SESSION ['logger']->info ( 'No se envió notificacion push debido a que el usuario ' . $claimDelete->getUserId () . ' no tiene registrationid' );
			// 	}
			// }
			
			// // Obteniendo los nuevos reclamos asignados
			// foreach ( $newClaims as $claimNew ) {
				
			// 	$user = $this->managerUser->getUser ( $claimNew->getUserId () );
			// 	$registrationId = $user->getRegistrationId ();
			// 	$claimAdd = $this->managerClaim->getClaim ( $claimNew->getId () );
				
			// 	if (isset ( $registrationId )) {
			// 		$crp = new ClaimRequestPush ( array (
			// 				$registrationId 
			// 		), $claimAdd, claimsConcepts::PUSH_ACTION_ADD );
			// 		$cnp = new ClaimNotificationPush ();
			// 		$cnp->sendClaimNotificationPush ( $crp );
			// 	} else {
					
			// 		$_SESSION ['logger']->info ( 'No se envió notificacion push debido a que el usuario ' . $claimNew->getUserId () . ' no tiene registrationid' );
			// 	}
			// }
		} catch ( Exception $e ) {
			$message = $e->getMessage ();
			$result = false;
		}
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/views/BasicAjaxMessageResponse.view.php';
		
		$html = BasicAjaxMessageResponse::render ( $message, $result );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/actions/AjaxRender.class.php';
		
		$render = new AjaxRender ( $html );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	/**
	 * Get the distance between points
	 *
	 * @throws InvalidArgumentException
	 * @return AjaxRender
	 */
	public function getDistanceBetweenPoints() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		
		try {
			if (! isset ( $_REQUEST ['claimsList'] ) || $_REQUEST ['claimsList'] == '') {
				self::$logger->error ( 'claimsList parameter expected ' );
				throw new InvalidArgumentException ( 'claimsList parameter expected ' );
			}
			
			if (! isset ( $_REQUEST ['company'] ) || $_REQUEST ['company'] == '') {
				self::$logger->error ( 'company parameter expected ' );
				throw new InvalidArgumentException ( 'company parameter expected ' );
			}
			
			$claimsList = json_decode ( $_REQUEST ['claimsList'], true );
			
			$company = json_decode ( $_REQUEST ['company'], true );
			
			$result = $this->managerTask->getOrderedListByDistance ( $claimsList, $company );
			
			if (! is_array ( $result )) {
				$data [] = array (
						"code" => 'OK',
						"result" => "no_data_found" 
				);
			} else {
				$data [] = array (
						"code" => 'OK',
						"result" => $result 
				);
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	/**
	 * Get the adr user history
	 *
	 * @return RenderActionResponse
	 */
	public function getAdrUserHistory() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		// Subtitle section
		$_REQUEST ['currentContent'] ['subtitle'] = Util::getSubmenuTitle ( $_REQUEST ['id'] );
		
		// States
		$adrClaimStates = array (
				"pending" => claimsConcepts::PENDINGSTATE,
				"closed" => claimsConcepts::CLOSEDSTATE,
				"cancelled" => claimsConcepts::CANCELLEDSTATE 
		);
		
		$claimStates = $this->managerUser->getAdrClaimStates ( $adrClaimStates );
		
		$zones = $this->managerUser->getAdrZones ();
		
		$html = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrUserHistory.view.php';
		
		$html .= AdrUserHistory::render ( $zones, $claimStates );
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMaster ();
		
		$view = $masterView->render ( $html );
		
		$render = new RenderActionResponse ( $view );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	/**
	 * Agregado por Diego Saez
	 */
	public function getTemporal() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		// Subtitle section
		$_REQUEST ['currentContent'] ['subtitle'] = Util::getSubmenuTitle ( $_REQUEST ['id'] );
		
		$html = '';
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrTemporal.view.php';
		
		$html .= AdrTemporal::render ();
		
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		
		$masterView = MasterFactory::getMaster ();
		
		$view = $masterView->render ( $html );
		
		$render = new RenderActionResponse ( $view );
		
		$this->logger->debug ( __METHOD__ . ' end' );
		
		return $render;
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	
	/**
	 * Get the user locations
	 *
	 * @throws InvalidArgumentException
	 * @return AjaxRender
	 */
	public function getHistoricalForUser() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		$filters = array ();
		try {
			if (isset ( $_REQUEST ['adrUserId'] ) && $_REQUEST ['adrUserId'] != '') {
				$filter = $this->getNumberFilter ( 'iduser', '', 10, 'iduser', '' );
				$filter->setSelectedValue ( $_REQUEST ['adrUserId'] );
				$filters [] = $filter;
			} else {
				$_SESSION ['logger']->debug ( 'adrUserId parameter expected.' );
				throw new InvalidArgumentException ( 'adrUserId parameter expected.' );
			}
			
			if (isset ( $_REQUEST ['adrClaimDateFrom'] ) && $_REQUEST ['adrClaimDateFrom'] != '' && isset ( $_REQUEST ['adrClaimDateTo'] ) && $_REQUEST ['adrClaimDateTo'] != '') {
				
				$adrClaimDateFrom = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['adrClaimDateFrom'] . ' 00:00:01') ) ) );
				$adrClaimDateTo = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['adrClaimDateTo'] . ' 23:59:59') ) ) );
				
				$_REQUEST ['filter_date_left_reportedtime'] = strtotime ( $adrClaimDateFrom ) * 1000;
				$_REQUEST ['filter_date_right_reportedtime'] = strtotime ( $adrClaimDateTo ) * 1000;
				$filter = $this->getDateFilter ( 'reportedtime', '', 'reportedtime', '' );
				$filters [] = $filter;
			}
			
			$result = $this->managerUser->getHistoricalRouteByUser ( $filters );
			
			if (empty ( $result )) {
				$data [] = array (
						"userid" => "no_data_found",
						"latitude" => "no_data_found",
						"longitude" => "no_data_found" 
				);
			} else {
				
				/* @var $point AdrUserPoint */
				foreach ( $result as $point ) {
					
					$data [] = array (
							"userid" => $point->getUserId (),
							"latitude" => $point->getLatitude (),
							"longitude" => $point->getLongitude () 
					);
				}
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	/**
	 * Get the detail of the user position
	 *
	 * @throws InvalidArgumentException
	 * @return AjaxRender
	 */
	public function getPositionDetailByUser() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		
		try {
			$filters = array ();
			
			if (! isset ( $_REQUEST ['userId'] ) || $_REQUEST ['userId'] == '') {
				$_SESSION ['logger']->debug ( 'userId parameter expected.' );
				throw new InvalidArgumentException ( 'userId parameter expected.' );
			} else {
				$filter = $this->getNumberFilter ( 'iduser', '', 10, 'iduser', '' );
				$filter->setSelectedValue ( $_REQUEST ['userId'] );
				$filters [] = $filter;
			}
			
			if (! isset ( $_REQUEST ['latitude'] ) || $_REQUEST ['latitude'] == '') {
				$_SESSION ['logger']->debug ( 'latitude parameter expected.' );
				throw new InvalidArgumentException ( 'latitude parameter expected.' );
			} else {
				$filter = $this->getNumberFilter ( 'latitude', '', 50, 'latitude', '' );
				$filter->setSelectedValue ( $_REQUEST ['latitude'] );
				$filters [] = $filter;
			}
			
			if (! isset ( $_REQUEST ['longitude'] ) || $_REQUEST ['longitude'] == '') {
				$_SESSION ['logger']->debug ( 'longitude parameter expected.' );
				throw new InvalidArgumentException ( 'longitude parameter expected.' );
			} else {
				$filter = $this->getNumberFilter ( 'longitude', '', 50, 'longitude', '' );
				$filter->setSelectedValue ( $_REQUEST ['longitude'] );
				$filters [] = $filter;
			}
			
			$result = $this->managerUser->getAdrUserPositionDetail ( $filters );
			
			if (empty ( $result )) {
				$data [] = array (
						"userId" => "no_data_found",
						"date" => "no_data_found",
						"time" => "no_data_found",
						"id" => "no_data_found" 
				);
			} else {
				
				/* @var $point AdrUserPoint */
				foreach ( $result as $point ) {
					
					$dateTime = $point->getReportedTime () / 1000;
					$date = date ( Util::getLiteral ( 'date_format' ), $dateTime );
					$time = date ( ' H:i:s', $dateTime );
					
					$data [] = array (
							"userid" => $point->getUserId (),
							"date" => $date,
							"time" => $time,
							"id" => $point->getId () 
					);
				}
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	/**
	 * Get the history report data
	 *
	 * @throws InvalidArgumentException
	 * @return AjaxRender
	 */
	public function getUserHistoryReportByUser() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		
		try {
			$filters = array ();
			
			if (! isset ( $_REQUEST ['userId'] ) || $_REQUEST ['userId'] == '') {
				$_SESSION ['logger']->debug ( 'userId parameter expected.' );
				throw new InvalidArgumentException ( 'userId parameter expected.' );
			} else {
				$filter = $this->getNumberFilter ( 'uz.systemuserid', '', 10, 'uz.systemuserid', '' );
				$filter->setSelectedValue ( $_REQUEST ['userId'] );
				$filters [] = $filter;
			}
			
			// TODO: pasar de date a timestamp y crear el filtro (non existe un filtro numerico between, armarlo aca)
			$dateFrom = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateFrom'] . ' 00:00:01') ) ) );
			$dateFrom = strtotime ( $dateFrom ) * 1000;
			
			$dateTo = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateTo'] . ' 23:59:59') ) ) );
			$dateTo = strtotime ( $dateTo ) * 1000;
			
			$result = $this->managerUser->getAdrUserHistoryReport ( $filters, $dateFrom, $dateTo );
			
			 
			
			if (empty ( $result )) {
				$data [] = array (
						"zone" => "no_data_found",
						"timeIn" => "no_data_found",
						"timeOut" => "no_data_found",
						"timeInZone" => "no_data_found" 
				);
			} else {
				
				$reportItem = null;
				/* @var $event AdrUserZoneEvent */
				foreach ( $result as $event ) {
					
					if ($event->getEvent () == EnumAdrUserHistory::EVENTIN) {
						$reportItem = new AdrUserReport ();
						
						$reportItem->setZoneIn ( $event->getEventTimestamp () );
						
						$reportItem->setZoneName ( $event->getZoneName () );
					} else {
						
						if ($reportItem != null) {
							
							$reportItem->setZoneOut ( $event->getEventTimestamp () );
							
							$dateIn = DateTime::createFromFormat ( 'd/m/Y H:i:s', date ( 'd/m/Y H:i:s', $reportItem->getZoneIn () / 1000 ) );
							$diff = $dateIn->diff ( DateTime::createFromFormat ( 'd/m/Y H:i:s', date ( 'd/m/Y H:i:s', $reportItem->getZoneOut () / 1000 ) ) );
							
							$inZoneTime = $diff->days . 'd ' . $diff->h . 'h ' . $diff->i . 'm ' . $diff->s . 's ';
							
							$data [] = array (
									
									"zone" => $reportItem->getZoneName (),
									"timeIn" => $reportItem->getZoneInFormated (),
									"timeOut" => $reportItem->getZoneOutFormated (),
									"timeInZone" => $inZoneTime 
							);
						}
					}
				}
			}
		} catch ( Exception $e ) {
			$_SESSION ['logger']->debug ( 'No data found.' );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	public function getUserActivityReport() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrUserReportActivity.class.php';
		$data = array ();
		
		$filters = array ();
		$filtersHistorical = array ();
		
		if (! isset ( $_REQUEST ['userId'] ) || $_REQUEST ['userId'] == '') {
			$_SESSION ['logger']->debug ( 'userId parameter expected.' );
			throw new InvalidArgumentException ( 'userId parameter expected.' );
		} else {
			$filter = $this->getNumberFilter ( 'useractivity.iduser', '', 10, 'useractivity.iduser', '' );
			$filter->setSelectedValue ( $_REQUEST ['userId'] );
			$filters [] = $filter;
			$filterHistorical = $this->getNumberFilter ( 'historicalreportuseractivity.iduser', '', 10, 'historicalreportuseractivity.iduser', '' );
			$filterHistorical->setSelectedValue ( $_REQUEST ['userId'] );
			$filtersHistorical [] = $filterHistorical;
		}
		
		$idUser = $_REQUEST ['userId'];
		 
		$dateFrom = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateFrom'] . ' ' . $_REQUEST ['timeFrom']) ) ) );
		$dateFrom = strtotime ( $dateFrom ) * 1000;
		
		$dateTo = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateTo'] . ' ' . $_REQUEST ['timeTo']) ) ) );
		$dateTo = strtotime ( $dateTo ) * 1000;
		
		$dateFromInit = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateFrom'] . '00:00:00') ) ) );
		
		$dateToInit = date ( 'Y-m-d  H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateTo'] . '00:00:00') ) ) );
		
		$milisFrom = strtotime ( $dateFromInit );
		$milisTo = strtotime ( $dateToInit );
		
		$dateNow = date ( 'Y-m-d 00:00:00' );
		
		$milisNow = strtotime ( $dateNow );
		$historical = array ();
		$result = array ();
		$dateNowFrom = date ('Y-m-d '.$_REQUEST ['timeFrom']);
		$dateNowTo = date ('Y-m-d '.$_REQUEST ['timeTo']);
		
		$dateNowFrom = strtotime ( $dateNowFrom ) * 1000;
		$dateNowTo = strtotime ( $dateNowTo ) * 1000;
		
		if (($milisNow > $milisFrom) && ($milisNow <= $milisTo)) { // intervalo
			
			$historical = $this->managerUser->getHistoricalReportUserActivity ( $filtersHistorical, $dateFrom, $dateTo, $idUser );
			$result = $this->managerUser->getUserActivityReport ( $filters, $dateNowFrom, $dateNowTo, $idUser );
		} else if (($milisNow == $milisFrom) && ($milisNow == $milisTo)) {
			
			$result = $this->managerUser->getUserActivityReport ( $filters, $dateNowFrom, $dateNowTo, $idUser );
		} else {
			
			$historical = $this->managerUser->getHistoricalReportUserActivity ( $filtersHistorical, $dateFrom, $dateTo, $idUser );
		}
		
		$unattended = array ();
		$reportMerged = array_merge ( $result, $historical );
		
		if (empty ( $reportMerged )) {
			$data [] = array (
					"codeclaim" => "no_data_found",
					"state" => "no_data_found",
					"timeIn" => "no_data_found",
					"timeOut" => "no_data_found",
					"timeInZone" => "no_data_found",
					"address" => "no_data_found" 
			);
		} else {
			/**
			 * @var $substate AdrSubstateActivityUser
			 */
			foreach ( $reportMerged as $substate ) {
				
				$reportItem = new AdrUserReportActivity ();
				if ($substate->getClaim ()->getStateName () != '-') {
					$reportItem->setState ( Util::getLiteral ( $substate->getClaim ()->getStateName () ) );
				} else {
					
					$reportItem->setState ( $substate->getClaim ()->getStateName () );
				}
				
				$reportItem->setCodeClaim ( $substate->getClaim ()->getCode () );
				$reportItem->setDateZoneIn ( $substate->getTimeZoneIn () );
				$reportItem->setDateZoneOut ( $substate->getTimeZoneOut () );
				$reportItem->setTimeZone ( $substate->getTimeZone () );
				$reportItem->setTraslado ( $substate->getTranslate () );
				
				if (! $reportItem->getTraslado () == "" && ! is_null ( $reportItem->getTraslado () )) {
					$data [] = array (
							"codeclaim" => "TRASLADO",
							"state" => "",
							"timeIn" => $reportItem->getTraslado (),
							"timeOut" => "",
							"timeInZone" => "",
							"address" => "",
							"unattended" => $substate->getUnattended () 
					);
				}
				
				if ($substate->getUnattended ()) {
					
					$unattended [] = array (
							"codeclaim" => $reportItem->getCodeClaim (),
							"state" => $reportItem->getState (),
							"timeIn" => $reportItem->getDateZoneIn (),
							"timeOut" => $reportItem->getDateZoneOut (),
							"timeInZone" => $reportItem->getTimeZone (),
							"address" => $substate->getClaim ()->getClaimAddress (),
							"unattended" => $substate->getUnattended () 
					);
				} else {
					$data [] = array (
							"codeclaim" => $reportItem->getCodeClaim (),
							"state" => $reportItem->getState (),
							"timeIn" => $reportItem->getDateZoneIn (),
							"timeOut" => $reportItem->getDateZoneOut (),
							"timeInZone" => $reportItem->getTimeZone (),
							"address" => $substate->getClaim ()->getClaimAddress (),
							"unattended" => $substate->getUnattended () 
					);
				}
				
			
			}
		}
		
		$data = array_merge ( $data, $unattended );
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return new AjaxRender ( json_encode ( $data ) );
	}
	
	
	
	public function getActivityUserForExport() {
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/classes/AdrUserReportActivity.class.php';
		$data = array ();
		
		$filters = array ();
		$filtersHistorical = array ();
		if (! isset ( $_REQUEST ['userId'] ) || $_REQUEST ['userId'] == '') {
			$_SESSION ['logger']->debug ( 'userId parameter expected.' );
			throw new InvalidArgumentException ( 'userId parameter expected.' );
		} else {
			$filter = $this->getNumberFilter ( 'useractivity.iduser', '', 10, 'useractivity.iduser', '' );
			$filter->setSelectedValue ( $_REQUEST ['userId'] );
			$filters [] = $filter;
			
			$filterHistorical = $this->getNumberFilter ( 'historicalreportuseractivity.iduser', '', 10, 'historicalreportuseractivity.iduser', '' );
			$filterHistorical->setSelectedValue ( $_REQUEST ['userId'] );
			$filtersHistorical [] = $filterHistorical;
		}
		
		//Obtenemos el usuario 
		$idUser = $_REQUEST ['userId'];
		$user = $this->managerUser->getUser($idUser);
		
		//Preparamos las fechas que son enviadas por REQUEST
		$dateFrom = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateFrom'] . ' ' . $_REQUEST ['timeFrom']) ) ) );
		$initDateString = $_REQUEST ['dateFrom'] . ' ' . $_REQUEST ['timeFrom'];
		
		$dateFrom = strtotime ( $dateFrom ) * 1000;
		
		$dateTo = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateTo'] . ' ' . $_REQUEST ['timeTo']) ) ) );
		$endDateString = $_REQUEST ['dateTo'] . ' ' . $_REQUEST ['timeTo'];
		$dateTo = strtotime ( $dateTo ) * 1000;
		$dateFromInit = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateFrom'] . '00:00:00') ) ) );
		
		$dateToInit = date ( 'Y-m-d  H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateTo'] . '00:00:00') ) ) );
		
		$milisFrom = strtotime ( $dateFromInit );
		$milisTo = strtotime ( $dateToInit );
		
		$dateNow = date ( 'Y-m-d 00:00:00' );
			
		
		$dateFromForDiff =new DateTime(date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateFrom'] . '00:00:00') ) ) ));
		$dateToForDiff = new DateTime( date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateTo'] . '00:00:00') ) ) ));
		
		
		$dateToFromDiff = $dateToForDiff->diff($dateFromForDiff);
		$differenceDays = $dateToFromDiff->days;
		$datesInitDay = array();
		$historicalByDate = array();
		$datesInitDay[] = $dateFromForDiff->format('Y-m-d H:i:s');
		for ($i = 0; $i < $differenceDays; $i++) {
			
			$dateFromForDiff->modify('+1 day');
			$d = $dateFromForDiff->format('Y-m-d H:i:s');
			$datesInitDay[] = $d;
		}
		
		$milisNow = strtotime ( $dateNow );
	
		$result = array ();
		$dateNowFrom = date ('Y-m-d '.$_REQUEST ['timeFrom']);
		$dateNowTo = date ('Y-m-d '.$_REQUEST ['timeTo']);		
		$dateNowFrom = strtotime ( $dateNowFrom ) * 1000;
		$dateNowTo = strtotime ( $dateNowTo ) * 1000;
		
		// En el histórico busco en los rangos de fecha que vienen 
		// En el de hoy busco en la fecha actual pero con la hora enviada
		$unattended = array();
				
		$unnatendedCountByDate = array();
		
		if (($milisNow > $milisFrom) && ($milisNow <= $milisTo)) { // intervalo
			
			$count = count($datesInitDay);
			
			isset($datesInitDay[$count-1]);
			
			foreach ($datesInitDay as $d) {
				
				//Formatear la fecha para agregarle la hora enviadas por parámetro
				$dateFromWithHour = date (str_replace('00:00:00', '', $d).$_REQUEST ['timeFrom']);
				$dateTowithHour = date (str_replace('00:00:00', '', $d).$_REQUEST ['timeTo']);				
				$dateFromWithHour = strtotime($dateFromWithHour)*1000;
				$dateTowithHour = strtotime($dateTowithHour)*1000;			
				$historicalByDate[$d] = $this->managerUser->getHistoricalReportUserActivity ( $filtersHistorical, $dateFromWithHour, $dateTowithHour, $idUser,false );
				$un= $this->managerUser->getHistoricalClaimsUnnatendedByDate($dateFromWithHour, $dateTowithHour, $idUser);
				$unnatendedCountByDate[$d] = count($un);
								
			}			
			
			$result[$dateNow] = $this->managerUser->getUserActivityReport ( $filters, $dateNowFrom, $dateNowTo, $idUser,false);
			$unattended = $this->managerUser->getUnnatendedClaim($idUser, $dateFrom, $dateTo);
			$unnatendedCountByDate[$dateNow] = count($unattended);
						
		} else if (($milisNow == $milisFrom) && ($milisNow == $milisTo)) {
			
			$result[$dateNow] = $this->managerUser->getUserActivityReport ( $filters, $dateNowFrom, $dateNowTo, $idUser,false);
			$unattended = $this->managerUser->getUnnatendedClaim($idUser, $dateFrom, $dateTo);
			$unnatendedCountByDate[$dateNow] = count($unattended);
		} else {
			
			foreach ($datesInitDay as $d) {
				
				//Formatear la fecha para agregarle la hora enviadas por parámetro
				$dateFromWithHour = date (str_replace('00:00:00', '', $d).$_REQUEST ['timeFrom']);
				$dateTowithHour = date (str_replace('00:00:00', '', $d).$_REQUEST ['timeTo']);				
				$dateFromWithHour = strtotime($dateFromWithHour)*1000;
				$dateTowithHour = strtotime($dateTowithHour)*1000;				
				//solo atendidos
				$historicalByDate[$d] = $this->managerUser->getHistoricalReportUserActivity ( $filtersHistorical, $dateFromWithHour, $dateTowithHour, $idUser,false);
				//procesar los atendidos y los no atendidos
				$un= $this->managerUser->getHistoricalClaimsUnnatendedByDate($dateFromWithHour, $dateTowithHour, $idUser);
				$unnatendedCountByDate[$d] = count($un); 
			}			
				$unattended = $this->managerUser->getHistoricalClaimsUnnatendedByDate($dateFrom, $dateTo, $idUser);
		}
			
		
		$resultMerge = array_merge($historicalByDate, $result);
		
		$data = $this->processReportByDate($resultMerge, $unattended,$user,$initDateString,$endDateString, $datesInitDay,$unnatendedCountByDate, true);

		return $data;
		
	}
		
	private function processReportByDate($data,$unnatendedClaims, $user,$initDateString,$endDateString,$dates, $unnatendedCountByDate,$processUnattended = true){

		$result = array();
		$row = array (
				"codeclaim" => "",
				"state" => "",
				"timeIn" => "",
				"timeOut" => "",
				"timeInZone" => "",
				"address" => "",
				"materials" => array(),
				"withoutfixingdetail" =>"",
				"claimaddress" => "",
				"latitude"=>"",
				"longitude"=>"",
				"region"=>"",
				"requestername"=> "",
				"requesterphone"=>	"",
				"entrydate" =>"",
				"closedate"=>"",
				"dependency" =>"",
				"piquete" =>"",
				"detail" =>"",
				"user"=>""
		
		);
		
		$summary = array(
				'user'=>strtoupper($user->getFirstName().' '.$user->getLastName() ),
				'initDate'=>$initDateString,
				'endDate'=>$endDateString,
				'totalPending' =>0,
				'totalClosed' =>0,
				'totalCancel' =>0,
				'totalAttended' =>0,
				'totalUnnatended' =>0,
				'totalAssigned' =>0,
				'totalHoursWorked' =>0,
				'sumarybydate' => array()
		);
		

		
		$ifData = false;
		$attended = array();
		
		$countTotalPendingClaim = 0;
		$countTotalClosedClaim = 0;
		$countTotalCancelClaim = 0;
		$countTotalAttended = 0;
		$countTotalUnnatended = 0;
		$countTotalAssigned = 0;
		$countTotalSecondsWorked = 0;
		
		foreach ($data as $date => $report) {
			//Por fecha vamos a buscar atendidos, no atendidos, horas trabajadas por reclamo mas traslado
			$listHoursWorked = array();
			$listHoursTraslate = array();
			$listIdsToFilter= array();
			$includeTraslate = false;
			//Sumario por fecha
			$summaryClaimsByDate = array (
					'countunattended' => 0,
					'countattended' => 0,
					'countpendingclaim' => 0,
					'countclosedclaim' => 0,
					'countcancelclaim' => 0,
					'countassigned' => 0,
					'hoursworked'=>0
					);
			$listIdsToFilter[$date]['pendingtofilter'] = array();
			$listIdsToFilter[$date]['closedtofilter'] = array();
			$listIdsToFilter[$date]['canceltofilter'] = array();
			$listIdsToFilter[$date]['unnatendedtofilter'] = array();
			$listIdsToFilter[$date]['attendedtofilter'] = array();
			
			//procesamos reporte
			/**
			 * @var $substate AdrSubstateActivityUser
			 */
			foreach ($report as $substate) {
				$ifData = true;
				$materials = array();
				
				if (! $substate->getTranslate () == "" && ! is_null ( $substate->getTranslate () )) {
					$result [] = array (
							"codeclaim" => "TRASLADO",
							"state" => "",
							"timeIn" => $substate->getTranslate (),
							"timeOut" => "",
							"timeInZone" => "",
							"address" => ""
					);
				//Sumar horas trabajadas para los traslados
				
					if(! $substate->getTranslate () == "" && ! is_null ( $substate->getTranslate () ) && $includeTraslate){
							
						$dateTraslate = $substate->getTimereporting();
						$dateTraslate = date('Y-m-d 00:00:00',  strtotime ( str_replace ( '/', '-', ($dateTraslate) ) ));
						$hoursTras = Util::getSecondsFromString($substate->getTranslate());
						$listHoursTraslate[$dateTraslate] [] = $substate->getTranslate();
							
						if(in_array($dateTraslate, $dates)){
					
							$summaryClaimsByDate['hoursworked']+= $hoursTras;
					
					
						}
							
					}
					
				}
				
				$without = null;
				$withoutFixing = new WithoutFixing("", "", "");
				
				//Populamos el reclamo para completar datos faltantes
				
				$claimId = $substate->getClaim ()->getId();
				$claim = $this->managerClaim->getClaim($claimId);
				if(isset($claim)){
						
					$substate->setClaim($claim);
										
				}
				
				
				if ($substate->getClaim ()->getStateId () == claimsConcepts::PENDINGSTATE) {
						
					$timeInPending = $substate->getTimeZoneIn();
					$datePending = '';
					$timeReporting = $substate->getTimereporting();
					$timeZoneIn = $substate->getTimeZoneIn();
						
					if(isset($timeInPending) && !empty($timeInPending)){
				
						$datePending = date('Y-m-d 00:00:00',  strtotime ( str_replace ( '/', '-', ($timeInPending) ) ));
				
					}else if(isset($timeReporting) && !empty($timeReporting)){
				
						if(is_numeric($timeReporting)){
								
							$datePending = date('Y-m-d 00:00:00',  $timeReporting/1000);
				
						}else{
								
							$datePending = date('Y-m-d 00:00:00',  strtotime ( str_replace ( '/', '-', ($timeReporting) ) ));
								
						}
								
				
					}
						
						
					if(in_array($datePending, $dates)){
				
				
						$listIdsToFilter[$datePending]['pendingtofilter'][]= $substate->getClaim ()->getId();
							
				
					}
						
						
						
				}elseif ($substate->getClaim ()->getStateId () == claimsConcepts::CLOSEDSTATE) {
					
					$timeInClosed = $substate->getTimeZoneIn();
					$dateClose = '';
					$timeReporting = $substate->getTimereporting();
						
					if(isset($timeInClosed) && !empty($timeInClosed)){
					
						$dateClose = date('Y-m-d 00:00:00',  strtotime ( str_replace ( '/', '-', ($timeInClosed) ) ));
					
					}else if(isset($timeReporting) && !empty($timeReporting)){
					
						if(is_numeric($timeReporting)){
								
							$dateClose = date('Y-m-d 00:00:00',  $timeReporting/1000);
						
						}else{
								
							
							$dateClose = date('Y-m-d 00:00:00',  strtotime ( str_replace ( '/', '-', ($timeReporting) ) ));
								
						}			
										
					
					}					
					
					$materialsClaims = $this->managerClaim->getMaterialsByClaim($substate->getClaim ()->getId());
					foreach ($materialsClaims as $material) {
						
						$materials[] =$material->getName();
						
					}
					
					$detail = $this->managerClaim->getClosedDescription($substate->getClaim ()->getId());
					
					$substate->getClaim ()->setDetail($detail);
					
					if(in_array($dateClose, $dates)){
										
						$listIdsToFilter[$dateClose]['closedtofilter'][] = $substate->getClaim ()->getId();
										
					}
					
					
				}else if ($substate->getClaim ()->getStateId () == claimsConcepts::CANCELLEDSTATE) {
					
					$timeInCanceled = $substate->getTimeZoneIn();
					$timeReporting = $substate->getTimereporting();						
					$dateCancel = '';
					
					
					if(isset($timeInCanceled) && !empty($timeInCanceled)){
							
						$dateCancel = date('Y-m-d 00:00:00',  strtotime ( str_replace ( '/', '-', ($timeInCanceled) ) ));
							
					}else if(isset($timeReporting)){
							
						if(is_numeric($timeReporting)){
						
							$dateCancel = date('Y-m-d 00:00:00',  $timeReporting/1000);
						
						}else{						
								
							$dateCancel = date('Y-m-d 00:00:00',  strtotime ( str_replace ( '/', '-', ($timeReporting) ) ));
						
						}	
							
					}
					
					$without = $this->managerClaim->getWithoutFixingByClaim($substate->getClaim ()->getId());

					
					if(in_array($dateCancel, $dates)){
														
						$listIdsToFilter[$dateCancel]['canceltofilter'] [] = $substate->getClaim ()->getId();
							
							
					}
						
				}
				
				
				if(isset($without) && !is_null($without)){
				
					$withoutFixing = $without;
				
				}
				
				$substate->getClaim ()->setWithoutFixingDetail($withoutFixing->getName());
				$entryDate = 	$substate->getClaim ()->getEntryDate();
				$closeDate = $substate->getClaim ()->getClosedDate();
				
				//Armamos el una fila para cada reclamo
				
				$row = array (
						"codeclaim" => $substate->getClaim ()->getCode (),
						"state" => Util::getLiteral ( $substate->getClaim ()->getStateName () ),
						"timeIn" => $substate->getTimeZoneIn (),
						"timeOut" => $substate->getTimeZoneOut (),
						"timeInZone" => $substate->getTimeZone (),
						"address" => $substate->getClaim ()->getClaimAddress () ,
						"materials" => $materials,
						"withoutfixingdetail" =>$substate->getClaim ()->getWithoutFixingDetail(),
						"claimaddress" => $substate->getClaim ()->getClaimAddress(),
						"latitude"=>$substate->getClaim ()->getLatitude(),
						"longitude"=>$substate->getClaim ()->getLongitude(),
						"region"=>$substate->getClaim ()->getRegionName(),
						"requestername"=> $substate->getClaim ()->getRequesterName(),
						"requesterphone"=>	$substate->getClaim ()->getRequesterPhone(),
						"entrydate" =>isset($entryDate)&&$entryDate?$entryDate->format('d/m/Y'):'',
						"closedate"=>isset($closeDate)&&$closeDate?$closeDate->format('d/m/Y'):'',
						"dependency" =>$substate->getClaim ()->getDependencyName(),
						"piquete" =>$substate->getClaim ()->getPiquete(),
						"detail" =>$substate->getClaim()->getDetail(),
						"user"=>$user->getFirstName().' '.$user->getLastName()
				
				);
				
			
					$attended [] = $row;
					//Calculando horas trabajadas de solos los atendidos
					$timeZoneSub = $substate->getTimeZone();
					if(isset($timeZoneSub) && $substate->getTimeZoneIn() != '' && $substate->getTimeZoneOut() != '' && !$substate->getUnattended()){
							
						$hours = Util::getSecondsFromString($substate->getTimeZone());
						$timeZoneInHour = $substate->getTimeZoneIn();
						$dateIn = date('Y-m-d 00:00:00',  strtotime ( str_replace ( '/', '-', ($timeZoneInHour) ) ));
						$listHoursWorked[$dateIn][] = $substate->getTimeZone();
						if(in_array($dateIn, $dates)){
								
							$summaryClaimsByDate['hoursworked']+= $hours;
								
						}				
							
					}
					$dateAttended = date('Y-m-d 00:00:00', $substate->getTimereporting()/1000);
					$timeReporting = $substate->getTimereporting();
					$timeZoneIn = $substate->getTimeZoneIn();
						
						
					if(isset($timeReporting)){
							
						if(is_numeric($timeReporting)){
				
							$dateAttended = date('Y-m-d 00:00:00', $timeReporting/1000);
				
						}else{
				
							$dateAttended = date('Y-m-d 00:00:00', strtotime ( str_replace ( '/', '-', ($timeReporting) ) ));
				
						}
				
					}else if(isset($timeZoneIn)){
							
							
						if(is_numeric($timeZoneIn)){
				
							$dateAttended = date('Y-m-d 00:00:00', $timeZoneIn/1000);
				
						}else {
				
							$dateAttended = date('Y-m-d 00:00:00', strtotime ( str_replace ( '/', '-', ($timeZoneIn) ) ));
				
						}
							
							
					}
						
					if(in_array($dateAttended, $dates)){
							
						$listIdsToFilter[$dateAttended]['attendedtofilter'] [] = $substate->getClaim ()->getId();
							
							
					}
						
						
					
				
				$includeTraslate = $substate->getTimeZoneIn() != '' && $substate->getTimeZoneOut() != ''; // incluyo el traslado en las horas ?
								
				
				
			}//end for each by substate
			
			//Contadores parciales por fecha
			$countPendingClaim = 0;
			$countClosedClaim = 0;
			$countCancelClaim = 0;
			$countAttended = 0;
			$countUnnatended = $unnatendedCountByDate[$date];
			
			$countClosedClaim = count ( array_values ( array_unique ( $listIdsToFilter[$date]['closedtofilter'] ) ) );
			$countCancelClaim = count ( array_values ( array_unique ( $listIdsToFilter[$date]['canceltofilter'] ) ) );
			$countAttended = count ( array_values ( array_unique ( $listIdsToFilter[$date]['attendedtofilter'] ) ) );
			
// 			$countPendingClaim = count ( array_values ( array_unique ( $listIdsToFilter[$date]['pendingtofilter'] ) ) );
			$countPendingClaim = ($countUnnatended + $countAttended) - ($countClosedClaim + $countCancelClaim) ;
			//Contadores totales			
		
			
			$countTotalPendingClaim += $countPendingClaim;
			$countTotalClosedClaim += $countClosedClaim;
			$countTotalCancelClaim += $countCancelClaim;
			$countTotalAttended += $countAttended;
			$countTotalUnnatended += $countUnnatended;
					
			
			//Estableciendo totales por fecha
			$dateFromWithHour = date (str_replace('00:00:00', '', $date).$_REQUEST ['timeFrom']);
			$dateTowithHour = date (str_replace('00:00:00', '', $date).$_REQUEST ['timeTo']);
			$dateFromWithHour = strtotime($dateFromWithHour)*1000;
			$dateTowithHour = strtotime($dateTowithHour)*1000;
					
			
			$summaryClaimsByDate['countunattended'] = $unnatendedCountByDate[$date];		
			
			$summaryClaimsByDate['countattended'] = $countAttended;
			$summaryClaimsByDate['countpendingclaim'] = $countPendingClaim;
			$summaryClaimsByDate['countclosedclaim'] = $countClosedClaim;
			$summaryClaimsByDate['countcancelclaim'] = $countCancelClaim;
			$summaryClaimsByDate['countassigned'] =  $countUnnatended + $countAttended;
			$secondsWorkedByDate = $summaryClaimsByDate['hoursworked'];
			
			$summaryClaimsByDate['hoursworked'] = Util::getHoursStringFromSeconds($secondsWorkedByDate);
			$countTotalSecondsWorked += $secondsWorkedByDate;
			$summary['sumarybydate'][$date] = $summaryClaimsByDate;
			
				
				
		}//end for each by date
		
		$unnatendedByDate = array();
		
			/**
			 * @var $substateUnattended AdrSubstateActivityUser
			 * 
			 */
			foreach ($unnatendedClaims as $substateUnattended) {
				$materials = array();
				$row = array (
						"codeclaim" => $substateUnattended->getClaim ()->getCode (),
						"state" => Util::getLiteral ( $substateUnattended->getClaim ()->getStateName () ),
						"timeIn" => $substateUnattended->getTimeZoneIn (),
						"timeOut" => $substateUnattended->getTimeZoneOut (),
						"timeInZone" => $substateUnattended->getTimeZone (),
						"address" => $substateUnattended->getClaim ()->getClaimAddress () ,
						"materials" => $materials,
						"withoutfixingdetail" =>$substateUnattended->getClaim ()->getWithoutFixingDetail(),
						"claimaddress" => $substateUnattended->getClaim ()->getClaimAddress(),
						"latitude"=>$substateUnattended->getClaim ()->getLatitude(),
						"longitude"=>$substateUnattended->getClaim ()->getLongitude(),
						"region"=>$substateUnattended->getClaim ()->getRegionName(),
						"requestername"=> $substateUnattended->getClaim ()->getRequesterName(),
						"requesterphone"=>	$substateUnattended->getClaim ()->getRequesterPhone(),
						"entrydate" =>'',
						"closedate"=>'',
						"dependency" =>$substateUnattended->getClaim ()->getDependencyName(),
						"piquete" =>$substateUnattended->getClaim ()->getPiquete(),
						"detail" =>$substateUnattended->getClaim()->getDetail(),
						"user"=>$user->getFirstName().' '.$user->getLastName()
				
				);
				
				$unnatendedByDate[]= $row;
				
			}
			
		
		//Registrando totales
		$summary['totalPending'] = $countTotalPendingClaim;
		$summary['totalClosed'] = $countTotalClosedClaim;
		$summary['totalCancel'] = $countTotalCancelClaim;
		$summary['totalAttended'] = $countTotalAttended;
		$summary['totalUnnatended'] = $countTotalUnnatended;
		$summary['totalAssigned'] = "";
		$summary['totalHoursWorked'] = Util::getHoursStringFromSeconds($countTotalSecondsWorked);
		//Si no hay datos
		if(!$ifData){
			$attended[] = $row;
			$result['dataclaims'] = $attended;
			$result['sumary'] = $summary;
		}else{
			
			$list = array_merge($attended, $unnatendedByDate);
			$result['dataclaims'] = $list;
			$result['sumary'] = $summary;
				
		}	
		
		return $result;
		
	}//end method
	
	/**
	 * Export process
	 *
	 * @return RenderActionResponse
	 */
	public function export() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		try {
			
			set_time_limit ( 0 );
			
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/ExportXLS.view.php';
			
			$export = new ExportXLS ();
			
			$header1 = array (
					'N° RECLAMO',
					'FECHA CREACIÓN',
					'FECHA/HORA ENTRADA',
					'FECHA/HORA SALIDA',
					'FECHA/HORA CIERRE',						
					'ESTADO',
					'TIEMPO EN ZONA',
					'MOTIVO BAJA',
					'OPERARIO',
					'UBICACIÓN/REGIÓN',
					'DOMICILIO',
					'CONTRIBUYENTE',
					'TELÉFONO',	
					'PIQUETE',				
					'MATERIAL 1',
					'MATERIAL 2',
					'MATERIAL 3',
					'MATERIAL 4',
					'MATERIAL 5',
					'DETALLE',
					'DEPENDENCIA'
			);
			
			$header2 = array (
					'FECHA',
					'CON ACTIVIDAD',
					'SIN ACTIVIDAD',
					'PENDIENTES',
					'BAJA',
					'CERRADOS',
					'ASIGNADOS' ,
					'HORAS TRABAJADAS'
			);
			
			
			$header3= array('DETALLE DE TAREAS', 'OPERADOR:');
			$list = $this->getActivityUserForExport ();
			
			$html = $export->export ( $header1, $header2, $header3, $list ['dataclaims'], $list ['sumary'] );
			
			$render = new RenderActionResponse ( $html );
		} 

		catch ( Exception $e ) {
			
			$html = $e->getMessage ();
			
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
			
			$masterView = MasterFactory::getMaster ();
			
			$view = $masterView->render ( $html );
			
			$render = new RenderActionResponse ( $view );
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		
		return $render;
	}
	public function getCoordsUserActivity() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		// $data = array();
		
		$data = $this->getHistoricalCoordForUser ();
		
		$filters = array ();
		
		if (! isset ( $_REQUEST ['userId'] ) || $_REQUEST ['userId'] == '') {
			$_SESSION ['logger']->debug ( 'userId parameter expected.' );
			throw new InvalidArgumentException ( 'userId parameter expected.' );
		} else {
			$filter = $this->getNumberFilter ( 'useractivity.iduser', '', 10, 'useractivity.iduser', '' );
			$filter->setSelectedValue ( $_REQUEST ['userId'] );
			$filters [] = $filter;
		}
		
		$dateFrom = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateFrom'] . ' ' . $_REQUEST ['timeFrom']) ) ) );
		$dateFrom = strtotime ( $dateFrom ) * 1000;
		
		$dateTo = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateTo'] . ' ' . $_REQUEST ['timeTo']) ) ) );
		$dateTo = strtotime ( $dateTo ) * 1000;
		
		$dateNow = date ( 'Y-m-d 00:00:01' );
		$dateNow = strtotime ( $dateNow ) * 1000;
		
		$dateNowFrom = date ( 'Y-m-d 00:00:00' );
		$dateNowTo = date ( 'Y-m-d 23:59:00' );
		$dateNowFrom = strtotime ( $dateNowFrom ) * 1000;
		$dateNowTo = strtotime ( $dateNowTo ) * 1000;
		
		$results = $this->managerUser->getCoordsUserActivity ( $filters, $dateNowFrom, $dateNowTo );
		
		/* @var $result Claim */
		
		foreach ( $results as $result ) {
			
			if ($result instanceof Claim) {
				$isCritical = $this->managerClaim->getCheckCriticalPendingClaim ( $result->getId () );
				$data [0] ['reclamos'] [] = array (
						"id" => $result->getId (),
						"code" => $result->getCode (),
						"stateId" => $result->getStateId (),
						"stateName" => $result->getStateName (),
						"isCritical" => $isCritical,
						"stateId" => $result->getStateId (),
						"substateId" => $result->getSubstateId (),
						"lat" => $result->getLatitude (),
						"long" => $result->getLongitude () 
				);
			} else if ($result instanceof AdrPlan) {
				$data [0] ['empresas'] [] = array (
						"id" => $result->getId (),
						"name" => $result->getName (),
						"lat" => $result->getLatitude (),
						"long" => $result->getLongitude (),
						"address" => $result->getAddress () 
				);
			}
		}
		
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
		return new AjaxRender ( json_encode ( $data ) );
	}
	public function getUnattendedCoordsClaimForUser() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		
		$data = array ();
		
		$filters = array ();
		
		if (! isset ( $_REQUEST ['userId'] ) || $_REQUEST ['userId'] == '') {
			$_SESSION ['logger']->debug ( 'userId parameter expected.' );
			throw new InvalidArgumentException ( 'userId parameter expected.' );
		} else {
			$filter = $this->getNumberFilter ( 'useractivity.iduser', '', 10, 'useractivity.iduser', '' );
			$filter->setSelectedValue ( $_REQUEST ['userId'] );
			$filters [] = $filter;
		}
		
		$dateFrom = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateFrom'] . ' ' . $_REQUEST ['timeFrom']) ) ) );
		$dateFrom = strtotime ( $dateFrom ) * 1000;
		$dateTo = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateTo'] . ' ' . $_REQUEST ['timeTo']) ) ) );
		$dateTo = strtotime ( $dateTo ) * 1000;
		
		$dateFromInit = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateFrom'] . '00:00:00') ) ) );
		
		$dateToInit = date ( 'Y-m-d  H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateTo'] . '00:00:00') ) ) );
		
		$milisFrom = strtotime ( $dateFromInit );
		$milisTo = strtotime ( $dateToInit );
		
		$dateNow = date ( 'Y-m-d 00:00:00' );
		
		$milisNow = strtotime ( $dateNow );
		$result = array ();
		$dateNowFrom = date ( 'Y-m-d 00:00:00' );
		$dateNowTo = date ( 'Y-m-d 23:59:00' );
		$dateNowFrom = strtotime ( $dateNowFrom ) * 1000;
		$dateNowTo = strtotime ( $dateNowTo ) * 1000;
		
		$results = array ();
		if (($milisNow > $milisFrom && $milisNow <= $milisTo) || ($milisNow == $milisFrom && $milisNow == $milisTo)) { // intervalo
			$results = $this->managerUser->getUnattendedCoordsClaimForUser ( $filters, $dateFrom, $dateTo, $_REQUEST ['userId'] );
		}
		
		$reclamos = array ();
		
		/* @var $result Claim */
		
		foreach ( $results as $result ) {
			
			$isCritical = $this->managerClaim->getCheckCriticalPendingClaim ( $result->getId () );
			$reclamos [] = array (
					"id" => $result->getId (),
					"code" => $result->getCode (),
					"stateId" => $result->getStateId (),
					"stateName" => $result->getStateName (),
					"isCritical" => $isCritical,
					"stateId" => $result->getStateId (),
					"substateId" => $result->getSubstateId (),
					"lat" => $result->getLatitude (),
					"long" => $result->getLongitude () 
			);
		}
		$data [] = array (
				"reclamos" => $reclamos 
		);
		
		return $data;
	}
	public function getHistoricalCoordForUser() {
		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );
		$data = $this->getUnattendedCoordsClaimForUser ();
		$filters = array ();
		
		$filtersRoutes = array ();
		
		$dateFrom = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateFrom'] . ' ' . $_REQUEST ['timeFrom']) ) ) );
		$dateFrom = strtotime ( $dateFrom ) * 1000;
		$dateTo = date ( 'Y-m-d H:i:s', strtotime ( str_replace ( '/', '-', ($_REQUEST ['dateTo'] . ' ' . $_REQUEST ['timeTo']) ) ) );
		$dateTo = strtotime ( $dateTo ) * 1000;
		
		if (! isset ( $_REQUEST ['userId'] ) || $_REQUEST ['userId'] == '') {
			$_SESSION ['logger']->debug ( 'userId parameter expected.' );
			throw new InvalidArgumentException ( 'userId parameter expected.' );
		} else {
			$filter = $this->getNumberFilter ( 'historicalreportuseractivity.iduser', '', 10, 'historicalreportuseractivity.iduser', '' );
			$filter->setSelectedValue ( $_REQUEST ['userId'] );
			$filters [] = $filter;
			
			$filterRoute = $this->getNumberFilter ( 'iduser', '', 10, 'iduser', '' );
			$filterRoute->setSelectedValue ( $_REQUEST ['userId'] );
			$filtersRoutes [] = $filterRoute;
			
			$_REQUEST ['filter_date_left_reportedtime'] = $dateFrom;
			$_REQUEST ['filter_date_right_reportedtime'] = $dateTo;
			$filterRoute = $this->getDateFilter ( 'reportedtime', '', 'reportedtime', '' );
			$filtersRoutes [] = $filterRoute;
		}
		
		$order = "ASC";
		$results = $this->managerUser->getHistoricalCoordUserActivity ( $filters, $dateFrom, $dateTo, $order, $_REQUEST ['userId'] );
		
		$rutas = array ();
		
		/* @var $result Claim */
		
		$data [0] ['empresas'] = array ();
		foreach ( $results as $result ) {
			
			if ($result instanceof Claim) {
				$isCritical = $this->managerClaim->getCheckCriticalPendingClaim ( $result->getId () );
				$data [0] ['reclamos'] [] = array (
						"id" => $result->getId (),
						"code" => $result->getCode (),
						"stateId" => $result->getStateId (),
						"stateName" => $result->getStateName (),
						"isCritical" => $isCritical,
						"stateId" => $result->getStateId (),
						"substateId" => $result->getSubstateId (),
						"lat" => $result->getLatitude (),
						"long" => $result->getLongitude () 
				);
			} else if ($result instanceof AdrPlan) {
				$data [0] ['empresas'] [] = array (
						"id" => $result->getId (),
						"name" => $result->getName (),
						"lat" => $result->getLatitude (),
						"long" => $result->getLongitude (),
						"address" => $result->getAddress () 
				);
			}
		}
		
		// Add puntos
		$routes = $this->managerUser->getHistoricalRouteByUser ( $filtersRoutes );
		
		foreach ( $routes as $point ) {
			
			$rutas [] = array (
					"userid" => $point->getUserId (),
					"latitude" => $point->getLatitude (),
					"longitude" => $point->getLongitude () 
			);
		}
		
		$data [0] ['rutas'] = $rutas;
		
		return $data;
	}
}
