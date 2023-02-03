<?php require_once "controllerUserData.php"; ?>
<?php echo file_get_contents("html/admin-header1.html"); ?>
<title>Forgot Password | 3Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<?php echo file_get_contents("html/admin-email-check1.html"); ?>
	<span id="table-header-text">RECOVER YOUR ACCOUNT</span>
	<div id="top-line-divider">
		<span id="table-body-text" id="success">PLEASE ENTER YOUR EMAIL TO SEARCH FOR YOUR ACCOUNT.</span>
	</div>
</div>
<div class="col-12 col-lg-12 mt-3">
	<input id="email" type="email" name="email" placeholder="EMAIL" required value="<?php echo $email ?>">
</div>
<?php
if(count($errors) > 0){
	?>
	<div class="col-12 col-lg-12">
		<div class="alert alert-danger">
			<?php
			foreach($errors as $showerror){
				echo $showerror;
			}
			?>
		</div>
	</div>
	<?php
}
?>
<div class="col-12 col-lg-6 mt-3">
<button id="search" name="check-email" type="submit">SEARCH</button>
<?php echo file_get_contents("html/admin-email-check2.html"); ?>