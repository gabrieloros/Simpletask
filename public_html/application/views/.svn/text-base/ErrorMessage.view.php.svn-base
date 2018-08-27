<?php
/**
 *  @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 15/03/2012
 *  UPDATE LIST
 *  * UPDATE: 
 *  CALLED BY:  
 */
class ErrorMessageView extends Render {
	
	static public function render ($message) {
		
		ob_start();
		
		?>
		<div id="errorMessage" class="error-popup news-text" >
			<?=$message?>
		</div>
		<?
		 
		return ob_get_clean();
		
	}
}