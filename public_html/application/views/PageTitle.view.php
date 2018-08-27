<?php
/** 
 * @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 12/03/2012
 *  UPDATE LIST
 *  * UPDATE: 
 *  CALLED BY:  Master.view.php
 */

class PageTitle extends Render {
	
	static public function render () {
		
		ob_start();
		
		?>		
		<div id="title-section" style="clear:both;">
			<div class="section-title">
			      <div class="section-title-bg">
			      
			      		<?php
			      		$subTitle = '';

			      		if(isset($_REQUEST['currentContent']['subtitle'])){
			      			if($_REQUEST['currentContent']['subtitle'] != '') {
			      				$subTitle = '> '.$_REQUEST['currentContent']['subtitle'];
			      			}			      			
			      		}

			      		?>
			             <div class="section-title-left"><div class="esquina-tit-top"><div class="esquina-tit-bottom"><?=$_REQUEST['currentContent']['title']?> <?= $subTitle ?></div></div>
			      </div></div>
			</div>
		</div>				
		<?php
		
		return ob_get_clean();
	}
}