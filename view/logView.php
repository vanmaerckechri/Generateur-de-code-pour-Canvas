<?php
$title = 'Générateur de Code pour le Canvas - ';
if ($_GET['log'] === "reg")
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
	  		<input class="submit" type="submit" value="valider">
		</form>
	</div>
	<?php 
	$content = ob_get_clean();
}
else if (($_GET['log'] === "in"))
{
	ob_start();
	?>
	<div id="main">		
		<h2>Login</h2>
		<form action="index.php" method="post">
	  		<label for="login">Login</label>
	        <input type="text" name="login" id="login" autofocus required>
	  		<label for="pwd">password</label>
	        <input type="password" name="pwd" id="pwd" required>
	        <input class="submit" type="submit" value="valider">
		</form>
	</div>
	<?php 
	$content = ob_get_clean();
}
else if (($_GET['log'] === "out"))
{
	ob_start();
	?>
	<div id="main">		
		<h2>Déconnection</h2>
		<p>Vous avez été déconnecté</p>
	</div>
	<?php 
	$content = ob_get_clean();
}

require('./view/template.php'); ?>