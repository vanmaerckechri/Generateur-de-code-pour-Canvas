<?php $title = 'Générateur de Canvas - Enregistrement dans la Gallerie'; ?>

<?php ob_start(); ?>
<div id="main" class="formulaire">		
    <h2>Options d'enregistrement</h2>
	<form action="index.php?action=galrecord" id="galRecordForm" method="post" style="width: auto;">
	  		<label for="newTitreDessin" style="width: 250px;">Titre:</label>
			<input type="text" name="newTitreDessin" id="newTitreDessin" style="width: 250px;">
			<?=$_SESSION['smsAuth']?>
			<input type="hidden" name="record_code" id="record_code" value='<?=$code?>'>
	        <input type="hidden" name="record_png" id="record_png" value='<?=$png?>'>
	  		<input class="submitAuth" type="submit" id="recordSubmit" value="valider">
	</form>
	<div>
	</div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('./view/template.php'); ?>