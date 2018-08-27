<?php
class usersList extends Render {
	/**
	 * 
	 * Users List drawing
	 * @author Gabriel Guzman
	 * @param array $usersList
	 * @param  $filterGroup
	 * @param  $pager
	 */
	static public function render ($usersList, $filterGroup, $pager) {
		ob_start();
		
		?>
		<div id="incidentActions" class="listActions">    	
	    	<input type="button" class="form_bt" name="btn_newUser" onclick="createPopup('createUser');" value="<?=$_SESSION['s_message']['create_user']?>"/>
	    </div>
	    
	    <div style="clear:both;"></div>		
		
		<br />
	    
    	<?php
    	echo $filterGroup->drawForm();
    	?>
    
    	<br />
    		
    		<table id="usersList" class="cmsTablesList">   		
    			<tr class="impar no_hover">
    				<th class="table_col_1">
    					#
					</th>
    				<th class="table_col_2">
						<?=$_SESSION['s_message']['name']?>
    				</th>
    				<th class="table_col_3">
						<?=$_SESSION['s_message']['surname']?>
    				</th>
    				<th class="table_col_4">
						<?=$_SESSION['s_message']['user']?>
    				</th>
    				<th class="table_col_5">
						<?=$_SESSION['s_message']['email']?>
    				</th>
    				<th class="table_col_6">
						<?=$_SESSION['s_message']['usertype']?>
    				</th>    				
    				<th class="table_col_11" colspan="2"></th>
    			</tr>
    		<?php
    		
    		for($i=0 ; $i < count($usersList) ; $i++){
    			$user = $usersList[$i];
    			
    			$rowClass = "par";
    			if($i%2){
    				$rowClass = "impar";
    			}
    		?>
    			<tr id='table_row_<?= $user->getId() ?>' class="<?= $rowClass ?>">
    				<td class="table_col_1" title="<?=$user->getId()?>">
    					<?
						echo $user->getId();
    					?>
					</td>
    				<td class="table_col_2" title="<?=$user->getUsername()?>">
    					<?
    				    echo $user->getUsername();
    					?>
    				</td>
    				<td class="table_col_3" title="<?=$user->getUsersurname()?>">
    					<?
    				    echo $user->getUsersurname();
						?>
					</td>
    				<td class="table_col_4" title="<?=$user->getUserlogin()?>">
    					<?
						echo $user->getUserlogin();
    				    ?>
					</td>    				    
    				<td class="table_col_5" title="<?=$user->getUseremail()?>">
    					<?
    				    echo $user->getUseremail();
    					?>
    				</td>    				
    				<td class="table_col_6" title="<?=$user->getUsertypename()?>">
    					<?
    				    echo $user->getUsertypename();
    					?>
					</td>
    				
    			    <td class="table_col_11" >
    			    	<div class="edit_icon" title="<?= $_SESSION['s_message']['edit'] ?>" onclick="editUser(<?= $user->getId()?>);"></div>
    			    </td>
    			    
    			    <td class="table_col_12" >
						<div class="delete_icon" title="<?= $_SESSION['s_message']['delete'] ?>" id="delete_link_<?=$user->getId()?>" onclick="deleteUser(<?=$user->getId()?>);"></div>
    			    </td>    			    
    			</tr>
    		<?php
    		}
    		if(count($usersList) == 0){   		
    	    	echo '<tr><td colspan="11">'.$_SESSION['s_message']['no_results_found'].'</td></tr>';
    		}
    		?>
    		</table>
    		
    		<br />
    		
    		<?php
    		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/views/Pager.view.php';
            echo Pager::render($pager);    	

    	$_REQUEST['jsToLoad'][] = "/modules/users/js/users.js";
				
		return ob_get_clean();
	}
}