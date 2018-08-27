<?php

class AdrAssignGroup extends Render {

	static public function render ($list) {

		ob_start();

		?>
		<script type="text/javascript">
			$(document).ready(function(){

				// Load map
				draw = true;
				loadGoogleMaps();

				// Get and show the markers
				setTimeout(function(){ 
					ShowUnassignedClaimsByGroups(); 
				}, 3000);
				
				$(function() {
					$( "#sortable" ).sortable();
					$( "#sortable" ).disableSelection();
				});

				$('#buttons').hide();

		        // Captions panel
				$('#panel').slidePanel({
	                triggerName: '#trigger',
	                triggerTopPos: '200px',
	                panelTopPos: '200px'
				});
	
				
			});

			function selectionchange()
			{
				var e = document.getElementById("mySelect");
				var str = e.options[e.selectedIndex].value;
				var str1 = e.options[e.selectedIndex].id;

				document.getElementById('adr-group-id').value = str1;
				document.getElementById('adr-group-fullname').value = str;

			document.getElementById('ejemplo').innerHTML = 'Grupo Seleccionado: '+str ;
			}

			
		</script>




		<form id="frm_assigned_claimsbygroup">
		
					<div class="row">
							<div class="col-lg-4">
								<h3>Seleccionar Grupo</h3>
								<select style="color: black" class="selectpicker"  onchange="selectionchange();"  id="mySelect" data-live-search="true" >
									<option></option>
									<?php
									
									/* @var $adrGroup adrGroup */
									foreach ($list as $adrGroup){
										$icon = $adrGroup->getIcon();
											?>
							
										<option id="<?php echo ($adrGroup->getId()) ?>" style=" color: black"><?php echo ($adrGroup->getName()) ?></option>
									<? } ?>
								</select>
								
								<a class="btn btn-info"   onclick="ShowClaimsByGroup();"  onchange="mostrarValor(this);">Buscar Grupo</a><br>
							</div>
							<div class="col-lg-4">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									
								<div class="panel-heading" role="tab" id="headingTwo">
							
										<!-- <div class="panel-heading" role="tab" id="headingTwo">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
													Ver Asignados al Operador
												</a>
											</h4>
										</div> -->
									

								<div id='ejemplo'></div>
										
										<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
											<div class="panel-body">
												<?=Util::getLiteral('adr_claims_track_assign_tasks_list_title')?>
												<div id="contenidos" >
													<div id="column1"><?=Util::getLiteral('adr_claims_track_assign_tasks_list_id')?></div>
													<div id="column2" >
														<input type="checkbox" id="assignAllCheck" onclick="checkAllClaims()"; />
													</div>
												</div>
												<div id="sortable">
													<!-- js auto append rows -->
												</div>
											</div>
										</div>
									</div>
									
									<div>






							</div>
									</div>
								</div>
							<div class="col-lg-4">
								<input type="hidden" id="polygon-coords-path" name="polygonCoordsPath" value="" />
								<button onclick="saveAssignedClaimsbyGroup();" id="filterSearch" class="btn btn-success"  type="button" value="<?=Util::getLiteral('adr_claims_track_assign_tasks_submit')?>" ><?=Util::getLiteral('adr_claims_track_assign_tasks_submit')?></button>
								<button onclick="deletePolygon();" id="reset-polygon" class="btn btn-warning"  type="button" value="<?=Util::getLiteral('adr_claims_track_reset_plygon')?>" /><?=Util::getLiteral('adr_claims_track_reset_plygon')?></button>

							</div>
						</div>

						<div >

						<input loadaction="getAdrUserFromAutoComplete"
							minChars="3"
							maxlength="50"
							class="autocomplete-control menu-item"
							type="hidden"
							placeholder="Buscar Group"
							name="adrGroupFullname"
							id="adr-group-fullname"
							style="display: inline; float: left; width: 210px;" />
						<input type="hidden" name="adrGroupId" value="" id="adr-group-id" />

						</div>

					
					
						<div id="map-canvas"></div>
						<div id="map-debug" style="height: 20px; display: none;"></div>
						<a href="#" id="trigger" class="trigger right"><?=Util::getLiteral('adr_captions_box')?></a>
						<div id="panel" class="panel right">
						<?php 
							require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrCaptions.view.php';
							echo AdrCaptions::render();    	
						?>
						</div>
					
				</div>

		
		
		</form>
				
		<?php
		
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/polygon.min.js";
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-common.js";
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-assign-tasks.js";
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-assign-tasks-map.js";
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
		$_REQUEST['jsToLoad'][] = "/core/js/jquery.slidePanel.min.js";
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/layers.js";			
		
		return ob_get_clean();
	}
	
}
?>
