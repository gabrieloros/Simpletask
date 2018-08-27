<?php
class createUser extends Render {
    
	static public function render ($fields = null, $userData = null, $readonly = false) {
		
	    ob_start();
	    
	    if(is_object($userData)){
	        
            $userId = $userData->getId();
            $userName = $userData->getUsername();
            $userSurname = $userData->getUsersurname();
            $userEmail = $userData->getUseremail();
            $userLogin = $userData->getUserlogin();
            $userTypeId = $userData->getUsertypeid();
	        
	    }
	    else{
	        
            $userId = '';
            $userName = '';
            $userSurname = '';
            $userEmail = '';
            $userLogin = '';
            $userTypeId = '';
	        
	    }
	    
	    if($readonly){
	        $readonlyProp = 'readonly="readonly"';
	    }
	    else{
	        $readonlyProp = '';
	    }
		
	    ?>
	    <div style="width: 380px;">
	    
	    	<form method="post" action="create" id="createUserForm" enctype="multipart/form-data">
		    
		    	<input type="hidden" name="userId" id="userId" value="<?=$userId?>" />
		    	
		    	<div id="userName" class="fila_form">
	        
	            	<?php
	            	$fields ['name']->setSelectedValue($userName);
	            	echo $fields ['name']->drawHtml();
	            	?>
	                
	                <div class="clear"></div>
	            
	            </div>
	            
				<div id="userSurname" class="fila_form">
	        
	            	<?php
	            	$fields ['surname']->setSelectedValue($userSurname);
	            	echo $fields ['surname']->drawHtml();
	            	?>
	                
	                <div class="clear"></div>
	            
	            </div>
	            
	            <div id="userEmail" class="fila_form">
	        
	            	<?php
	            	$fields ['email']->setSelectedValue($userEmail);
	            	echo $fields ['email']->drawHtml();
	            	?>
	                
	                <div class="clear"></div>
	            
	            </div>
	            
	            <div id="userLogin" class="fila_form">
	        
	            	<?php
	            	$fields ['login']->setSelectedValue($userLogin);
	            	echo $fields ['login']->drawHtml();
	            	?>
	                
	                <div class="clear"></div>
	            
	            </div>
	            
	            <div id="userPassword" class="fila_form">
	        
	            	<?php
	            	echo $fields ['password']->drawHtml();
	            	?>
	                
	                <div class="clear"></div>
	            
	            </div>
	            
				<div id="userType" class="fila_form">
	        
	            	<?php
	            	$fields ['usertype']->setSelectedValue($userTypeId);
	            	echo $fields ['usertype']->drawHtml();
	            	?>
	                
	                <div class="clear"></div>
	            
	            </div>
	            
	            <br />
	            
	            <div style="border-top: 1px solid #AFAFAF;"></div>
	    	    
	            <div class="fila_form" id="registerButtonsCell">
	            
	            	<?php
	        	    if(!$readonly){ 
	        	    ?>
	        	    <input style="float: left; margin-right: 6px;" class="form_bt" type="button" onclick="sendFormAjax('createUserForm');" value="<?=$_SESSION['s_message']['save']?>"/>
	            	<?php
	        	    }
	                ?>
	            
	            	<div class="clear"></div>
	            
	            </div>
		    
		    </form>
		    
	    </div>
    	    
	    <?php
	    
	    return ob_get_clean();
	}
}