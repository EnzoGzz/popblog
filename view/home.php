<?php $title = "test"; ?>

<?php ob_start(); ?>
<h3>Yo</h3>
<p>Home</p>
<?php $content = ob_get_clean(); ?>

<?php require "./view/template.php"; ?>
