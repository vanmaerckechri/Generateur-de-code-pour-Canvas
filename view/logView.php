<?php
$title = 'Générateur de Code pour le Canvas - ';
if (isset($_GET['log']) && $_GET['log'] === "reg")
{
	ob_start();
	?>
	<div id="main">		
		<h2>Register</h2>
		<form action="index.php?action=log&log=reg" method="post">
	  		<label for="login">Login</label>
	        <input type="text" name="login" id="login" autofocus required>
	       	<?=$_SESSION['smsLogin']?>
	  		<label for="pwd">password</label>
	        <input type="password" name="pwd" id="pwd" required>
	       	<?=$_SESSION['smsPwd']?>
	       	<label for="pwd2">répéter le password</label>
	       	<input type="password" name="pwd2" id="pwd2" required>
	       	<?=$_SESSION['smsPwd2']?>
	        <label for="mail">email</label>
	        <input type="email" name="mail" id="mail" required>
	        <?=$_SESSION['smsMail']?>
	        <input type="hidden" name="register" id="register" value="1">
	  		<input class="submit" type="submit" value="valider">
		</form>
		<?=$_SESSION['smsAuth']?>
	</div>
	<?php 
	$content = ob_get_clean();
}
else if (isset($_GET['log']) && $_GET['log'] === "in")
{
	ob_start();
	?>
	<div id="main">		
		<h2>Authentification</h2>
		<form action="index.php?action=log&log=in" method="post">
	  		<label for="login">Login</label>
	        <input type="text" name="login" id="login" autofocus required>
	  		<label for="pwd">password</label>
	        <input type="password" name="pwd" id="pwd" required>
	       	<input type="hidden" name="auth" id="auth" value="1">
	        <input class="submit" type="submit" value="valider">
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
		<h2>Vous avez été déconnecté</h2>
	</div>
	<?php 
	$content = ob_get_clean();
}
else
{
	$content = "";
}
require('./view/template.php'); ?>
