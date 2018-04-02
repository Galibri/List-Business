<?php
ob_start();
session_start();

$_SESSION['user_role'] = NULL;
$_SESSION['username'] = NULL;
$_SESSION['user_email'] = NULL;

header("Location: ./login.php");

exit;