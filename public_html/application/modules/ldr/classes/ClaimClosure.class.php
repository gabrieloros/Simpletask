<?php
/**
 * Maneja el cierre del reclamo
 * 
 * @author pdavid.romero
 *
 */
class ClaimClosure{ 
	private $id;
	private $claimId;
	private $systemuserId;
	private $materialldrId;
	private $withoutfixingldrId;
	private $description;
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $claimId
	 */
	public function getClaimId() {
		return $this->claimId;
	}

	/**
	 * @return the $systemuserId
	 */
	public function getSystemuserId() {
		return $this->systemuserId;
	}

	/**
	 * @return the $materialldrId
	 */
	public function getMaterialldrId() {
		return $this->materialldrId;
	}

	/**
	 * @return the $withoutfixingldrId
	 */
	public function getWithoutfixingldrId() {
		return $this->withoutfixingldrId;
	}

	/**
	 * @return the $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $claimId
	 */
	public function setClaimId($claimId) {
		$this->claimId = $claimId;
	}

	/**
	 * @param field_type $systemuserId
	 */
	public function setSystemuserId($systemuserId) {
		$this->systemuserId = $systemuserId;
	}

	/**
	 * @param field_type $materialldrId
	 */
	public function setMaterialldrId($materialldrId) {
		$this->materialldrId = $materialldrId;
	}

	/**
	 * @param field_type $withoutfixingldrId
	 */
	public function setWithoutfixingldrId($withoutfixingldrId) {
		$this->withoutfixingldrId = $withoutfixingldrId;
	}

	/**
	 * @param field_type $description
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

}
?>