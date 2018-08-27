<?php

/**
 * AdrUserReport entity
 * @author 
 *
 */
class AdrUserReportActivity {

	private $codeClaim;
	private $state;
	private $dateZoneIn;
	private $dateZoneOut;
	private $timeZone;
	private $address;
	private $traslado;


	public function setCodeClaim($codeClaim){
		$this->codeClaim = $codeClaim;
	}

	public function getCodeClaim(){

		return $this->codeClaim;
	}

	public function setState($state){
		$this->state = $state;

	}
	 
	public function getState()
	{
		return $this->state;
	}

	public function setPropertyName($state)
	{
		$this->state = $state;
	}
	    
	public function getDateZoneIn() 
	{
	  return $this->dateZoneIn;
	}
	
	public function setDateZoneIn($dateZoneIn) 
	{
	  $this->dateZoneIn = $dateZoneIn;
	}
	
	    
	public function getDateZoneOut() 
	{
	  return $this->DateZoneOut;
	}
	
	public function setDateZoneOut($dateZoneOut) 
	{
	  $this->DateZoneOut = $dateZoneOut;
	}
		    
	public function getTimeZone() 
	{
	  return $this->timezone;
	}
	
	public function setTimeZone($timeZone) 
	{
	  $this->timezone = $timeZone;
	}	
	    
	public function getAddress() 
	{
	  return $this->address;
	}
	
	public function setAddress($address) 
	{
	  $this->address = $value;
	}
	
	
	    
	public function getTraslado() 
	{
	  return $this->traslado;
	}
	
	public function setTraslado($traslado) 
	{
	  $this->traslado = $traslado;
	}
}
?>