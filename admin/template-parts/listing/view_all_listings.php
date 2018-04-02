<table class="table table-bordered table-responsive">
    <thead>
        <tr>
            <td>Business Owner</td>
            <td>Business Name</td>
            <td>Business Email</td>
            <td>Business Phone</td>
            <td>Foundation Year</td>
            <td>Business Type</td>
            <td>Business Motto</td>
            <td>Business Description</td>
            <td>Edit</td>
            <td>Delete</td>
        </tr>
    </thead>
    <tbody>
        <?php
            if(is_admin()) {
                showListing();
            } else {
                showListingByUserId();
            }
        ?>
    </tbody>
</table>