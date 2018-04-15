<?php
$title = '';
if (isset($_GET['log']) && $_GET['log'] === "reg")
{
	$title = 'Canvas UI - Register';
	ob_start();
	?>
	<div id="main" class="formulaire">		
		<h2>Register</h2>
		<form action="index.php?action=log&log=reg" method="post">
	  		<label for="login">Login</label>
	        <input type="text" name="login" id="login" value="<?php if (isset($_POST['login'])) {echo $_POST['login'];} ?>" autofocus required>
	       	<?=$_SESSION['smsLogin']?>
	  		<label for="pwd">Password</label>
	        <input type="password" name="pwd" id="pwd" required>
	       	<?=$_SESSION['smsPwd']?>
	       	<label for="pwd2">Vérifier le password</label>
	       	<input type="password" name="pwd2" id="pwd2" required>
	       	<?=$_SESSION['smsPwd2']?>
	        <label for="mail">Email</label>
	        <input type="email" name="mail" id="mail" value="<?php if (isset($_POST['mail'])) {echo $_POST['mail'];} ?>" required>
	        <?=$_SESSION['smsMail']?>
	        <input type="hidden" name="register" id="register" value="1">
	  		<input class="submitAuth" type="submit" value="valider">
		</form>
		<?=$_SESSION['smsAuth']?>
	</div>
	<?php 
	$content = ob_get_clean();
}
else if (isset($_GET['log']) && $_GET['log'] === "in")
{
	$title = 'Canvas UI - Authentification';
	ob_start();
	?>
	<div id="main" class="formulaire">		
		<h2>Authentification</h2>
		<form action="index.php?action=log&log=in" method="post">
	  		<label for="login">Login</label>
	        <input type="text" name="login" id="login" autofocus required>
	  		<label for="pwd">Password</label>
	        <input type="password" name="pwd" id="pwd" required>
	       	<input type="hidden" name="auth" id="auth" value="1">
	        <input class="submitAuth" type="submit" value="valider">
		</form>
		<form action="index.php?action=log&log=lost" method="post">
	       	<input type="hidden" name="pwdLost" id="pwdLost" value="1">
	        <input class="submitHref" type="submit" value="Password oublié">
		</form>
		<?=$_SESSION['smsAuth']?>
	</div>
	<?php 
	$content = ob_get_clean();
}
else if (isset($_GET['log']) && $_GET['log'] === "lost")
{
	$title = 'Canvas UI - Password Oublié';
	ob_start();
	?>
	<div id="main" class="formulaire">		
		<h2>Password Oublié</h2>
		<form action="index.php?action=log&log=lost" method="post">
 			<label for="mail">
 				Veuillez entrer votre adresse email.
 			</label>
	        <input type="email" name="mail" id="mail" value="" required>
	       	<input type="hidden" name="lost" id="lost" value="1">
	        <input class="submitAuth" type="submit" value="valider">
		</form>
		<?=$_SESSION['smsAuth']?>
	</div>
	<?php 
	$content = ob_get_clean();
}
else if (isset($GLOBALS['resetPwd']) && $GLOBALS['resetPwd'] === TRUE)
{
	$title = 'Canvas UI - Password Oublié';
	ob_start();
	?>
	<div id="main" class="formulaire">		
		<h2>Password Oublié</h2>
		<form action="index.php?action=log&log=newpwd" method="post">
	  		<label for="pwd">password</label>
	        <input type="password" name="pwd" id="pwd" required>
	       	<?=$_SESSION['smsPwd']?>
	       	<label for="pwd2">répéter le password</label>
	       	<input type="password" name="pwd2" id="pwd2" required>
	       	<?=$_SESSION['smsPwd2']?>
	       	<input type="hidden" name="newpwd" id="newpwd" value="<?=$GLOBALS['id']?>">
	        <input class="submitAuth" type="submit" value="valider">
		</form>
		<?=$_SESSION['smsAuth']?>
	</div>
	<?php 
	$content = ob_get_clean();
}
else if (isset($_GET['log']) && $_GET['log'] === "out")
{
	ob_start();
	?>
	<div id="main">		
		<h2 class="sms">Vous avez été déconnecté</h2>
	</div>
	<div></div>
	<?php 
	$content = ob_get_clean();
}
else
{
	$content = "";
}
require('./view/template.php'); ?>
