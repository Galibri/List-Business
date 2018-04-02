<?php require_once("template-parts/header.php"); ?>
<div class="row">  
    <div class="col-md-12">
        <?php 
            if(isset($_GET['action'])) {
                $action = $_GET['action'];
            } else {
                $action = "";
            }
            switch ($action) {
                case 'edit':
                    require_once("template-parts/users/edit_user.php");
                    break;

                case 'delete':
                    require_once("template-parts/users/delete_user.php");
                    break;

                case 'add':
                    require_once("template-parts/users/add_new_user.php");
                    break;
                
                default:
                    require_once("template-parts/users/view_all_users.php");
                    break;
            }

        ?>
    </div>
</div>
<?php require_once("template-parts/footer.php"); ?>
