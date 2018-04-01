<?php $title = 'Générateur de Canvas - Galerie'; ?>

<?php ob_start(); ?>
    <div id="main">
    	<h2>Galerie</h2>
	    <div class="filtres">
	    	<form method="post" id="formFilter" action="index.php?action=gallery">
			   	<p>
			       	<label for="parPage">Nombre de dessins par page:</label>
			       	<select name="parPage" id="parPage">
			           	<option value="10"<?=$GLOBALS['parPageSelected'][0]?>>10</option>
			           	<option value="20"<?=$GLOBALS['parPageSelected'][1]?>>20</option>
			           	<option value="30"<?=$GLOBALS['parPageSelected'][2]?>>30</option>
			           	<option value="40"<?=$GLOBALS['parPageSelected'][3]?>>40</option>
			           	<option value="50"<?=$GLOBALS['parPageSelected'][4]?>>50</option>
			       	</select>
			       	<label for="trierPar">Trier par:</label>
			       	<select name="trierPar" id="trierPar">
			       		<option value="date">date</option>
			           	<option value="auteur">auteur</option>
			           	<option value="nom">nom</option>
			       	</select>
			   	</p>
			</form>
		</div>
		<div class="dessins">
		    <?php foreach ($fichiersDessin as $key => $value)
		    {
		    ?>
			<div class="dessin">
			    <?php
			    	$contenu = './assets/gallery/'.$value.'.png';
			    	echo '<img src="'.$contenu.'">';
			    	/*
			    	$contenu = file_get_contents('./assets/gallery/'.$value.'.canvas');
					$contenu = htmlspecialchars($contenu);
					$contenu = str_replace("\n",'<br>', $contenu);
					echo $contenu;*/
				?>
				<div class="dessinInfo">
			    	<p class="dessinTitre"><?=$dessinsInfo[$key][1]?></p>
			    	<p class="dessinAuteur"><?=$dessinsInfo[$key][0]?></p>
			    	<p class="dessinDate"><?=$dessinsInfo[$key][2]?></p>
			    </div>
				</div>
				<?php
			    }
		    ?>
		</div>
	</div>
	<script src="assets/js/gallery.js"></script>
	<?php
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