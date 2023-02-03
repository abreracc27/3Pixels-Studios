<?php require_once "controllerUserData.php"; ?>
<?php 
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
<title>Administrator Control | 3Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<?php echo file_get_contents("html/admin-main-nav.html"); ?>

<div id="welcome" class="m-3"><span id="welcome">Welcome, <?php echo $fetch_info['name']?>!</span></div>
	
<div id="admin" class="container-fluid">
	<div class="row">
		<div class="col-12 col-lg-12 order-lg-first mt-4">
			<span id="table-header-text">ADMINISTRATOR DASHBOARD</span></td>
			<div id="top-line-divider"></div>
		</div>
		<div class="col-12 col-lg-6 mb-4 mt-3">
			<div class="col-12 col-lg-12">
				<button class="dropdown-toggle admin-nav" type="button"  data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">VIEW MEDIA</button>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0 admin-ul">
						<li class="nav-item ul-text"><a id="list-nav-btn" class="nav-link" href="graphicmedia.php">GRAPHIC DESIGN</a></li>
						<li class="nav-item ul-text"><a id="list-nav-btn" class="nav-link" href="productmedia.php">PRODUCT PHOTOGRAPHY</a></li>
						<li class="nav-item ul-text"><a id="list-nav-btn" class="nav-link" href="portraitmedia.php">PORTRAIT PHOTOGRAPHY</a></li>
					</ul>
				</div>
			</div>
			<div class="col-12 col-lg-12 mt-3">
				<button class="dropdown-toggle admin-nav" type="button"  data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo04" aria-controls="navbarTogglerDemo04" aria-expanded="false" aria-label="Toggle navigation">MANAGE MEDIA</button>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo04">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0 admin-ul">
						<li class="nav-item ul-text"><a id="list-nav-btn" class="nav-link" href="list-graphic.php">GRAPHIC DESIGN</a></li>
						<li class="nav-item ul-text"><a id="list-nav-btn" class="nav-link" href="list-product.php">PRODUCT PHOTOGRAPHY</a></li>
						<li class="nav-item ul-text"><a id="list-nav-btn" class="nav-link" href="list-portrait.php">PORTRAIT PHOTOGRAPHY</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-6 mb-4 mt-3">
			<div class="col-12 col-lg-12">
				<button type="button" class="new-app">NEW APPOINTMENT</button>
				<script>
					$('.new-app').on('click', function (e) {
						location.href = "list-pending.php?showModal=1";
					});
				</script>
			</div>
			<div class="col-12 col-lg-12 mt-3">
				<button class="dropdown-toggle admin-nav" type="button"  data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo05" aria-controls="navbarTogglerDemo05" aria-expanded="false" aria-label="Toggle navigation">MANAGE APPOINTMENTS</button>
				<div class="collapse navbar-collapse" id="navbarTogglerDemo05">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0 admin-ul">
						<li class="nav-item ul-text"><a id="list-nav-btn" class="nav-link" href="list-pending.php">PENDING APPOINTMENTS</a></li>
						<li class="nav-item ul-text"><a id="list-nav-btn" class="nav-link" href="list-accepted.php">ACCEPTED APPOINTMENTS</a></li>
						<li class="nav-item ul-text"><a id="list-nav-btn" class="nav-link" href="list-completed.php">COMPLETED APPOINTMENTS</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>