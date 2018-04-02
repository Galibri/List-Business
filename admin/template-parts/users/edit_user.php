<?php 
    if(!is_admin()) {
        $showError = editMyProfile();
        $user_info = showMyProfile();
    }else {
        $showError = editUserById();
        $user_info = showUserDataById();
    }
?>
<form action="" method="post">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" value="<?php echo !empty($user_info['username']) ? $user_info['username'] : ''; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="user_firstname">First Name:</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo !empty($user_info['user_firstname']) ? $user_info['user_firstname'] : ''; ?>">
        <strong><span class="text-danger"><?php echo !empty($showError['user_firstname']) ? $showError['user_firstname'] : ''; ?></span></strong>
    </div>
    <div class="form-group">
        <label for="user_lastname">Last Name:</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo !empty($user_info['user_lastname']) ? $user_info['user_lastname'] : ''; ?>">
        <strong><span class="text-danger"><?php echo !empty($showError['user_lastname']) ? $showError['user_lastname'] : ''; ?></span></strong>
    </div>
    <div class="form-group">
        <label for="user_email">Email:</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo !empty($user_info['user_email']) ? $user_info['user_email'] : ''; ?>" readonly>
    </div>
    <div class="form-group">
        <label for="user_password">Password:</label>
        <input type="password" class="form-control" name="user_password">
        <strong><span class="text-danger"><?php echo !empty($showError['user_password']) ? $showError['user_password'] : ''; ?></span></strong>
    </div>
    <div class="form-group">
        <label for="user_role">User Role:</label>
        <?php $db_role = $user_info['user_role']; ?>
        <select class="form-control" name="user_role" id="user_role">
            <option value="subscriber" <?php echo $db_role == 'subscriber' ? 'selected' : '' ?>>Subscriber</option>
            <option value="author" <?php echo $db_role == 'author' ? 'selected' : '' ?>>Author</option>
            <option value="administrator" <?php echo $db_role == 'administrator' ? 'selected' : '' ?>>Administrator</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-info" name="edit_user_submit" value="Update User!">
    </div>
</form>