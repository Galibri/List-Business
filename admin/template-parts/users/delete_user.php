<?php 
    if(!is_admin()) {
        header("Location: ./index.php");
        exit;
    }
?>
<?php require_once("template-parts/header.php"); ?>
<?php deleteUserById(); ?>
<?php require_once("template-parts/footer.php"); ?>