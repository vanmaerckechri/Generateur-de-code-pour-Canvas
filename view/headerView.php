<?php ob_start(); ?>
<header>
    <h1>Générateur de Code pour le Canvas</h1>
    <?php 
    	if ($GLOBALS['sessionAuthOk'] === TRUE)
    	{
    ?>
    		<div class="connect"></div>
    <?php
		}
    ?>
</header>
<?php $header = ob_get_clean(); ?>