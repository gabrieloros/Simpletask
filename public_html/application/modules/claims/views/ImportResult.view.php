<?php

/**
 * Draws the import upload result
 * @author Gabriel Guzman
 *
 */
class ImportResult extends Render{
	
	public function render($var = null){
		
		ob_start();
		?>
		<div class="upload-result-container">
			<span class="action-messages">Los reclamos se importaron correctamente.</span>
			<br /><br />
			<a href="/<?=$_REQUEST['urlargs'][0]?>/<?=$_REQUEST['urlargs'][1]?>"><?=Util::getLiteral('back')?></a>
		</div>
		<?php 
		return ob_get_clean();
	}

}

?>