<?php

class AdrAssignTasks extends Render {

	static public function render ($list,$listGroup) {

		ob_start();

		?>


		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" xmlns="http://www.w3.org/1999/html"
			  xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
		<script type="text/javascript">

			function selectionchange()
			{
				var e = document.getElementById("mySelect");
				var str = e.options[e.selectedIndex].value;
				var str1 = e.options[e.selectedIndex].id;

				document.getElementById('adr-user-id').value = str1;
				document.getElementById('adr-user-fullname').value = str;
			}
			function selectionchangeGroup()
			{
				var e = document.getElementById("mySelectGroup");
				var str = e.options[e.selectedIndex].value;
				var str1 = e.options[e.selectedIndex].id;

				document.getElementById('adr-group-id').value = str1;
				document.getElementById('adr-group-fullname').value = str;

			}
		</script>



		<!-- Trigger the modal with a button -->
		<button type="button"  class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></button>

		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Filtro de Asignacion</h4>
					</div>
					<div class="modal-body">
						<form id="frm_assigned_claims">
						<div class="row">
							<div class="col-lg-4">
								<h3>Seleccionar Operario</h3>
								<select style="color: black" class="selectpicker"  onchange="selectionchange();" id="mySelect" data-live-search="true" >
									<option></option>
									<?php
									/* @var $adrUser AdrUser */
									foreach ($list as $adrUser){?>
										<option style="color: black" id="<?php echo ($adrUser->getId()) ?>"><?php echo ($adrUser->getFirstName() .' '. $adrUser->getLastName()) ?></option>
									<? } ?>
								</select>
								<h3>Seleccionar Grupo</h3>
								<select style="color: black" class="selectpicker"  onchange="selectionchangeGroup();"  id="mySelectGroup" data-live-search="true" >
									<option></option>
									<?php
									
									/* @var $adrGroup adrGroup */
									foreach ($listGroup as $adrGroup){
										$icon = $adrGroup->getIcon();
											?>
							
										<option id="<?php echo ($adrGroup->getId()) ?>" style=" color: black"><?php echo ($adrGroup->getName()) ?></option>
									<? } ?>
								</select>
								<hr>
								<!--id="search-buttonn"-->
								<a class="btn btn-info"   onclick="getClaimsForUser();" >Buscar</a><br>
							</div>
							<div class="col-lg-4">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="headingTwo">
											<h4 class="panel-title">
												<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
													Ver Asignados al Operador
												</a>
											</h4>
										</div>
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
								<button onclick="saveAssignedClaims();" id="filterSearch" class="btn btn-success"  type="button" value="<?=Util::getLiteral('adr_claims_track_assign_tasks_submit')?>" ><?=Util::getLiteral('adr_claims_track_assign_tasks_submit')?></button>
								<button onclick="deletePolygon();" id="reset-polygon" class="btn btn-warning"  type="button" value="<?=Util::getLiteral('adr_claims_track_reset_plygon')?>" /><?=Util::getLiteral('adr_claims_track_reset_plygon')?></button>
								<button onclick="drawRoute();" id="generate-route" class="btn btn-default"   type="button" value="<?=Util::getLiteral('adr_claims_track_generate_route')?>" /><?=Util::getLiteral('adr_claims_track_generate_route')?></button>
								<button onclick="drawOptimizedRoute();" id="optimize-route" class="btn btn-default"  type="button" value="<?=Util::getLiteral('adr_claims_track_optimize_route')?>" /><?=Util::getLiteral('adr_claims_track_optimize_route')?></button>

							</div>
						</div>


							<div >
											<!-- //cambiar a hidden -->
								<input loadaction="getAdrUserFromAutoComplete"
									   minChars="3"
									   maxlength="50"
									   class="autocomplete-control menu-item"
									   type="hidden"
									   placeholder="Buscar Operario"
									   name="adrUserFullname"
									   id="adr-user-fullname"
									   style="display: inline; float: left; width: 210px;" />
								<input type="hidden" name="adrUserId" value="" id="adr-user-id" />
								<input loadaction="getAdrGroupFromAutoComplete"
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


						</form>



					</div>




					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>

				</div>
				</div>

			</div>

		<!-- !PAGE CONTENT! -->

		<div id="map-canvas"></div>
		<div id="map-debug" style="max-width:1200px;margin-top:100px; display: none;"></div>
		<a href="#" id="trigger" class="trigger right"><?=Util::getLiteral('adr_captions_box')?></a>
		<div id="panel" class="panel right">
			<?php
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrCaptions.view.php';
			echo AdrCaptions::render();
			?>
		</div>









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
