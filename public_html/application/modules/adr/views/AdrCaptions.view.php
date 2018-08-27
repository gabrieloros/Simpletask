<?php
class AdrCaptions extends Render {

	static public function render () {

		ob_start();

		?>
		<div>
			<ul id="captions-box">
				<li class="caption-item"><img src="/modules/claims/css/img/state_1.png" alt="<?=Util::getLiteral('caption_pending_claim_critic')?>" /><?=Util::getLiteral('caption_pending_claim_critic')?></li>
				<li class="caption-item"><img src="/modules/claims/css/img/state_0.png" alt="<?=Util::getLiteral('caption_pending_claim')?>" /><?=Util::getLiteral('caption_pending_claim')?></li>
				<li class="caption-item"><img src="/modules/claims/css/img/state_2.png" alt="<?=Util::getLiteral('caption_closed_claim')?>" /><?=Util::getLiteral('caption_closed_claim')?></li>
				<li class="caption-item"><img src="/modules/claims/css/img/state_4.png" alt="<?=Util::getLiteral('caption_canceled_claim')?>" /><?=Util::getLiteral('caption_canceled_claim')?></li>
				<li class="caption-item"><img src="/modules/claims/css/img/state_pending_assigned.png" alt="<?=Util::getLiteral('caption_assigned_claim')?>" /><?=Util::getLiteral('caption_assigned_claim')?></li>
				<li class="caption-item"><img src="/modules/adr/css/img/arrow_stop_35.png" alt="<?=Util::getLiteral('caption_user_path')?>" /><?=Util::getLiteral('caption_user_path')?></li>
				<li class="caption-item"><img src="/modules/adr/css/img/user_1.png" alt="<?=Util::getLiteral('caption_user')?>" /><?=Util::getLiteral('caption_user')?></li>
				<li class="caption-item"><img src="/modules/adr/css/img/user_3.png" alt="<?=Util::getLiteral('caption_user_online')?>" /><?=Util::getLiteral('caption_user_online')?></li>
				<li class="caption-item"><img src="/modules/adr/css/img/user_2.png" alt="<?=Util::getLiteral('caption_user_offline')?>" /><?=Util::getLiteral('caption_user_offline')?></li>
				<li class="caption-item"><img src="/modules/adr/css/img/company.png" alt="<?=Util::getLiteral('caption_company')?>" /><?=Util::getLiteral('caption_company')?></li>
			</ul>
		</div>
		<?php

		return ob_get_clean();

	}
	
}
?>