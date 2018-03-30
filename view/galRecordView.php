<?php $title = 'Générateur de Canvas - Enregistrement dans la Gallerie'; ?>

<?php ob_start(); ?>
<div>
    <h2>Options d'enregistrement</h2>
	<form action="index.php?action=galrecord" id="galRecordForm" method="post">
	  		<label for="newTitreDessin">Titre:</label>
			<input type="text" name="newTitreDessin" id="newTitreDessin">
			<?=$_SESSION['smsAuth']?>
	        <input type="hidden" name="record_code" id="record_code" value='<?=$code?>'>
	  		<input class="button_unselect" type="submit" id="recordSubmit" value="valider">
	</form>
	<div>
		<?=$code?>
	</div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('./view/template.php'); ?>