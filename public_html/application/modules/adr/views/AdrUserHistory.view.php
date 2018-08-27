<?php
class AdrUserHistory extends Render {

	static public function render ($zones, $claimStates) {

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
				
			});
		</script>
		
		<div class="div-table">
			<div class="div-row">
			
				<form id="frm_historical_filters">
			
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
					  						id="adr-history-user-fullname" />
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
									<input id="filterSearch" class="form_bt" type="button" onclick="getHistoricalRoute();" value="<?=Util::getLiteral('adr_claim_track_apply_filters')?>" style="float: left; margin-right: 2px;">
									<input id="filterClear" class="form_bt" type="button" onclick="cleanFormFields();" value="<?=Util::getLiteral('adr_claim_track_clean_filters')?>" style="float: left; margin-right: 2px;">
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
						foreach ($zones as $zone) {
						?>
						<div class="div-table1">
							<?php 							
		  						$regioncolor = '#ffffff';
							?>
							<div class="div-row1">
								<div class="div-cell1 region" id="region_<?=$zone->getId() ?>">
		 							<input id="regionId" class="regionId" type="hidden" value="<?=$zone->getId() ?>" />
									<input id="color" type="hidden" value="<?//= $regioncolor ?>" />
									<input class="coordinates" type="hidden" value="<?=$zone->getCoordinates() ?>" />
								</div>
							</div>
						</div>
						<?php 
						}
						?>

					</div>
				
				</form>
				
				<div  class="div-cell-rigth">
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
			</div>
		</div>
		
		<br />

		<?php 
		require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrUserHistoryReport.view.php';
		echo AdrUserHistoryReport::render();    	

		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-common.js";
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-user-history.js";
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-user-history-map.js";
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
		$_REQUEST['jsToLoad'][] = "/core/js/jquery.slidePanel.min.js";
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/layers.js";		
		return ob_get_clean();
	}
	
}
?>