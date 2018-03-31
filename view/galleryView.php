<?php $title = 'Générateur de Canvas - Galerie'; ?>

<?php ob_start(); ?>
    <h2>Galerie</h2>
    <?php foreach ($fichiersDessin as $key => $value)
    {
    	echo "<p>".$dessinsInfo[$key][0]."</p>";
    	echo "<p>".$dessinsInfo[$key][1]."</p>";
    	echo "<p>".$dessinsInfo[$key][2]."</p>";
    	$contenu = './assets/gallery/'.$value.'.png';
    	echo '<img src="'.$contenu.'" style="border: 1px solid black">';

    	$contenu = file_get_contents('./assets/gallery/'.$value.'.canvas');
		$contenu = htmlspecialchars($contenu);
		$contenu = str_replace("\n",'<br>', $contenu);
		echo $contenu;
    }
$content = ob_get_clean();
require('./view/template.php');
?>

<?php
/*
	$file = './assets/gallery/'.$value;
	$contenu = file_get_contents($file);
	$contenu = htmlspecialchars($contenu);
	$contenu = str_replace("\n",'<br>', $contenu);
	//virer le premier retour à la ligne qui ne sert à rien.
	$contenu = preg_replace('/<br>/', '', $contenu, 1);
	echo $contenu;
*/
?>