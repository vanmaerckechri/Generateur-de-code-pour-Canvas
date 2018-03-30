<?php $title = 'Générateur de Code pour le Canvas - Gallery'; ?>

<?php ob_start(); ?>
<div>
    <p>PAGE DE TEST</p>
	<?=require('./assets/gallery/262/1.canvas');?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('./view/template.php'); ?>