									<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/managers/actions/ModuleActionManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/managers/AdrUsersManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/managers/ClaimsManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/ldr/managers/ClosureClaimManager.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterGroup.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/ldr/classes/ClaimClosure.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/common/EnumCommon.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/enums/claims.enum.php';

/**
 * Trata las acciones del usuario desde el telefono
 *
 * @author promero
 *
 */
class ldrActionManager extends ModuleActionManager {
	protected $managerUser;
	protected $managerClaim;
	protected $managerClosureClaim;
	protected $logger;
	function __construct() {
		$this->managerUser = AdrUsersManager::getInstance ();
		$this->managerClaim = ClaimsManager::getInstance ();
		$this->managerClosureClaim = ClosureClaimManager::getInstance ();

		$this->logger = $_SESSION ['logger'];
	}

	/**
	 * List Claim in Maps
	 *
	 * @param int $maxQuantity
	 */
	public function getList(/*$maxQuantity*/) {
		$this->logger->debug ( __METHOD__ . ' begin' );

		if($_SESSION['loggedUser']->getUserLogin() == 'fito') {
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/ldr/views/LdrListMapClaim2.view.php';
			$html .= LdrListMapClaim2::render ();
		} else {
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/ldr/views/LdrListMapClaim1.view.php';
			$html .= LdrListMapClaim1::render ();
		}

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';
		$masterView = MasterFactory::getMasterLdr();

		$view = $masterView->render ( $html );

		$render = new RenderActionResponse ( $view );

		$this->logger->debug ( __METHOD__ . ' end' );

		return $render;
	}

	/**
	 *
	 * @return RenderActionResponse
	 */
	public function closeClaimFormPhone() {
		$this->logger->debug ( __METHOD__ . ' begin' );

		$subConcept = 'ldrCloseClaimFormPhone';

		if (! isset ( $_SESSION ['loggedUser'] )) {
			throw new LoginException ( 'Login User Session invalid' );
		}

		if (! isset ( $_REQUEST ['claim_id'] )) {
			throw new UnexpectedValueException ( "Id Claim null" );
		}

		if (! isset ( $_REQUEST ['claim_action'] )) {
			throw new UnexpectedValueException ( "The action is null" );
		}

		$action_claim = $_REQUEST ['claim_action'];

		// obtengo el detalle del reclamo que quiere cerrar/dar de baja
		$claim = $this->managerClaim->getClaim ( $_REQUEST ['claim_id'] );

		$withoutFixings = $this->managerClosureClaim->getWithoutFixing ();
		$materials = $this->managerClosureClaim->getMaterials ();

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/ldr/views/LdrCloseClaimFormPhone.view.php';

		$html .= LdrCloseClaimFormPhone::render ( $claim, $action_claim, $withoutFixings, $materials );

		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/factories/MasterFactory.class.php';

		$masterView = MasterFactory::getMaster ();

		$view = $masterView->render ( $html );

		$render = new RenderActionResponse ( $view );

		$this->logger->debug ( __METHOD__ . ' end' );

		return $render;
	}

	/**
	 * @throws LoginException
	 * @throws UnexpectedValueException
	 * @return RenderActionResponse
	 */
	public function closeClaimPhone() {
		$this->logger->debug ( __METHOD__ . ' begin' );

		if (! isset ( $_SESSION ['loggedUser'] )) {
			throw new LoginException ( 'Login User Session invalid' );
		}

		$userId = $_SESSION ['loggedUser']->getId ();

		if (! isset ( $_REQUEST ['claim_id'] )) {
			throw new UnexpectedValueException ( "Id Claim null" );
		}

		if (! isset ( $_REQUEST ['action_claim'] )) {
			throw new UnexpectedValueException ( "The action is null" );
		}

		$stateCliamId = $_REQUEST ['action_claim'];

		$claimClosure = new ClaimClosure ();
		$claimClosure->setClaimId ( $_REQUEST ['claim_id'] );
		$claimClosure->setDescription ( $_REQUEST ['description'] );
		$claimClosure->setWithoutfixingldrId ( $_REQUEST ['without_fixing'] );
		$claimClosure->setSystemuserId ( $userId );
		$claimClosure->setMaterialldrId ( $_REQUEST ['material'] );

		$this->managerClaim->changeStateClaim ( $_REQUEST ['claim_id'], $stateCliamId );

		$materials = $this->managerClosureClaim->saveClosureClaim ( $claimClosure, $stateCliamId );

		$this->logger->debug ( __METHOD__ . ' end' );
		return $this->getList ();
	}

	/**
	 * Get all assigned claims positions for an user
	 * @throws LoginException
	 * @return AjaxRender
	 */
	public function getAssignedClaimsPositions() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$subConcept = 'ldrListMap';

		if (! isset ( $_SESSION ['loggedUser'] )) {
			throw new LoginException ( 'Login User Session invalid' );
		}

		$userId = $_SESSION ['loggedUser']->getId ();

		/* reclamos asignados */
		$filtersUsers = array ();
		$filtersUser = $this->getNumberFilter ( 'claimsystemuseradr.systemuseradrid', '', 10, 'claimsystemuseradr.systemuseradrid', '' );
		$filtersUser->setSelectedValue ( $userId );
		$filtersUsers [] = $filtersUser;
		$arrayClaim = $this->managerClaim->getAssignedClaimsForUser ( $filtersUsers, 'claimsystemuseradr.listplace' );

		if(empty($arrayClaim)) {
			$data [] = array(
					"id"			=> "",
					"code"			=> "no_data_found",
					"substate"		=> "",
					"latitude"		=> Util::getLiteral('adr_claims_latitude_error'),
					"longitude"		=> Util::getLiteral('adr_claims_longitude_error'),
					"subject"		=> "",
					"entryDate"		=> "",
					"inputType"		=> "",
					"cause"			=> "",
					"dependency"	=> "",
					"requester"		=> "",
					"claimAddress"	=> "",
					"requesterPhone" => ""
			);
		} else {
			/* @var $result Claim */
			foreach ($arrayClaim as $result) {

				$data [] = array(
						"id"			=> $result->getId(),
						"code"			=> $result->getCode(),
						"substate"		=> $result->getSubstateid(),
						"latitude"		=> $result->getLatitude(),
						"longitude"		=> $result->getLongitude(),
						"subject"		=> $result->getSubjectName(),
						"entryDate"		=> $result->getEntryDateForLDR(),
						"inputType"		=> $result->getInputTypeName(),
						"cause"			=> $result->getCauseName(),
						"dependency"	=> $result->getDependencyName(),
						"requester"		=> $result->getRequesterName(),
						"claimAddress"	=> $result->getClaimAddress(),
						"requesterPhone" => $result->getRequesterPhone()
				);

			}

		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
			
		return new AjaxRender(json_encode($data));

	}


	/**
	 * Get all assigned claims positions for an user
	 * @throws LoginException
	 * @return AjaxRender
	 */
	private function getAssignedClaimsByUser($userId) {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$subConcept = 'ldrListMap';

		if (! isset ( $_SESSION ['loggedUser'] )) {
			throw new LoginException ( 'Login User Session invalid' );
		}

		$data = array();

		//$userId = $_SESSION ['loggedUser']->getId ();

		/* reclamos asignados */
		$filtersUsers = array ();
		$filtersUser = $this->getNumberFilter ( 'claimsystemuseradr.systemuseradrid', '', 10, 'claimsystemuseradr.systemuseradrid', '' );
		$filtersUser->setSelectedValue ( $userId );
		$filtersUsers [] = $filtersUser;
		$arrayClaim = $this->managerClaim->getAssignedClaimsForUser ( $filtersUsers, 'claimsystemuseradr.listplace' );

		if(!empty($arrayClaim)) {
			/* @var $result Claim */
			foreach ($arrayClaim as $result) {

				$data [] = array(
						"id"			=> $result->getId(),
						"code"			=> $result->getCode(),
						"substate"		=> $result->getSubstateid(),
						"latitude"		=> $result->getLatitude(),
						"longitude"		=> $result->getLongitude(),
						"subject"		=> $result->getSubjectName(),
						"entryDate"		=> $result->getEntryDateForLDR(),
						"inputType"		=> $result->getInputTypeName(),
						"cause"			=> $result->getCauseName(),
						"dependency"	=> $result->getDependencyName(),
						"requester"		=> $result->getRequesterName(),
						"claimAddress"	=> $result->getClaimAddress(),
						"requesterPhone" => $result->getRequesterPhone()
				);

			}

		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
			
		return $data;

	}


	/**
	 * Get the adr map positions
	 * @throws LoginException
	 * @return AjaxRender
	 */
	public function getADRMapData() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$subConcept = 'ldrListMap';

		if (! isset ( $_SESSION ['loggedUser'] )) {
			throw new LoginException ( 'Login User Session invalid' );
		}

		// 		$userId = $_SESSION ['loggedUser']->getId ();

		//Por cada usuario busco sus reclamos
		$data = array();

		//Busco todos los usuarios
		$userList = $this->managerUser->getAdrUsers(0, 10, null);

		foreach ($userList as $result) {

			$userId = $result->getId();

			//Busco su empresa
			$company = $this->getCompanyPositionByUser($userId);

			/* Ultima posición */
			$userLastPosition = $this->managerUser->getAdrUserCoordLast ($userId);
			$positions = count($userLastPosition);
			$userLastPosition = $userLastPosition[0];


			if($positions>0) {
				// Busco los reclamos del usuario
				$userClaims = $this->getAssignedClaimsByUser($userId);

				$user = array(
						"id"	=> $userLastPosition->getUserId(),
						"lat"	=> $userLastPosition->getLatitude(),
						"long"	=> $userLastPosition->getLongitude(),
						"name"  => $userLastPosition->getName(),
						"reporttime" =>   date('d/m H:i:s', $userLastPosition->getReportedTime() /1000),
						"company"   => $company,
						"claims"    => $userClaims
				);
				$data[] = $user;
			}
		}
			
		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
			
		return new AjaxRender(json_encode($data));

	}

	/**
	 * Get the user company position
	 * @throws LoginException
	 * @return data[]
	 */
	private function getCompanyPositionByUser($userId) {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$subConcept = 'ldrListMap';

		if (! isset ( $_SESSION ['loggedUser'] )) {
			throw new LoginException ( 'Login User Session invalid' );
		}

		//		$userId = $_SESSION ['loggedUser']->getId ();

		$data = array();

		/* @var $adruser AdrUser */
		$filtersCompanys = array ();
		$filtersCompany = $this->getNumberFilter ( 'u.systemuserid', '', 10, 'u.systemuserid', '' );
		$filtersCompany->setSelectedValue ( $userId );
		$filtersCompanys [] = $filtersCompany;

		/* posicion del plan / empresa punto de partida de los vehiculos */
		$companyPosition = $this->managerUser->getCompanyCoordsByUser ( $filtersCompanys );

		if(!empty($companyPosition)) {
			$data = array(
					"id"	=> $companyPosition[0]->getId(),
					"lat"	=> $companyPosition[0]->getLatitude(),
					"long"	=> $companyPosition[0]->getLongitude()
			);
		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
			
		return $data;

	}

	/**
	 * Get the last user position
	 * @throws LoginException
	 * @return AjaxRender
	 */
	public function getUserLastPosition() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$subConcept = 'ldrListMap';

		if (! isset ( $_SESSION ['loggedUser'] )) {
			throw new LoginException ( 'Login User Session invalid' );
		}

		$userId = $_SESSION ['loggedUser']->getId ();

		/* Ultima posición */
		$userLastPosition = $this->managerUser->getAdrUserCoordLast ( $userId);

		if(empty($userLastPosition)) {
			$data [] = array(
					"id"		=> "no_data_found",
					"lat"		=> Util::getLiteral('adr_claims_latitude_error'),
					"long"		=> Util::getLiteral('adr_claims_longitude_error'),
					"name"      => "no_data_found",
					"reporttime" => "no_data_found"
			);
		} else {
			/* @var $result2 AdrUserPoint */
			foreach ($userLastPosition as $result2) {

				$data [] = array(
						"id"	=> $result2->getUserId(),
						"lat"	=> $result2->getLatitude(),
						"long"	=> $result2->getLongitude(),
						"name"  => $result2->getName(),
						"reporttime" =>   date('d/m H:i:s', $result2->getReportedTime() /1000)
				);

			}

		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
			
		return new AjaxRender(json_encode($data));

	}

	/**
	 * Get the user company position
	 * @throws LoginException
	 * @return AjaxRender
	 */
	public function getCompanyPosition() {

		$_SESSION ['logger']->debug ( __METHOD__ . ' begin' );

		$subConcept = 'ldrListMap';

		if (! isset ( $_SESSION ['loggedUser'] )) {
			throw new LoginException ( 'Login User Session invalid' );
		}

		$userId = $_SESSION ['loggedUser']->getId ();

		/* @var $adruser AdrUser */
		$filtersCompanys = array ();
		$filtersCompany = $this->getNumberFilter ( 'u.systemuserid', '', 10, 'u.systemuserid', '' );
		$filtersCompany->setSelectedValue ( $userId );
		$filtersCompanys [] = $filtersCompany;

		/* posicion del plan / empresa punto de partida de los vehiculos */
		$companyPosition = $this->managerUser->getCompanyCoordsByUser ( $filtersCompanys );

		if(empty($companyPosition)) {
			$data [] = array(
					"id"		=> "no_data_found",
					"lat"		=> Util::getLiteral('adr_claims_latitude_error'),
					"long"		=> Util::getLiteral('adr_claims_longitude_error')
			);
		} else {
			/* @var $result AdrPlan */
			foreach ($companyPosition as $result) {

				$data [] = array(
						"id"	=> $result->getId(),
						"lat"	=> $result->getLatitude(),
						"long"	=> $result->getLongitude()
				);
			}
		}

		$_SESSION ['logger']->debug ( __METHOD__ . ' end' );
			
		return new AjaxRender(json_encode($data));

	}

}
