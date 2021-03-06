<?php
/**
 *  MasterViewLdr
 *  @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 15/03/2012
 *  CALLED BY: url.php
 */

require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/Render.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/CssManager.class.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/util/JsManager.class.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Header.view.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Footer.view.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Menu.view.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/PageTitle.view.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/ContentTools.view.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/views/Content.view.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/managers/common/BreadcrumbManager.class.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/managers/common/HeaderManager.class.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/managers/common/FooterManager.class.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/ContentManager.class.php');
// require_once ($_SERVER['DOCUMENT_ROOT'] . '/../application/core/exceptions/BreadcrumbException.class.php');

class MasterViewLdr extends Render {
    
    public function render (&$render) {
        
//         $link = '';	
		
// 		foreach ($_SESSION['s_languages'] as $language){
// 			$link .= '<link rel="alternate" type="text/html" href="/'.$language->getIso().'" hreflang="'.$language->getIso().'" lang="'.$language->getIso().'" title="'.$_SESSION['s_parameters']['site_title'].'" />'."\n";
// 		}
		
 		$isHome = preg_match('/home/', $_REQUEST['currentContent']['menukey'])>0  ? true : false ;
		
		ob_start();
		       
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?//= $_REQUEST['currentContent']['title']?> | <?=$_SESSION['s_parameters']['site_title']?></title>
	
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="cache-control" content="public" />

	<meta name="viewport" content="width=device-width; user-scalable=no; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; target-densityDpi=device-dpi;" />
	<script type="text/javascript"    src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
		
	<meta name="ROBOTS" content="ALL" />

	<?//=$link?>
	
	<?php 
	//Array with all the css to be load.
	$css = array("/core/css/popup.css",
				"/core/css/generalextra.css",
				"/core/css/general.css",
				"/core/css/interior.css",
				"/core/css/jquery-ui-1.8.16.custom.css",
				"/core/css/treeSelector.css",
				"/core/css/gdr.css"
				);
				
	$configurator=Configurator::getInstance();
	
	if ($configurator->getMinimiceCss()) {
		
		//to avoid multiple disk access
		if(! isset($_SERVER['cssToInclude'])){
			
			//Add document root to all css.
			foreach ($css as $key=>$singleCss) {
				$css[$key]=$_SERVER['DOCUMENT_ROOT'].$singleCss;					 
			}
	
			$cssManager = new CssManager($css);
			
			$cssToInclude = $cssManager->getCssFile($_SERVER['DOCUMENT_ROOT']."/core/css/", "master");
			
			if(! $cssToInclude){
				
				$cssManager->mergeFiles($_SERVER['DOCUMENT_ROOT']."/core/css/", "master");
				
				$cssToInclude = $cssManager->getCssFile($_SERVER['DOCUMENT_ROOT']."/core/css/", "master");
				
			}
			
			$_SERVER['cssToInclude'] = $cssToInclude;
			
			?>
			<link href="<?= $_SERVER['cssToInclude'] ?>" rel="stylesheet" type="text/css" />
			<?
		}
	} else {
		foreach ($css as $singleCss) {
			?>
			<link href="<?= $singleCss ?>" rel="stylesheet" type="text/css" />
			<?
			}
		}
	 
		if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/core/css/custom.css')){
			echo '<link href="/core/css/custom.css" rel="stylesheet" type="text/css" />';	
	    }
	    
	    //home CSS
    	if($isHome)			
    		echo '<link href="/core/css/home.css" rel="stylesheet" type="text/css" />';
	
		/*
		 * STYLES
		 * NOTE: Always put styles before JavaScripts for performance
		 */
		if(isset($_REQUEST['currentContent']['modulename']) && $_REQUEST['currentContent']['modulename']!=''){
			$filePath = '/modules/'.$_REQUEST['currentContent']['modulename'].'/css/'.$_REQUEST['currentContent']['modulename'].'.css';
			if (file_exists($_SERVER['DOCUMENT_ROOT'].$filePath)){
				echo '<link href="'.$filePath.'" rel="stylesheet" type="text/css" />';
			}
		}
	?>
	
	
 	<script type="text/javascript" src="/core/js/jquery-1.7.min.js"></script>
 	<script type="text/javascript" src="/core/js/jquery-ui-1.8.16.custom.min.js"></script>
 	<script type="text/javascript" src="http://btburnett.com/spinner/ui.spinner.min.js"></script>
 		<?php
 		//FIXME: con la 1.4.4 el boton limpiar de seguimiento de reclamos deja de funcionar con el select de tipos de reclamos
 		?>
<!--  		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js"></script> -->
<!-- 		<script type="text/javascript" src="/core/js/jquery-ui-1.8.16.custom.min.js"></script> -->
<!-- 		<script type="text/javascript" src="http://btburnett.com/spinner/ui.spinner.min.js"></script> -->
 
 
	<script type="text/javascript" src="/core/js/modernizr.js"></script>
	
	<script type="text/javascript" src="/core/js/resources-<?= $_SESSION['s_languageIso'] ?>.js"></script>

	<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>
	<?
	
	$headerManager = HeaderManager::getInstance();
	
	?>
</head>
<body>
	<noscript>
		<div class="noscript-message"><?=self::renderContent(Util::getLiteral('no_script_message'))?></div>
	</noscript>
	<div id="container" class="container0">
		
		<div id="container2">		
			
			<div id="container3a">		    
				
				<div id="search_on">
					
					<form id="search-form" class="search-form" name="search" method="post" action="/<?=$_SESSION['s_languageIsoUrl']?>/search">
						
						<label for="search-query"><span class="search-name"><?=self::renderContent(Util::getLiteral('search'))?></span></label>
						<input id="maxresults" type="hidden" name="maxresults" value="20" />
						<input id="fromresult" type="hidden" name="fromresult" value="0" />
						<input id="search-query" value="<?=self::renderContent(Util::getLiteral('search_txt'))?>" onfocus="clearMe(this);" name="search_query"/>
						<a href="#" class="button-buscar" id="button-buscar" title="<?=self::renderContent(Util::getLiteral('click_here_search'))?>" onclick="$('#search-form').submit();" onkeypress="$('#search-form').submit();">
						<?=self::renderContent(Util::getLiteral('search'))?>
						</a>		
					<?
					$searchButtons = null;
					if (isset($searchButtons) && $searchButtons!='') {
						
						foreach ($searchButtons as $searchButton) {
						?>
						 <div id="search_module_button_<?=$searchButton['pfwid']?>" class="<?=$searchButton['css']?>" onclick="javascript:submitActionForm('/<?=$_SESSION['s_languageIsoUrl']?>/search',generalActions.SEARCH,'','',{search_query:document.getElementById('search-query').value})"></div>
						<? 
						}
						
					} 
					?>
					</form>
				</div>
				<?
				echo Header::render();
				
				echo Header::pageHeaderRender($isHome);
				?>

				<div id="menu-search">
					<?=Menu::renderHeaderMenu();?>
				</div>			
				
				<div id="interior-container-02">			
					
					<div id="interior-container">				
						
						<div id="interior-container-0"></div>				
						
						<div id="interior-content">
							<?if(!$isHome){
								echo '<div id="content-detail">';
								$id='content-back';
							  }else{
							  	$id='content-back2';
						  	}		
							?>						
							<div id="<?=$id?>">		
								<? 
								if(!$isHome){
									try {	
										$breadcrumb = BreadcrumbManager::getBreadcrum();
										
										$fullBreadcrumb ='';
										foreach ($breadcrumb as $crumb){
											if ($crumb['idcontent'] == $_REQUEST['currentContent']['id']){
												$fullBreadcrumb .= ' <strong>'.$crumb['content_title'].'</strong>';
											}
											else{
												$fullBreadcrumb .=' <a href="/'.$_SESSION['s_languageIsoUrl'].'/'.$crumb['content_url'].'"> '.$crumb['content_title'].'</a>';
											}
										}
										echo '<div id="path">';
											echo '<a href="/'.$_SESSION['s_languageIsoUrl'].'">'.Util::getLiteral('home').'</a> '.$fullBreadcrumb;
										echo '</div>';
									} catch (BreadcrumbException $e) {
										$this->session->logger->fatal($e->getMessage()." trace: ".$e->getTraceAsString());
									echo '<div class="errorMessageException">'.$e->getMessage().'</div>';
									}
								}	
								
								$socialMediaInMiddle = false;
								
								echo ContentTools::render(array(),$socialMediaInMiddle,$isHome);
								?>	
							</div>						
							
							<div class="central-content">
								<? if($isHome){?>
									<div class="linkbox-content-home">
								<? }
								$menu = '';
								try {
									$menu = Menu::renderMenu();
									if ($menu!='') {
		    							if (!isset($_SESSION['s_parameters']['lateral_menu_position']) || $_SESSION['s_parameters']['lateral_menu_position']=='') {
											$menu_position='left';
										} elseif ($_SESSION['s_parameters']['lateral_menu_position']=='left') {
											$menu_position='left';
										} elseif ($_SESSION['s_parameters']['lateral_menu_position']=='right') {
											$menu_position='right';
										}
									} else {
										$menu_position=false;
									}
								} catch (BreadcrumbException $e) {
									$this->session->logger->fatal($e->getMessage()." trace: ".$e->getTraceAsString());
									echo '<div class="errorMessageException">'.$e->getMessage().'</div>';
								}										
								if($isHome){
									echo '</div>';
								}
								if($isHome){
									echo '<div id="center-div-home" class="center-div-03-home">';
								} else {
									echo '<div id="center-div" class="center-div-04">';
								}

									echo PageTitle::render();
									
									echo Content::render();
									
									?>
									<div id="especific-content" style="">
											<? 
											echo $render;
											?>
										<div style="clear:both;"></div>
									</div>
													
								</div>
								
							</div>

							<?if(!$isHome){
								echo '</div>';	
    						}?>
    												
						</div>
						
					</div>
					
					<div id="footer-mix">
							
					</div>
					
				</div>
				
			</div>
			
			<div id="container4a">
				
				<div class="footer-content">
					
					<div id="footer">
						<?
						$footerManager=FooterManager::getInstance();
						$footerLink = $footerManager->getFooterLinks();
						$lastItem=count($footerLink);
						$count=1;
						foreach ($footerLink as $link) {
						?>
							<a <?=$link['target'];?> class="<?=$link['link_class'];?>" href="<?=$link['url'];?>" title="<?=self::renderContent($link['link_title']);?>"><?=self::renderContent($link['link_title']);?></a>				
						<?
							if ($count<$lastItem) {
						?>
								&nbsp; <span>|</span>	
						<?
							}
							$count++;
						}
						?>
						<br /><br />
							
							<?=self::renderContent(Util::getLiteral('copyright'))?>
							
					</div>
					
				</div>
				
			</div>
			
 		</div>
 		
	</div>	
<?
$jsArray = array(
			"/core/js/actionResponse.js",
			"/core/js/allPopup.js",
			"/core/js/util.js",
			"/core/js/scripts.js",
			"/core/js/EnumsJS.js"
			);
			
$jsCalendarTranslationFile = $_SERVER['DOCUMENT_ROOT'] . "/core/js/jquery.ui.datepicker-".$_SESSION['s_languageIso'].".js";
		
if(file_exists($jsCalendarTranslationFile)){
	$jsArray[] = "/core/js/jquery.ui.datepicker-".$_SESSION['s_languageIso'].".js";
}
			
			
if ($configurator->getMinimiceJs()) {
	//to avoid multiple disk access
	if(!isset($_SESSION['scriptToInclude'])){
		//Add document root to all css.
		foreach ($jsArray as $key=>$js) {
			$jsArray[$key]=$_SERVER['DOCUMENT_ROOT'].$js;					 
		}
		
		$jsManager = new JsManager($jsArray);
	
		$scriptToInclude = $jsManager->getJsFile($_SERVER['DOCUMENT_ROOT']."/core/js/", "allScripts");
		
		if(! $scriptToInclude){
			
			$jsManager->mergeFiles($_SERVER['DOCUMENT_ROOT']."/core/js/", "allScripts");
			
			$scriptToInclude = $jsManager->getJsFile($_SERVER['DOCUMENT_ROOT']."/core/js/", "allScripts");
		}
		
		$_SESSION['scriptToInclude'] = $scriptToInclude;
		
	}
	echo '<script type="text/javascript" src="'.$_SESSION['scriptToInclude'].'"></script>';
} else {
	foreach ($jsArray as $key=>$js) {
		echo '<script type="text/javascript" src="'.$js.'"></script>';					 
	}
}	

if (isset($_REQUEST['jsToLoad']) && $_REQUEST['jsToLoad']!='') {
	$scripts = array_unique($_REQUEST['jsToLoad']);
	
	foreach($scripts as $scriptSource){
		echo '<script type="text/javascript" src="'.$scriptSource.'"></script>';
	}
}
	
if (isset($_SESSION['s_parameters']['google_analytics_key']) && $_SESSION['s_parameters']['google_analytics_key']!='') {
?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
  		_gaq.push(['_setAccount', '<?=$_SESSION['s_parameters']['google_analytics_key']?>']);
  		_gaq.push(['_trackPageview']);

		(function() {
    	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  		})();
	</script>
<?}?>	
</body>
</html>      
<?php
		return ob_get_clean();
    }
}
?>