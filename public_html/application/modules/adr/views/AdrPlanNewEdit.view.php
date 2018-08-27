<?php
class AdrPlanNewEdit extends Render {

	static public function render ($plan) {
		
		ob_start();

		/* @var $plan AdrPlan */
		?>
		<div class="row">
		<div class="col-md-4">

		</div>
		<div class="col-md-4"  >
		<div >
	  		<form id="adrPlanNewEditForm" name="adrPlanNewEditForm" method="POST" action="" autocomplete="off">
	  			<div >
		  			<label><?=Util::getLiteral('plan_name')?>:</label><input type="text" id="name" class="form-control" name="name" value="<?=$plan->getName()?>" />
		  		</div>
		  		<div >
		  			<label><?=Util::getLiteral('plan_coordinateupdatetime_short')?> (<?=Util::getLiteral('plan_coordinateupdatetime_short_unit')?>):</label>
		  			<input type="number"  class="form-control" name="coordinateUpdateTime" value="<?=$plan->getCoordinateUpdateTime()==''? 0: $plan->getCoordinateUpdateTime() ?>" style="width: 200px;" />
		  		</div>
		  		<div >
		  			<label style="float: left; display: inline; "><?=Util::getLiteral('plan_minutestoclose_short')?> (<?=Util::getLiteral('plan_minutestoclose_short_unit')?>):</label>
		  			<input type="number"  class="form-control" name="claimMinutesToCloseTime" value="<?=$plan->getClaimMinutesToCloseTime()==''? 0: $plan->getClaimMinutesToCloseTime() ?>" style="float: left; display: inline; width: 200px;" />
		  		</div>
		  		<br />
		  		<div >
		  			<label style="float: left; display: inline; "><?=Util::getLiteral('plan_minutesforcancellation_short')?> (<?=Util::getLiteral('plan_minutesforcancellation_short_unit')?>):</label>
		  			<input type="number"  class="form-control" name="claimMinutesForCancellation" value="<?=$plan->getClaimMinutesForCancellation()==''? 0: $plan->getClaimMinutesForCancellation() ?>" style="float: left; display: inline; width: 200px;" />
		  		</div>
		  		<br><br>
		  		<div >
		  			<label><?=Util::getLiteral('plan_latitude')?>:</label>
		  			<input type="number" id="claimLatitude" class="form-control" name="claimLatitude" value="<?=$plan->getLatitude()?>" />
		  		</div>
		  		<div >
		  			<label><?=Util::getLiteral('plan_longitude')?>:</label>
		  			<input type="number" id="claimLongitude" class="form-control" name="claimLongitude" value="<?=$plan->getLongitude()?>" />
		  		</div>
		  		<div  style="border-top: 1px solid #a9bdc6;">
		  			<input type="hidden" name="id" value="<?=$plan->getId()?>" />
		  			<div onclick="savePlan();" title="<?=Util::getLiteral('plan_save')?>" class="btn btn-success"><?=Util::getLiteral('plan_save')?></div>
		  			<div onclick="cancelSavePlan();" title="<?=Util::getLiteral('plan_cancel_save')?>" class="btn btn-danger"><?=Util::getLiteral('plan_cancel_save')?></div>
				</div>
			</form>
		</div>
		</div>

			<div class="col-md-4">

			</div>
		</div>

		<script type="text/javascript">
			jQuery().ready(function($) {
				$('#coordinateUpdateTime').spinner({ min: 0, max: 2000 });
			});
		
			jQuery().ready(function($) {
				$('#claimMinutesToCloseTime').spinner({ min: 0, max: 2000 });
			});

			jQuery().ready(function($) {
				$('#claimMinutesForCancellation').spinner({ min: 0, max: 2000 });
			});
		</script>
		
		<?php
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-plans.js";
				
		return ob_get_clean();
	}
	
}
?>