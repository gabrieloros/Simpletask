<?php
class AdrPlansList extends Render {

	static public function render ($list, $filterGroup, $pager, $actions, $numrows) {
		
		ob_start();
		?>
		
		
		<?
		echo $filterGroup->drawForm();
    	?>
    
    	<br />
    	
		<?php
    	//Actions
    	echo $actions;

    	//Counters
    	?>
    	<div class="plans-counters">
    	<?php
	    	echo '<div>' . Util::getLiteral('total_plans') . ': ' . $numrows . '</div>';
    	?>
    	</div>
    	
    	<div style="clear:both;"></div>
  		
	   	<?php
		if(count($list) != 0) {
		?>
			<table class="table table-hover">
				<thead>
				<tr>
					<th><?=Util::getLiteral('plan_id')?></th>
					<th><?=Util::getLiteral('plan_name')?></th>
					<th><?=Util::getLiteral('plan_coordinateupdatetime_short')?> (<?=Util::getLiteral('plan_coordinateupdatetime_short_unit')?>)</th>
					<th><?=Util::getLiteral('plan_minutestoclose_short')?> (<?=Util::getLiteral('plan_minutestoclose_short_unit')?>)</th>
					<th><?=Util::getLiteral('plan_minutesforcancellation_short')?> (<?=Util::getLiteral('plan_minutesforcancellation_short_unit')?>)</th>
					<th><?=Util::getLiteral('plan_actions')?></th>
				</tr>
				</thead>
			<?php
			/* @var $adrPlan adrPlan */
			foreach ($list as $adrPlan){?>
				<tbody>
				<tr>
					<td><?php echo ($adrPlan->getId()) ?></td>
					<td><?php echo ($adrPlan->getName()) ?></td>
					<td><?php echo ($adrPlan->getCoordinateUpdateTime()) ?></td>
					<td><?php echo ($adrPlan->getClaimMinutesToCloseTime()) ?></td>
					<td><?php echo ($adrPlan->getClaimMinutesForCancellation()) ?></td>
					<td><div onclick="editPlan(<?=$adrPlan->getId()?>);" title="<?=Util::getLiteral('plan_edit')?>" class="btn btn-primary""><?=Util::getLiteral('plan_edit')?></div>
						<?php
						$display = '';

						if($adrPlan->getHasUser() != 0) {
							$display = 'style="display: none; "';
						}
						?>
						<div onclick="deletePlan(<?=$adrPlan->getId()?>);" title="<?=Util::getLiteral('plan_delete')?>" class="btn btn-primary" <?=$display?>><?=Util::getLiteral('plan_delete')?></div></td>

				</tr>

				</tbody>
			<?php }?>
			</table>
		 

		
		<?php 
		} else {
			echo '<div>'.$_SESSION['s_message']['no_results_found'].'</div>';
		}

		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/views/Pager.view.php';
		echo Pager::render($pager);    	

    	$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-plans.js";
				
		return ob_get_clean();
	}
	
}
?>
