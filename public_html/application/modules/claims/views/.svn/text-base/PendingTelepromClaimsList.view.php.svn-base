<?php

class PendingTelepromClaimsList extends Render {

	static public function render ($list, $filterGroup, $pager) {
		
		ob_start();
		
		?>
		<br />
		
		<?php
		echo $filterGroup->drawForm();
    	?>
    
    	<br />
    	
    	<div class="listActions">
	    	<input type="button" class="form_bt" onclick="telepromStats();" value="<?=Util::getLiteral('stats')?>"/>
	    </div>
	    <div style="clear:both;"></div>
    		
    		<table id="pendingTelepromClaimsList" class="tablesList">
    		<?php
    		
    		for($i=0 ; $i < count($list) ; $i++){
    			$element = $list[$i];
    			
    			$rowClass = "par";
    			if($i%2){
    				$rowClass = "impar";
    			}
    		?>
    			<tr id='table_row_<?= $element->getId() ?>' class="<?= $rowClass ?> claim_element_row">
    			
					<?php 
					/* ?>
					<td class="table_col_1">
						<div style="padding-top: 5px;">
    					<input type="checkbox" name="massiveActions[]" id="massiveActions_<?=$element->getId()?>" />
    					</div>
    				</td>
    				<?
    				*/
    				?>
    				
    				<td class="table_col_2">
    				
    					<?php
						$dependencyName = $element->getDependencyName();
						$thirdCellWidth = '28%';
						$fourthCellWidth = '2%';
						if(isset($dependencyName) && $dependencyName != null){
							$thirdCellWidth = '20%';
							$fourthCellWidth = '10%';
						}
						?>
    				
    					<table id="claimData_<?=$element->getId()?>" style="table-layout: fixed; ">
    						<tr id="element_row_<?=$element->getId()?>_1" class="claim_row_element_1">
    							<td width="30%">
    								<div title="<?=$element->getEntryDate()->format("d/m/Y")?>" class="text-ellipsis">Fecha de ingreso: <?=$element->getEntryDate()->format("d/m/Y")?></div>	
    							</td>
    							<td width="40%">
    								<div title="<?=$element->getId()?>" class="text-ellipsis">ID: <?=$element->getCode()?></div>
    							</td>
    							<td width="<?=$thirdCellWidth?>">
    							</td>
    							<td width="<?=$fourthCellWidth?>">
    							</td>
    						</tr>
    						<tr id="element_row_<?=$element->getId()?>_2" class="claim_row_element_2">
    							<td>
    								<div title="<?=$element->getSubjectName()?>" class="text-ellipsis">Tema: <?=$element->getSubjectName()?></div>
    							</td>
    							<td>
    								<div title="<?=$element->getInputTypeName()?>" class="text-ellipsis">Ingreso: <?=$element->getInputTypeName()?></div>
    							</td>
    							<td>
    								<div title="<?=$element->getCauseName()?>" class="text-ellipsis">Motivo: <?=$element->getCauseName()?></div>
    							</td>
    							<td>
    								<?php
    								/*
		    						if(isset($dependencyName) && $dependencyName != null){ 
		    						?>
		    							<div title="<?=$element->getDependencyName()?>" class="text-ellipsis">Dependencia: <?=$element->getDependencyName()?></div>
		    						<?php
		    						}
		    						*/
		    						?>
    							</td>
    						</tr>
    						<tr id="element_row_<?=$element->getId()?>_3" class="claim_row_element_3">
    							<td>
    							<?php
	    						$requesterName = $element->getRequesterName();
	    						if(isset($requesterName) && $requesterName != null){ 
	    						?>
	    						<div title="<?=$element->getRequesterName()?>" class="text-ellipsis">Solicitante: <?=$element->getRequesterName()?></div>
	    						<?php
    							}
    							?>
    							</td>
    							<td>
	    						<div title="<?=$element->getRequesterAddress()?>" class="text-ellipsis">
	    							Domicilio: <input type="text" name="requester_address_<?=$element->getId()?>" id="requester_address_<?=$element->getId()?>" value="<?=$element->getRequesterAddress()?>" disabled="disabled" />
	    							<input type="hidden" name="requester_address_orig_<?=$element->getId()?>" id="requester_address_origin_<?=$element->getId()?>" value="<?=$element->getRequesterAddress()?>" />
			    					<br />
			    					Editar <input type="checkbox" name="chk_edit_address_<?=$element->getId()?>" id="chk_edit_address_<?=$element->getId()?>" onclick="enableRequesterAddressText(<?=$element->getId()?>, this.checked)" />
	    						</div>
    							</td>
    							<td>
    							<?php
	    						$requesterPhone = $element->getRequesterPhone();
	    						if(isset($requesterPhone) && $requesterPhone != null){ 
	    						?>
	    						<div title="<?=$element->getRequesterPhone()?>" class="text-ellipsis">Teléfono: <?=$element->getRequesterPhone()?></div>
	    						<?php
		    					}
		    					?>
    							</td>
    							<td>
    							</td>
    						</tr>
    					</table>
    				</td>
    				
    				<td class="table_col_3">
    					<table>
    						<tr>
    							<td>&nbsp;</td>
    						</tr>
    						<tr>
    							<td "style="height: 35px; ">
    								<select name="cause_<?=$element->getId()?>" id="cause_<?=$element->getId()?>" onchange="verifyTelepromCause(<?=$element->getId();?>);">
    									<option value=""><?=Util::getLiteral('select_an_option')?></option>
			    						<?php
			    						if(isset($_SESSION['claimsConcepts']['telepromCauses']) && is_array($_SESSION['claimsConcepts']['telepromCauses'])){
			    							foreach ($_SESSION['claimsConcepts']['telepromCauses'] as $key => $cause){
			    							?>
			    							<option value="<?=$cause["causeId"]?>_<?=$key?>"><?=strtoupper($cause["name"])?></option>
			    							<?php
			    							}
			    						} 
			    						?>
			    					</select>
			    				</td>
			    			</tr>
			    		</table>
    				</td>
    				
    				<td class="table_col_5">
    					<table>
    						<tr>
    							<td>&nbsp;</td>
    						</tr>
    						<tr>
    							<td "style="height: 35px; ">
			    					<input class="piquete mandatory-input" placeholder="Piquete..." maxlength="100" type="text" name="piquete_<?=$element->getId()?>" id="piquete_<?=$element->getId()?>" />
			    				</td>
			    			</tr>
			    		</table>
    				</td>
    				
    			    <td class="table_col_6">
    					<table>
    						<tr>
    							<td>&nbsp;</td>
    						</tr>
    						<tr>
    							<td	style="height: 35px; ">
									<div class="confirm_icon action_button" style="float: right; " title="<?=Util::getLiteral('confirm')?>" onclick="savePendingTelepromClaim(<?=$element->getId()?>);"><?=Util::getLiteral('confirm')?></div>
									<form action="updateTelepromClaim" id="savePendingTelepromDataForm_<?=$element->getId()?>" name="savePendingTelepromDataForm_<?=$element->getId()?>">
										<input class="mandatory-input" type="hidden" name="causeId" />
										<input class="input-text-validate" type="hidden" name="detail" />
										<input class="input-text-validate" type="hidden" name="piquete" />
										<input type="hidden" name="claimId" value="<?=$element->getId()?>" />
										<input type="hidden" name="street" id="street"/>
										<input type="hidden" name="streetNumber"  id="streetNumber"/>
										<input type="hidden" id="streetNumberChk" name="streetNumberChk" value="false" />
										<input type="hidden" id="requesterFullName" name="requesterFullName" value="<?=$element->getRequesterName()?>" />
										<input type="hidden" id="requesterPhone" name="requesterPhone" value="<?=$element->getRequesterPhone()?>" />
										<input type="hidden" id="requesterAddress" name="requesterAddress" />
										<input type="hidden" id="requesterAddressChk" name="requesterAddressChk" value="false" />
									</form>
								</td>
							</tr>
						</table>
    			    </td>
    			    
    			</tr>
    			
    			<tr id='table_row_label_<?= $element->getId() ?>' class="<?= $rowClass ?> claim_element_row">
    				<td>
    					<strong>Datos del reclamo: </strong>
    					<span style="float: right; margin-right: 10px; ">Detalle: </span>
    				</td>
    				
    				<td colspan="3" rowspan="2">
    					<textarea class="claimDetail" placeholder="" maxlength="150" name="detail_<?=$element->getId()?>" id="detail_<?=$element->getId()?>"></textarea>
    				</td>
    				
    			</tr>
    			
    			<tr id='table_row_extended_<?= $element->getId() ?>' class="<?= $rowClass ?> claim_element_row">
    				<td class="table_col_2">
    					<table style="table-layout: fixed; " id="claim_address">
    						<tr>
    							<td width="35%">
    								Calle: 
			    					<input loadaction="getStreetFromAutoComplete" maxlength="50" class="autocomplete_control" type="text" name="street_<?=$element->getId()?>" id="street_<?=$element->getId()?>" />
			    				</td>
			    				<td width="35%">
			    					Número:
			    					<select name="street_number_<?=$element->getId()?>" id="street_number_<?=$element->getId()?>" style="min-width: 140px; " >
			    					</select>
			    					<input type="text" name="new_street_number_<?=$element->getId()?>" id="new_street_number_<?=$element->getId()?>" class="" maxlength="100" size="100" style="width: 130px; height: 20px; display: none; " disabled="disabled" />
			    				</td>
			    				<td width="50%">
			    					Nuevo: 
			    					<input type="checkbox" name="chk_new_street_number_<?=$element->getId()?>" id="chk_new_street_number_<?=$element->getId()?>" onclick="enableNewNumberText(<?=$element->getId()?>, this.checked)" />
			    				</td>
			    				<!-- <td width="<?=$fourthCellWidth?>">
			    				</td>-->
    						</tr>
    					</table>
    				</td>
    				
    			</tr>
    			
    			<tr id="table_row_separator_<?=$element->getId()?>">
    				<td colspan="5" style="border-bottom: 1px  solid; "></td>
    			</tr>
    			
    		<?php
    		}
    		if(count($list) == 0){   		
    	    	echo '<tr><td colspan="4">'.$_SESSION['s_message']['no_results_found'].'</td></tr>';
    		}
    		?>
    		</table>

    		<br />
    		
    		<?php
    		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/views/Pager.view.php';
            echo Pager::render($pager);    	
        $_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
    	$_REQUEST['jsToLoad'][] = "/modules/claims/js/claims.js";
				
		return ob_get_clean();
	}
	
}