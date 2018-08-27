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

class MasterViewPublic extends Render {
    
    public function render (&$render) {
        
		ob_start();
		       
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?//= $_REQUEST['currentContent']['title']?> | <?=$_SESSION['s_parameters']['site_title']?></title>
	
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="cache-control" content="public" />

	<meta name="viewport" content="width=device-width; user-scalable=no; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; target-densityDpi=device-dpi;" />
		
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
				"/core/css/gdr.css",
				"/core/css/public.css"
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
	<script type="text/javascript" src="/core/js/modernizr.js"></script>
	<script type="text/javascript" src="/core/js/resources-<?= $_SESSION['s_languageIso'] ?>.js"></script>
	<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>
</head>
<body>
	<noscript>
		<div class="noscript-message"><?=self::renderContent(Util::getLiteral('no_script_message'))?></div>
	</noscript>
	<div id="container" class="container0">
		
		<div id="container2">		
			
			<div id="container3a">		    			
			
				<div id="interior-container-02">			
					
					<div id="interior-container">								
						
						<div id="interior-content">										
							<div class="central-content">
								<? 
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
