<?
class ClaimsActions extends Render {
	
	static public function render () {
		
	    ob_start();
		
	    ?>
	    <div class="listActions">
	  
			<button type="button" class="btn btn-danger" onclick="changeClaimsState(<?=claimsConcepts::CANCELLEDSTATE?>);" ><?=Util::getLiteral('cancel_claims')?></button>
			<button type="button" class="btn btn-success"  onclick="exportClaims();" > <?=Util::getLiteral('export')?></button>
			<button type="button" class="btn btn-info" onclick="mapClaims();"  ><?=Util::getLiteral('map')?></button>
			<button type="button" class="btn btn-primary" onclick="addClaim();" ><?=Util::getLiteral('new_claim')?></button>
			<button type="button" class="btn btn-primary" onclick="addMultipleClaims();" > + Multiples Reclamos</button>
	    </div>
	    <div style="clear:both;"></div>
	    <?php
	    
	    return ob_get_clean();
	}
}
