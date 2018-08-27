<?php
class AdrUsersList extends Render {

	static public function render ($list, $filterGroup, $pager, $actions, $numrows) {
		
		ob_start();
		?>
		
		<br />
		
		<?
		echo $filterGroup->drawForm();
    	?>
    
    	<br />
    	
		<?php
    	//Actions
    	echo $actions;

    	//Counters?>
   		<div class="users-counters">
   		<?php
    		echo '<div>' . Util::getLiteral('total_users') . ': ' . $numrows . '</div>';
   		?>
   		</div>
    		

   		<?php
	    if(count($list) != 0){
		?>

			<table class="table">
				<thead>
				<tr>
					<th><?=Util::getLiteral('user_loggin')?></th>
					<th><?=Util::getLiteral('user_fullname')?></th>
					<th><?=Util::getLiteral('adr_plan_name')?></th>
					<th><?=Util::getLiteral('user_state')?></th>
					<th><?=Util::getLiteral('user_actions')?></th>
				</tr>
				</thead>
				<?php
				/* @var $adrUser AdrUser */
				foreach ($list as $adrUser){?>
				<tbody>
				<tr>
					<th ><?php echo ($adrUser->getUserLogin()) ?></th>
					<th><?php echo ($adrUser->getFirstName() .' '. $adrUser->getLastName()) ?></th>
					<th><?php echo ($adrUser->getPlanName()) ?></th>
					<th><?php echo ($adrUser->getStateName()) ?></th>
					<th><div onclick="editUser(<?=$adrUser->getId()?>);" title="<?=Util::getLiteral('user_edit')?>" class="btn btn-primary"><?=Util::getLiteral('user_edit')?></div>
						<div onclick="deleteUser(<?=$adrUser->getId()?>);" title="<?=Util::getLiteral('user_delete')?>" class="btn btn-danger"><?=Util::getLiteral('user_delete')?></div>
						<div class="btn btn-info " onclick="javascript:window.open('http://capital.gestionyservicios.com.ar/es/ldr?user=<?php echo($adrUser->getUserLogin()) ?>&passport=<?php echo($adrUser->getPassword())?>','','width=900,height=700,left=50,top=50,toolbar=yes');" />Ver en Mapa</div>

					</th>
				</tr>

				</tbody>
				<?php } ?>
			</table>







			    </div>

			<script>
				function myFunction() {
					window.open("http://godoycruz.gestionyservicios.com.ar/es/ldr?user=mario&passport=e10adc3949ba59abbe56e057f20f883e");
				}
			</script>

			</div>
		<?php
		} else {
				echo '
					<div>'.$_SESSION['s_message']['no_results_found'].'</div>
				';
		}
		?>
    
		<br />

		<?php
		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/views/Pager.view.php';
		echo Pager::render($pager);    	

    	$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-users.js";
				
		return ob_get_clean();
	}
	
}
?>
