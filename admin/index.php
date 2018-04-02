<?php require_once("template-parts/header.php"); ?>
<div class="row">  
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-0 toppad" >

      <div class="panel panel-info">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo $_SESSION['username']; ?></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class=" col-md-12 col-lg-12 "> 
              <table class="table table-user-information">
                <?php $user = showUserData(); ?>
                <tbody>
                  <tr>
                    <td>Username:</td>
                    <td><?php echo $user['username']; ?></td>
                  </tr>

                  <tr>
                    <td>First Name:</td>
                    <td><?php echo $user['user_firstname']; ?></td>
                  </tr>

                  <tr>
                    <td>Last Name:</td>
                    <td><?php echo $user['user_lastname']; ?></td>
                  </tr>

                  <tr>
                    <td>Email:</td>
                    <td><?php echo $user['user_email']; ?></td>
                  </tr>

                  <tr>
                    <td>Role:</td>
                    <td><?php echo $user['user_role']; ?></td>
                  </tr>

                  <tr>
                    <td>Joining Date:</td>
                    <td><?php echo $user['registered_date']; ?></td>
                  </tr>
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
            <div class="panel-footer">
                <a href="users.php?action=edit&user_id=<?php echo userIdByUsername(); ?>" data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit my Profile</a>
                <span class="pull-right">
                <a href="business.php?action=add_listing" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-plus"></i> Add Business Information</a>
                </span>
            </div>
        
      </div>
    </div>
</div>
<?php require_once("template-parts/footer.php"); ?>
