<?php
require_once('template-parts/db.php');

function is_user_logged_in() {
	if(isset($_SESSION['user_role'])) {
		return true;
	}
}

function is_admin() {
	if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'administrator') {
		return true;
	}
}
function is_subscriber() {
	if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'subscriber') {
		return true;
	}
}

function is_author() {
	if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'author') {
		return true;
	}
}

function registerUser() {
	global $connection;
	$error = [];
	if(isset($_POST['registration_submit'])) {
		$username 		= cleanData($_POST['username']);
		$user_firstname = cleanData($_POST['user_firstname']);
		$user_lastname 	= cleanData($_POST['user_lastname']);
		$user_email 	= cleanData($_POST['user_email']);
		$user_password 	= cleanData($_POST['user_password']);
		$user_role 		= cleanData($_POST['user_role']);

		if(empty($username) || $username == '') {
			$error['username'] = "Username can't be empty";
		} elseif(username_exists($username)) {
			$error['username'] = "Username already exists. Try different one.";
		}
		if(empty($user_firstname) || $user_firstname == '') {
			$error['user_firstname'] = "First Name can't be empty";
		}
		if(empty($user_lastname) || $user_lastname == '') {
			$error['user_lastname'] = "Last Name can't be empty";
		}
		if(empty($user_email) || $user_email == '') {
			$error['user_email'] = "Email can't be empty";
		} elseif (email_exists($user_email)) {
			$error['user_email'] = "This email already signed up. Try another one.";
		}
		if(empty($user_password) || $user_password == '') {
			$error['user_password'] = "Password can't be empty";
		}
		if(empty($error)) {
			$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12) );
			$query  = "INSERT INTO users (username, user_firstname, user_lastname, user_email, user_role, user_password, registered_date) VALUES ('$username', '$user_firstname', '$user_lastname', '$user_email', '$user_role', '$user_password', now() )";
			$result = mysqli_query($connection, $query);
			confirmQuery($result, "<h3 class='text-success'>Registration Successful</h3>");
			header("Location: login.php?message=success");
		} else {
			return $error;
		}
	}
}

function registerAdmin() {
	global $connection;
	$error = [];
	if(isset($_POST['admin_register_submit'])) {
		$username 		= cleanData($_POST['username']);
		$user_firstname = cleanData($_POST['user_firstname']);
		$user_lastname 	= cleanData($_POST['user_lastname']);
		$user_email 	= cleanData($_POST['user_email']);
		$user_password 	= cleanData($_POST['user_password']);

		if(empty($username) || $username == '') {
			$error['username'] = "Username can't be empty";
		} elseif(username_exists($username)) {
			$error['username'] = "Username already exists. Try different one.";
		}
		if(empty($user_firstname) || $user_firstname == '') {
			$error['user_firstname'] = "First Name can't be empty";
		}
		if(empty($user_lastname) || $user_lastname == '') {
			$error['user_lastname'] = "Last Name can't be empty";
		}
		if(empty($user_email) || $user_email == '') {
			$error['user_email'] = "Email can't be empty";
		} elseif (email_exists($user_email)) {
			$error['user_email'] = "This email already signed up. Try another one.";
		}
		if(empty($user_password) || $user_password == '') {
			$error['user_password'] = "Password can't be empty";
		}
		if(empty($error)) {
			$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12) );
			$query  = "INSERT INTO users (username, user_firstname, user_lastname, user_email, user_role, user_password, registered_date) VALUES ('$username', '$user_firstname', '$user_lastname', '$user_email', 'administrator', '$user_password', now() )";
			$result = mysqli_query($connection, $query);
			confirmQuery($result, "<h3 class='text-success'>Registration Successful</h3>");
			header("Location: ../login.php?registration=success");
		} else {
			return $error;
		}
	}
}


function loginUser(){
	global $connection;
	if(isset($_SESSION['user_role'])) {
		header("Location: admin");
	}
	$error = [];
	if(isset($_POST['login_submit'])) {
		$username_email = cleanData($_POST['username_email']);
		$user_password 	= cleanData($_POST['user_password']);
		if(empty($username_email) || $username_email == '') {
			$error['username_email'] = "Please enter your username or email";
		}
		if(empty($user_password) || $user_password == '') {
			$error['user_password'] = "Please enter your password";
		}
		if(empty($error)) {
			$query = "SELECT username, user_password, user_email, user_role FROM users WHERE username = '$username_email' OR user_email = '$username_email'";
			$result = mysqli_query($connection, $query);
			$user_exists = mysqli_num_rows($result);
			if($user_exists > 0) {

				$row = mysqli_fetch_assoc($result);
				$db_username = $row['username'];
				$db_password = $row['user_password'];
				$user_email  = $row['user_email'];
				$user_role   = $row['user_role'];

				$password_matched = password_verify($user_password, $db_password);

				if(($username_email === $db_username || $username_email === $user_email) && $password_matched) {
					$_SESSION['user_role'] = $user_role;
					$_SESSION['username'] = $db_username;
					$_SESSION['user_email'] = $user_email;
					header("Location: admin/index.php");
				} else {
					$error['user_password'] = "Incorrect Password";
				}
			} else {
				$error['username_email'] = "Please enter your correct username or email.";
			}
		}
	}
	return $error;
}

function cleanData($data){
	global $connection;
	$data = mysqli_real_escape_string($connection, trim($data));

	return $data;
}

function confirmQuery($result, $info = "") {
	global $connection;
	if(!$result) {
		die("Failed." . mysqli_error($connection));
	} else {
		echo $info;
	}
}

function username_exists($username) {
	global $connection;
	$query = "SELECT username FROM users WHERE username = '$username'";
	$result = mysqli_query($connection, $query);
	$exist_username = mysqli_num_rows($result);
	if($exist_username > 0) {
		return true;
	}
}

function email_exists($user_email) {
	global $connection;
	$query = "SELECT user_email FROM users WHERE user_email = '$user_email'";
	$result = mysqli_query($connection, $query);
	$exist_email = mysqli_num_rows($result);
	if($exist_email > 0) {
		return true;
	}
}

function listingBusiness() {
	global $connection;
	$user = [];

	$query = "SELECT * FROM listing";
	$result = mysqli_query($connection, $query);

	while($row = mysqli_fetch_assoc($result)){

		$listing_id				= $row['id'];
		$business_owner			= $row['business_owner'];
		$business_name			= $row['business_name'];
		$business_email 		= $row['business_email'];
		$business_phone			= $row['business_phone'];
		$business_f_year 		= $row['business_f_year'];
		$business_type 			= $row['business_type'];
		$business_motto 		= $row['business_motto'];
		$business_description 	= $row['business_description'];

		echo "<tr>";
		echo "<td>$business_name</td>";
		echo "<td>$business_email</td>";
		echo "<td><a business_owner='{$business_owner}' business_name='{$business_name}' business_email='{$business_email}' business_phone='{$business_phone}' business_f_year='{$business_f_year}' business_type='{$business_type}' business_motto='{$business_motto}' business_description='{$business_description}' href='#' class='btn btn-info modalListingList' data-toggle='modal' data-target='#listingModal'>View Details</a></td>";
		echo "</tr>";
	}
}

function firstAdmin() {
	global $connection;
	$query = "SELECT id FROM users WHERE user_role = 'administrator' ORDER BY id ASC LIMIT 1";
	$result = mysqli_query($connection, $query);
	$total_admin_one = mysqli_num_rows($result);
	while($row = mysqli_fetch_assoc($result)) {
		echo $row['id'] . "<br />";
	}

	// if($total_admin_one == 1) {
	// 	return true;
	// } else {
	// 	return false;
	// }
}

function listingBusinessById() {
	global $connection;
	$user = [];
	//need to get the id from $_GET global varibale to use this function
	$query = "SELECT * FROM listing";
	$result = mysqli_query($connection, $query);

	while($row = mysqli_fetch_assoc($result)){

		$listing_id				= $row['id'];
		$business_owner			= $row['business_owner'];
		$business_name			= $row['business_name'];
		$business_email 		= $row['business_email'];
		$business_phone			= $row['business_phone'];
		$business_f_year 		= $row['business_f_year'];
		$business_type 			= $row['business_type'];
		$business_motto 		= $row['business_motto'];
		$business_description 	= $row['business_description'];

		echo "<tr>";
		echo "<td>$business_name</td>";
		echo "<td>$business_email</td>";
		echo "<td>$business_phone</td>";
		echo "</tr>";
	}
}

function thereIsUser() {
	global $connection;
	$query = "SELECT username FROM users";
	$result = mysqli_query($connection, $query);
	if(mysqli_num_rows($result) > 0) {
		return true;
	} else {
		return false;
	}
}

function createTablesInDatabase() {
	global $connection;

	/***********************
	@ Create Users Table
	************************/
	$query = "CREATE TABLE IF NOT EXISTS users (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) NULL,
	user_firstname VARCHAR(255) NULL,
	user_lastname VARCHAR(255) NULL,
	user_email VARCHAR(255) NULL,
	user_password VARCHAR(255) NULL,
	user_role VARCHAR(255) NULL,
	registered_date DATE NULL 
	)";
	$result = mysqli_query($connection, $query);
	if(!$result) {
		die("Can't create table users." . mysqli_error($connection));
	}

	/***********************
	@ Create business Table
	************************/
	$query = "CREATE TABLE IF NOT EXISTS listing (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	business_owner VARCHAR(255) NULL,
	listing_user VARCHAR(255) NULL,
	business_name VARCHAR(255) NULL,
	business_email VARCHAR(255) NULL,
	business_phone VARCHAR(255) NULL,
	business_f_year INT(11) NULL,
	business_type VARCHAR(255) NULL,
	business_motto VARCHAR(255) NULL,
	business_description TEXT NULL
	)";
	$result = mysqli_query($connection, $query);
	if(!$result) {
		die("Can't create table business." . mysqli_error($connection));
	}
}