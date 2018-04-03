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
			       		<option value="date"<?=$GLOBALS['trierParSelect'][0]?>>date</option>
			           	<option value="auteur"<?=$GLOBALS['trierParSelect'][1]?>>auteur</option>
			           	<option value="titre"<?=$GLOBALS['trierParSelect'][2]?>>titre</option>
						<?php
			           	if ($GLOBALS['sessionAuthOk'] === TRUE)
			           	{
			           	?>
			           		<option value="mesDessins"<?=$GLOBALS['trierParSelect'][3]?>>mes dessins</option>
			           	<?php
 						}
			           	?>
			       	</select>
			   	</p>
			</form>
		</div>
		<div class="pagination">
			<form method="post" id="paginLeft" action="index.php?action=gallery">
				<input type="submit" name="paginLeft" id="paginLeft" value="<">
			</form>
			<?php
				for($i = 0; $i < $_SESSION['pagesLength']; $i++) 
				{
					$page = $i + 1;
					$class = 'paginationChiffre';
					$class = $page == $_SESSION['pageActu'] ? 'paginationChiffreActu' : $class;
					?>
					<a href="index.php?action=gallery&page=<?=$page?>" class="<?=$class?>"><?=$page?></a>
					<?php
				}
			?>
			<form method="post" id="paginRight" action="index.php?action=gallery">
				<input type="submit" name="paginRight" id="paginRight" value=">">
			</form>

		</div>
		<div class="dessins">
		    <?php
				for ($i = $_SESSION['premierDessinPage']; $i < $_SESSION['dernierDessinPage']; $i++)
				{
		    ?>
			<div class="dessin">
			    <?php
				$contenu = $fichiersDessin[$i][0].'.png';
			    echo '<img class="miniature" src="'.$contenu.'">';
				?>
				<div class="dessinInfo">
			    	<p class="dessinTitre"><?=$fichiersDessin[$i][2]?>
			    		<?php
			    			if ($GLOBALS['sessionAuthOk'] === TRUE && $_SESSION['login'] === $fichiersDessin[$i][1])
			    			{
			    		?>		
			    				<img src="assets/img/trash.png" class="deleteDessin">
			    		<?php
			    			}
			    		?>
			    	</p>
			    	<p class="dessinAuteur"><?=$fichiersDessin[$i][1]?></p>
			    	<p class="dessinDate"><?=$fichiersDessin[$i][3]?></p>
			    </div>
			</div>
				<?php
			    }
		    ?>
			<div id="dessinDetail" class="dessinDetailMin">
				<div id="modalContainer">
					<div class="arrowLeft"></div>
					<div id="imgActu"></div>
					<div class="arrowRight"></div>
					<button id="toggleDisplay">Code</button>
				</div>
			</div>
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