<?php require_once "controllerUserData.php"; ?>
<?php 

// verify if logged in as admin
$email = $_SESSION['email'];
$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($conn, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        if($status == "verified"){
            if($code != 0){
                header('Location: reset-code.php');
            }
        }else{
            header('Location: user-otp.php');
        }
    }
}else{
    header('Location: login.php');
}

//display updated table
if (isset($_GET['update-id'])) {
	$user_id = $_GET['update-id'];
	$sql = "SELECT * FROM `appointments` WHERE `id`='$user_id'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$lname = $row['lname'];
			$fname = $row['fname'];
			$phone = $row['phone'];
			$email = $row['email'];
			$type = $row['type'];
			$date = $row['date'];
			$time = $row['time'];
			$venue = $row['venue'];
			$message = $row['message'];
			$date_time = $row['date_time'];
			$id = $row['id'];
		}
			?>
            <?php echo file_get_contents("html/admin-header1.html"); ?>
			<title>Update Appointment Request | 3Pixels Studios</title>
			<?php echo file_get_contents("html/admin-header2.html"); ?>
            <?php echo file_get_contents("html/admin-main-nav.html"); ?>
			<?php
			if(count($errors)){
				?>
				<div class="col-12 col-lg-12">
					<div class="alert alert-danger alert-dismissible fade show revised_notif">
						<?php
						foreach($errors as $showerror){
							echo $showerror;
						}
						?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				</div>
				<?php
			}
			?>
			<div id="userform" class="container-fluid">
				<form action="" method="POST">
					<div class="row">
						<div class="col-12 col-lg-12 order-lg-first mt-4">
							<span id="table-header-text">UPDATE CLIENT APPOINTMENT REQUEST</span></td>
							<div id="top-line-divider"><span id="table-body-text">KINDLY FILL UP THE FORM BELOW TO REQUEST AN APPOINTMENT WITH THE PHOTOGRAPHERS.</span></div>
						</div>
						<div class="col-12 col-lg-12 mt-3">
							<span class="frm-text">APPOINTMENT ID:</span> <input id="uid" type="text" name="user_id" value="<?php echo $id; ?>" readonly>
						</div>
						<div class="col-12 col-lg-6 mb-4 mt-3">
							<div class="frm-text">LASTNAME</div>
							<input id="uname" type="text" name="lname" value="<?php echo $lname; ?>" required>
						</div>
						<div class="col-12 col-lg-6 mb-4 mt-3">
							<div class="frm-text">FIRSTNAME</div>
							<input id="uname" type="text" name="fname" value="<?php echo $fname; ?>" required>
						</div>
						<div class="col-12 col-lg-6 mb-4 mt-3">
							<div class="frm-text">EMAIL</div>
							<input id="uemail" type="email" name="email" value="<?php echo $email; ?>" required>
						</div>
						<div class="col-12 col-lg-6 mb-4 mt-3">
							<div class="frm-text">PHONE</div>
							<input id="uphone" type="text" name="phone" maxlength="11" value="<?php echo $phone; ?>" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))" required>
						</div>
						<div class="col-12 col-lg-6 mb-4 mt-3">
							<div class="frm-text">SERVICE TYPE</div>
							<select name="type" id="utype" required>
								<option value="<?php echo $type; ?>" selected hidden><?php echo $type; ?></option>
								<option value="Portrait Photography">Portrait Photography</option>
								<option value="Product Photography">Product Photography</option>
								<option value="Graphic Design">Graphic Design</option>
							</select>
						</div>
						<div class="col-12 col-lg-6 mb-4 mt-3">
							<div class="frm-text">APPOINTMENT DATE</div>
							<input id="udate" type="date" name="date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $date; ?>" required>
						</div>
						<div class="col-12 col-lg-6 mb-4 mt-3">
							<div class="frm-text">APPOINTMENT TIME</div>
							<select name="time" id="utime" required>
								<option value="<?php echo $time; ?>" selected hidden><?php echo $time; ?></option>
								<option value="10:00 AM-12:00 PM">10:00 AM-12:00 PM</option>
								<option value="2:00 PM-4:00 PM">2:00 PM-4:00 PM</option>
								<option value="6:00 PM-8:00 PM">6:00 PM-8:00 PM</option>
							</select>
						</div>
						<div class="col-12 col-lg-6 mb-4 mt-3">
							<div class="frm-text">APPOINTMENT VENUE (OPTIONAL)</div>
							<input id="uvenue" type="text" name="venue" value="<?php echo $venue; ?>">
						</div>
						<div class="col-12 col-lg-12 mb-4 mt-3">
							<div class="frm-text">BRIEF DESCRIPTION OF THE PROJECT</div>
							<textarea id="umessage" type="text" name="message" required><?php echo $message; ?></textarea>
						</div>
						<div class="col-12 col-lg-6 mt-3">
							<input id="form-update" type="submit" value="UPDATE" name="update">
						</div>
						<div class="col-12 col-lg-6 order-last offset-12 offset-lg-0 mt-3">
							<a href="list-accepted.php"><input type="button" id="cancel-update" name="cancel" value="CANCEL"></a>
						</div>
					</div>
				</form>
			</div>
            </body>
            </html>

			<?php

			
	}else{
			header('Location: list-accepted.php');
	}
}
?>

			
