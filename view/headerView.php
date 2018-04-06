<?php ob_start(); ?>
	<div class="social">
		<a href="https://www.becode.org/" target="_blank" rel="noopener" title="becode">Becode³ | Swartz</a>

		<a href="https://github.com/vanmaerckechri/Generateur-de-code-pour-Canvas/" target="_blank" rel="noopener" title="github"><img src="assets/img/github.png" alt="logo github, silhouette de chat dans un cercle"></a>

		<a href="https://www.linkedin.com/in/christophe-van-maercke-01b609152/" target="_blank" rel="noopener" title="linkedin"><img src="assets/img/linkedin.png" alt="logo linkedin, les lettres 'i' et 'n' dans un cercle"></a>
	</div>
    <h1>Canvas UI</h1>
    <div class="connect">
    	<a href="index.php?action=home" class="submit">Home</a>
    	<a href="index.php?action=gallery" class="submit">Gallery</a>
	    <?php 
	    	if ($GLOBALS['sessionAuthOk'] === TRUE)
	    	{
	    ?>
	    	    <!--<a href="index.php?action=profil" class="submit">Profil</a>-->
	    		<a href="index.php?action=log&log=out" class="submit">Logout</a>
	    <?php
			}
			else
			{
		?>
				<a href="index.php?action=log&log=in" class="submit">Login</a>
				<a href="index.php?action=log&log=reg" class="submit">Register</a>
		<?php
			}
	    ?>
	</div>
<?php $header = ob_get_clean(); ?>