<?php
$title = 'Générateur de Code pour le Canvas - ';
if (isset($_GET['log']) && $_GET['log'] === "reg")
{
	ob_start();
	?>
	<div id="main">		
		<h2>Register</h2>
		<form action="index.php" method="post">
	  		<label for="login">Login</label>
	        <input type="text" name="login" id="login" autofocus required>
	  		<label for="pwd">password</label>
	        <input type="password" name="pwd" id="pwd" required>
	        <label for="email">email</label>
	        <input type="email" name="mail" id="mail" required>
	        <input type="hidden" name="register" id="register" value="1">
	  		<input class="submit" type="submit" value="valider">
		</form>
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
		<form action="index.php" method="post">
	  		<label for="login">Login</label>
	        <input type="text" name="login" id="login" autofocus required>
	  		<label for="pwd">password</label>
	        <input type="password" name="pwd" id="pwd" required>
	       	<input type="hidden" name="auth" id="auth" value="1">
	        <input class="submit" type="submit" value="valider">
		</form>
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