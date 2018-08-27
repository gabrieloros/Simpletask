<?php

/**
 * AdrUser entity
 * @author mmogrovejo
 *
 */
class AdrUser {

	/**
	 * AdrUser id
	 * @var int
	 */
	private $id;

	/**
	 * AdrUser userLogin 
	 * @var string
	 */
	private $userLogin;

	/**
	 * AdrUser password
	 * @var string
	 */
	private $password;

	/**
	 * AdrUser firstName
	 * @var string
	 */
	private $firstName;
	
	/**
	 * AdrUser lastName
	 * @var string
	 */
	private $lastName;
	
	/**
	 * AdrUser phoneNumber
	 * @var string
	 */
	private $phoneNumber;
	
	/**
	 * AdrUser phoneCompany
	 * @var string
	 */
	private $phoneCompany;

	/**
	 * AdrUser planId
	 * @var int
	 */
	private $planId;
	
	/**
	 * AdrUser planName
	 * @var string
	 */
	private $planName;
	
	/**
	 * AdrUser stateId
	 * @var int
	 */
	private $stateId;
	
	/**
	 * AdrUser stateName
	 * @var string
	 */
	private $stateName;
	
	
	private $registrationId;
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $userLogin
	 */
	public function getUserLogin() {
		return $this->userLogin;
	}

	/**
	 * @param string $userLogin
	 */
	public function setUserLogin($userLogin) {
		$this->userLogin = $userLogin;
	}

	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * @return the $firstName
	 */
	public function getFirstName() {
		return $this->firstName;
	}
	
	/**
	 * @param string $firstName
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}
	
	/**
	 * @return the $lastName
	 */
	public function getLastName() {
		return $this->lastName;
	}
	
	/**
	 * @param string $lastName
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * @return the $phoneNumber
	 */
	public function getPhoneNumber() {
		return $this->phoneNumber;
	}
	
	/**
	 * @param string $phoneNumber
	 */
	public function setPhoneNumber($phoneNumber) {
		$this->phoneNumber = $phoneNumber;
	}
	
	/**
	 * @return the $phoneCompany
	 */
	public function getPhoneCompany() {
		return $this->phoneCompany;
	}
	
	/**
	 * @param string $phoneCompany
	 */
	public function setPhoneCompany($phoneCompany) {
		$this->phoneCompany = $phoneCompany;
	}

	/**
	 * @return the $planId
	 */
	public function getPlanId() {
		return $this->planId;
	}
	
	/**
	 * @param string $planId
	 */
	public function setPlanId($planId) {
		$this->planId = $planId;
	}

	/**
	 * @return the $planName
	 */
	public function getPlanName() {
		return $this->planName;
	}
	
	/**
	 * @param string $planName
	 */
	public function setPlanName($planName) {
		$this->planName = $planName;
	}

	/**
	 * @return the $stateId
	 */
	public function getStateId() {
		return $this->stateId;
	}
	
	/**
	 * @param string $stateId
	 */
	public function setStateId($stateId) {
		$this->stateId = $stateId;
	}
	
	/**
	 * @return the $stateName
	 */
	public function getStateName() {
		return $this->stateName;
	}
	
	/**
	 * @param string $stateName
	 */
	public function setStateName($stateName) {
		$this->stateName = $stateName;
	}
	public function getRegistrationId() {
		return $this->registrationId;
	}
	public function setRegistrationId($registrationId) {
		$this->registrationId = $registrationId;
		return $this;
	}
	
	
}