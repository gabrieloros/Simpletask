<?php
/**
 * Pager class
 *
 * @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 20/03/2012 
 */
class Pager extends Render {
	
	static public function render ($pager_array,$post=false) {
		ob_start();
		?>
		<div id="pager-main">
			<?php
			if(isset($pager_array) && is_array($pager_array) && count($pager_array) > 0){ 
			?>
			<form id='form_pager' method='post' action='<?=$pager_array['url']?>'>
			<?
				if($post != false){
					foreach ($post as $key=>$hiddenInput) {
						echo '<input type="hidden" id="'.$key.'" name="'.$key.'" value="'.$hiddenInput.'"/>';
					}
				}
			?>
				<input type='hidden' id='txtPage' name='page'/>
				
				<?if ($pager_array['first']!='') {?>
					<a class="link-paginador" href="javascript:navigatePage('<?=Render::renderContentJavascript($pager_array['first'])?>');">&lt;&lt;</a>
				<?}
				if ($pager_array['previous']!='') {?>
					<a class="link-paginador" href="javascript:navigatePage('<?=Render::renderContentJavascript($pager_array['previous'])?>');"><?=Util::getLiteral('previous')?></a>
				<?}?>
				<span id="pager">
				
				<?if ($pager_array['morePagesPrevious']) {?>
				<span class="threepoints">...</span>
				<?}		
				foreach($pager_array['pageList'] as $this_page) {
					if ($this_page['text']==$pager_array['page']) {
					?>
						<strong><?=$this_page['text']?></strong>&nbsp;
					<?} else {?>
						<a class="link-paginador" href="javascript:navigatePage('<?=Render::renderContentJavascriptNoEntities($this_page['url'])?>');"><?=$this_page['text']?></a>&nbsp;
					<?}
				}
				
				if($pager_array['morePagesNext']) {
				?>
				<span class="threepoints">...</span>
				<?}?>
				</span>
				<?
				if($pager_array['next'] != '') {?>
					<a class="link-paginador" href="javascript:navigatePage('<?=Render::renderContentJavascript($pager_array['next'])?>');"><?=Util::getLiteral('next')?></a>
				<?}
				if($pager_array['last'] != '') {
				?>
					<a class="link-paginador" href="javascript:navigatePage('<?=Render::renderContentJavascript($pager_array['last'])?>');">&gt;&gt;</a>
				<?}?>
			</form>
			<?php
			} 
			?>
		</div>
		
				
		<?php 
		return ob_get_clean();
	}
}