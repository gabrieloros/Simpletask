<?php
/**
 *  @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 15/03/2012
 *  UPDATE LIST
 *  * UPDATE: 
 *  CALLED BY:  
 */
class BasicAjaxMessageResponse extends Render {
	
	static public function render ($message, $result) {
		
		ob_start();
		
		?>
		<div id="basicAjaxResultContainer" style="display: none;">
			<div id="ajaxMessageResult">
			<?php
			if($result){
				echo '1';
			}
			else{
				echo '0';
			}
			?>
			</div>
			<div id="ajaxMessageResponse" class="message-text">
				<?=$message?>
			</div>
		</div>
		<?
		 
		return ob_get_clean();
		
	}
}