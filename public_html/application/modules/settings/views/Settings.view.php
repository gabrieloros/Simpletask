<?php

/*
 * View Settings
 * 
 */
class Settings extends Render{
	
	public function render($layers, $settings){

		?>	
		<div id="settings_layer_container">
		<h3 class="center_settings">Layers</h3>
		<div class="upload-form-container">
			
			<form id="uploadLayerFileForm" action="" method="post" enctype="multipart/form-data">
				
				<label for="claimsFile"><?=$_SESSION['s_message']['document']?>:</label>
				
				<input class="mandatory-input" type="file" name="layerFile" id="layerFile" />
				
				<?=$_SESSION['s_message']['maxuploadfilesize']?>: <?=ini_get('upload_max_filesize')?>
				
								
				<div id="button-container">
					<input type="button" value="<?=$_SESSION['s_message']['upload']?>" onclick="sendUploadLayerForm('uploadLayerFileForm');" />
				</div>
				
				<br />
				
				<div id="upload-messages" style="display: none;">
				</div>
								
			</form>
			
		</div>
		<div id="container_layers">
		<div id="content_list_layers">
		<ul id="list_layers">
		<?php 
		foreach ($layers as $layer){
		?>	
		<li id="item_<?php echo $layer?>"><?php echo $layer?></li>
		<?php 
		}
		
		?>
		
		</ul>
		</div>
		</div>
		<hr align="center" noshade="noshade" size="2" width="80%" />
		</div>
		<?php 

		$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
		$_REQUEST['jsToLoad'][] = "/core/js/ajaxfileupload.js";
		$_REQUEST['cssToInclude'] = "modules/settings/css/settings.css";
		return ob_get_clean();
	}	
	
}