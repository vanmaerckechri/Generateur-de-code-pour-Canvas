<?php $title = 'Générateur de Code pour le Canvas - Gallery'; ?>

<?php ob_start(); ?>
<div>
    <p>PAGE DE TEST</p>
</div>
<script src="assets/js/init.js"></script>
<?php $content = ob_get_clean(); ?>
<?php require('./view/template.php'); ?>