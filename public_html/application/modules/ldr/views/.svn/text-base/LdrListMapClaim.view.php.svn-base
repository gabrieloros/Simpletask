<?php
class LdrListMapClaim extends Render {

	static public function render ($width,$heigth,$userLastPosition,$arrayClaim,$companyPosition) {
		
		ob_start();
// 		$width = "150";
// 		$heigth = "200";
		?>

		<link href="/modules/ldr/css/ldr.css" rel="stylesheet" type="text/css" />
		
		<div id="map_canvas_container">
			<div id="map_canvas" style="width: <?=$width.'px'?>; height: <?=$heigth.'px' ?>"></div>
		</div> 
		
		
		<script type="text/javascript">
		<?		$countPoint = count($arrayClaim);?>
		var map;

		function initialize() {

			<?php
			/* @var $companyPosition[0] AdrPlan */
			$companyPosition[0]->getLongitude();
			?>
			// map options
			var myOptions = {
				zoom : 13,
				center : new google.maps.LatLng('<?=$companyPosition[0]->getLatitude()?>','<?=$companyPosition[0]->getLongitude()?>'),
				mapTypeId : google.maps.MapTypeId.ROADMAP
			};
			
			
			document.getElementById('map_canvas').style.width=window.innerWidth + "px";
			document.getElementById('map_canvas').style.height=window.innerHeight+ "px";
			

			// the map
			map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

			// Define our origin position, the start of our trip.

			var infowindowBO = new google.maps.InfoWindow({
				content : '<div id="content"> Usuario </div>'
			});
			originPosition = new google.maps.Marker({
				position : new google.maps.LatLng('<?=$userLastPosition[0]->getLatitude()?>','<?=$userLastPosition[0]->getLongitude()?>'),
				icon : '../modules/adr/css/img/user_1.png',
				map : map
			});
			google.maps.event.addListener(originPosition, 'click', function() {
				infowindowBO.open(map, originPosition);
			});


			var infoWindowUserLastPosition = new google.maps.InfoWindow({
				content : '<div id="content"> Base de Operaciones </div>'
			});
			positionUser = new google.maps.Marker({
				position : new google.maps.LatLng('<?=$companyPosition[0]->getLatitude()?>','<?=$companyPosition[0]->getLongitude()?>'),
				icon : '../modules/adr/css/img/company.png',
				map : map
			});
			google.maps.event.addListener(positionUser, 'click', function() {
				infoWindowUserLastPosition.open(map, positionUser);
			});
			

			
			<?if($countPoint > 0){?>
			// directions service
			directionsService = new google.maps.DirectionsService();

			

			/***********Puntos Intermedios**************/
			wayPointArray = new Array();
			
			 
			<?
			$contador = 0 ;  
			$claimFinal = null;
			/* @var $cla Claim */
			foreach ($arrayClaim as $cla){
					$contador++ ;
					if($contador == $countPoint){
							$claimFinal = $cla;
					}else{
						$actionForm = '';
						if($cla->getSubstateid()==claimsConcepts::SUBSTATE_YOU_CAN_CANCEL){
							$actionForm = '<hr /> <form class="form-claim_closure" action="/'.$_SESSION['s_languageIsoUrl'].'/ldr?action=closeClaimFormPhone" name="closeClaimForm" method="post">'.
													'<input type="hidden" value="'.$cla->getId().'" name="claim_id" id="claim_id">'.
													'<input type="hidden" value="'.claimsConcepts::CLOSEDSTATE .'" name="claim_action" id="claim_action">'.
												  	'<input type="submit" value="Cerrar Reclamo"  class="form_bt">'.
										  		  '</form> <hr />';
						}elseif ($cla->getSubstateid()==claimsConcepts::SUBSTATE_YOU_CAN_CLOSE){
							$actionForm =' <hr /> <form class="form-claim_closure" action="/'.$_SESSION['s_languageIsoUrl'].'/ldr?action=closeClaimFormPhone" name="closeClaimForm" method="post">'.
											'<input type="hidden" value="'.$cla->getId().'" name="claim_id" id="claim_id">'.
											'<input type="hidden" value="'.claimsConcepts::CANCELLEDSTATE .'" name="claim_action" id="claim_action">'.
											'<input type="submit" value="Dar de BAJA Reclamo"  class="form_bt">'.
											'</form> <hr />';
						}
							?>
							
								var infowindowIntermedio_<?=$cla->getId()?> = new google.maps.InfoWindow({
									content : 	'<div id="infowHead">' +
				 								'	<ul id="double">' +
				 								'		<li>ID: <?=$cla->getCode()?></li>' +
				 								'		<li style="float: right; ">' + s_message["entry_date"] + ': <?=$cla->getEntryDate()->format("d/m/Y")?></li>' +
				 								'	</ul>' +
				 								'</div>' +
				 								'<div>' +
				 								'	<ul id="items">' +
				 								'		<li>' + s_message['subject_name'] + ': <?=addslashes($cla->getSubjectName())?></li>' +
				 								'		<li>' + s_message['input_type_name'] + ': <?=$cla->getInputTypeName()?></li>' +
				 								'		<li>' + s_message['cause_name'] + ': <?=$cla->getCauseName()?></li>' +
				 								'		<li>' + s_message['dependency'] + ': <?=$cla->getDependencyName()?></li>' +
				 								'		<li class="line"></li>' +
				 								'		<li>' + s_message['requester_name'] + ': <?=addslashes($cla->getRequesterName())?></li>' +
				 								'		<li>' + s_message['claim_address'] + ': <?=addslashes($cla->getClaimAddress())?></li>' +
				 								'		<li>' + s_message['requester_phone'] + ': <?=$cla->getRequesterPhone()?></li>' +
				 								'		<li class="line"></li>' +
				 								'	</ul>' +
				 								'<?=$actionForm?>'+
				 								'</div>'
								});

								var waypoint_<?=$cla->getId()?> = new google.maps.Marker({
									position : new google.maps.LatLng('<?=$cla->getLatitude()?>',
											'<?=$cla->getLongitude()?>'),
									icon : '../modules/claims/css/img/state_pending_<?=($cla->getSubstateid()==NULL||$cla->getSubstateid()==0||$cla->getSubstateid()==claimsConcepts::SUBSTATE_CAME_TO_THE_PLACE)?'assigned':$cla->getSubstateid()?>.png',
									map : map
								});

								
							
							google.maps.event.addListener(waypoint_<?=$cla->getId()?>, 'click', function() {
								infowindowIntermedio_<?=$cla->getId()?>.open(map, waypoint_<?=$cla->getId()?>);
							});
							
							wayPointArray.push({
								location : waypoint_<?=$cla->getId()?>.position,
								stopover : true
							});
			
					<?}//fin del else
			}// FIN DEL FOREACH?>
			/***********FIN Puntos Intermedios**************/

	

			<?
 
			$actionForm = '';
			if($claimFinal->getSubstateid()==claimsConcepts::SUBSTATE_YOU_CAN_CANCEL){
				$actionForm = '<hr /> <form class="form-claim_closure" action="/'.$_SESSION['s_languageIsoUrl'].'/ldr?action=closeClaimFormPhone" name="closeClaimForm" method="post">'.
						'<input type="hidden" value="'.$claimFinal->getId().'" name="claim_id" id="claim_id">'.
						'<input type="hidden" value="'.claimsConcepts::CLOSEDSTATE .'" name="claim_action" id="claim_action">'.
						'<input type="submit" value="Cerrar Reclamo"  class="form_bt">'.
						'</form> <hr />';
			}elseif ($claimFinal->getSubstateid()==claimsConcepts::SUBSTATE_YOU_CAN_CLOSE){
				$actionForm =' <hr /> <form class="form-claim_closure" action="/'.$_SESSION['s_languageIsoUrl'].'/ldr?action=closeClaimFormPhone" name="closeClaimForm" method="post">'.
						'<input type="hidden" value="'.$claimFinal->getId().'" name="claim_id" id="claim_id">'.
						'<input type="hidden" value="'.claimsConcepts::CANCELLEDSTATE .'" name="claim_action" id="claim_action">'.
						'<input type="submit" value="Dar de bAJA reclamo"  class="form_bt">'.
						'</form> <hr />';
			}
			
			?>
			var destinoInfowindowIntermedio_<?=$claimFinal->getId()?> = new google.maps.InfoWindow({
				content : 	'<div id="infowHead">' +
								'	<ul id="double">' +
								'		<li>ID: <?=$claimFinal->getCode()?></li>' +
								'		<li style="float: right; ">' + s_message["entry_date"] + ': <?=$claimFinal->getEntryDate()->format("d/m/Y")?></li>' +
								'	</ul>' +
								'</div>' +
								'<div>' +
								'	<ul id="items">' +
								'		<li>' + s_message['subject_name'] + ': <?=addslashes($claimFinal->getSubjectName())?></li>' +
								'		<li>' + s_message['input_type_name'] + ': <?=$claimFinal->getInputTypeName()?></li>' +
								'		<li>' + s_message['cause_name'] + ': <?=$claimFinal->getCauseName()?></li>' +
								'		<li>' + s_message['dependency'] + ': <?=$claimFinal->getDependencyName()?></li>' +
								'		<li class="line"></li>' +
								'		<li>' + s_message['requester_name'] + ': <?=addslashes($claimFinal->getRequesterName())?></li>' +
								'		<li>' + s_message['claim_address'] + ': <?=addslashes($claimFinal->getClaimAddress())?></li>' +
								'		<li>' + s_message['requester_phone'] + ': <?=$claimFinal->getRequesterPhone()?></li>' +
								'		<li class="line"></li>' +
								'	</ul>' +
								'<?=$actionForm?>'+
							'</div>'
			});
			

			destinationPosition = new google.maps.Marker({
				position : new google.maps.LatLng('<?=$claimFinal->getLatitude()?>',
						'<?=$claimFinal->getLongitude()?>'),
				icon : '../modules/claims/css/img/state_pending_<?=($claimFinal->getSubstateid()==NULL||$cla->getSubstateid()==0||$claimFinal->getSubstateid()==claimsConcepts::SUBSTATE_CAME_TO_THE_PLACE)?'assigned':$claimFinal->getSubstateid()?>.png',
				map : map
			});

			
		
			google.maps.event.addListener(destinationPosition, 'click', function() {
				destinoInfowindowIntermedio_<?=$claimFinal->getId()?>.open(map, destinationPosition);
			});
			

			


			var request = {
				origin : originPosition.position,
				destination : destinationPosition.position,
				waypoints : wayPointArray,
				travelMode : google.maps.DirectionsTravelMode.DRIVING,
				unitSystem : google.maps.DirectionsUnitSystem.METRIC,
				optimizeWaypoints : true
			};


			directionsService.route(request, function(response, status) {

				if (status == google.maps.DirectionsStatus.OK) {

					var polyOpts = {
						strokeOpacity : 1.0,
						strokeColor : '#0000FF',
						strokeWeight : 2
					};

					var directionsDisplayOptions = {
						suppressMarkers : true,
						suppressInfoWindows : true,
						preserveViewport : false,
						polylineOptions : polyOpts
					};

					directionsRenderer = new google.maps.DirectionsRenderer(
							directionsDisplayOptions);
					directionsRenderer.setMap(map);
					directionsRenderer.setDirections(response);

				} else {

					console.info('could not get route');
					console.info(response);

				}
			});
			

			<?php }?>

		}

		google.maps.event.addDomListener(window, 'load', initialize);

		



		</script>
		
		<?php

//     	$_REQUEST['jsToLoad'][] = "/modules/ldr/js/ldr.js";
				
		return ob_get_clean();
	}
	
}
?>