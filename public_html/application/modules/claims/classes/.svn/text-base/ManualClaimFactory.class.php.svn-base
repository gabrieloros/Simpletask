<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ManualClaimCreator.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/enums/claims.enum.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ManualClaimType.class.php';

class ManualClaimFactory {

	function __construct() {
	}

	/**
	 * Creates an manual claim and configures it
	 * @param string $originName
	 * @throws InvalidArgumentException
	 * @return Importer
	 */
	public function create(){

		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		$claimType = new ManualClaimType();

		$creator = new ManualClaimCreator($claimType);

		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $creator;

	}
}
?>