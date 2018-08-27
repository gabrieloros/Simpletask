<?php
class ClaimPicView extends Render {

	static public function render ($claimPic,$claim, $subjectsList, $inputTypeList, $causeList, $dependencyList, $stateList, $typeAddress = false) {
		
		ob_start();
	
		/* @var $claim Claim */
		$style = '';
		$disabledInputType = 'disabled="disabled"';
		$disabledEntryDate = 'disabled="disabled"';
		//Nuevo
		if($claim->getId() == null) {
			$style = 'style="display: none;"';
			$defaultState = claimsConcepts::PENDINGSTATE;
			$entryDate = date('d/m/Y');
			$origin = claimsConcepts::CLAIMTYPEMANUALID;
		//Existente
		} else {
			$entryDate = date('d/m/Y', strtotime(str_replace('/', '-', $claim->getEntryDateForDB())));
			$origin = $claim->getOriginId();
			$disabledInputType = '';
		}

		?>

		<script type="text/javascript">
		var geolocationEnabled = <?echo $typeAddress? 'false':'true'?>;
		</script>
		<div id="claim-new-edit">

			<?$imgData=  $claimPic->getPhoto();?>
			<?echo "<img height='400' width='400' src='data:image/jpeg;base64, $imgData' />";?>


			<div onclick="cancelSaveClaim();" title="salir" class="close_icon action_button">Salir</div>

		</div>

		<?php
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
    	$_REQUEST['jsToLoad'][] = "/modules/claims/js/claims.js";

		return ob_get_clean();
	}
	
}
?>