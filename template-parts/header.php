<?php ob_start(); ?>
<?php session_start(); ?>
<?php
if(file_exists('./template-parts/db.php')) {
	require_once('./template-parts/db.php');
} else {
	header("Location: ./template-parts/install.php");
}
?>
<?php require_once(dirname(dirname(__FILE__)) . '/functions.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Register System</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
<?php require_once("template-parts/data_modal.php"); ?>
	<header class="header">
		<nav class="navbar navbar-default">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="./index.php">Galibweb</a>
				</div>
				<ul class="nav navbar-nav">
					<li><a href="./index.php">Home</a></li>
					<?php if(!is_user_logged_in()) { ?>
					<li><a href="./login.php">Login</a></li>
					<li><a href="./register.php">Sign Up</a></li>
					<?php } else { ?>
					<li><a href="./admin/">Admin</a></li>
					<li><a href="./logout.php">Logout</a></li>
					<?php } ?>
				</ul>
			</div>
		</nav>
	</header>
	<div class="container main-body">