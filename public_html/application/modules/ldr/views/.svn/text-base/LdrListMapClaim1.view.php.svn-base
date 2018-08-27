<?php
class LdrListMapClaim1 extends Render {

	static public function render () {

		ob_start();

		?>

		<link href="/modules/ldr/css/ldr.css" rel="stylesheet" type="text/css" />
		
		<div id="map_canvas_container">
			<div id="map_canvas" style="width: 450px; height: 500px; "></div>
		</div> 
		<input type="hidden" id="timer" value="" />
		
		
		<script type="text/javascript">
		var initialInterval;
		$(document).ready(function(){

			// get session parameters
			languageIsoUrl = "<?=$_SESSION['s_languageIsoUrl']?>";
			closedState = <?=claimsConcepts::CLOSEDSTATE?>;
			substateYouCanCancel = <?=claimsConcepts::SUBSTATE_YOU_CAN_CANCEL?>;
			cancelledState = <?=claimsConcepts::CANCELLEDSTATE?>;
			substateYouCanClose = <?=claimsConcepts::SUBSTATE_YOU_CAN_CLOSE?>;
			substateCameToThePlace = <?=claimsConcepts::SUBSTATE_CAME_TO_THE_PLACE?>;
			
			// get user data
			getUserPosition();

			//get company data
			getCompanyPosition();
					
			// Load map
			loadGoogleMaps();

			$('#timer').val('15000');

			initialInterval = window.setInterval(function(){
				firstRefresh();
			}, 3000);

		});

		function firstRefresh(){
			window.clearInterval(initialInterval);
			genMapContent();
			getTimer();
		}
		
		</script>
		
		<?php

//     	$_REQUEST['jsToLoad'][] = "/modules/ldr/js/ldr.js";
    	$_REQUEST['jsToLoad'][] = "/modules/ldr/js/ldr-map.js";
				
		return ob_get_clean();
	}
	
}
?>