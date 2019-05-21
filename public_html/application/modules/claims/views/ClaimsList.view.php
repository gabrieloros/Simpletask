<?php
class ClaimsList extends Render {

	static public function render ($list, $filterGroup, $pager, $actions, $counters,$dataUser) {

		ob_start();

		/* @var $element Claim */

		?>

		<style>
			.table1{
				margin-top: -20px;
			},
			.panel-heading {
				padding: 0px 3px;
				border-bottom: 1px solid transparent;
				border-top-left-radius: 3px;
				border-top-right-radius: 3px;
			},

			.tdTitle{
								 font-size: 14px;}

			.divInfo{
				font-size: 12px;}
		</style>
		<br />

		<?
		echo $filterGroup->drawForm();
    	?>

    	<br />

    	<?php
    	//Actions
    	echo $actions;

    	//Counters
    	if(is_array($counters) && count($counters) > 0){

    		?>
    		<div>
				<table  >
					<tbody>


					<tr>






    		<?php
	    	foreach ($counters as $key => $counter){
	    		echo '<td >' . Util::getLiteral($_SESSION['claimsConcepts']['states'][$key]) . ':  <span class="badge">' . $counter . '</span></td>';
	    	}
    		?>

					</tr>

					</tbody>
				</table>
    		</div>
		<br>
    		<div style="clear:both;"></div>
    		<?php
    	}
    	?>


	<form id="massiveActionsForm" name="massiveActionsForm" method="post" action="/<?=$_REQUEST['urlargs'][0]?>/<?=$_REQUEST['urlargs'][1]?>?action=changeClaimState">

		<?php
		for($i=0 ; $i < count($list) ; $i++){
			$element = $list[$i];

			$rowClass = "par";
			if($i%2){
				$rowClass = "impar";
			}


			$state = 0;

			if($element->getStateId() == claimsConcepts::PENDINGSTATE){

				$day = $element->getDaypending();
				// $now = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
				// $diff = $now->diff($element->getEntryDate());
				// $years = $diff->y;
				// $months = $diff->m;
				// $days = $diff->d;
				//$years > 0 || $months > 0 || $days >=
				if( -($day) > claimsConcepts::CRITICALPENDINGSTATETIME){
					$state = 1;
				}
			}
			$nameCode = substr($element->getCode(),0,3 );

			$cause = $element->getCauseId();
			$priority = $element->getPriority();


			// var_dump($element->getCode());
			// die();

			$dependencyName = $element->getDependencyName();
			$thirdCellWidth = '28%';
			$fourthCellWidth = '2%';
			if(isset($dependencyName) && $dependencyName != null){
				$thirdCellWidth = '30%';
				$fourthCellWidth = '10%';
			}
						$colorState = null;
						$closedDate = $element->getClosedDate();
						if(isset($closedDate) && $closedDate != null){
								$colorState = "panel panel-success";
						}
						else{
							if($element->getAssigned()){
								$colorState = "panel panel-primary";
							}
							else{
								if($element->getStateId() != claimsConcepts::CANCELLEDSTATE){
									$colorState = "panel panel-warning";
								}
							}
						}



					
						/* var_dump($element->getDetailCloseClaim());*/
						
			?>

		<div class='<?=$colorState?>'>

			<div class="panel-heading">

				<table class="table1" >
				<tbody>


				<tr>

					<td><img src="/modules/claims/css/img/<?=$cause?>_<?=$priority?>_<?=$state?>.png"></td>
					<div class="tdTitle"><td>ID: <?= $element->getCode()?></td></div>
				
					<td> <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> <?=$element->getEntryDate()->format("d/m/Y")?> </td>
						<?
						if(null != $element->getClosedDate()){
							?>
							<br>
							<td><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>    <?=$element->getClosedDate()->format("d/m/Y")?></td>
							<?
						}else{
							?>
							<br/>
							<td><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>    <?php echo Util::getLiteral("no_closing_date")?></td>
							<?
						}
						?>


					<td><?php
						$closedDate = $element->getClosedDate();
						if(isset($closedDate) && $closedDate != null){
							echo 'Terminado ' . Util::getAssignedDate($element->getClosedDate()->format("Y-m-d"));
						}
						else{
							if($element->getAssigned()){
								echo 'Subido ' . Util::getAssignedDate($element->getEntryDate()->format("Y-m-d"));
							}
							else{
								if($element->getStateId() != claimsConcepts::CANCELLEDSTATE){
									echo "Sin asignar";
								}
							}
						}


						?></td>

					<td> <div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>  <span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a onclick="editClaim(<?=$element->getId()?>);">Editar</a></li>
								<li><a onclick="claimPic(<?=$element->getId()?>);">Ver Foto</a></li>

								<?php
								if($_SESSION['loggedUser']->getUserTypeId()=='1'){
									if($element->getStateId() == claimsConcepts::PENDINGSTATE){
										?>
										<li><a onclick="closeClaim(<?=$element->getId()?>,<?=claimsConcepts::CLOSEDSTATE?>);">Cerrar</a></li>
										<?php
									} }
								?>
							</ul>
						</div> </td>


				</tr>

				</tbody>
				</table>
			</div>


			<div class="panel-body divInfo">

			<table  id="claimsList">




					<tbody>


				<tr>


					<td><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>   <?=$element->getRequesterPhone()?>
					<br><span class="glyphicon glyphicon-user" aria-hidden="true"></span>   <?=$element->getRequesterName()?></td>
					<td><span class="glyphicon glyphicon-home" aria-hidden="true"></span>   <?=$element->getClaimAddress()?>
							<br><span class="glyphicon glyphicon-list" aria-hidden="true"></span>   <?=$element->getCauseName()?></td>
					<td><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>   <?=$element->getUserName()?>
                        <br><span class="glyphicon glyphicon-phone" aria-hidden="true"></span>  <?=$element->getDetailCloseClaim()?>
                    </td>


				</tr>

				</tbody>



			</table>

				<span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>   <?=$element->getDetail()?>
				<br>
				<span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>   
				<?php
				if($element->getMat_1()){
					echo $element->getMat_1();
				}
				if($element->getMat_2()){
					echo ' / ' . $element->getMat_2();
				}
				if($element->getMat_3()){
					echo ' / ' . $element->getMat_3();
				}

				if($element->getMat_4()){
					echo ' / ' . $element->getMat_4();
				}

				if($element->getMat_5()){
					echo ' / ' . $element->getMat_5();
				}


				?>						

			</div>
		</div>




				<?php
				}
				if(count($list) == 0){
					echo '<tr><td colspan="5">'.$_SESSION['s_message']['no_results_found'].'</td></tr>';
				}
				?>


		</form>

		<br />

		<?php
		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/views/Pager.view.php';
		echo Pager::render($pager);
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
    	$_REQUEST['jsToLoad'][] = "/modules/claims/js/claims.js";

		return ob_get_clean();
	}

}
