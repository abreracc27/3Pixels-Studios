<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login.php');
}
?>
<?php echo file_get_contents("html/admin-header1.html"); ?>
<title>Code Verification | 3Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<body>
    <div class="frm-login" class="container-fluid">
        <img id="center-header-logo" src="../images/FINAL-LOGO.png"/>
		<form action="user-otp.php" method="POST" autocomplete="off">
			<div class="row">
                <div class="col-12 col-lg-12 order-lg-first mt-4">
                    <span id="table-header-text">CODE VERIFICATION</span>
                    <div id="top-line-divider"></div>
                </div>
                <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
                    <div class="col-12 col-lg-12">
                        <div class="alert alert-<?php echo $_SESSION['statusMsg']; ?>">
                            <?php echo $_SESSION['success_message']; ?>
                        </div>
                    </div>
                    <?php
                    unset($_SESSION['success_message']);
                }
                ?>
				<div class="col-12 col-lg-12 mt-3">
                    <input id="otp-code" type="text" name="otp" placeholder="6-DIGIT CODE" maxlength="6" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))" required>
				</div>
				<?php if(count($errors) > 0){ ?>
					<div class="col-12 col-lg-12">
                        <div class="alert alert-danger">
							<?php
							foreach ($errors as $showerror) {
								echo $showerror;
							}
							?>
						</div>
					</div>
				<?php } ?>
				<div class="col-12 col-lg-12 mt-3">
                    <input id="submit-code" type="SUBMIT" name="check" value="SUBMIT">
				</div>
            </div>
        </div>
    </div>
</body>
</html>