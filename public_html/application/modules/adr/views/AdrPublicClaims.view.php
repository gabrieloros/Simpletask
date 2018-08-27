<?php
class AdrPublicClaims extends Render {

	static public function render ($claimStates) {
		?>
		<script type="text/javascript">
			$(document).ready(function(){

				loadGoogleMaps();
				$('#spacer').show();
				sendPublicClaims('frm_claims_track_filters');
$('#adr-claim-code').live("keypress", function(e) {if (e.keyCode == 13) {sendPublicClaims('frm_claims_track_filters');return false;}});
			});
		</script>
<!--		<a href="#" id="trigger" class="trigger right"><?=Util::getLiteral('adr_captions_box')?></a>
		<div id="panel" class="panel right">
		<?php 
//			require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/modules/adr/views/AdrCaptions.view.php';
//			echo AdrCaptions::render();    	
		?>
		</div>
-->		
		<div class="div-table">
			<div class="div-row">
				<form id="frm_claims_track_filters">
					<div class="div-cell-left">
						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1"><?=Util::getLiteral('adr_claims_track_claims_title')?></div>
							</div>
						</div>
						<div class="div-table1">
							<div class="div-row1">
								<div class="div-cell1">
									<div class="search-item menu-item" style="background: gray;padding:1px;">
										<input loadaction="getAdrClaimFromAutoComplete"
												minChars="4"
												maxlength="50" 
												class="autocomplete-control search-item-txt" 
												type="text" 
												name="adrClaimCode" 
												id="adr-claim-code" 
												placeholder="<?=Util::getLiteral('adr_claims_track_search_claim')?>" />
                                                                       		<input id="filterSearch" class="seach-icon" type="button" onclick="sendPublicClaims('frm_claims_track_filters'); applyBtn=true;" title="Buscar" >
									</div>
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

						<div style="margin: 4px 4px 24px 4px; text-align: justify; -webkit-box-shadow: -0px 5px 2px -2px;">							<span style="font-family:Arial; font-size:14px;">Mantenimiento del alumbrado publico de godoy cruz<br><span style="font-size:12px; text-transform: initial;">Las operaciones de mantenimiento son aquellos que se realizan entre el fusible y la luminaria a efectos de mantenerla prendida.</br></span>
						</div>
			 <div class="div-table1">
				<div class="div-row1">
					<input class="marker-pend" type="button" />
					<span class="text-leyend">Reclamos pendientes a la fecha</span>
				</div>
				<div class="div-row1">
 					<input class="marker-close" type="button" />
					<span class="text-leyend">Reclamos terminados el d&iacute;a de la fecha</span>
				</div>
			 	<div class="div-row1">
                                	<input class="marker-baja" type="button" />
                                        <span class="text-leyend">Reclamos que pertenecen a la coopertiva el&eacute;ctrica de Godoy Cruz</span>
                        	</div>
				<div class="div-row1">
                                        <input class="marker-obra" type="button" />
                                        <span class="text-leyend">Reclamos que pertenecen a obras de alumbrado, su tiempo de realizaci&oacute;n es distinto al  de mantenimiento.</span>
                                </div>

			</div>
<div id="weather" style="margin: 22px 5px 15px 12px;  " >
 <span  style="font-family:Arial; font-size:12px;">D&iacute;as lluviosos: </br>Los d&iacute;as con lluvia no se realizar&aacute;n acciones de mantenimiento de acuerdo a la reglamentaci&oacute;n legal sobre riesgos de trabajo ART.</span>
</div>
						<div>
<div id="TT_RCTkk11E1YBc88sU7AwzzDjDDWnUMY1FrY1YEZC5K1jIm5mI3"><a href="http://www.tutiempo.net/argentina/mendoza.html">El Tiempo en Mendoza</a></div>
<script type="text/javascript" src="http://www.tutiempo.net/widget/eltiempo_RCTkk11E1YBc88sU7AwzzDjDDWnUMY1FrY1YEZC5K1jIm5mI3"></script>
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
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-public-claims.js";
		$_REQUEST['jsToLoad'][] = "/modules/adr/js/adr-claims-track-map.js";
		$_REQUEST['jsToLoad'][] = "/core/js/jquery.slidePanel.min.js";
		return ob_get_clean();
	}
}
?>
