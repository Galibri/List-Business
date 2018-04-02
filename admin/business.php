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
                case 'edit_listing':
                    require_once("template-parts/listing/edit_listing.php");
                    break;

                case 'delete_listing':
                    require_once("template-parts/listing/delete_listing.php");
                    break;

                case 'add_listing':
                    require_once("template-parts/listing/add_new_listing.php");
                    break;
                
                default:
                    require_once("template-parts/listing/view_all_listings.php");
                    break;
            }
        ?>
    </div>
</div>
<?php require_once("template-parts/footer.php"); ?>
