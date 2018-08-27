<?php


/**
 * Claim entity
 * @author Gabriel Oros
 *
 */
class ClaimMap {
	
	/**
	 * Claim id
	 * @var int
	 */
	private $id;
	
	/**
	 * Claim code
	 * @var string
	 */
	private $code;
	
	
	/**
	 * Claim latitude
	 * @var string
	 */
	private $latitude;
	
	/**
	 * Claim longitude
	 * @var string
	 */
	private $longitude;

		
	/**
	 * Claim nameGroup
	 * @var string
	 */
	private $namegroup;

		/**
	 * Claim icon
	 * @var string
	 */
	private $icon;

		/**
	 * Claim stateid
	 * @var string
	 */
	private $stateid;

	private $groupid;
	//----------------------------------------------------------------------------------
	function __construct($id, $code ) {
		
		$this->id = $id;
		
		$this->code = $code;
	
	}

	
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
	 * @return the $code
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @param string $code
	 */
	public function setCode($code) {
		$this->code = $code;
	}


	/**
	 * @return the $causeId
	 */
	public function getCauseId() {
		return $this->causeId;
	}

	/**
	 * @param int $causeId
	 */
	public function setCauseId($causeId) {
		$this->causeId = $causeId;
	}

	
	/**
	 * @return the $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}

	/**
	 * @param string $latitude
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	/**
	 * @return the $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}

	/**
	 * @param string $longitude
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	
	
	/**
	 * @return the $groupId
	 */
	public function getGroupid() {
		return $this->groupid;
	}

	/**
	 * @param int $groupId
	 */
	public function setGroupid($groupid) {
		$this->groupid = $groupid;
	}

	/**
	 * @return the $icon
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * @param int $groupId
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}

	/**
	 * @return the $namegroup
	 */
	public function getNamegroup() {
		return $this->namegroup;
	}

	/**
	 * @param int $groupId
	 */
	public function setNamegroup($namegroup) {
		$this->namegroup = $namegroup;
	}

	/**
	 * @return the $stateid
	 */
	public function getStateid() {
		return $this->stateid;
	}

	/**
	 * @param int $groupId
	 */
	public function setStateid($stateid) {
		$this->stateid = $stateid;
	}


			
}
