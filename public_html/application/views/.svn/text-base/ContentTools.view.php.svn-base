<?php
/**
 *  Content Tools
 *  @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 15/03/2012
 *  CALLED BY: Master.php
 */

class ContentTools extends Render {

	static public function render ($socialMediaInMiddle, $isHome=false) {
		
		ob_start();
		
		$uri = getCurrenProtocol().'/'.$_SESSION['s_languageIso'];
		
		?>
		<form id="actions_print_form" method="post" action="<?=$uri?>" target="_blank">
			<input id="title_form_popup" name="title" type="hidden" value="" />
			<input id="content_form_popup" name="content" type="hidden" value="" />
			<input id="head_form_popup" name="head" type="hidden" value="" />			
			<input name="pdf_document_name" type="hidden" value="<?= $_REQUEST['currentContent']['title']?><p:sectionTitle/>" />
		</form>
		
		<div id="tools_hidden_div" style="display:none;"></div>
		
		<div class="actions-right">
			
			<div class="actions-right1">
				
				<div class="actions-right2">
					
					<div class="icons-content">
						
						<ul class="margin-0">
							
							<li>
								<a class="icon-print" title="<?=Util::getLiteral('print')?>" href="javascript:openPrintPopUp();" onkeypress="openPrintPopUp();"><?=Util::getLiteral('print')?></a>
							</li>							
							
							<li>
								<a class="icon-recomendation" id="send-recommendation-link" title="<?=Util::getLiteral('recommend')?>" onclick="recommend('<?= '/'. $_SESSION['s_languageIsoUrl']?>')" onkeypress="recommend('<?= '/'. $_SESSION['s_languageIsoUrl']?>')" href=""><?=Util::getLiteral('recommend')?></a>
							</li>
							
						</ul>
						
					</div>
					
				</div>
				
			</div>
			
			<?
			if ($socialMediaInMiddle) {
			?>		
			<div class="actions-right1">
				
				<div class="actions-right2">				
					
					<div class="icons-content">
						
						<div class="addthis_toolbox">
							
							<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4bc5a68f4dae4078"></script>
							
							<ul class="margin-0">
							<?
							foreach ($socialMediaInMiddle as $socialLink) {
								$literal=isset($socialLink['literal']) && $socialLink['litera']!='' ? Util::getLiteral(strtolower($socialLink['literal'])) : '' ; 
							?>
							<li> <a class="<?=$socialLink['css_class']?>"><?=$literal?></a> </li>							
							<?}?>
							</ul>
							
						</div>
						
					</div>
					
				</div>
				
			</div>
			<?
			}
			?>	
		</div>
		<?
			
		return ob_get_clean();
    }
    
}