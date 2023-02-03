<?php require_once "controllerUserData.php"; ?>
<?php
if($_SESSION['info'] == false){
    header('Location: login.php');  
}
?>
<?php echo file_get_contents("html/admin-header1.html"); ?>
<title>Account Verified | 3Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<?php echo file_get_contents("html/submitted1.html"); ?>
<div class="col-12 col-lg-12 order-lg-first pt-4">
    <span id="table-header-text">ACCOUNT VERIFIED</span>
    <div id="top-line-divider">
        <span class="frm-text">YOUR ACCOUNT HAS BEEN VERIFIED! YOU CAN NOW LOGIN WITH YOUR ACCOUNT.</span>
    </div>
</div>
<?php echo file_get_contents("html/submitted2.html"); ?>
        