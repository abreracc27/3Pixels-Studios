<?php
include "config.php";
$errors = array();
$name = "";
$email = "";
$qone = "";
$qtwo = "";
$qthree = "";
$qfour = "";
$qfive = "";
$comments = "";

// if the form's submit button is clicked, we need to process the form
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$qone = $_POST['qone'];
	$qtwo = $_POST['qtwo'];
	$qthree = $_POST['qthree'];
	$qfour = $_POST['qfour'];
	$qfive = $_POST['qfive'];
	$comments = $_POST['comments'];

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "INVALID EMAIL FORMAT!";
	}
	if(count($errors) === 0){
		$sql = "INSERT INTO `feedback`(`name`, `email`, `qone`, `qtwo`, `qthree`, `qfour`, `qfive`, `comments`) VALUES ('$name','$email','$qone','$qtwo','$qthree','$qfour','$qfive','$comments')";

		$email_from = 'noreply3pixelsstudios@gmail.com';
		$email_subject = "Copy of Feedback Form Submission";
		$email_body = "Name: $name\n".
					"\nEmail: $email\n".
					"\nHow did you hear about us?\n$qone\n".
					"\nHow would you describe your experience with our website?\n$qtwo\n".
					"\nHow satisfied were you with our service?\n$qthree\n".
					"\nDid our employees or customer service help you? How?\n$qfour\n".
					"\nWould you recommend us to your friends and family?\n$qfive\n".
					"\nAdditional comments:\n$comments";

		$to_email = "$email,noreply3pixelsstudios@gmail.com"; //change to business email
		$headers = "From: $email_from \r\n";

		$result = $conn->query($sql);
		if ($result == TRUE)  {
			mail($to_email, $email_subject, $email_body, $headers);
		}else{
			$error['sql-error'] = "'ERROR:'. $sql . '<br>'. $conn->error";
		}
		header("location:feedbacksubmit.php");
	}

}
?>
<?php echo file_get_contents("html/header1.html"); ?>
<title>Feedback Form | 3Pixels Studios</title>
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
		<div class="alert alert-danger alert-dismissible fade show">
			<?php
			foreach($errors as $showerror){
				?>
				<li><?php echo $showerror; ?></li>
			<?php } ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	</div>
<?php } ?>
<div id="userform" class="container-fluid">
	<form action="" method="post" autocomplete="">
		<div class="row">
			<div class="col-12 col-lg-12 order-lg-first mt-4">
				<span id="table-header-text">FEEDBACK FORM</span></td>
				<div id="top-line-divider"><span id="table-body-text">HELP US IMPROVE OUR SERVICE BY ANSWERING THE FOLLOWING QUESTIONS:</span></div>
			</div>
			<div class="col-12 col-lg-12 order-lg-first mb-4 pt-3">
				<div class="frm-text">NAME</div>
				<input id="name" type="text" name="name" value="<?php echo $name; ?>">
			</div>
			<div class="col-12 col-lg-12 mb-4 pt-3">
				<div class="frm-text">EMAIL</div>
				<input type="email" id="email"  name="email"  value="<?php echo $email; ?>">
			</div>
			<div class="col-12 col-lg-12 mb-4 pt-3">
				<div class="frm-text">HOW DID YOU HEAR ABOUT US?</div>
				<input id="qone" type="text" name="qone" value="<?php echo $qone; ?>"required>
			</div>
			<div class="col-12 col-lg-12 mb-4 pt-3">
				<div class="frm-text">HOW WOULD YOU DESCRIBE YOUR EXPERIENCE WITH OUR SERVICE?</div>
				<input id="qtwo" type="text" name="qtwo" value="<?php echo $qtwo; ?>" required>
			</div>
			<div class="col-12 col-lg-12 mb-4 pt-3">
				<div class="frm-text">HOW SATISFIED WERE YOU WITH OUR SERVICE?</div>
				<ul id="radiob">
					<li>
						<input type="radio" name="qthree" value="excellent" required> 
						<label for="excellent">EXCELLENT</label>
					</li>
					<li>
						<input type="radio" name="qthree" value="good"> 
						<label for="good">GOOD</label>
					</li>
					<li>
						<input type="radio" name="qthree" value="fair">
						<label for="neutral">FAIR</label>
					</li>
					<li>
						<input type="radio" name="qthree" value="poor"> 
						<label for="poor">POOR</label>
					</li>
				</ul>	
			</div>
			<div class="col-12 col-lg-12 mb-4 pt-3">
				<div class="frm-text">DID OUR EMPLOYEES OR CUSTOMER SERVICE HELP YOU? HOW?</div>
				<input id="qfour" type="text" name="qfour" value="<?php echo $qfour; ?>"required>
			</div>
			<div class="col-12 col-lg-12 mb-4 pt-3">
				<div class="frm-text">WOULD YOU RECOMMEND US TO YOUR FRIENDS OR FAMILY?</div>
				<input id="qfive" type="text" name="qfive" value="<?php echo $qfive; ?>"required>
			</div>
			<div class="col-12 col-lg-12 mb-4 pt-3">
				<div class="frm-text">ADDITIONAL COMMENTS:</div>
				<textarea id="message" type="text" name="comments"><?php echo $comments; ?></textarea>
			</div>
			<div class="col-12 col-lg-6">
				
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
