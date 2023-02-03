<?php require_once "controllerUserData.php"; ?>
<?php 

//write the query to get data from users table

$sql = "SELECT * FROM appointments WHERE status = '2'";

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
<title>Accepted Appointments | 3Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<?php echo file_get_contents("html/admin-main-nav.html"); ?>
<?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
	<div class="col-12 col-lg-12">
		<div class="alert alert-<?php echo $_SESSION['statusMsg']; ?> alert-dismissible fade show revised_notif">
			<?php echo $_SESSION['success_message']; ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	</div>
<?php unset($_SESSION['success_message']); } ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 g-0">
			<form action="appointment-list.php" method="post">
				<div id="datatable-container">
					<span id="table-header-text">ACCEPTED APPOINTMENT REQUESTS</span>
					<div id="top-line-divider2">
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
													<a href="update.php?update-id=<?php echo $row['id']; ?>"><input type="button" id="edit" value="EDIT"></a>
													<a href="controllerUserData.php?completed-id=<?php echo $row['id']; ?>&email3=<?php echo $row['email']; ?>"><input type="button" id="complete" value="COMPLETE"></a>
													<button type="button" id="reject" data-toggle="modal" data-target="#modal<?php echo $row['id']; ?>">REMOVE</button>
												</td>	
												<div class="modal fade" id="modal<?php echo $row['id']; ?>" tabindex="-1"> 
													<div class="modal-dialog"> 
														<div class="modal-content"> 
															<div class="modal-header"> 
																<span id="table-header-text">REMOVE APPOINTMENT</span>
																<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
															</div> 
															<div class="modal-body"> 
																<div class="frm-text">THIS ACTION CANNOT BE UNDONE. ARE YOU SURE YOU WANT TO REMOVE APPOINTMENT ID <?php echo $row['id']; ?>?</div>
															</div> 
															<div class="modal-footer"> 
																<a href="controllerUserData.php?delete-id=<?php echo $row['id']; ?>&email3=<?php echo $row['email']; ?>"><input type="button" id="reject" value="REMOVE"></a>
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