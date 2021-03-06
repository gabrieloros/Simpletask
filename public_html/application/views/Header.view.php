<?php
class Header extends Render {
    
	static public function render ($linksHeader = array()) {
		
		ob_start();
	        
		require_once $_SERVER['DOCUMENT_ROOT'].'/../application/core/enums/LoginActionManagerActions.enum.php';
		
		?>
		<script type="text/javascript">
		function CreateBookmarkLink() {
			if (document.all)
				window.external.AddFavorite(location.href, document.title);
			else if (window.sidebar)
				window.sidebar.addPanel(document.title, location.href, "");
			else {
				var title_message = "<?=Util::getLiteral('add_to_favorites')?>";
				var body_message = "<?=Util::getLiteral('add_favorites')?>";
				submitActionAjax ('/<?=$_SESSION['s_languageIso']?>',commonActionManagerActions.ERRORMESSAGE,'','','',{errorTitle:title_message,errorMessage:body_message});
			}		
		}
		</script>

		<div>
			
			<div></div>
			
			<div>
			
				<?php
				/*
				?>
				
				<div id="actions-menu">
					
					<div class="actions-menu">
						
						<div class="actions-menu3 actions-top">
						<?
						$lastItem=count($linksHeader);
						$count=1;
						foreach ($linksHeader as $link) {
						?>
							<div id="<?=self::renderContent($link['link_title']);?>_tools_header"><a <?=$link['target'];?> class="<?=$link['link_class'];?>" href="<?=$link['url']?>" title="<?=self::renderContent($link['link_title']);?>"><?=self::renderContent($link['link_title']);?></a></div>				
						<?
							if ($count<$lastItem) {
						?>
								<span class="divider">|</span>	
						<?
							}
							$count++;
						}
						?>
						</div>
						
					</div>
					
				</div>		
				
				<div id="container-idiomas">
					
					<div id="idiomas">
					<?			
					if ($_SESSION['s_languages']!='' && count($_SESSION['s_languages']) > 1) {
						
						foreach($_SESSION['s_languages'] as $langObj) {
							
							$active = $langObj->getId() == $_SESSION['s_languageId'] ? 'active-flag' :'';
							
							$url = isset($_REQUEST['urlargs'][1]) ? '/'.$_REQUEST['currentContent']['url_lang'][$langObj->getIso()] : '';							
					?>
							<a title="<?=self::renderContentWithStrip($langObj->getName())?>"
								class="idioma-<?=$langObj->getIso()?> <?=$active?>" 
								href="/<?=$langObj->getIso().$url?>">
									<?=self::renderContentWithStrip($langObj->getName())?>
							</a>
					<?	
						}
					}
					?>
					</div>
					
				</div>
				
				<?php
				*/ 
				?>
				
				<span style="display: none; float: right; margin-right: 10px;" class="date">
					<?
						setlocale(LC_TIME, $_SESSION['s_message']['locale_code']);
						echo strftime(Util::getLiteral('date_format_long'));
					?>
				</span>
				
				<?php
				/* 
				?>
				
				<div class="div-action">
					<script type="text/javascript">
						<? 
						if(isset($_SESSION['s_parameters']['addthis_username']) && $_SESSION['s_parameters']['addthis_username']!=''){
						?>
							var addthis_pub = "<?=$_SESSION['s_parameters']['addthis_username']?>";
						<?}?>
						var addthis_language = "<?=$_SESSION['s_languageIso'];?>";
					</script>
				</div>
				<?
				*/
				?>
				
				<div >
					<a style="margin-right: 4px; margin-left: 2px; color: white; background: none;" href="#" onclick="javascript:submitActionForm('/<?=$_SESSION['s_languageIsoUrl']?>/<?=$_REQUEST['currentContent']['menukey']?>','<?=LoginActionManagerActions::LOGOUT?>')">
                        <?=Util::getLiteral('logout')?>
					</a>
					<div style="float:right; display: none;">
						<?=Util::getLiteral('welcome')?>, <span><?=$_SESSION['loggedUser']->getUserName()?> <?=$_SESSION['loggedUser']->getUserSurName()?></span>
					</div>
				</div>
				
			</div>
				
		</div>
<?php
		return ob_get_clean();
    }
    
    static public function pageHeaderRender ($isHome) {

    	ob_start();
    	
    	?>
		<div id="header-home">
			
			<div id="link-home">
				<a id="link-home-img" href="/<?=$_SESSION['s_languageIsoUrl']?>" title="<?=$_SESSION['s_parameters']['site_title']?>">
				</a>
			</div>
				
			<div class="st01" >
				<div class="div-st01-text">
					<div class="st01-text"><?=$_SESSION['s_message']['site_header_title']?></div>
				</div>		
				<div class="st02"></div>
			</div>
				
			<div class="text-header">
				<span class="header-text"><?=$_SESSION['s_message']['site_header_motto']?></span>
			</div>
	
		</div>    	
    	<? 
    	return ob_get_clean();
    }	
}