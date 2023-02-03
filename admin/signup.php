<?php require_once "controllerUserData.php"; ?>
<?php echo file_get_contents("html/admin-header1.html"); ?>
<title>Administrator Signup | 3Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<body>
    <div class="frm-login" class="container-fluid"> 
        <img id="center-header-logo" src="../images/FINAL-LOGO.png"/>
		<form action="signup.php" method="POST" autocomplete="off">
			<div class="row">
                <div class="col-12 col-lg-12 order-lg-first mt-4">
                    <span id="table-header-text">ADMINISTRATOR SIGNUP</span>
                    <div id="top-line-divider">
                        <input id="username" type="text" name="name" placeholder="USERNAME" required value="<?php echo $name ?>">
                    </div>
                </div>
				<div class="col-12 col-lg-12 mt-3">
                    <input id="email" type="email" name="email" placeholder="EMAIL" required value="<?php echo $email ?>">
				</div>
                <div class="col-12 col-lg-12 mt-3">
                    <input id="password" type="password" name="password" minlength="8" placeholder="PASSWORD" required>
				</div>
                <div class="col-12 col-lg-12 mt-3">
                    <input id="password" type="password" name="cpassword" minlength="8" placeholder="CONFIRM PASSWORD" required>
				</div>
				<?php if(count($errors)== 1){ ?>
					<div class="col-12 col-lg-12 mt-3">
						<div class="alert alert-danger">
							<?php
							foreach($errors as $showerror){
								echo $showerror;
							}
							?>
						</div>
					</div>
				<?php } ?>
				<?php if(count($errors) > 1){ ?>
					<div class="col-12 col-lg-12 mt-3">
						<div class="alert alert-danger">
							<?php
							foreach($errors as $showerror){
								?>
								<li><?php echo $showerror; ?></li>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<div class="col-12 col-lg-12 mt-3">
                    <input id="btn-signup" type="submit" name="signup" value="SIGNUP">
				</div>
                <div class="col-12 col-lg-12 order-last offset-12 offset-lg-0">
                    <span id="log_msg"><a class="log-link" href="login.php">ALREADY A MEMBER?</a></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>