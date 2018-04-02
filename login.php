<?php require_once('template-parts/header.php'); ?>
	<?php $loginError = loginUser(); ?>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<p class="text-center"><?php echo isset($_GET['message']) ? 'Registration Successful. Please login now.' : '' ?></p>
				<p class="text-center"><?php echo isset($_GET['registration']) ? 'All done! Login Now with your username and password' : '' ?></p>
				<form action="" method="post">
					<div class="form-group">
						<label for="username">Username:</label>
						<input type="text" name="username_email" class="form-control">
						<strong><span class="text-danger"><?php echo !empty($loginError['username_email']) ? $loginError['username_email'] : ''; ?></span></strong>
					</div>
					<div class="form-group">
						<label for="password">Password:</label>
						<input type="password" name="user_password" class="form-control">
						<strong><span class="text-danger"><?php echo !empty($loginError['user_password']) ? $loginError['user_password'] : ''; ?></span></strong>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-success" name="login_submit" value="Login">
					</div>
				</form>
			</div>
		</div>
<?php require_once('template-parts/footer.php'); ?>