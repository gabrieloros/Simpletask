<?php
class PopupPrintView {
	
	static public function render () {
		
		ob_start();
		
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<?
				$title = $_POST['title'];
				$content = $_POST['content'];
				$head = $_POST['head'];
			?>
			
			<head>
				<?=$head?>
				<link type="text/css" rel="stylesheet" href="/core/css/print.css" />
			</head>
			<body>
			<script type="text/javascript">
				function ecological_print(){

					$('.eco-print-cover-div').css('display','none');

					var header_content = $('#ecological-header-container').html();			

					$('#ecological-header-container').html('');
					$('#ecological-header-container').css('height','20px');

					window.print();

					setTimeout(function(){
						$('#ecological-header-container').html(header_content);
						$('#ecological-header-container').css('height','auto');
						$('.eco-print-cover-div').css('display','block');
					},1000);
				}
			</script>
			<div class="interior-eco-container">
				
				<div id="interior-container">
					
					<div class="ecological-content">
						
						<div id="ecological-header-container">
							
							<div class="eco-title">
								<div class="button-close-eco">
									<input type="button" value="<?=Util::getLiteral('close')?>" onclick="window.close();"/>
								</div>			
							</div>
											
							
							<br />
					      	
					      	<div class="separador"></div>
				      		
				      		<br />
							
							<div id="eco-header-elements">
								<? 
								if ($_SESSION['s_parameters']['ecological_header_img']!='') {
									echo '<div id="ecological-header-content">';
										echo '<img src="/pfw_files/tpl/'.$_SESSION['s_parameters']['ecological_header_img'].'"/>';
									echo '</div>';
								}
								?>
								
								<div class="eco-print" >
									<a href="#" class="eco-print-img" onclick="ecological_print();" title="<?=Util::getLiteral('print')?>"><?=Util::getLiteral('print')?></a>
								</div>
								
								<div class="eco-frame-extern">
					      			
					      			<div class="eco-frame">
										
										<div class="eco-sup-bg"></div>
					            		
					            		<div class="eco-frame-content">
					            			<div class="content-text base-grey"><?=Util::getLiteral('dont_print')?></div>
					                  		<div class="eco-img"></div>
					          			</div>
					          			
					            		<div class="eco-inf-bg">
											<span class="eco-inf-left"></span>
										</div>
										
						      		</div>
						      		
								</div>
												
							</div>
							
						</div>
						
						<div class="eco-include">
							<?=$content?>
						</div>
						
						<?
						if ($_SESSION['s_parameters']['ecological_footer_img']!='') {
							echo '<div id="ecological-footer-content">';
								echo '<img src="/pfw_files/tpl/'.$_SESSION['s_parameters']['ecological_footer_img'].'"/>';	
							echo '</div>';
						}
						?>
						
					</div>
							
				</div>
				
			</div>
			
			<script type="text/javascript">
				<!-- remove calendar secc events -->
				$('#calendari').remove();		
			</script>
			
			<div class="popup-background eco-print-cover-div"></div>
			
			</body>
		</html>
<?
	return ob_get_clean();
	}
}