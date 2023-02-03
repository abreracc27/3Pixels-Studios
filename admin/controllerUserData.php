<?php 
session_start();
require "connection.php";
$email = "";
$name = "";

$lname = "";
$fname = "";
$phone = "";
$email2 = "";
$type = "";
$date = "";
$time = "";
$venue = "";
$message = "";
$errors = array();

//if user signup button
if(isset($_POST['signup'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    if($password !== $cpassword){
        $errors['password'] = "CONFIRM PASSWORD NOT MATCHED!";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "INVALID EMAIL FORMAT!";
    }
    $name_check = "SELECT * FROM usertable WHERE `name` = '$name'";
    $res = mysqli_query($conn, $name_check);
    if(mysqli_num_rows($res) > 0){
        $errors['name'] = "THE USERNAME YOU HAVE ENTERED IS ALREADY TAKEN!";
    }
    $email_check = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($conn, $email_check);
    if(mysqli_num_rows($res) > 0){
        $errors['email'] = "THE EMAIL YOU HAVE ENTERED ALREADY EXIST!";
    }
    if(count($errors) === 0){
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "notverified";
        $insert_data = "INSERT INTO usertable (name, email, password, code, status)
                        values('$name', '$email', '$encpass', '$code', '$status')";
        $data_check = mysqli_query($conn, $insert_data);
        if($data_check){
            $subject = "Email Verification Code"; 
            $message = "Your verification code is $code";
            $sender = "From: noreply3pixelsstudios@gmail.com";
            if(mail($email, $subject, $message, $sender)){
                $_SESSION['statusMsg'] = "success";
				$_SESSION['success_message'] = "WE HAVE SENT AN OTP CODE TO YOUR EMAIL - $email";
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();
            }else{
                $errors['otp-error'] = "FAILED WHILE SENDING CODE!";
            }
        }else{
            $errors['db-error'] = "FAILED WHILE INSERTING DATA TO DATABASE!";
        }
    }

}
//if user click verification code submit button
if(isset($_POST['check'])){
    $info = "WE HAVE SENT A CODE TO YOUR EMAIL - .";
    $_SESSION['info'] = $info;
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
    $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
    $code_res = mysqli_query($conn, $check_code);
    if(mysqli_num_rows($code_res) > 0){
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['code'];
        $email = $fetch_data['email'];
        $code = 0;
        $status = 'verified';
        $update_otp = "UPDATE usertable SET code = $code, status = '$status' WHERE code = $fetch_code";
        $update_res = mysqli_query($conn, $update_otp);
        if($update_res){
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            header('location:account-verified.php');
            exit();
        }else{
            $errors['otp-error'] = "FAILED WHILE UPDATING CODE!";
        }
    }else{
        $errors['otp-error'] = "YOU'VE ENTERED INCORRECT CODE!";
    }
}


//if user click login button
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $check_email = "SELECT * FROM usertable WHERE email = '$email'";
    $res = mysqli_query($conn, $check_email);
    if(mysqli_num_rows($res) > 0){
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['password'];
        if(password_verify($password, $fetch_pass)){
            $_SESSION['email'] = $email;
            $status = $fetch['status'];
            if($status == 'verified'){
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: admin.php');
            }else{
                $_SESSION['statusMsg'] = "warning";
                $_SESSION['success_message'] = "YOUR EMAIL HAS NOT YET BEEN VERIFIED. VERIFY YOUR EMAIL - $email";
                header('location: user-otp.php');
            }
        }else{
            $errors['email'] = "THE PASSWORD YOU'VE ENTERED IS INCORRECT!";
        }
    }else{
        $errors['email'] = "THE EMAIL YOU'VE ENTERED DOES NOT EXIST!";
    }
}

//if user click continue button in forgot password form
if(isset($_POST['check-email'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email = "SELECT * FROM usertable WHERE email='$email'";
    $run_sql = mysqli_query($conn, $check_email);
    if(mysqli_num_rows($run_sql) > 0){
        $code = rand(999999, 111111);
        $insert_code = "UPDATE usertable SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($conn, $insert_code);
        if($run_query){
            $subject = "Password Reset Code";
            $message = "Your password reset code is $code";
            $sender = "From: noreply3pixelsstudios@gmail.com";
            if(mail($email, $subject, $message, $sender)){
                $_SESSION['statusMsg'] = "success";
                $_SESSION['success_message'] = "WE HAVE SENT AN OTP CODE TO YOUR EMAIL - $email";
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            }else{
                $errors['otp-error'] = "FAILED WHILE SENDING CODE!";
            }
        }else{
            $errors['db-error'] = "SOMETHING WENT WRONG!";
        }
    }else{
        $errors['email'] = "YOUR SEARCH DID NOT RETURN ANY RESULTS! PLEASE TRY AGAIN.";
    }
}

//if user click check reset otp button
if(isset($_POST['check-reset-otp'])){
    $info = "WE HAVE SENT AN OTP CODE TO YOUR EMAIL - .";
    $_SESSION['info'] = $info;
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
    $check_code = "SELECT * FROM usertable WHERE code = $otp_code";
    $code_res = mysqli_query($conn, $check_code);
    if(mysqli_num_rows($code_res) > 0){
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please enter a new password.";
        $_SESSION['info'] = $info;
        header('location: change-password.php');
        exit();
    }else{
        $errors['otp-error'] = "YOU'VE ENTERED INCORRECT CODE!";
    }
}

//if user click change password button
if(isset($_POST['change-password'])){
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    if($password !== $cpassword){
        $errors['password'] = "CONFIRM PASSWORD NOT MATCHED!";
    }else{
        $code = 0;
        $email = $_SESSION['email']; //getting this email using session
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $update_pass = "UPDATE usertable SET code = $code, password = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_pass);
        if($run_query){
            $statusMsg = "success";
            $_SESSION['statusMsg'] = $statusMsg;
            $info = "YOUR PASSWORD HAS BEEN CHANGED! YOU CAN NOW LOGIN WITH YOUR NEW PASSWORD.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
        }else{
            $errors['db-error'] = "FAILED TO CHANGE YOUR PASSWORD!";
        }
    }
}

//if login now button click
if(isset($_POST['login-now'])){
    header('Location: login.php');
}

//if logout button is clicked
if(isset($_GET['logout'])){
    if($_GET['logout'] == 1){
        session_start();
        session_unset();
        session_destroy();
        header('location: login.php');
    }
}

//if submit appointment is clicked
if (isset($_POST['appointment-submit'])) {
	$lname = $_POST['lname'];
	$fname = $_POST['fname'];
	$phone = $_POST['phone'];
	$email2 = $_POST['email'];
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
		if (!filter_var($email2, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = "INVALID EMAIL FORMAT!";
		}
		if(count($errors) === 0){
			//write sql query
			$sql = "INSERT INTO `appointments`(`lname`,`fname`, `phone`, `email`, `type`, `date`,`time`,`venue`,`message`,`date_time`) VALUES ('$lname','$fname','$phone','$email2','$type','$date','$time','$venue','$message','$date_time')";

			$email_from = 'noreply3pixelsstudios@gmail.com';
			$email_subject = "Copy of Appointment Form Submission";
			$email_body = "Name: $lname, $fname\n".
							"Phone: $phone\n".
							"Email: $email2\n".
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

			$to_email = "$email2, noreply3pixelsstudios@gmail.com"; //change to business email
			$headers = "From: $email_from \r\n";


			$result = $conn->query($sql);
			if ($result == TRUE)  {
				mail($to_email, $email_subject, $email_body, $headers);
				$_SESSION['statusMsg'] = "success";
				$_SESSION['success_message'] = "NEW APPOINTMENT ADDED SUCCESSFULLY!";
			}else{
				$errors['sql-error'] = "'Error:'. $sql . '<br>'. $conn->error";
			}
			session_start();
			header("location:list-pending.php");
			exit();
		}
	}else{
		$errors['current_date'] = "SAME DAY APPOINTMENT IS NOT ALLOWED!";
	}				
}

//if accept button from list-pending is clicked
if (isset($_GET['accept-id'])) {
    $user_id = $_GET['accept-id'];
    $email3 = $_GET['email3'];

	$sql = "UPDATE appointments SET status = '2' WHERE `id`='$user_id'";
	// Execute the query

    $email_from = 'noreply3pixelsstudios@gmail.com';
    $email_subject = "3Pixels Studios Appointment Status [Accepted]";
    $email_body = "Your appointment request has been accepted.\n\n".
                   "THIS IS AN AUTOMATED EMAIL. PLEASE DO NOT REPLY.\n\n".
                   "If you have any concerns or questions, you may contact us on:\n". 
                   "Facebook: https://www.facebook.com/3pixels.studiosph\n".
                   "Instagram: https://www.instagram.com/3pixels.studios/\n".
                   "Email: 3pixels.studios@gmail.com";

    $to_email = "$email3"; //change to business email
    $headers = "From: $email_from \r\n";

	$result = $conn->query($sql);

	if ($result == TRUE) {
		mail($to_email, $email_subject, $email_body, $headers);
	}else{
		echo "ERROR:" . $sql . "<br>" . $conn->error;
	}
	session_start();
	$_SESSION['statusMsg'] = "success";
	$_SESSION['success_message'] = "APPOINTMENT MOVED TO ACCEPTED!";
	header('Location: list-pending.php');
	exit();
}

//If reject button from list-pending is clicked
if (isset($_GET['reject-id'])) {
	$user_id = $_GET['reject-id'];
    $email3 = $_GET['email3'];

	// write delete query
	$sql = "DELETE FROM `appointments` WHERE `id`='$user_id'";
	// Execute the query

    $email_from = 'noreply3pixelsstudios@gmail.com';
    $email_subject = "3Pixels Studios Appointment Status [Rejected]";
    $email_body = "Your appointment request has been rejected.\n\n".
                   "THIS IS AN AUTOMATED EMAIL. PLEASE DO NOT REPLY\n\n".
                   "If you have any concerns or questions, you may contact us on:\n". 
                   "Facebook: https://www.facebook.com/3pixels.studiosph\n".
                   "Instagram: https://www.instagram.com/3pixels.studios/\n".
                   "Email: 3pixels.studios@gmail.com";

    $to_email = "$email3"; //change to business email
    $headers = "From: $email_from \r\n";

	$result = $conn->query($sql);

	if ($result == TRUE) {
		mail($to_email, $email_subject, $email_body, $headers);
	}else{
		echo "Error:" . $sql . "<br>" . $conn->error;
	}
	session_start();
	$_SESSION['statusMsg'] = "success";
	$_SESSION['success_message'] = "APPOINTMENT REJECTED!";
	header('Location: list-pending.php');
	exit();
}

//If complete button from list-accepted is clicked
if (isset($_GET['completed-id'])) {
	$user_id = $_GET['completed-id'];
    $email3 = $_GET['email3'];

	$sql = "UPDATE appointments SET status = '3' WHERE `id`='$user_id'";
	// Execute the query

    $email_from = 'noreply3pixelsstudios@gmail.com';
    $email_subject = "3Pixels Studios Appointment Status [Completed]";
    $email_body = "Your appointment request has been completed.\n\n".
                   "THIS IS AN AUTOMATED EMAIL. PLEASE DO NOT REPLY.\n\n".
                   "If you have any concerns or questions, you may contact us on:\n". 
                   "Facebook: https://www.facebook.com/3pixels.studiosph\n".
                   "Instagram: https://www.instagram.com/3pixels.studios/\n".
                   "Email: 3pixels.studios@gmail.com";

    $to_email = "$email3"; //change to business email
    $headers = "From: $email_from \r\n";

	$result = $conn->query($sql);

	if ($result == TRUE) {
        mail($to_email, $email_subject, $email_body, $headers);
	}else{
		echo "Error:" . $sql . "<br>" . $conn->error;
	}
	session_start();
	$_SESSION['statusMsg'] = "success";
	$_SESSION['success_message'] = "APPOINTMENT MOVED TO COMPLETED!";
	header('Location: list-accepted.php');
	exit();
}

//If delete button from list-accepted is clicked
if (isset($_GET['delete-id'])) {
	$user_id = $_GET['delete-id'];
    $email3 = $_GET['email3'];

	// write delete query
	$sql = "DELETE FROM `appointments` WHERE `id`='$user_id'";
	// Execute the query

    $email_from = 'noreply3pixelsstudios@gmail.com';
    $email_subject = "3Pixels Studios Appointment Status [Deleted]";
    $email_body = "Your appointment request has been deleted.\n\n".
                   "THIS IS AN AUTOMATED EMAIL. PLEASE DO NOT REPLY.\n\n".
                   "If you have any concerns or questions, you may contact us on:\n". 
                   "Facebook: https://www.facebook.com/3pixels.studiosph\n".
                   "Instagram: https://www.instagram.com/3pixels.studios/\n".
                   "Email: 3pixels.studios@gmail.com";

    $to_email = "$email3"; //change to business email
    $headers = "From: $email_from \r\n";

	$result = $conn->query($sql);

	if ($result == TRUE) {
        mail($to_email, $email_subject, $email_body, $headers);
	}else{
		echo "Error:" . $sql . "<br>" . $conn->error;
	}
	session_start();
	$_SESSION['statusMsg'] = "success";
	$_SESSION['success_message'] = "APPOINTMENT DELETED!";
	header('Location: list-accepted.php');
	exit();
}

if (isset($_POST['update'])) {
	$lname = $_POST['lname'];
	$fname = $_POST['fname'];
	$phone = $_POST['phone'];
	$email2 = $_POST['email'];
	$type = $_POST['type'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	$venue = $_POST['venue'];
    $message = $_POST['message'];
	$user_id = $_POST['user_id'];
	$date_time = mysqli_real_escape_string($conn, $_POST['date']." ".$_POST['time']);
	$currentdate = date("Y-m-d");


	#GET DATE_TIME VALUE FROM DATABASE THEN PLACE IN A NEW VARIABLE#
	if (isset($_GET['update-id'])) {
		$user_id = $_GET['update-id'];
		$sql = "SELECT * FROM `appointments` WHERE `id`='$user_id'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$date_time_old = $row['date_time'];
			}
		}
	}

	#CHECK IF YUNG LUMANG DATE_TIME AT BAGONG DATE_TIME IS PAREHAS OR HINDI#
	if($date_time != $date_time_old){
		if($date != $currentdate){
			$datetime_check = "SELECT * FROM appointments WHERE date_time = '$date_time'";
			$res = mysqli_query($conn, $datetime_check);
			if(mysqli_num_rows($res) > 0){
				$errors['date_time'] = "THE DATE AND TIME YOU ENTERED HAS ALREADY BEEN BOOKED!";
			}
			// check if e-mail address is well-formed
			if (!filter_var($email2, FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = "INVALID EMAIL FORMA!T";
			}
			if(count($errors) === 0){
				$sql = "UPDATE `appointments` SET `lname`='$lname',`fname`='$fname',`type`='$type',`email`='$email2',`phone`='$phone',`venue`='$venue',`date`='$date',`time`='$time',`date_time`='$date_time',`message`='$message' WHERE `id`='$user_id'";

                $email_from = 'noreply3pixelsstudios@gmail.com';
                $email_subject = "Copy of Updated Appointment Submission";
                $email_body = "Name: $lname, $fname\n".
                                "Phone: $phone\n".
                                "Email: $email2\n".
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
                
                $to_email = "$email2, noreply3pixelsstudios@gmail.com"; //change to business email
			    $headers = "From: $email_from \r\n";

				$result = $conn->query($sql);
				if ($result == TRUE) {
                    mail($to_email, $email_subject, $email_body, $headers);
                    $_SESSION['statusMsg'] = "success";
				    $_SESSION['success_message'] = "RECORD UPDATED!";
				}else{
					echo "ERROR:" . $sql . "<br>" . $conn->error;
				}
				session_start();
				header('Location: list-accepted.php');
				exit();	
			}
		}else{
			$errors['current_date'] = "SAME DAY APPOINTMENT IS NOT ALLOWED!";
		}
	}
	#GAWIN ITO KUNG ANG DATE_TIME AY HINDI BINAGO#
	else{
		if (!filter_var($email2, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = "INVALID EMAIL FORMA!T";
		}
		if(count($errors) === 0){
			$sql = "UPDATE `appointments` SET `lname`='$lname',`fname`='$fname',`type`='$type',`email`='$email2',`phone`='$phone',`venue`='$venue',`date`='$date',`time`='$time',`date_time`='$date_time',`message`='$message' WHERE `id`='$user_id'";

            $email_from = 'noreply3pixelsstudios@gmail.com';
            $email_subject = "Copy of Updated Appointment Submission";
            $email_body = "Name: $lname, $fname\n".
                            "Phone: $phone\n".
                            "Email: $email2\n".
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
            
            $to_email = "$email2, noreply3pixelsstudios@gmail.com"; //change to business email
            $headers = "From: $email_from \r\n";

			$result = $conn->query($sql);
			if ($result == TRUE) {
                mail($to_email, $email_subject, $email_body, $headers);
                $_SESSION['statusMsg'] = "success";
                $_SESSION['success_message'] = "RECORD UPDATED!";
			}else{
				echo "ERROR:" . $sql . "<br>" . $conn->error;
			}
			session_start();
			header('Location: list-accepted.php');
			exit();	
		}
	}
}

//if clear list from list-completed is clicked
if (isset($_GET['clear-completed'])) {
    if($_GET['clear-completed'] == 1){
        $sql = "DELETE FROM `appointments` WHERE status = '3'";
        $result = $conn->query($sql);
    
        if ($result == TRUE) {
    
        }else{
            echo "ERROR:" . $sql . "<br>" . $conn->error;
        }
        session_start();
        $_SESSION['statusMsg'] = "success";
        $_SESSION['success_message'] = "RECORD CLEARED!";
        header('Location: list-completed.php');
        exit();	
    }
}

//if clear from list-graphic is clicked
if (isset($_GET['clear-graphic'])) {
    if($_GET['clear-graphic'] == 1){
        $sql = "DELETE FROM `imggraphic`";
        $result = $conn->query($sql);
    
        if ($result == TRUE) {
            foreach(glob('../uploads/imggraphic/*.*') as $file)
                if(is_file($file))
                    @unlink($file);
    
        }else{
            echo "ERROR:" . $sql . "<br>" . $conn->error;
        }
        session_start();
        $_SESSION['statusMsg'] = "success";
        $_SESSION['success_message'] = "RECORD CLEARED!";
        header('Location: list-graphic.php');
        exit();		
    }
}

//if clear from list-portrait is clicked
if (isset($_GET['clear-portrait'])) {
    if($_GET['clear-portrait'] == 1){
        $sql = "DELETE FROM `imgportrait`";
        $result = $conn->query($sql);
    
        if ($result == TRUE) {
            foreach(glob('../uploads/imgportrait/*.*') as $file)
                if(is_file($file))
                    @unlink($file);
    
        }else{
            echo "ERROR:" . $sql . "<br>" . $conn->error;
        }
        session_start();
        $_SESSION['statusMsg'] = "success";
        $_SESSION['success_message'] = "RECORD CLEARED!";
        header('Location: list-portrait.php');
        exit();		
    }
}

//if clear from list-product is clicked
if (isset($_GET['clear-product'])) {
    if($_GET['clear-product'] == 1){
        $sql = "DELETE FROM `imgproduct`";
        $result = $conn->query($sql);
    
        if ($result == TRUE) {
            foreach(glob('../uploads/imgproduct/*.*') as $file)
                if(is_file($file))
                    @unlink($file);
    
        }else{
            echo "ERROR:" . $sql . "<br>" . $conn->error;
        }
        session_start();
        $_SESSION['statusMsg'] = "success";
        $_SESSION['success_message'] = "RECORD CLEARED!";
        header('Location: list-product.php');
        exit();		
    }
}
?>