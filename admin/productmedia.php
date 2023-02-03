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

require_once 'db.class.php';
$db = new DB();

// Fetch the images data
$condition = array('where' => array('status' => 1));
$images = $db->getRows('imgproduct', $condition);
?>
<?php echo file_get_contents("html/admin-header1.html"); ?>
<title>Product Photography | 3Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<?php echo file_get_contents("html/admin-main-nav.html"); ?>
<div class="container-fluid">
	<div class="row my-3">
		<a href="list-product.php"><button id="manage-img" type="button">MANAGE PRODUCT PHOTOGRAPHY</button></a>
	</div>
	<div class="grid">
		<div class="grid-col grid-col--1"></div>
		<div class="grid-col grid-col--2"></div>
		<div class="grid-col grid-col--3"></div>
		<div class="grid-col grid-col--4"></div>
		<?php
		if(!empty($images)){
			foreach($images as $row){
				$uploadDir = '../uploads/imgproduct/';
				$imageURL = $uploadDir.$row["file_name"];
		?>
		<div class="grid-item">
			<a href="<?php echo $imageURL; ?>" data-fancybox="gallery" >
				<img id="img-gallery" src="<?php echo $imageURL; ?>" alt="image" />
			</a>
		</div>
		<?php }
		} ?>
	</div>
</div>

<script>
	var colc = new Colcade( '.grid', {
	columns: '.grid-col',
	items: '.grid-item'
	});
</script>
</body>
</html>