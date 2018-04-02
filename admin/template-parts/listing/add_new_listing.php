<?php $showError = addNewListing(); ?>
<form action="" method="post">
    <div class="form-group">
        <label for="business_owner">Business Owner:</label>
        <input type="text" class="form-control" name="business_owner" value="<?php echo empty($_POST['business_owner']) ? '' : $_POST['business_owner'] ?>">

        <strong><span class="text-danger"><?php echo !empty($showError['business_owner']) ? $showError['business_owner'] : ''; ?></span></strong>
    </div>

    <div class="form-group">
        <label for="business_name">Business Name:</label>
        <input type="text" class="form-control" name="business_name" value="<?php echo empty($_POST['business_name']) ? '' : $_POST['business_name'] ?>">

        <strong><span class="text-danger"><?php echo !empty($showError['business_name']) ? $showError['business_name'] : ''; ?></span></strong>
    </div>

    <div class="form-group">
        <label for="business_email">Business Email:</label>
        <input type="email" class="form-control" name="business_email" value="<?php echo empty($_POST['business_email']) ? '' : $_POST['business_email'] ?>">

        <strong><span class="text-danger"><?php echo !empty($showError['business_email']) ? $showError['business_email'] : ''; ?></span></strong>
    </div>

    <div class="form-group">
        <label for="business_phone">Business Phone:</label>
        <input type="tel" class="form-control" name="business_phone" value="<?php echo empty($_POST['business_phone']) ? '' : $_POST['business_phone'] ?>">

        <strong><span class="text-danger"><?php echo !empty($showError['business_phone']) ? $showError['business_phone'] : ''; ?></span></strong>
    </div>

    <div class="form-group">
        <label for="business_f_year">Foundation Year:</label>
        <input type="number" min="1950" max="2019" step="1" class="form-control" name="business_f_year" value="<?php echo empty($_POST['business_f_year']) ? 2018 : $_POST['business_f_year'] ?>">

        <strong><span class="text-danger"><?php echo !empty($showError['business_f_year']) ? $showError['business_f_year'] : ''; ?></span></strong>
    </div>
    
    <div class="form-group">
        <label for="business_type">Business Type:</label>
        <select class="form-control" name="business_type" id="business_type">
            <option value="subscriber">Subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <label for="business_motto">Business Motto:</label>
        <input type="text" class="form-control" name="business_motto" value="<?php echo empty($_POST['business_motto']) ? '' : $_POST['business_motto'] ?>">

        <strong><span class="text-danger"><?php echo !empty($showError['business_motto']) ? $showError['business_motto'] : ''; ?></span></strong>
    </div>

    <div class="form-group">
        <label for="business_description">Business Description:</label>
        <textarea name="business_description" id="" cols="30" rows="10" class="form-control"><?php echo empty($_POST['business_description']) ? '' : $_POST['business_description'] ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-info" name="listing_submit" value="Register Now!">
    </div>
</form>