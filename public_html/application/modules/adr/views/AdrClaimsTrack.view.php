<?php
class AdrClaimsTrack extends Render {

	static public function render ($claimStates) {

		ob_start();

		?>
		<script type="text/javascript">
			$(document).ready(function(){

				// Load map
				loadGoogleMaps();

				// Default Values
				$('#adr-claim-state option[value="<?=claimsConcepts::PENDINGSTATE?>"]').attr("selected",true);

				//Hide for default
				$('#adr-hour-left').hide();
				$('#adr-hour-right').hide();
				$('#spacer').show();

				sendClaimsTrackFilters('frm_claims_track_filters');

				$('#continousTracking').click(function(event){
					continousTrackingManager(<?=$_SESSION ['s_parameters'] ['adr_track_interval_time']?>);
				});

				// Captions panel
				$('#panel').slidePanel({
					triggerName: '#trigger',
					triggerTopPos: '200px',
					panelTopPos: '200px'
				});

			});
		</script>

		<a href="#" id="trigger" class="trigger right"><?=Util::getLiteral('adr_captions_box')?></a>
		<div id="panel" class="panel right">
			<?php
			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrCaptions.view.php';
			echo AdrCaptions::render();
			?>
		</div>

		<div class="div-table">
			<div class="div-row">

				<form id="frm_claims_track_filters">

					<div class="div-cell-left">

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1"><?=Util::getLiteral('adr_claims_track_user_title')?></div>
							</div>
						</div>

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<input loadaction="getAdrUserFromAutoComplete"
										   minChars="3"
										   maxlength="50"
										   class="autocomplete-control menu-item"
										   type="text"
										   name="adrUserFullname"
										   id="adr-user-fullname" />
									<input type="hidden" name="adrUserId" value="" id="adr-user-id" />
								</div>
							</div>
						</div>

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1"><?=Util::getLiteral('adr_claims_track_claims_title')?></div>
							</div>
						</div>


						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<div class="search-item menu-item">
										<input loadaction="getAdrClaimFromAutoComplete"
											   minChars="7"
											   maxlength="50"
											   class="autocomplete-control search-item-txt"
											   type="text"
											   name="adrClaimCode"
											   id="adr-claim-code"
											   placeholder="<?=Util::getLiteral('adr_claims_track_search_claim')?>" />
										<input type="hidden" name="adrClaimId" value="" id="adr-claim-id" />
									</div>
								</div>
							</div>
						</div>

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<select class="menu-item" id="adr-claim-state" name="adrClaimStateId">
										<option value=""><?=Util::getLiteral('adr_claims_track_states_select')?></option>
										<?php
										/* @var $claimState State */
										foreach ($claimStates as $claimState) {
											$selectedClaimState = '';
											echo '<option value="'.$claimState->getId().'" '.$selectedClaimState.'>'.$claimState->getName().'</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<div class="search-item menu-item">
										<input maxlength="50"
											   class="datepicker"
											   type="text"
											   name="adrClaimDateFrom"
											   id="adr-date-left"
											   placeholder="<?=Util::getLiteral('adr_claims_track_date_from')?>"
											   readonly="readonly" />
									</div>
								</div>
							</div>
						</div>

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<div class="search-item menu-item">
										<input maxlength="50"
											   class="datepicker"
											   type="text"
											   name="adrClaimDateTo"
											   id="adr-date-right"
											   placeholder="<?=Util::getLiteral('adr_claims_track_date_to')?>"
											   readonly="readonly" />
									</div>
								</div>
							</div>
						</div>

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<input maxlength="50"
										   class="menu-item"
										   type="text"
										   name="adrClaimHourFrom"
										   id="adr-hour-left"
										   placeholder="<?=Util::getLiteral('adr_claims_track_hour_from')?>"
										   disabled="disabled"
										   onblur="alert('No implementado');" />
									<div class="menu-item-spacer" id="spacer"></div>
								</div>
							</div>
						</div>

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<input maxlength="50"
										   class="menu-item"
										   type="text"
										   name="adrClaimHourTo"
										   id="adr-hour-right"
										   placeholder="<?=Util::getLiteral('adr_claims_track_hour_to')?>"
										   disabled="disabled"
										   onblur="alert('No implementado');" />
									<div class="menu-item-spacer" id="spacer"></div>
								</div>
							</div>
						</div>

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<div class="search-item">
										<input type="checkbox" name="timerOn" value="" id="continousTracking" />
										<label><?=Util::getLiteral('adr_claims_track_timer')?></label>
									</div>
								</div>
							</div>
						</div>

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<input id="filterSearch" class="form_bt" type="button" onclick="sendClaimsTrackFilters('frm_claims_track_filters'); applyBtn=true;" value="<?=Util::getLiteral('adr_claim_track_apply_filters')?>" style="float: left; margin-right: 2px;">
									<input id="filterClear" class="form_bt" type="button" onclick="cleanClaimsTrackFilters();" value="<?=Util::getLiteral('adr_claim_track_clean_filters')?>" style="float: left; margin-right: 2px;">
								</div>
							</div>
						</div>

						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<div id="notify"></div>
								</div>
							</div>
						</div>

					</div>

				</form>

				<div  class="div-cell-rigth">
					<div id="map-canvas"></div>
					<div id="map-debug" style="height: 20px; display: none;"></div>
				</div>
			</div>
		</div>

		<?php
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-common.js";
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-claims-track.js";
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-claims-track-map.js";
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
		$_REQUEST['jsToLoad'][] = "/core/js/jquery.slidePanel.min.js";
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/layers.js";

		return ob_get_clean();
	}

}
?>