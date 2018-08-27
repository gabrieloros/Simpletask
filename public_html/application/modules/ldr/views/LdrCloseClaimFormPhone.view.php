<?php
class LdrCloseClaimFormPhone extends Render {
	/* @var $claim Claim */
	static public function render($claim,$action_claim,$withoutFixings,$materials) {
		ob_start ();
		?>

<link href="/modules/ldr/css/ldr.css" rel="stylesheet" type="text/css" />

<div id="map_canvas_container">

	<form
		action="/<?=$_SESSION['s_languageIsoUrl']?>/ldr?action=closeClaimPhone"
		method="post">
		<input type="hidden" name=claim_id id="claim_id" value="<?=$claim->getId() ?>">
		<input type="hidden" name="action_claim" id="action_claim" value="<?=$action_claim ?>">
		
		
		<table>
			<tr>
				<td>ID / Code</td>
				<td><?=$claim->getCode() ?></td>
			</tr>
			<tr>
				<td>Detalle</td>
				<td><?=$claim->getSubjectName() ?></td>
			</tr>
			<tr>
				<td>Fecha de ingreso</td>
				<td><?=$claim->getEntryDate()->format("d/m/Y") ?></td>
			</tr>
			<tr>
				<td>Teléfono Sol.</td>
				<td><?=$claim->getRequesterPhone()?></td>
			</tr>
			
			<tr>
				<td>Domicilio</td>
				<td><?=$claim->getClaimAddress() ?></td>
			</tr>
						
			
			
			
			
			<?php if($action_claim==claimsConcepts::CANCELLEDSTATE){?>
			<tr>
				<td>Sin Arreglar por</td>
				<td>
					<select id="without_fixing" name="without_fixing">
						<?php 
						/* @var $wf ConceptDetailGeneric */
						foreach ($withoutFixings as $wf ){?>
						 	<option value="<?=$wf->getId()  ?>"><?=$wf->getName()?></option>
						 <?php }?>
					</select>
				</td>
			</tr>
			<?php }?>
			
			<?php if($action_claim==claimsConcepts::CLOSEDSTATE){?>
			
			<tr>
				<td>Materiales</td>
				<td>
					<select id="material" name="material">					
					<?php 
					/* @var $mat ConceptDetailGeneric */
					foreach ($materials as $mat ){?>
					 	<option value="<?=$mat->getId()  ?>"><?=$mat->getName()?></option>
					 <?php }?>
					
					</select>
				</td>
			</tr>
			<?php }?>
			<tr>
				<td>Descripción</td>
				<td>
					<textarea id="description" name="description" ></textarea>
				</td>
			</tr>
			
			
			<tr>
				<td><input type="submit" value="Guardar" />
				<input type="button" value="Volver atrás" name="Volver atrás" onclick="history.back()" />				
			</tr>
		</table>
	</form>
	<form>  </form>
</div>


<?php
		return ob_get_clean ();
	}
}
?>