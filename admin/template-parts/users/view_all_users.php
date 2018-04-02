<?php 
    if(!is_admin()) {
        header("Location: ./index.php");
        exit;
    }
?>
<table class="table table-bordered table-responsive">
    <thead>
        <tr>
            <td>Username</td>
            <td>User Email</td>
            <td>First Name</td>
            <td>Last Name</td>
            <td>User Role</td>
            <td>User Registered</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
    </thead>
    <tbody>
        <?php showUsers(); ?>
    </tbody>
</table>