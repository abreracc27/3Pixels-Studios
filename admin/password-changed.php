<?php require_once "controllerUserData.php"; ?>
<?php 
$email = $_SESSION['email'];
if($email == false){
  header('Location: login.php');
}
?>
<?php echo file_get_contents("html/admin-header1.html"); ?>
<title>Password Changed | 3Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<?php echo file_get_contents("html/submitted1.html"); ?>
<div class="col-12 col-lg-12 order-lg-first pt-4">
    <span id="table-header-text">PASSWORD CHANGED</span>
    <div id="top-line-divider">
        <span class="frm-text">YOUR PASSWORD HAS BEEN CHANGED! YOU CAN NOW LOGIN WITH YOUR NEW PASSWORD.</span>
    </div>
</div>
<?php echo file_get_contents("html/submitted2.html"); ?>