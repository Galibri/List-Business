<?php require_once(dirname(dirname(__FILE__)) . "/template-parts/db.php"); ?>
<?php

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

function showUserData() {
	global $connection;
	$user = [];
	if(isset($_SESSION['username'])) {
		$username = $_SESSION['username'];

		$query = "SELECT * FROM users WHERE username = '$username'";
		$result = mysqli_query($connection, $query);

		$row = mysqli_fetch_assoc($result);

		$user['username'] 			= $row['username'];
		$user['user_firstname'] 	= $row['user_firstname'];
		$user['user_lastname'] 		= $row['user_lastname'];
		$user['user_email'] 		= $row['user_email'];
		$user['registered_date'] 	= $row['registered_date'];
		$user['user_role'] 			= $row['user_role'];
	}
	return $user;
}

function showUsers() {
	global $connection;
	$user = [];

	$query = "SELECT * FROM users";
	$result = mysqli_query($connection, $query);

	while($row = mysqli_fetch_assoc($result)){

		$user_id			= $row['id'];
		$username			= $row['username'];
		$user_firstname 	= $row['user_firstname'];
		$user_lastname		= $row['user_lastname'];
		$user_email 		= $row['user_email'];
		$registered_date 	= $row['registered_date'];
		$user_role 			= $row['user_role'];

		echo "<tr>";
		echo "<td>$username</td>";
		echo "<td>$user_email</td>";
		echo "<td>$user_firstname</td>";
		echo "<td>$user_lastname</td>";
		echo "<td>$user_role</td>";
		echo "<td>$registered_date</td>";
		echo "<td><a href='users.php?action=edit&user_id={$user_id}'>Edit</a></td>";
		echo "<td><a href='users.php?action=delete&user_id={$user_id}'>Delete</a></td>";
		echo "</tr>";
	}
}

function deleteUserById() {
	global $connection;
	if(is_user_logged_in()) {
		if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['user_id'])) {
			if(firstAdmin() != $_GET['user_id']) {
				$user_id = $_GET['user_id'];
	
				$query = "DELETE FROM users WHERE id = $user_id";
				$result = mysqli_query($connection, $query);
				header("Location: users.php");
			} else {
				header("Location: users.php");
			}
		}
	} else {
		header("Location: ../index.php");
	}
}

function firstAdmin() {
	global $connection;
	$query = "SELECT id FROM users WHERE user_role = 'administrator' ORDER BY id ASC LIMIT 1";
	$result = mysqli_query($connection, $query);
	$row = mysqli_fetch_assoc($result);
	$first_admin = $row['id'];
	
	return $first_admin;
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
		} else {
			return $error;
		}
	}
}

function editUserById() {
	global $connection;
	$error = [];
	if(isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];
		if(isset($_POST['edit_user_submit'])) {
			$user_firstname = cleanData($_POST['user_firstname']);
			$user_lastname 	= cleanData($_POST['user_lastname']);
			$user_role 		= cleanData($_POST['user_role']);
			$user_password 	= cleanData($_POST['user_password']);

			if(empty($user_firstname) || $user_firstname == '') {
				$error['user_firstname'] = "First Name can't be empty";
			}
			if(empty($user_lastname) || $user_lastname == '') {
				$error['user_lastname'] = "Last Name can't be empty";
			}
			if(!empty($user_password) || $user_password != '') {
				$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12) );
				$query = "UPDATE users SET user_password = '$user_password' WHERE id = $user_id";
				$result = mysqli_query($connection, $query);
			}
			if(empty($error)) {
				$query  = "UPDATE users SET ";
				$query .= "user_firstname = '$user_firstname', ";
				$query .= "user_lastname = '$user_lastname', ";
				$query .= "user_role = '$user_role' ";
				$query .= "WHERE id = $user_id";
				$result = mysqli_query($connection, $query);
				confirmQuery($result, "<h3 class='text-success'>User Updated</h3>");
			} else {
				return $error;
			}
		}
	}
}

function editMyProfile() {
	global $connection;
	$error = [];
	if(isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		if(isset($_POST['edit_user_submit'])) {
			$user_firstname = cleanData($_POST['user_firstname']);
			$user_lastname 	= cleanData($_POST['user_lastname']);
			$user_role 		= cleanData($_POST['user_role']);
			$user_password 	= cleanData($_POST['user_password']);

			if(empty($user_firstname) || $user_firstname == '') {
				$error['user_firstname'] = "First Name can't be empty";
			}
			if(empty($user_lastname) || $user_lastname == '') {
				$error['user_lastname'] = "Last Name can't be empty";
			}
			if(!empty($user_password) || $user_password != '') {
				$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12) );
				$query = "UPDATE users SET user_password = '$user_password' WHERE username = '$username'";
				$result = mysqli_query($connection, $query);
			}
			if(empty($error)) {
				$query  = "UPDATE users SET ";
				$query .= "user_firstname = '$user_firstname', ";
				$query .= "user_lastname = '$user_lastname', ";
				$query .= "user_role = '$user_role' ";
				$query .= "WHERE username = '$username'";
				$result = mysqli_query($connection, $query);
				confirmQuery($result, "<h3 class='text-success'>Profile Updated</h3>");
			} else {
				return $error;
			}
		}
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

function confirmQuery($result, $info = "") {
	global $connection;
	if(!$result) {
		die("Failed." . mysqli_error($connection));
	} else {
		echo $info;
	}
}

function cleanData($data){
	global $connection;
	$data = mysqli_real_escape_string($connection, trim($data));

	return $data;
}


function showUserDataById() {
	global $connection;
	$user = [];
	if(isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['user_id'])) {
		$user_id = $_GET['user_id'];

		$query = "SELECT * FROM users WHERE id = '$user_id'";
		$result = mysqli_query($connection, $query);

		$row = mysqli_fetch_assoc($result);

		$user['username'] 			= $row['username'];
		$user['user_firstname'] 	= $row['user_firstname'];
		$user['user_lastname'] 		= $row['user_lastname'];
		$user['user_email'] 		= $row['user_email'];
		$user['registered_date'] 	= $row['registered_date'];
		$user['user_role'] 			= $row['user_role'];
	}
	return $user;
}

function showMyProfile() {
	global $connection;
	$user = [];
	if(isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_SESSION['username'])) {
		$username = $_SESSION['username'];

		$query = "SELECT * FROM users WHERE username = '$username'";
		$result = mysqli_query($connection, $query);

		$row = mysqli_fetch_assoc($result);

		$user['username'] 			= $row['username'];
		$user['user_firstname'] 	= $row['user_firstname'];
		$user['user_lastname'] 		= $row['user_lastname'];
		$user['user_email'] 		= $row['user_email'];
		$user['registered_date'] 	= $row['registered_date'];
		$user['user_role'] 			= $row['user_role'];
	}
	return $user;
}

function userIdByUsername() {
	global $connection;
	if(isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$query = "SELECT id FROM users WHERE username = '$username'";
		$result = mysqli_query($connection, $query);
		$row = mysqli_fetch_assoc($result);
		$user_id = $row['id'];

		return $user_id;
	}
}

function addNewListing() {
	global $connection;
	if(is_user_logged_in()) {
		$session_user = $_SESSION['username'];

		$error = [];
		if(isset($_POST['listing_submit'])) {
			$business_owner 		= cleanData($_POST['business_owner']);
			$business_name 			= cleanData($_POST['business_name']);
			$business_email 		= cleanData($_POST['business_email']);
			$business_phone 		= cleanData($_POST['business_phone']);
			$business_f_year 		= cleanData($_POST['business_f_year']);
			$business_type 			= cleanData($_POST['business_type']);
			$business_motto 		= cleanData($_POST['business_motto']);
			$business_description 	= cleanData($_POST['business_description']);

			if(empty($business_owner) || $business_owner == '') {
				$error['business_owner'] = "Business Owner can't be empty";
			}
			if(empty($business_name) || $business_name == '') {
				$error['business_name'] = "Business Name can't be empty";
			}
			if(empty($business_email) || $business_email == '') {
				$error['business_email'] = "Email can't be empty";
			}
			if(empty($business_phone) || $business_phone == '') {
				$error['business_phone'] = "Phone can't be empty";
			}
			if(empty($business_motto) || $business_motto == '') {
				$error['business_motto'] = "Motto can't be empty";
			}
			if(empty($error)) {
				$query  = "INSERT INTO listing (business_owner, listing_user, business_name, business_email, business_phone, business_f_year, business_type, business_motto, business_description) VALUES ('$business_owner', '$session_user', '$business_name', '$business_email', '$business_phone', $business_f_year, '$business_type', '$business_motto', '$business_description')";
				$result = mysqli_query($connection, $query);
				confirmQuery($result, "<h3 class='text-success'>Listing done!</h3>");
				header("Location: business.php");
			} else {
				return $error;
			}
		}
	}
}

function showListing() {
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
		echo "<td>$business_owner</td>";
		echo "<td>$business_name</td>";
		echo "<td>$business_email</td>";
		echo "<td>$business_phone</td>";
		echo "<td>$business_f_year</td>";
		echo "<td>$business_type</td>";
		echo "<td>$business_motto</td>";
		echo "<td>$business_description</td>";
		echo "<td><a href='business.php?action=edit_listing&listing_id={$listing_id}'>Edit</a></td>";
		echo "<td><a href='business.php?action=delete_listing&listing_id={$listing_id}'>Delete</a></td>";
		echo "</tr>";
	}
}

function showListingByUserId() {
	global $connection;
	$user = [];
	if(is_user_logged_in()) {
		$session_user = $_SESSION['username'];

		$query = "SELECT * FROM listing WHERE listing_user = '$session_user'";
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
			echo "<td>$business_owner</td>";
			echo "<td>$business_name</td>";
			echo "<td>$business_email</td>";
			echo "<td>$business_phone</td>";
			echo "<td>$business_f_year</td>";
			echo "<td>$business_type</td>";
			echo "<td>$business_motto</td>";
			echo "<td>$business_description</td>";
			echo "<td><a href='business.php?action=edit_listing&listing_id={$listing_id}'>Edit</a></td>";
			echo "<td><a href='business.php?action=delete_listing&listing_id={$listing_id}'>Delete</a></td>";
			echo "</tr>";
		}
	}
}

function deleteListingById() {
	global $connection;
	if(is_user_logged_in()) {
		if(isset($_GET['action']) && $_GET['action'] == 'delete_listing' && isset($_GET['listing_id'])) {
			$listing_id = $_GET['listing_id'];

			$query = "DELETE FROM listing WHERE id = '$listing_id'";
			$result = mysqli_query($connection, $query);
			header("Location: business.php");
		}
	} else {
		header("Location: ../index.php");
	}
}