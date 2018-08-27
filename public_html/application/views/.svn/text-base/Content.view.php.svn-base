<?php
/**
 *  Content
 *  @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 13/03/2012
 *  CALLED BY: Master.view.php
 */

class Content extends Render {

    static public function render () {
    	
		ob_start();
		
		?>
		<div class="real-content">
			
			<?
			$contentText = $_REQUEST['currentContent']['body'];		
			?>
			
		</div>
		
		<?php
		if($contentText != ''){ 
			?>
			<div class="text-content" style=""><?=$contentText?></div>
			<?php
		} 
		?>
		
		<?
		if($contentText != '') {
		?>
			<div class="news-separador"></div>
		<?
		}
		
		return ob_get_clean();
    }
    
}