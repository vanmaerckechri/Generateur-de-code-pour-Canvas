<?php $title = 'Générateur de Canvas - Galerie'; ?>

<?php ob_start(); ?>
<div>
    <h2>Galerie</h2>
    <?php foreach ($fichiersDessin as $key => $value)
    {
    	echo "<p>".$dessinsInfo[$key][0]."</p>";
    	echo "<p>".$dessinsInfo[$key][1]."</p>";
    	echo "<p>".$dessinsInfo[$key][2]."</p>";
    	require('./assets/gallery/'.$value);
    }
    ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('./view/template.php'); ?>