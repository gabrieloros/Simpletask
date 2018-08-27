<?php
/**
 *  FooterView
 *  @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 15/03/2012
 *  CALLED BY: Master.php
 */

class FooterView extends Render {

    static public function render () {
    	
		ob_start();
		
		echo Menu::renderFooterMenu();

		return ob_get_clean();
    }
    
}