<?php
class AdrTemporal extends Render {

	static public function render ( ) {

		ob_start();

?>


<script type="text/javascript">

		
			$(document).ready(function(){
				
				// Load map
				loadGoogleMaps();
				resetFormFields();

		        // Captions panel
				$('#panel').slidePanel({
	                triggerName: '#trigger',
	                triggerTopPos: '200px',
	                panelTopPos: '200px'
		        });


		        var date = new Date();
		        
		        //var horaString = date.getHours()+":"+date.getMinutes();

				var hora = date.getHours();
				var minutes = date.getMinutes();
				
				var horaString = '';
				var minutesString = '';
				if(hora<10){
					horaString = '0'+hora;

					}else {
					horaString = hora+'';
						}
				if(minutes < 10){

					minutesString = '0'+minutes;

					}else {minutesString = minutes+'';}
		        
		        $('#adr-date-time-right,#adr-date-time-left').attr("placeholder",hora);        

		       $('#adr-date-time-right').val(horaString+":"+minutesString);
		       $('#adr-date-time-left').val(horaString+":"+minutesString);
		        
		        //window.alert(date.getHours()+" : "+date.getMinutes());
				$('#adr-date-time-left,#adr-date-time-right').timepicker({
					controlType: 'select',
					stepMinute: 15,

				}
				);
						
		      
				
			});
		</script>

<div class="div-table">
	<div class="div-row">

		<form id="frm_activity_user_filters">

			<div class="div-cell-left">

				<div class="div-table1">
					<div class="div-row1">
						<div class="div-cell1">
							<? echo 'Vehículo'//=Util::getLiteral('adr_claims_track_user_title')?>
						</div>
					</div>
				</div>

				<div class="div-table1">
					<div class="div-row1">
						<div class="div-cell1">
							<input loadaction="getAdrUserFromAutoComplete" minChars="3"
								maxlength="50" class="autocomplete-control menu-item"
								type="text" name="adrUserFullname"
								id="adr-history-user-fullname" /> <input type="hidden"
								name="userId" value="" id="adr-user-id" />
						</div>
					</div>
				</div>

				<div class="div-table1">
					<div class="div-row1">
						<div class="div-cell1">
							<?//=Util::getLiteral('adr_claims_track_claims_title')?>
						</div>
					</div>
				</div>




				<div class="div-table1">
					<div class="div-row1">
						<div class="div-cell1">
							<div class="search-item menu-item">
								<input maxlength="50" class="datepicker" type="text"
									name="dateFrom" id="adr-date-left"
									placeholder="<?=Util::getLiteral('adr_claims_track_date_from')?>"
									readonly="readonly" />
							</div>
						</div>

					</div>

					<div class="div-row2">
						<div class="div-cell1">
							<div class="search-item menu-item">
								<input maxlength="50" class="timepicker" type="text"
									name="timeFrom" id="adr-date-time-left"
									placeholder="<?echo 'Desde hora'?>" readonly="readonly" />
							</div>
						</div>

					</div>


				</div>

				<div class="div-table1">
					<div class="div-row1">
						<div class="div-cell1">
							<div class="search-item menu-item">
								<input maxlength="50" class="datepicker" type="text"
									name="dateTo" id="adr-date-right"
									placeholder="<?=Util::getLiteral('adr_claims_track_date_to')?>"
									readonly="readonly" />
							</div>
						</div>
					</div>
					<div class="div-row2">
						<div class="div-cell1">
							<div class="search-item menu-item">
								<input maxlength="50" class="timepicker" type="text"
									name="timeTo" id="adr-date-time-right"
									placeholder="<?echo 'Hasta hora'?>" readonly="readonly" />
							</div>
						</div>

					</div>



				</div>

				<div class="div-table1">
					<div class="div-row1">
						<div class="div-cell1">
							<input id="filterSearch" class="form_bt" type="button"
								onclick="getReportActivity()"
								value="<?=Util::getLiteral('adr_claim_track_apply_filters')?>"
								style="float: left; margin-right: 2px;"> <input id="filterClear"
								class="form_bt" type="button" onclick="cleanFormFields();"
								value="<?=Util::getLiteral('adr_claim_track_clean_filters')?>"
								style="float: left; margin-right: 2px;">
								<input id="filterClear"
								class="form_bt" type="button" onclick="exportActivity();"
								value="<?=Util::getLiteral('export')?>"
								style="float: left; margin-right: 2px;">
						</div>
					</div>
				</div>

				<div class="div-table1">
					<div class="div-row1">
						<div class="div-cell1">
							<div id="notify">&nbsp;</div>
						</div>
					</div>
				</div>

				<?php 
				/* @var $zone AdrZone */
				//foreach ($zones as $zone) {
				?>
				<div class="div-table1">
					<?php 							
					$regioncolor = '#ffffff';
					?>
					<div class="div-row1">
						<div class="div-cell1 region" id="region_<?//=$zone->getId() ?>">
							<input id="regionId" class="regionId" type="hidden"
								value="<?//=$zone->getId() ?>" /> <input id="color"
								type="hidden" value="<?//= $regioncolor ?>" /> <input
								class="coordinates" type="hidden"
								value="<?//=$zone->getCoordinates() ?>" />
						</div>
					</div>
				</div>
				<?php 
				//}
				?>

			</div>

		</form>

		<div class="div-cell-rigth">
			<div id="map-canvas"></div>
			<div id="map-debug" style="height: 20px; display: none;"></div>
			<a href="#" id="trigger" class="trigger right"><?//=Util::getLiteral('adr_captions_box')?>
			</a>
			<div id="panel" class="panel right">
				<?php 
				require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrCaptions.view.php';
				//echo AdrCaptions::render();
				?>
			</div>
		</div>
	</div>
</div>

<br />
//Location
<?php 
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrTemporalReport.view.php';
echo AdrTemporalReport::render();

$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-common.js";
$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-user-history.js";
$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-user-history-map.js";
$_REQUEST['jsToLoad'][] = "/core/js/jquery.slidePanel.min.js";
$_REQUEST['jsToLoad'][] = "/core/js/jquery-ui-timepicker-addon.js";
$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-user-activity.js";
$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-claims-track-map.js";
$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
$_REQUEST['jsToLoad'][] = "/modules/settings/js/layers.js";
return ob_get_clean();
	}

}
?>