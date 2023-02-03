<?php require_once "controllerUserData.php"; ?>
<?php 
//write the query to get data from users table


$sql = "SELECT * FROM appointments WHERE status='1'";

//execute the query

$result = $conn->query($sql);

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
?>
<?php echo file_get_contents("html/admin-header1.html"); ?>
<title>Pending Appointments | 3Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<?php echo file_get_contents("html/admin-main-nav.html"); ?>
<?php if(count($errors)== 1){ ?>
	<div class="alert alert-danger alert-dismissible fade show revised_notif">
		<?php
		foreach($errors as $showerror){
			echo $showerror;
		}
		?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php } ?>
<?php if(count($errors) > 1){ ?>
	<div class="alert alert-danger alert-dismissible fade show revised_notif">
		<?php
		foreach($errors as $showerror){
			?>
			<li><?php echo $showerror; ?></li>
		<?php } ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php } ?>
<?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
	<div class="col-12 col-lg-12">
		<div class="alert alert-<?php echo $_SESSION['statusMsg']; ?> alert-dismissible fade show revised_notif">
			<?php echo $_SESSION['success_message']; ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	</div>
<?php unset($_SESSION['success_message']); } ?>
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="add-app" tabindex="-1"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<span id="table-header-text">NEW APPOINTMENT</span>
				<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
			</div> 
			<div class="modal-body"> 
				<form action="" method="POST" autocomplete="off">
					<div class="row">
						<div class="col-12 col-lg-6 order-lg-first">
							<div class="frm-text">LASTNAME</div>
							<input id="uname2" type="text" name="lname" value="<?php echo $lname; ?>" required>
						</div>
						<div class="col-12 col-lg-6">
							<div class="frm-text">FIRSTNAME</div>
							<input id="uname2" type="text" name="fname" value="<?php echo $fname; ?>" required>
						</div>
						<div class="col-12 col-lg-6">
							<div class="frm-text">EMAIL</div>
							<input id="uemail2" type="email" name="email" value="<?php echo $email2; ?>" required>
						</div>
						<div class="col-12 col-lg-6">
							<div class="frm-text">PHONE</div>
							<input id="uphone2" type="text" name="phone" maxlength="11" value="<?php echo $phone; ?>" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))" required>
						</div>
						<div class="col-12 col-lg-6">
							<div class="frm-text">SERVICE TYPE</div>
							<select name="type" id="utype2" required>
								<option value="<?php echo $type; ?>" selected hidden><?php echo $type; ?></option>
								<option value="Portrait Photography">Portrait Photography</option>
								<option value="Product Photography">Product Photography</option>
								<option value="Graphic Design">Graphic Design</option>
							</select>
						</div>
						<div class="col-12 col-lg-6">
							<div class="frm-text">APPOINTMENT DATE</div>
							<input id="udate2" type="date" name="date" min="<?php echo date("Y-m-d"); ?> value="<?php echo $date; ?>" required>
						</div>
						<div class="col-12 col-lg-6">
							<div class="frm-text">APPOINTMENT TIME</div>
							<select name="time" id="utime2" required>
								<option value="<?php echo $time; ?>" selected hidden><?php echo $time; ?></option>
								<option value="10:00 AM-12:00 PM">10:00 AM-12:00 PM</option>
								<option value="2:00 PM-4:00 PM">2:00 PM-4:00 PM</option>
								<option value="6:00 PM-8:00 PM">6:00 PM-8:00 PM</option>
							</select>
						</div>
						<div class="col-12 col-lg-6">
							<div class="frm-text">APP. VENUE (OPTIONAL)</div>
							<input id="uvenue2" type="text" name="venue" value="<?php echo $venue; ?>">
						</div>
						<div class="col-12 col-lg-12">
							<div class="frm-text">BRIEF DESCRIPTION OF THE PROJECT</div>
							<textarea id="umessage2" type="text" name="message" required><?php echo $message; ?></textarea>
						</div>
						<div class="col-12 col-lg-6"></div>
						<div class="col-12 col-lg-6 order-last offset-12 offset-lg-0">
							<input id="submit-appointment" type="submit" name="appointment-submit" data-toggle="modal" data-target="message" value="SUBMIT">
						</div>
					</div>
				</form>
			</div> 								 
		</div> 
	</div>
</div>
<script>
	if(<?php echo $_GET['showModal'] ?> == 1){
		var myModal = new bootstrap.Modal(document.getElementById("add-app"), {backdrop: 'static', keyboard: false});
		document.onreadystatechange = function () {
		myModal.show();
		};
	};

	$('.btn-close').on('click', function (e) {
		myModal.hide()
	});
</script>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 g-0">
			<form action="" method="post">
				<div id="datatable-container">
					<span id="table-header-text">PENDING APPOINTMENT REQUESTS</span>
					<div id="top-line-divider2">
						<button type="button" id="clear" data-target="#add-app" data-toggle="modal">NEW APPOINTMENT</button>
						<button id="list-nav" class="dropdown-toggle" type="button" data-toggle="dropdown">LISTS</button>
						<ul class="dropdown-menu">
							<li><a id="list-nav-btn" class="nav-link" href="list-pending.php">PENDING</a></li>
							<li><a id="list-nav-btn" class="nav-link" href="list-accepted.php">ACCEPTED</a></li>
							<li><a id="list-nav-btn" class="nav-link" href="list-completed.php">COMPLETED</a></li>
						</ul>
					</div>
					<table id="table_idhel" class="row-border cell-border order-column" style="width:100%">
						<thead>
							<tr>
								<th class="row-head">ID</td>
								<th class="row-head">LASTNAME</td>
								<th class="row-head">FIRSTNAME</td>
								<th class="row-head">PHONE</td>
								<th class="row-head">EMAIL</td>
								<th class="row-head">TYPE</td>
								<th class="row-head">DATE</td>
								<th class="row-head">TIME</td>
								<th class="row-head">VENUE</td>
								<th class="row-head">MESSAGE</td>
								<th class="row-head">ACTION</td>
							</tr>
						</thead>
						<tbody>
							<?php
								if ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) {
										?>
											<tr>
												<td id="data"><?php echo $row['id']; ?></td>
												<td id="data"><?php echo $row['lname']; ?></td>
												<td id="data"><?php echo $row['fname']; ?></td>
												<td id="data"><?php echo $row['phone']; ?></td>
												<td id="data"><?php echo $row['email']; ?></td>
												<td id="data"><?php echo $row['type']; ?></td>
												<td id="data"><?php echo $row['date']; ?></td>
												<td id="data"><?php echo $row['time']; ?></td>
												<td id="data"><?php echo $row['venue']; ?></td>
												<td id="data"><?php echo $row['message']; ?></td>
												<td id="data">
													<a href="controllerUserData.php?accept-id=<?php echo $row['id']; ?>&email3=<?php echo $row[
														'email']; ?>"><input type="button" id="accept" value="ACCEPT"></a>
													<button type="button" id="reject" data-toggle="modal" data-target="#modal<?php echo $row['id']; ?>">REJECT</button>
												</td>														
												<div class="modal fade" id="modal<?php echo $row['id']; ?>" tabindex="-1"> 
													<div class="modal-dialog"> 
														<div class="modal-content"> 
															<div class="modal-header"> 
																	<span id="table-header-text">REJECT APPOINTMENT</span>
																	<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
															</div> 
															<div class="modal-body"> 
																<div class="frm-text">THIS ACTION CANNOT BE UNDONE. ARE YOU SURE YOU WANT TO REJECT APPOINTMENT ID <?php echo $row['id']; ?>?</div>
															</div> 
															<div class="modal-footer"> 
																<a href="controllerUserData.php?reject-id=<?php echo $row['id']; ?>&email3=<?php echo $row['email']; ?>"><input type="button" id="reject" value="REJECT"></a>
															</div> 								 
														</div> 
													</div>
												</div>
											</tr>
										<?php
									}
								}
							?>													
						</tbody>
					</table>
					<script>
						$(document).ready(function() {
							$('#table_idhel').DataTable( {
								"scrollY": "60vh",
								"scrollX": true,
								"scrollCollapse": true,
								"paging": true,	
								"columnDefs": [
									{"className": "dt-center", "targets": "_all"}
								]									
							} );
						} );
					</script> 	
				</div>						
			</form>
		</div>
	</div>
</div>
</body>
</html>