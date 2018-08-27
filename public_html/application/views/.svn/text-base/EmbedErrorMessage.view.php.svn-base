<?php
/**
 *  @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 15/03/2012
 *  UPDATE LIST
 *  * UPDATE: 
 *  CALLED BY:  
 */
class EmbedErrorMessageView extends Render {
	
	static public function render ($message, $url) {
		
		ob_start();
		
		?>
		<div id="embedErrorMessage" class="">
			<?=$message?>
		</div>
		
		<br />
		
		<a href="<?=$url?>"><?=Util::getLiteral('back')?></a>
		<?
		 
		return ob_get_clean();
		
	}
}