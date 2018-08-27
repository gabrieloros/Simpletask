<?php

/**
 * Draws the import upload component
 * @author Gabriel Guzman
 *
 */
class Import extends Render{
	
	public function render($origins){
		
		ob_start();
		
		?>



		<div class="upload-form-container">
			
			<form id="uploadFileForm" action="" method="post" enctype="multipart/form-data">
				<br>

				<div class="container">
					<!-- Example row of columns -->
					<div class="row">
						<div class="col-md-4">

						</div>
						<div class="col-md-4">
							<label for="claimsFile"><?=$_SESSION['s_message']['document']?>:</label>

							<input class="form-control" type="file" name="claimsFile" id="claimsFile" />

							<?=$_SESSION['s_message']['maxuploadfilesize']?>: <?=ini_get('upload_max_filesize')?>

							<br /><br />

							<label for="originName"><?=$_SESSION['s_message']['origin']?>:</label>


							<select class="form-control" name="originName" id="originName">
								<?php
								foreach ($origins as $originKey => $origin){
									?>
									<option value="<?=$origin?>"><?=Util::getLiteral($origin)?></option>
									<?php
								}
								?>
							</select>

							<br /><br />

							<div id="button-container">
								<button type="button" class="btn btn-success"  onclick="sendUploadForm('uploadFileForm');" > <?=$_SESSION['s_message']['upload']?></button>
								<a type="button" class="btn btn-danger"  href="/<?=$_REQUEST['urlargs'][0]?>/<?=$_REQUEST['urlargs'][1]?>" > <?=Util::getLiteral('back')?></a>

							</div>

							<br />

							<div id="upload-messages" style="display: none;">
							</div>

			</form>
						</div>
						<div class="col-md-4">

						</div>
					</div>

			
		</div>
		
		<br /><br />
		

		
		<?php 
		$_REQUEST['jsToLoad'][] = "/modules/settings/js/settings.js";
		$_REQUEST['jsToLoad'][] = "/modules/claims/js/claims.js";
		$_REQUEST['jsToLoad'][] = "/core/js/ajaxfileupload.js";
		
		return ob_get_clean();
	}

}