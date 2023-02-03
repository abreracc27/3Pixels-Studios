<?php 
include "config.php";
$lname = "";
$fname = "";
$phone = "";
$email = "";
$type = "";
$date = "";
$time = "";
$venue = "";
$message = "";
$errors = array();

// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit'])) {

    
	// get variables from the form
	$lname = $_POST['lname'];
	$fname = $_POST['fname'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$type = $_POST['type'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	$venue = $_POST['venue'];
	$message = $_POST['message'];
	$date_time = mysqli_real_escape_string($conn, $_POST['date']." ".$_POST['time']);
	$currentdate = date("Y-m-d");
	  
	if($date != $currentdate){
		$datetime_check = "SELECT * FROM appointments WHERE date_time = '$date_time'";
		$res = mysqli_query($conn, $datetime_check);
		if(mysqli_num_rows($res) > 0){
			$errors['date_time'] = "THE DATE AND TIME YOU ENTERED HAS ALREADY BEEN BOOKED!";
		}
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = "INVALID EMAIL FORMAT!";
		}
		if(count($errors) === 0){
			//write sql query
			$sql = "INSERT INTO `appointments`(`lname`,`fname`, `phone`, `email`, `type`, `date`,`time`,`venue`,`message`,`date_time`) VALUES ('$lname','$fname','$phone','$email','$type','$date','$time','$venue','$message','$date_time')";

			$email_from = 'noreply3pixelsstudios@gmail.com';
			$email_subject = "Copy of Appointment Form Submission";
			$email_body = "Name: $lname, $fname\n".
							"Phone: $phone\n".
							"Email: $email\n".
							"Type: $type\n".
							"Date: $date\n".
							"Time: $time\n".
							"Venue: $venue\n".
							"Message: $message\n\n".
                            "THIS IS AN AUTOMATED EMAIL. PLEASE DO NOT REPLY.\n\n".
                            "If you have any concerns or questions, you may contact us on:\n". 
                            "Facebook: https://www.facebook.com/3pixels.studiosph\n".
                            "Instagram: https://www.instagram.com/3pixels.studios/\n".
                            "Email: 3pixels.studios@gmail.com";

			$to_email = "$email; noreply3pixelsstudios@gmail.com"; //change to business email
			$headers = "From: $email_from \r\n";

			$secretKey = "6LePkVsaAAAAADb7lsbf-dQNlpziNyZziB7LENA-";
			$responseKey = $_POST['g-recaptcha-response'];
			$UserIP = $_SERVER['REMOTE_ADDR'];
			$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$UserIP";

			$response = file_get_contents($url);
			$response = json_decode($response);

			// execute the query
			if($response->success){
				$result = $conn->query($sql);
				if ($result == TRUE)  {
					mail($to_email, $email_subject, $email_body, $headers);
				}else{
					$error['sql-error'] = "'Error:'. $sql . '<br>'. $conn->error";
				}
				header("location:submitted.php");
			}
			else{
				$errors['captcha-error'] = "INVALID CAPTCHA! PLEASE TRY AGAIN.";
			}
		}
	}else{
		$errors['current_date'] = "SAME DAY APPOINTMENT IS NOT ALLOWED!";
	}
}
?>
<?php echo file_get_contents("html/header1.html"); ?>
<title>Contact | 3Pixels Studios</title>
<?php echo file_get_contents("html/header2.html"); ?>
<?php echo file_get_contents("html/main-nav.html"); ?>
<?php if(count($errors)== 1){ ?>
	<div class="col-12 col-lg-12">
		<div class="alert alert-danger alert-dismissible fade show">
			<?php
			foreach($errors as $showerror){
				echo $showerror;
			}
			?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	</div>
<?php } ?>
<?php if(count($errors) > 1){ ?>
	<div class="col-12 col-lg-12">
		<div class="alert alert-danger">
			<?php
			foreach($errors as $showerror){
				?>
				<li><?php echo $showerror; ?></li>
			<?php } ?>
		</div>
	</div>
<?php } ?>
<div id="userform" class="container-fluid">
	<form action="" method="POST" autocomplete="">
		<div class="row">
			<div class="col-12 col-lg-12 order-lg-first mt-4">
				<span id="table-header-text">PHOTOGRAPHY APPOINTMENT SCHEDULING FORM</span></td>
				<div id="top-line-divider"><span id="table-body-text">KINDLY FILL UP THE FORM BELOW TO REQUEST AN APPOINTMENT WITH THE PHOTOGRAPHERS.</span></div>
			</div>
			<div class="col-12 col-lg-6 mb-4 mt-3">
				<div class="frm-text">LASTNAME</div>
				<input id="name" type="text" name="lname" value="<?php echo $lname; ?>" required>
			</div>
			<div class="col-12 col-lg-6 mb-4 mt-3">
				<div class="frm-text">FIRSTNAME</div>
				<input id="name" type="text" name="fname" value="<?php echo $fname; ?>" required>
			</div>
			<div class="col-12 col-lg-6 mb-4 mt-3">
				<div class="frm-text">EMAIL</div>
				<input id="email" type="email" name="email" autocomplete="off" value="<?php echo $email; ?>" required>
			</div>
			<div class="col-12 col-lg-6 mb-4 mt-3">
				<div class="frm-text">PHONE</div>
				<input id="phone" type="text" minlength="11" maxlength="11" name="phone" value="<?php echo $phone; ?>" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))" required>
			</div>
			<div class="col-12 col-lg-6 mb-4 mt-3">
				<div class="frm-text">SERVICE TYPE</div>
				<select name="type" id="type" required>
					<option value="<?php echo $type; ?>" selected hidden><?php echo $type; ?></option>
					<option value="Portrait Photography">Portrait Photography</option>
					<option value="Product Photography">Product Photography</option>
					<option value="Graphic Design">Graphic Design</option>
				</select>
			</div>
			<div class="col-12 col-lg-6 mb-4 mt-3">
				<div class="frm-text">APPOINTMENT DATE</div>
				<input id="date" type="date" name="date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $date; ?>"required>
			</div>
			<div class="col-12 col-lg-6 mb-4 mt-3">
				<div class="frm-text">APPOINTMENT TIME</div>
				<select name="time" id="time" required>
                    <option value="<?php echo $time; ?>" selected hidden><?php echo $time; ?></option>
                    <option value="10:00 AM-12:00 PM">10:00 AM-12:00 PM</option>
                    <option value="2:00 PM-4:00 PM">2:00 PM-4:00 PM</option>
                    <option value="6:00 PM-8:00 PM">6:00 PM-8:00 PM</option>
                </select>
			</div>
			<div class="col-12 col-lg-6 mb-4 mt-3">
				<div class="frm-text">APPOINTMENT VENUE (OPTIONAL)</div>
				<input id="venue" type="text" name="venue" value="<?php echo $venue; ?>">
			</div>
			<div class="col-12 col-lg-12 mb-4 mt-3">
				<div class="frm-text">BRIEF DESCRIPTION OF THE PROJECT</div>
				<textarea id="message" type="text" name="message" required><?php echo $message; ?></textarea>
			</div>
			<div class="col-12 col-lg-6 mb-1 mt-3">
				<div class="g-recaptcha" data-sitekey="6LePkVsaAAAAAIsnqjYyAgKIq8Rkny8S7wJJRFPd"></div>
			</div>
			<div class="col-12 col-lg-6 order-last offset-12 offset-lg-0 mt-3">
				<input id="submit-appointment" type="submit" name="submit" value="SUBMIT">
			</div>
		</div>
	</form>
</div>
<script>
	$("body").on("contextmenu", "img", function(e) {
		return false;
	})
</script>
<?php echo file_get_contents("html/footer.html"); ?>
