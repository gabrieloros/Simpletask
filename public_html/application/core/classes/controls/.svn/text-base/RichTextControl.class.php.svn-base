<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/../application/core/classes/filters/FilterControl.class.php';

/** 
 * @author gabriel.guzman
 * 
 * 
 */
class RichTextControl extends FilterControl{

	function __construct($fieldName, $label='', $isMandatory=false, $readonly) {
		
		parent::setFieldName ( $fieldName );
		
		parent::setLabel ( $label );
		
		parent::setIsMandatory($isMandatory);
		
		parent::setReadonly($readonly);
	
	}
	
	public function drawHtml() {
	    
	    if(parent::getIsMandatory()){
	        $mandatoryClass = 'mandatory-input';
	        $mandatoryLabelClass = 'mandatory-label';
	    }
	    else{
	        $mandatoryClass = '';
	        $mandatoryLabelClass = '';
	    }
	    
        if(parent::getReadonly()){
            $readonly = "readonly: 1,";
        }
        else{
            $readonly = "";
        }
	    
	    $html = '
				<label class="'.$mandatoryLabelClass.'" for="control_' . parent::getFieldName () . '">
	    			' . parent::getLabel () . '
    	    	</label>
    	    	
    	    	<textarea class="'.$mandatoryClass.'" id="control_'.parent::getFieldName().'" name="control_'.parent::getFieldName().'">'.parent::getSelectedValue().'</textarea>
    	    	';
	    
	    $html .= '
	    		<script type="text/javascript" src="/core/thirdparty/tiny_mce_3.5/jscripts/tiny_mce/jquery.tinymce.js"></script>
	    											
	    		<script type="text/javascript">
	    		
	    			$("#control_'.parent::getFieldName().'").tinymce({
	    			
	    				// Location of TinyMCE script
						script_url : "/core/thirdparty/tiny_mce_3.5/jscripts/tiny_mce/tiny_mce.js",
					
                	    // General options
                	    '.$readonly.'
                	    theme : "advanced",                	    
                	    /*
                	    valid_elements : ""
                	    	+"a[href|target],"
                	    	+"b,strong,em,i,u,"
                	    	+"br,"
                	    	+"font[color|face|size],"
                	    	+"img[src|id|width|height|align|hspace|vspace],"
                	    	+"li,ul,ol,"
                	    	+"p[align|class|style],"
                	    	+"h1,h2,h3,h4,h5,h6,"
                	    	+"span[style|class],"
                	    	+"pre[style|class],"
                	    	+"blockquote[style|class],"
                	    	+"textformat[blockindent|indent|leading|leftmargin|rightmargin|tabstops],",
                	    	*/
                	    valid_elements : "@[id|class|style|title|dir<ltr?rtl|lang|xml::lang|onclick|ondblclick|"
								+ "onmousedown|onmouseup|onmouseover|onmousemove|onmouseout|onkeypress|"
								+ "onkeydown|onkeyup],a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
								+ "name|href|target|title|class|onfocus|onblur],strong/b,em/i,strike,u,"
								+ "#p,-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
								+ "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
								+ "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
								+ "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
								+ "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
								+ "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
								+ "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
								+ "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
								+ "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
								+ "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
								+ "|height|src|*],script[src|type],map[name],area[shape|coords|href|alt|target],bdo,"
								+ "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
								+ "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
								+ "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
								+ "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
								+ "q[cite],samp,select[disabled|multiple|name|size],small,"
								+ "textarea[cols|rows|disabled|name|readonly],tt,var,big",
                	    plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist",
                	    height: "260px",
                	    width: "580px",
                	    theme_advanced_buttons1 : ",bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,image,media,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,cleanup,help,code",
                	    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,advhr,|,table",
                	    theme_advanced_buttons3 : ",fontselect,fontsizeselect,",
                	    theme_advanced_toolbar_location : "top",
                	    theme_advanced_toolbar_align : "left",
                	    theme_advanced_statusbar_location : "none",
                	    theme_advanced_resizing : false,
                	    extended_valid_elements: "img[!src|border:0|alt|title|width|height|style]a[name|href|target|title|onclick]", 
                	    force_br_newlines : true,
        				force_p_newlines : false,
        				forced_root_block : \'\',
        				cleanup : true,
        				media_strict: false,
        				relative_urls : false,
        				file_browser_callback : MadFileBrowser
        				
                	});
                	
					function MadFileBrowser(field_name, url, type, win) {
						tinyMCE.activeEditor.windowManager.open({
					      file : "/core/thirdparty/tiny_mce_3.5/jscripts/tiny_mce/plugins/madFileUploader/mfm.php?field=" + field_name + "&url=" + url + "",
					      title : \'File Manager\',
					      width : 640,
					      height : 450,
					      resizable : "no",
					      inline : "yes",
					      close_previous : "no"
					  }, {
					      window : win,
					      input : field_name
					  });
					  return false;
					}
                    
                </script>';
	    
	    return $html;
	    
	}
    
}