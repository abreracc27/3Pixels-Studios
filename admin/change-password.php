<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login.php');
}
?>
<?php echo file_get_contents("html/admin-header1.html"); ?>
	<title>Change Password | 3Pixels Studios</title>
	<?php echo file_get_contents("html/admin-header2.html"); ?>
<body>
	<div class="frm-login" class="container-fluid"> 
        <img id="center-header-logo" src="../images/FINAL-LOGO.png"/>
		<form action="change-password.php" method="POST" autocomplete="">
			<div class="row">
                <div class="col-12 col-lg-12 order-lg-first mt-4">
                    <span id="table-header-text">CHANGE YOUR PASSWORD</span>
                    <div id="top-line-divider">
						<span id="table-body-text" id="success">PLEASE ENTER A NEW PASSWORD.</span>
					</div>
                </div>
				
				<div class="col-12 col-lg-12 mt-3">
					<input id="password" type="password" name="password" minlength="8" placeholder="NEW PASSWORD" required>
				</div>
                <div class="col-12 col-lg-12 mt-3">
					<input id="password" type="password" name="cpassword" minlength="8" placeholder="CONFIRM PASSWORD" required>
				</div>
				<?php if(count($errors) > 0){ ?>
					<div class="col-12 col-lg-12 mt-3">
						<div class="alert alert-danger">
							<?php
							foreach ($errors as $showerror) {
                                echo $showerror;
							}
							?>
						</div>
					</div>
				<?php } ?>
                <div class="col-12 col-lg-6 mt-3">
					<button id="reset" name="change-password" type="submit">CHANGE</button>
				</div>
				<div class="col-12 col-lg-6 mt-3">
					<a href="login.php"><button id="cancel" type="button">CANCEL</button></a>
				</div>
            </div>
        </div>
    </div>
</body>
</html>