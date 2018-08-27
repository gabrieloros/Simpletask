<?php
/**
 * Dibuja el mapa con las regiones
 * 
 * @author mmogrovejo
 *
 */
class Stats extends Render{
	
	public function render($regions, $filterGroup){
		
		ob_start();
		
		echo $filterGroup->drawForm();
    	?>
    
    	<br />
    	
    	<hr />
		
		<div class="cols_container">
		
			<div class="col" id="mapa">
				<div id="map-canvas" class="map-canvas" ></div>
				<input id="polygonStrokeColor" class="polygonStrokeColor" type="hidden" />
			</div>
		</div>
		

		<div class="cols_container" style="display: none;">
			<div class="col statsQuestion" >
				<table>
					<?php 
					/* @var $region Region */
					foreach ($regions as $region) {
					?>
					<tr>
						<?php 							
  							$regioncolor = '#ffffff';
						?>
 						<th class="region" id="region_<?= $region->getId() ?>">
 							<input id="regionId" class="regionId" type="hidden" value="<?= $region->getId() ?>" />
							<input id="color" type="hidden" value="<?= $regioncolor ?>" />
							<input class="coordinates" type="hidden" value="<?= $region->getCoordinates() ?>" />
						</th>
					</tr>
					<?php 
					}
					?>
				</table>
			</div>
		</div>							
    	<?php
    	
    	$_REQUEST['jsToLoad'][] = "/modules/claims/js/statsGraph.js";
    	$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
    	$_REQUEST['jsToLoad'][] = "/modules/settings/js/layers.js";
		return ob_get_clean();
		
	}

}