<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/ClaimType.class.php';
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/claims/classes/Claim.class.php';

/**
 * 
 * Class that defines the CAU's claim type. CAU = Centro de Atencion Unificada
 * @author Gabriel Guzman
 *
 */
class CAUClaimType extends ClaimType {
	
	function __construct() {
	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see ClaimType::parse()
	 * Parses an array and seeks for CAU-formatted claims
	 * @return boolean
	 */
	public function parse($data){
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' begin' );
		
		if(!isset($data) || $data == null || !is_array($data)){
			$_SESSION ['logger']->error("Data variable to parse must be an array");
			throw new InvalidArgumentException("Data variable to parse must be an array");
		}
		
		$parsedData = array();
			
		//Check if is CAU valid claim list
		$firstColumnLabel = trim($data[4]['A']);
		
		if($firstColumnLabel != claimsConcepts::CLAIMTYPECAUCOLUMNCHECK){
			$_SESSION['logger']->error("Invalid file format");
			throw new InvalidArgumentException("Invalid file format");
		}

		$claimInvalid = array();
		//Remove the first three row, left only claims data
		$parsedData = array_slice($data, 4);

		if(count($parsedData) > 0){

			$counter = 0;
			
			foreach ($parsedData as $row){
				$i =0;
				$parsedData[$i] =  $parsedData [$i+1];

				//Entry date
				$entryDate = date("d/m/Y");
				
				//Address
				$address = '';
				$addresForGeoLocation = '';
				// columna M
				/*if(isset($row['I'])){
					$address .= $row['I'];
					$addresForGeoLocation .= $row['I']; 
				}*/
				if(isset($row['M'])){
					$address .= $row['M'];
					$addresForGeoLocation .= $row['M'];
				}
				//colum P
				/*if(isset($row['J'])){
					$address .= ' ' . $row['J'];
					$addresForGeoLocation .= ' ' . $row['J'];
				}*/
				if(isset($row['P'])){
					$address .= ' ' . $row['P'];
					$addresForGeoLocation .= ' ' . $row['P'];
				}
				
				/*
				 * Datos no necesarios para el nuevo excel
				 *
				 * if(isset($row['K']))
					$address .= ' ' . $row['K'];

				if(isset($row['L']))
					$address .= ' ' . $row['L'];*/
				//colum N
				/*if(isset($row['M']))
					$address .= ' ' . $row['M'];*/
				if(isset($row['N']))
					$address .= ' ' . $row['N'];

				$claimObj = new Claim(null, $row['C'], $row['H'], $address, $row['I']);
				
				//Set entry date				
				$claimObj->setEntryDate($entryDate, 'd/m/Y');
				
				//Set input type
				$inputTypeId = array_search(Util::cleanString($row['A']), $_SESSION['claimsConcepts']['inputtypes']);
				if($inputTypeId !== false){
					$claimObj->setInputTypeId($inputTypeId);
				}
				else{
					$claimObj->setInputTypeId('NULL');
				}
				$claimObj->setDetail($row['L']);



				//Set origin
				$originId = array_search(claimsConcepts::CLAIMTYPECAU, $_SESSION['claimsConcepts']['origins']);
				if($originId !== false){
					$claimObj->setOriginId($originId);
				}
				
				//Set subject
				$subjectId = array_search(Util::cleanString($row['E']), $_SESSION['claimsConcepts']['subjects']);
				if($subjectId !== false){
					$claimObj->setSubjectId($subjectId);
				}
				else{
					$claimObj->setSubjectId('NULL');
				}
				
				//Set cause
				$availableCauses = array();
				foreach ($_SESSION['claimsConcepts']['causes'] as $key => $cause){
					$availableCauses [$key] = $cause ["name"];
				}
				
				$causeId = array_search(Util::cleanString($row['F']), $availableCauses);

				if($causeId !== false){
					$claimObj->setCauseId($causeId);


					//Set dependency
					//The current XLF for CAU doesn't have the dependency field
					$claimObj->setDependencyId($_SESSION['loggedUser']->getDependencyid());

					//Set assigned
					//Currently all the claims are marked as assigned, in the future it will change
					$claimObj->setAssigned('true');

					//Set state
					//By default is pending
					$claimObj->setStateId(claimsConcepts::PENDINGSTATE);

					//Get GeoLocation data
					if(trim($addresForGeoLocation) != ''){

						require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/util/GoogleAPI/GeoLocation.class.php';

						$fullAddress = trim($addresForGeoLocation) . ' ' . $_SESSION['loggedUser']->getLocationName() . ' ' . $_SESSION['loggedUser']->getProvinceName() . ' ' . $_SESSION['loggedUser']->getCountryName();

						$geoLocation = new GeoLocation();
						$geoCodes = $geoLocation->getGeoLocationFromAddress($fullAddress);

						if(is_array($geoCodes) && count($geoCodes) > 0){
							$claimObj->setLatitude($geoCodes ['lat']);
							$claimObj->setLongitude($geoCodes ['lon']);
						}

					}

					$result = $claimObj->insert();

					if(!$result){
						$_SESSION['logger']->error("Error inserting claim");
						throw new Exception("Error inserting claim", $counter);
					}
					$counter ++;
				}
				else{
					//guardarlo en una lista para despues mostrar el motivo.
					$claimObj->setCauseId('NULL');

					$id = $claimObj->getCode();

					array_push($claimInvalid,array($id,$row['F']));



				}


			}

			?>
			<button type="button" class="btn btn-info" data-toggle="modal" data-target=".bs-example-modal-lg">Resultados de la Importacion</button>

			<div class="modal fade bs-example-modal-lg" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">


				<table class="table">
					<thead>
					<tr>
						<th>Identificador</th>
						<th>Motivo</th>
						<th>Detalle</th>
					</tr>
					</thead>
					<tbody>

						<?php
						foreach ($claimInvalid as list($a,$b) ) {?>

					<tr class="warning">
						<td><?php echo "$a"; ?></td>
						<td> <?php echo "$b"; ?></td>
						<td> Motivo no válido para el sistema</td>
					</tr>
						<?php }
						?>

					</tbody>
				</table>

			</div>
			</div></div>
			<?php



			//var_dump($claimInvalid);
		}
		else{
			$_SESSION['logger']->error("Claims file is empty");
			throw new Exception("Claims file is empty");
		}
		
		$_SESSION ['logger']->debug ( __CLASS__ . '-' . __METHOD__ . ' end' );
		
		return count($parsedData);
		
	}
}