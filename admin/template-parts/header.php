<?php ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php session_start(); ?>
<?php require_once(dirname(dirname(dirname(__FILE__))) . "/template-parts/db.php"); ?>
<?php require_once("functions.php"); ?>
<?php 
	if(!is_user_logged_in()) {
		header("Location: ../login.php");
		exit;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Business Directory | APBD Devs</title>
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/css/styles.css">

</head>
<body class="home">
    <div class="container-fluid display-table">
        <div class="row display-table-row">
        	<?php require_once("navigation.php"); ?>
        	    <div class="user-dashboard">