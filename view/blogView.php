<?php $title = "Blog" ?>

<?php ob_start() ?>
<h3>Yo</h3>
<p>List de posts</p>
<?php $content = ob_get_clean() ?>

<?php require "./view/template.php" ?>
