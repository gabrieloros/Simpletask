<!DOCTYPE  PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Password generator</title>
	<style type="text/css">
		* {
			font-family: Verdana;
			font-size: 11px;	
		}
		
		.formContainer{
			margin: 200px auto; 
			width: 300px;
			height: 120px;
			border: 2px solid #447799;
			padding: 10px;	
		}
		
		.formTitle{
			font-size: 12px;
			font-weight: bold;
			text-align: center;	
		}
	</style>
</head>
<body>
	<?php
	$password = "";
	
	if(isset($_POST['password']) && $_POST['password'] != null){
		$password = trim($_POST['password']); 
	}
	?>
	<div class="formContainer">
		<div class="formTitle">
			Password Generator
		</div>
		<br />
		<form name="cryptForm" method="post" action="">
			Text to crypt: <input type="text" name="password" id="password" maxlength="20" value="<?=$password?>" />
			<br /><br />
			<input type="button" value="Crypt!" onclick="sendForm();" />
			<input type="button" value="Clear" onclick="resetForm();" />
		</form>
		<script type="text/javascript">
			function sendForm(){
		
				valueToSend = document.getElementById('password').value;
		
				if(typeof(valueToSend) == 'undefined' || valueToSend == ''){
					alert('Type a value!');
					return;
				}
				else{
					document.forms[0].submit();
				}
				
			}

			function resetForm(){

				document.getElementById('password').value = "";
				
			}
		</script>
		<?php
			if(isset($password) && $password != null){
				echo 'Generated password: <br />' . crypt($password);
			} 
		?>
	</div>
</body>
</html>