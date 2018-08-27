<?php
/**
 * Login class
 *
 * @author Gabriel Guzman
 *  @version 1.0
 *  DATE OF CREATION: 16/03/2012
 *  UPDATE LIST
 *  * UPDATE:
 *  CALLED BY:
 */
class Login  extends Render{

	static public function render ($showerror=false, $currentUrl='', $returnUrl='', $returnAction='', $errormsg=null) {

		ob_start();
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>

			<title><?=$_SESSION['s_parameters']['site_title']?> Login</title>

			<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />

			<link rel="stylesheet" type="text/css" href="/core/css/login.css" />

			<link  type="image/x-icon" rel="shortcut icon" href="/core/img/favicon.ico"/>
			<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
			<style type="text/css">
				@import url(https://fonts.googleapis.com/css?family=Roboto:300);

				.login-page {
					width: 360px;
					padding: 8% 0 0;
					margin: auto;
				}
				.form {
					position: relative;
					z-index: 1;
					background: #263ed4;
					max-width: 360px;
					margin: 30px auto 100px;
					padding: 20px;
					text-align: center;
					box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
				}
				.form input {
					font-family: "Roboto", sans-serif;
					outline: 0;
					background: #010cd4;
					width: 100%;
					border: 0;
					margin: 0 0 15px;
					padding: 22px;
					box-sizing: border-box;
					font-size: 26px;
					color: #FFFFFF;

				}
				.form button {
					font-family: "Roboto", sans-serif;
					/**text-transform: uppercase;**/
					outline: 0;
					background: #0b72ee;
					width: 100%;
					border: 0;
					padding: 4px;
					color: #FFFFFF;
					font-size: 28px;
					-webkit-transition: all 0.3 ease;
					transition: all 0.3 ease;
					cursor: pointer;
				}

				.form button:hover,.form button:active,.form button:focus {
					background: #2644ee;
				}
				.form .message {
					margin: 15px 0 0;
					color: #b3b3b3;
					font-size: 12px;
				}
				.form .message a {
					color: #0b72ee;
					text-decoration: none;
				}
				.form .register-form {
					display: none;
				}
				.container {
					position: relative;
					z-index: 1;
					max-width: 300px;
					margin: 0 auto;
				}
				.container:before, .container:after {
					content: "";
					display: block;
					clear: both;
				}
				.container .info {
					margin: 50px auto;
					text-align: center;
				}
				.container .info h1 {
					margin: 0 0 15px;
					padding: 0;
					font-size: 36px;
					font-weight: 300;
					color: #1a1a1a;
				}
				.container .info span {
					color: #4d4d4d;
					font-size: 12px;
				}
				.container .info span a {
					color: #000000;
					text-decoration: none;
				}
				.container .info span .fa {
					color: #EF3B3A;
				}
				body {
					background: #263ed4; /* fallback for old browsers */
					background: -webkit-linear-gradient(right, #010cd4, #263ed4);
					background: -moz-linear-gradient(right, #010cd4, #263ed4);
					background: -o-linear-gradient(right, #010cd4, #263ed4);
					background: linear-gradient(to left, #010cd4, #263ed4);
					font-family: "Roboto", sans-serif;
					-webkit-font-smoothing: antialiased;
					-moz-osx-font-smoothing: grayscale;
				}

				h1 {
					color: white;
					font-family: "Roboto", sans-serif;
					outline: 0;

					width: 100%;
					border: 0;
					margin: 0 0 15px;
					padding: 30px;
					box-sizing: border-box;
					font-size: 42px;
				}
/** css para mostrar web en celular /**
			/**	#aviso-movil-horizontal { display: none; }
				@media only screen and (orientation:portrait) {
					#wrapper { display:none; }
					#aviso-movil-horizontal { display:block; }
				}
				@media only screen and (orientation:landscape) {
					#aviso-movil-horizontal { display:none; }
				}

				.messageMovil{
					font-size: 48px;
					margin-top: 150px;

				}**/
				::-webkit-input-placeholder {color: #FFFFFF;},
				:-ms-input-placeholder {color: #FFFFFF;},
				:-moz-placeholder{color: #FFFFFF;}
			</style>
		</head>
		<body>

		<div id="aviso-movil-horizontal">
		<!--	<div style="align-content: center" class="messageMovil">Por favor, coloca tu móvil en horizontal.</div> -->
		</div>


		<div id="wrapper" class="login-page">
			<div class="form">

				<form action="/<?=$_SESSION['s_languageIsoUrl']?>/login" name="loginForm" method="post">

					<div class="login_form">

						<input type="hidden" id="action" name="action" value="login" />
						<input type="hidden" id="returnUrl" name="returnUrl" value="<?php echo $returnUrl;?>" />
						<input type="hidden" id="returnAction" name="returnAction" value="<?php echo $returnAction;?>" />

						<table align="center">
							<tr><h1 >SimpleTask</h1></tr><br>
							<tr>

								<td>
									<input type="text" value="" id="login_user" name="login_user" placeholder="Usuario" title="<?php echo self::renderContent(Util::getLiteral('user'));?>" alt="<?php echo self::renderContent(Util::getLiteral('login'));?>" />
								</td>
							</tr>
							<tr>

								<td>
									<input type="password" value="" id="login_password" placeholder="Contraseña" name="login_password" title="<?php echo self::renderContent(Util::getLiteral('password'));?>" alt="<?php echo self::renderContent(Util::getLiteral('password'));?>" />
								</td>
							</tr>
							<tr>
								<td colspan="2" align="right"> <button type="submit" value="<?php echo self::renderContent(Util::getLiteral('login'));?>" alt="<?php echo self::renderContent(Util::getLiteral('login'));?>"/><?php echo self::renderContent(Util::getLiteral('login'));?></button></td>
							</tr>

						</table>

						<?php
						if($showerror){?>
							<div id='invalidLogin' class="invalidLogin">
								<div class='centered-container'>
									<div class='centered-content'>
										<?
										$errormsg = isset($errormsg) && $errormsg!='' ? $errormsg : Util::getLiteral('loginerror');
										echo self::renderContent($errormsg);//show the login error message
										?>
									</div>
								</div>
							</div>
							<div style="clear: both;"></div>
							<br/>
						<?php }
						?>

					</div>

					<script type="text/javascript">
						document.forms[0].login_user.focus();
					</script>

				</form>
			</div>
		</div>




		</body>
		</html>
		<?
		return ob_get_clean();
	}
}