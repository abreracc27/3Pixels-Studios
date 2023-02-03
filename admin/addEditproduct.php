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

$postData = $imgData = array();

// Get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Get posted data from session
if(!empty($sessData['postData'])){
    $postData = $sessData['postData'];
    unset($_SESSION['sessData']['postData']);
}

// Get image data
if(!empty($_GET['id'])){
    // Include and initialize DB class
    require_once 'db.class.php';
    $db = new DB();
    
    $conditions['where'] = array(
        'id' => $_GET['id'],
    );
    $conditions['return_type'] = 'single';
    $imgData = $db->getRows('imgproduct', $conditions);
}

// Pre-filled data
$imgData = !empty($postData)?$postData:$imgData;

// Define action
$actionLabel = !empty($_GET['id'])?'Edit':'Add';
?>
<?php echo file_get_contents("html/admin-header1.html"); ?>
<title>Add/Edit Media | 3Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<?php echo file_get_contents("html/admin-main-nav.html"); ?>
<!-- Display status message -->
<?php if(!empty($statusMsg)){ ?>
<div class="col-xs-12">
    <div class="alert alert-<?php echo $statusMsgType; ?> alert-dismissible fade show revised_notif">
        <?php echo $statusMsg; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php } ?>
    
<div class="frm-login" class="container-fluid">
    <form method="post" action="productpostAction.php" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-lg-12 order-lg-first mt-4">
                <span id="table-header-text">UPLOAD PRODUCT MEDIA</span>
                <div id="top-line-divider"></div>
            </div>
            <div class="col-12 col-lg-12">
                <?php if(!empty($imgData['file_name'])){ ?>
                    <span class="frm-text">IMAGE ID:</span> <input type="text" id="uid" name="id" value="<?php echo !empty($imgData['id'])?$imgData['id']:''; ?>">
                    <img id="img-update" src="../uploads/imgproduct/<?php echo $imgData['file_name']; ?>"> 
                <?php } ?>
            </div>
            <div class="col-12 col-lg-12 mt-3">
                <input id="ufile" type="file" accept="image/png, image/jpeg, image/gif" name="image" required>
            </div>
            <div class="col-12 col-lg-12 mt-3">
                <input type="text" id="utype" name="title" placeholder="GIVE THIS IMAGE A TITLE" value="<?php echo !empty($imgData['title'])?$imgData['title']:''; ?>"> 
            </div>
            <div class="col-12 col-lg-6 mt-3">
                <input id="upload" type="submit" name="imgSubmit" value="UPLOAD">
            </div>
            <div class="col-12 col-lg-6 order-last offset-12 offset-lg-0 mt-3">
                <a href="list-product.php"><button type="button" id="upload-back">BACK</button></a>
            </div>
        </div>
    </form>
</div>
</body>
</html>