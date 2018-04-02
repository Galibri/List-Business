<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Install Listing Directory</title>
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">

</head>
<body>
<?php
if(file_exists('db.php')) {
	header("Location: ../index.php");
	exit;
}

//checking database info
if(isset($_POST['db_submit'])) {
	$db_host = $_POST['dbhost'];
	$dbuser  = $_POST['dbuser'];
	$dbpass  = $_POST['dbpass'];
	$dbname  = $_POST['dbname'];

	$connection = mysqli_connect( $db_host, $dbuser, $dbpass, $dbname );

	if(!$connection) {
		echo "<h2 class='text-center'>Something went wrong. Please try again.</h2>";
	} else {
		$myfile = fopen("db.php", "w") or die("Unable to open file!");
		$txt  = '<?php'. "\n";
		$txt .= '$db["db_host"] = '."'{$db_host}';\n";
		$txt .= '$db["db_user"] = '."'{$dbuser}';\n";
		$txt .= '$db["db_pass"] = '."'{$dbpass}';\n";
		$txt .= '$db["db_name"] = '."'{$dbname}';\n\n";
		$txt .= 'foreach ( $db as $key => $value ) {' . "\n";
		$txt .= "\t".'//define database properties' . "\n";
		$txt .= "\t".'define( strtoupper( $key ), $value );' . "\n";
		$txt .= '}' . "\n";
		$txt .= '$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME );' . "\n\n";
		$txt .= 'mysqli_character_set_name($connection);' . "\n";
		$txt .= "\t".'/* change character set to utf8 */' . "\n";
		$txt .= 'if (!mysqli_set_charset($connection, "utf8")) {' . "\n";
		$txt .= "\t".'die(mysqli_error($connection));' . "\n";
		$txt .= "\t".'exit();' . "\n";
		$txt .= '} else {' . "\n";
		$txt .= "\t".'mysqli_character_set_name($connection);' . "\n";
		$txt .= '}' . "\n";
		$txt .= 'if( ! $connection ) {' . "\n";
		$txt .= "\t".'die( "<h2>Database can\'t be connected.</h2>" . mysqli_error( $connection ) );' . "\n";
		$txt .= '}' . "\n";

		fwrite($myfile, $txt);
		fclose($myfile);
		header("Location: install_2.php");
	}
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h3>Configure Database</h3>
			<form action="" method="post">
				<div class="form-group">
					<label for="dbhost">Hostname:</label>
					<input type="text" name="dbhost" class="form-control">
				</div>
				<div class="form-group">
					<label for="dbuser">Database User:</label>
					<input type="text" name="dbuser" class="form-control">
				</div>
				<div class="form-group">
					<label for="dbpass">Database Password:</label>
					<input type="text" name="dbpass" class="form-control">
				</div>
				<div class="form-group">
					<label for="dbname">Database Name:</label>
					<input type="text" name="dbname" class="form-control">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-success" name="db_submit" value="Go Ahead">
				</div>
			</form>
		</div>
	</div>
</div>

</body>
</html>