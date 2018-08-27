<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Claim.class.php';

/**
 * Electric Department Claim Entity
 * @author Gabriel Guzman
 *
 */
class CAUElectricClaim extends Claim {
	
	/**
	 * Nº de tulipas
	 * @var int
	 */
	private $tulipa;
	
	/**
	 * Nº de portalamparas
	 * @var int
	 */
	private $portalampara;
	
	/**
	 * Nº de canastos
	 * @var int
	 */
	private $canasto;
	
	/**
	 * Nº de fusibles
	 * @var int
	 */
	private $fusible;
	
	/**
	 * Nº de lamparas de 125
	 * @var int
	 */
	private $lamp_125;
	
	/**
	 * Nº de lamparas de 150
	 * @var int
	 */
	private $lamp_150;
	
	/**
	 * Nº de lamparas de 250
	 * @var int
	 */
	private $lamp_250;
	
	/**
	 * Nº de lamparas de 400
	 * @var int
	 */
	private $lamp_400;
	
	/**
	 * Nº de lamparas externas de 125
	 * @var int
	 */
	private $ext_125;
	
	/**
	 * Nº de lamparas externas de 150
	 * @var int
	 */
	private $ext_150;
	
	/**
	 * Nº de lamparas externas de 250
	 * @var int
	 */
	private $ext_250;
	
	/**
	 * Nº de lamparas externas de 400
	 * @var int
	 */
	private $ext_400;
	
	/**
	 * Nº de lamparas internas de 125
	 * @var int
	 */
	private $int_125;
	
	/**
	 * Nº de lamparas internas de 150
	 * @var int
	 */
	private $int_150;
	
	/**
	 * Nº de lamparas internas de 250
	 * @var int
	 */
	private $int_250;
	
	/**
	 * Nº de lamparas internas de 400
	 * @var int
	 */
	private $int_400;
	
	/**
	 * Nº de morcetos
	 * @var int
	 */
	private $morceto;
	
	/**
	 * Nº de espejos
	 * @var int
	 */
	private $espejo;
	
	/**
	 * Nº de columnas
	 * @var int
	 */
	private $columna;
	
	/**
	 * Nº de atrios
	 * @var int
	 */
	private $atrio;
	
	/**
	 * Nº de neutros
	 * @var int
	 */
	private $neutro;
	
	/**
	 * Nº de cables
	 * @var int
	 */
	private $cable;
	
	
	function __construct($id, $code, $claimAddress) {
		
		parent::setId($id);
		
		parent::setCode($code);
		
		parent::setClaimAddress($claimAddress);
	
	}
	
	public function insert(){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		$result = parent::insert();
		
		if(!$result){
			$_SESSION['logger']->error("Error inserting parent claim");
			throw new Exception("Error inserting parent claim");
		}
		
		$rs = true;
		
		if($result > 1){
			
			$claimData = array();
			
			$claimData['claimId'] = $result;
			
			$claimData['tulipa'] = $this->tulipa;
			$claimData['portalampara'] = $this->portalampara;
			$claimData['canasto'] = $this->canasto;
			$claimData['fusible'] = $this->fusible;
			$claimData['lamp_125'] = $this->lamp_125;
			$claimData['lamp_150'] = $this->lamp_150;
			$claimData['lamp_250'] = $this->lamp_250;
			$claimData['lamp_400'] = $this->lamp_400;
			$claimData['ext_125'] = $this->ext_125;
			$claimData['ext_150'] = $this->ext_150;
			$claimData['ext_250'] = $this->ext_250;
			$claimData['ext_400'] = $this->ext_400;
			$claimData['int_125'] = $this->int_125;
			$claimData['int_150'] = $this->int_150;
			$claimData['int_250'] = $this->int_250;
			$claimData['int_400'] = $this->int_400;
			$claimData['morceto'] = $this->morceto;
			$claimData['espejo'] = $this->espejo;
			$claimData['columna'] = $this->columna;
			$claimData['atrio'] = $this->atrio;
			$claimData['neutro'] = $this->neutro;
			$claimData['cable'] = $this->cable;
			
			$insertQuery = ClaimsDB::insertStreetLightsClaimData($claimData);
			
			$connectionManager = ConnectionManager::getInstance ();
				
			$rs = $connectionManager->executeTransaction($insertQuery);
			
			$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		}
		
		return $rs;
		
	}

	/**
	 * @return the $tulipa
	 */
	public function getTulipa() {
		return $this->tulipa;
	}

	/**
	 * @param int $tulipa
	 */
	public function setTulipa($tulipa) {
		$this->tulipa = $tulipa;
	}

	/**
	 * @return the $portalampara
	 */
	public function getPortalampara() {
		return $this->portalampara;
	}

	/**
	 * @param int $portalampara
	 */
	public function setPortalampara($portalampara) {
		$this->portalampara = $portalampara;
	}

	/**
	 * @return the $canasto
	 */
	public function getCanasto() {
		return $this->canasto;
	}

	/**
	 * @param int $canasto
	 */
	public function setCanasto($canasto) {
		$this->canasto = $canasto;
	}

	/**
	 * @return the $fusible
	 */
	public function getFusible() {
		return $this->fusible;
	}

	/**
	 * @param int $fusible
	 */
	public function setFusible($fusible) {
		$this->fusible = $fusible;
	}

	/**
	 * @return the $lamp_125
	 */
	public function getLamp_125() {
		return $this->lamp_125;
	}

	/**
	 * @param int $lamp_125
	 */
	public function setLamp_125($lamp_125) {
		$this->lamp_125 = $lamp_125;
	}

	/**
	 * @return the $lamp_150
	 */
	public function getLamp_150() {
		return $this->lamp_150;
	}

	/**
	 * @param int $lamp_150
	 */
	public function setLamp_150($lamp_150) {
		$this->lamp_150 = $lamp_150;
	}

	/**
	 * @return the $lamp_250
	 */
	public function getLamp_250() {
		return $this->lamp_250;
	}

	/**
	 * @param int $lamp_250
	 */
	public function setLamp_250($lamp_250) {
		$this->lamp_250 = $lamp_250;
	}

	/**
	 * @return the $lamp_400
	 */
	public function getLamp_400() {
		return $this->lamp_400;
	}

	/**
	 * @param int $lamp_400
	 */
	public function setLamp_400($lamp_400) {
		$this->lamp_400 = $lamp_400;
	}

	/**
	 * @return the $ext_125
	 */
	public function getExt_125() {
		return $this->ext_125;
	}

	/**
	 * @param int $ext_125
	 */
	public function setExt_125($ext_125) {
		$this->ext_125 = $ext_125;
	}

	/**
	 * @return the $ext_150
	 */
	public function getExt_150() {
		return $this->ext_150;
	}

	/**
	 * @param int $ext_150
	 */
	public function setExt_150($ext_150) {
		$this->ext_150 = $ext_150;
	}

	/**
	 * @return the $ext_250
	 */
	public function getExt_250() {
		return $this->ext_250;
	}

	/**
	 * @param int $ext_250
	 */
	public function setExt_250($ext_250) {
		$this->ext_250 = $ext_250;
	}

	/**
	 * @return the $ext_400
	 */
	public function getExt_400() {
		return $this->ext_400;
	}

	/**
	 * @param int $ext_400
	 */
	public function setExt_400($ext_400) {
		$this->ext_400 = $ext_400;
	}

	/**
	 * @return the $int_125
	 */
	public function getInt_125() {
		return $this->int_125;
	}

	/**
	 * @param int $int_125
	 */
	public function setInt_125($int_125) {
		$this->int_125 = $int_125;
	}

	/**
	 * @return the $int_150
	 */
	public function getInt_150() {
		return $this->int_150;
	}

	/**
	 * @param int $int_150
	 */
	public function setInt_150($int_150) {
		$this->int_150 = $int_150;
	}

	/**
	 * @return the $int_250
	 */
	public function getInt_250() {
		return $this->int_250;
	}

	/**
	 * @param int $int_250
	 */
	public function setInt_250($int_250) {
		$this->int_250 = $int_250;
	}

	/**
	 * @return the $int_400
	 */
	public function getInt_400() {
		return $this->int_400;
	}

	/**
	 * @param int $int_400
	 */
	public function setInt_400($int_400) {
		$this->int_400 = $int_400;
	}

	/**
	 * @return the $morceto
	 */
	public function getMorceto() {
		return $this->morceto;
	}

	/**
	 * @param int $morceto
	 */
	public function setMorceto($morceto) {
		$this->morceto = $morceto;
	}

	/**
	 * @return the $espejo
	 */
	public function getEspejo() {
		return $this->espejo;
	}

	/**
	 * @param int $espejo
	 */
	public function setEspejo($espejo) {
		$this->espejo = $espejo;
	}

	/**
	 * @return the $columna
	 */
	public function getColumna() {
		return $this->columna;
	}

	/**
	 * @param int $columna
	 */
	public function setColumna($columna) {
		$this->columna = $columna;
	}

	/**
	 * @return the $atrio
	 */
	public function getAtrio() {
		return $this->atrio;
	}

	/**
	 * @param int $atrio
	 */
	public function setAtrio($atrio) {
		$this->atrio = $atrio;
	}

	/**
	 * @return the $neutro
	 */
	public function getNeutro() {
		return $this->neutro;
	}

	/**
	 * @param int $neutro
	 */
	public function setNeutro($neutro) {
		$this->neutro = $neutro;
	}

	/**
	 * @return the $cable
	 */
	public function getCable() {
		return $this->cable;
	}

	/**
	 * @param int $cable
	 */
	public function setCable($cable) {
		$this->cable = $cable;
	}


}