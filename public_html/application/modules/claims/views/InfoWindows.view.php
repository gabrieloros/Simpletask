<?php
class InfoWindows extends Render {

	public function render($data) {

		ob_start();

		?>
		<style>
		<!--
			.basic-popup-border {
				border: none;
			}
			
			.basic-popup {
				padding: 0;
			}
		-->
		</style>
		<div id="regionStat" class="regionStat">
			<h3><?=$data['name']?></h3>
			<p><b>Pendientes:</b> <?=$data['pending']?></p>
			<p><b>Cerrados:</b> <?=$data['closed']?></p>
		</div>
		<?php

		return ob_get_clean();

	}

}