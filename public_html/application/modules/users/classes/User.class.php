<?php
class User{
	
	private $id;
	
	private $username;
	
	private $usersurname;
	
	private $useremail;
	
	private $userlogin;
	
	private $userpassword;
	
	private $usertypeid;
	
	private $usertypename;
	
	private $dependencyid;
	
	private $dependencyname;
	
	private $locationname;
	
	private $provincename;
	
	private $countryname;
	
	private $locationid;
	
	private $locationmap;
	
	private $locationmapstyle;
	
	public function __construct($user = null){
		
		if ($user != null) {
			$this->autoLoad ( $user );
		}
	
	}
	
	/**
	 * Auto load of the object with existent data
	 * @author Gabriel Guzman
	 * @param array $user
	 */
	private function autoLoad($user) {
		
		Util::autoMapEntity ( $this, $user );
	
	}
	
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param field_type $username
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @return the $usersurname
	 */
	public function getUsersurname() {
		return $this->usersurname;
	}

	/**
	 * @param field_type $usersurname
	 */
	public function setUsersurname($usersurname) {
		$this->usersurname = $usersurname;
	}

	/**
	 * @return the $useremail
	 */
	public function getUseremail() {
		return $this->useremail;
	}

	/**
	 * @param field_type $useremail
	 */
	public function setUseremail($useremail) {
		$this->useremail = $useremail;
	}

	/**
	 * @return the $userlogin
	 */
	public function getUserlogin() {
		return $this->userlogin;
	}

	/**
	 * @param field_type $userlogin
	 */
	public function setUserlogin($userlogin) {
		$this->userlogin = $userlogin;
	}

	/**
	 * @return the $userpassword
	 */
	public function getUserpassword() {
		return $this->userpassword;
	}

	/**
	 * @param field_type $userpassword
	 */
	public function setUserpassword($userpassword) {
		$this->userpassword = $userpassword;
	}

	/**
	 * @return the $usertypeid
	 */
	public function getUsertypeid() {
		return $this->usertypeid;
	}

	/**
	 * @param field_type $usertypeid
	 */
	public function setUsertypeid($usertypeid) {
		$this->usertypeid = $usertypeid;
	}

	/**
	 * @return the $usertypename
	 */
	public function getUsertypename() {
		return $this->usertypename;
	}

	/**
	 * @param field_type $usertypename
	 */
	public function setUsertypename($usertypename) {
		$this->usertypename = $usertypename;
	}
	
	/**
	 * @return the $dependencyid
	 */
	public function getDependencyid() {
		return $this->dependencyid;
	}

	/**
	 * @param field_type $dependencyid
	 */
	public function setDependencyid($dependencyid) {
		$this->dependencyid = $dependencyid;
	}

	/**
	 * @return the $dependencyname
	 */
	public function getDependencyname() {
		return $this->dependencyname;
	}

	/**
	 * @param field_type $dependencyname
	 */
	public function setDependencyname($dependencyname) {
		$this->dependencyname = $dependencyname;
	}

	/**
	 * @return the $locationname
	 */
	public function getLocationname() {
		return $this->locationname;
	}

	/**
	 * @param field_type $locationname
	 */
	public function setLocationname($locationname) {
		$this->locationname = $locationname;
	}

	/**
	 * @return the $provincename
	 */
	public function getProvincename() {
		return $this->provincename;
	}

	/**
	 * @param field_type $provincename
	 */
	public function setProvincename($provincename) {
		$this->provincename = $provincename;
	}

	/**
	 * @return the $countryname
	 */
	public function getCountryname() {
		return $this->countryname;
	}

	/**
	 * @param field_type $countryname
	 */
	public function setCountryname($countryname) {
		$this->countryname = $countryname;
	}
	
	/**
	 * @return the $locationid
	 */
	public function getLocationid() {
		return $this->locationid;
	}

	/**
	 * @param field_type $locationid
	 */
	public function setLocationid($locationid) {
		$this->locationid = $locationid;
	}
	
	/**
	 * @return the $locationmap
	 */
	public function getLocationmap() {
		return $this->locationmap;
	}

	/**
	 * @param field_type $locationmap
	 */
	public function setLocationmap($locationmap) {
		$this->locationmap = $locationmap;
	}

	/**
	 * @return the $locationmapstyle
	 */
	public function getLocationmapstyle() {
		return $this->locationmapstyle;
	}

	/**
	 * @param field_type $locationmapstyle
	 */
	public function setLocationmapstyle($locationmapstyle) {
		$this->locationmapstyle = $locationmapstyle;
	}
	
}