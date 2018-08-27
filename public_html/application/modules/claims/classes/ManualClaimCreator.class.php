<?php

/**
 * This class manages the creation of claims. Is responsible for invoking file loaders and array parsers.
* @author Gabriel Guzman
*
*/
class ManualClaimCreator {

	private $claimType;

	function __construct($claimType) {

		if(!is_a($claimType, "ClaimType")){
			$_SESSION ['logger']->error("Expected ClaimType objects");
			throw new InvalidArgumentException("Expected ClaimType objects");
		}

		$this->claimType = $claimType;

	}

	/**
	 * Invokes the array parser
	 * @throws Exception
	 * @return array $parsedData
	 */
	public function create($data){

		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );

		try {
				
			$createdData = $this->claimType->parse($data);
				
		} catch (Exception $e) {
			throw $e;
		}

		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );

		return $createdData;

	}

}

?>