<?php
class GeoLocationClaimsList extends Render {

	static public function render ($list, $pager) {
		
		ob_start();
		?>


		<br /><br />

		<table id="geoLocationList" class="table table-striped">
		<?php
    		
    	for($i=0 ; $i < count($list) ; $i++){
    		
    		$element = $list[$i];
    		?>

			<tbody>
			<tr>
				<td>
					<div title="<?=$element->getCode()?>"><?=$element->getCode()?></div>

				</td>
				<td >
					<?php
					$claimAddress = $element->getClaimAddress();
					?>

					<div id="address_<?=$element->getId()?>"  title="<?=$element->getClaimAddress()?>" ><?=$element->getClaimAddress()?></div>

					<div style="color: #0b72ee" id="detail_<?=$element->getId()?>" ><?=$element->getDetail()?></div>


				</td>
				<td >
					<?php
					$requesterPhone = $element->getRequesterPhone();
					if(isset($requesterPhone) && $requesterPhone != null){
						?>
						<div  title="<?=$element->getRequesterPhone()?>">Teléfono: <?=$element->getRequesterPhone()?></div>
						<?php
					}
					?>
				</td>
				<td>

					<div  id="geolocate_button_<?=$element->getId()?>" class="btn btn-primary"  title="<?=Util::getLiteral('geolocate')?>" value="<?=$element->getId()?>"><?=Util::getLiteral('geolocate')?></div>

					<div style="display: none;" id="geo_location_container_<?=$element->getId()?>">
						<strong><?=Util::getLiteral('lat')?>:</strong> <span id="latitude_<?=$element->getId()?>"></span>
						<strong><?=Util::getLiteral('long')?>:</strong> <span id="longitude_<?=$element->getId()?>"></span>
					</div>
					<div id="confirm_button_<?=$element->getId()?>" class="btn btn-success" style=" display: none;"  title="<?=Util::getLiteral('confirm')?>" onclick="saveClaimGeoLocation(<?=$element->getId()?>);"><?=Util::getLiteral('confirm')?></div>
				</td>

				<td>
					<div id="close_button_<?=$element->getId()?>"  class="btn btn-danger" title="<?=Util::getLiteral('close_claim_no_geo')?>" onclick="closeClaimNoGeo(<?=$element->getId()?>,<?=claimsConcepts::CLOSEDSTATENOGEO?>);">
						<?=Util::getLiteral('close_claim_no_geo_short')?>
					</div>
				</td>

			</tr>

			</tbody>

    			

    		<?php
    		}
    		if(count($list) == 0){
    	    	echo '<tr><td colspan="5">'.$_SESSION['s_message']['no_results_found'].'</td></tr>';
    		}
    		?>
    	</table>


    		
		<?php
		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/views/Pager.view.php';
		echo Pager::render($pager);    	

		$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
    	$_REQUEST['jsToLoad'][] = "/modules/claims/js/claims.js";
    	$_REQUEST['jsToLoad'][] = "/modules/settings/js/layers.js";    	 
		return ob_get_clean();
	}
	
}