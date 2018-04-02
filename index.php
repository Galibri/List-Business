<?php require_once('template-parts/header.php'); ?>
		<div class="row">
			<div class="col-md-8">			
				<table class="table table-bordered table-responsive table-hover">
					<thead>
				        <tr>
				            <td>Business Name</td>
				            <td>Business Email</td>
				            <td>Action</td>
				        </tr>
				    </thead>
				    <tbody>
				    	<?php listingBusiness(); ?>
				    </tbody>
				</table>
			</div>
			<div class="col-md-4">
				<?php require_once('template-parts/sidebar.php'); ?>
			</div>
		</div>
<?php require_once('template-parts/footer.php'); ?>