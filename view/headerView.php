<?php ob_start(); ?>
    <h1>Générateur de Canvas</h1>
    <div class="connect">
    	<a href="index.php?action=home" class="submit">home</a>
    	<a href="index.php?action=gallery" class="submit">gallery</a>
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