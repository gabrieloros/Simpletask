<?php
/**
 * Page not found class
 *
 * @author Gabriel Guzmán
 *  @version 1.0
 *  DATE OF CREATION: 15/03/2012
 *  UPDATE LIST
 *  * UPDATE: 
 *  CALLED BY:  ErrorActionManager.php
 */

class Error404View extends Render {
	
	static public function render ($error404, $pageNotFound) {
		
		ob_start();
		
		?>
		<div id="content-all">
 			
 			<div class="position-bg-content-all" id="content2">
 			
 				<div id="foot-content-all">

					<div id="foot-content2">
					
						<div id="content-folder-all">

							<div class="header-content-folder-all">
                            </div>
                            
                          	<div id="notfound-img"></div>
							
							<h2 class="tit-error-404"><?=self::renderContent($error404);?></h2>
							
							<div class="error-404 blue"><?=self::renderContent($pageNotFound);?></div>
                         	
						</div>

					</div>

				</div>

			</div>
		
		</div>
		
		<?php
		 
		return ob_get_clean();
	}
}