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

// Include and initialize DB class
require_once 'db.class.php';
$db = new DB();

// Fetch the users data
$images = $db->getRows('imgportrait');

// Get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>
<?php echo file_get_contents("html/admin-header1.html"); ?>
<title>Manage Portrait Photography | 3 Pixels Studios</title>
<?php echo file_get_contents("html/admin-header2.html"); ?>
<?php echo file_get_contents("html/admin-main-nav.html"); ?>
<!-- Display status message -->
<?php if(!empty($statusMsg)){ ?>
<div class="col-xs-12">
    <div class="alert alert-<?php echo $statusMsgType; ?>  alert-dismissible fade show revised_notif">
        <?php echo $statusMsg; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php } ?>
<?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
	<div class="col-12 col-lg-12">
		<div class="alert alert-<?php echo $_SESSION['statusMsg']; ?> alert-dismissible fade show revised_notif">
			<?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	</div>
	<?php
	unset($_SESSION['success_message']);
}
?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-lg-12 g-0">
            <form action="" method="post">
                <div id="datatable-container">
                    <span id="table-header-text">MANAGE PORTRAIT PHOTOGRAPHY</span>
                    <div id="top-line-divider2">
                        <a href="addEditportrait.php" target="_blank"><input type="button" id="add-frm" value="NEW IMAGE"></a>
                        <button type="button" id="clear" data-target="#modal_confirm" data-toggle="modal">CLEAR LIST</button>
                        <button id="list-nav" class="dropdown-toggle" type="button" data-toggle="dropdown">MANAGE</button>
                        <ul class="dropdown-menu">
                            <li><a id="list-nav-btn" class="nav-link" href="list-graphic.php">GRAPHIC DESIGN</a></li>
                            <li><a id="list-nav-btn" class="nav-link" href="list-portrait.php">PORTRAIT PHOTOGRAPHY</a></li>
                            <li><a id="list-nav-btn" class="nav-link" href="list-product.php">PRODUCT PHOTOGRAPHY</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a id="list-nav-btn" class="nav-link" href="portraitmedia.php">VIEW PORTRAIT MEDIA</a></li>
                        </ul>
                    </div> 
                    <table id="table_idhel" class="row-border cell-border order-column" style="width:100%">
                        <thead>
                            <tr>
                                <th class="row-head">ID</td>
                                <th class="row-head">IMAGE</td>
                                <th class="row-head">TITLE</td>
                                <th class="row-head">STATUS</td>
                                <th class="row-head">ACTION</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(!empty($images)){
                                foreach($images as $row){
                                    $statusLink = ($row['status'] == 1)?'portraitpostAction.php?action_type=block&id='.$row['id']:'portraitpostAction.php?action_type=unblock&id='.$row['id'];
                                    $statusTooltip = ($row['status'] == 1)?'Click to Inactive':'Click to Active';
                            ?>
                            <tr>
                                <td id="data"><?php echo $row['id']; ?></td>
                                <td id="data"><img src="<?php echo '../uploads/imgportrait/'.$row['file_name']; ?>" alt="" /></td>
                                <td id="data"><?php echo $row['title']; ?></td>
                                <td id="data"><a href="<?php echo $statusLink; ?>" title="<?php echo $statusTooltip; ?>"><span class="<?php echo ($row['status'] == 1)?'active':'inactive'; ?>"><?php echo ($row['status'] == 1)?'ACTIVE':'INACTIVE'; ?></span></a></td>
                                <td id="data">
                                    <a href="addEditportrait.php?id=<?php echo $row['id']; ?>" target="_blank"><input type="button" id="edit" value="EDIT"></a>
                                    <button type="button" id="reject" data-toggle="modal" data-target="#modal<?php echo $row['id']; ?>">DELETE</button>
                                </td>
                                <div class="modal fade" id="modal<?php echo $row['id']; ?>" tabindex="-1"> 
                                    <div class="modal-dialog"> 
                                        <div class="modal-content"> 
                                            <div class="modal-header"> 
                                                    <span id="table-header-text">DELETE IMAGE</span>
                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                            </div> 
                                            <div class="modal-body"> 
                                                <div class="frm-text">THIS ACTION CANNOT BE UNDONE. ARE YOU SURE YOU WANT TO DELETE IMAGE ID <?php echo $row['id']; ?>?</div>
                                            </div> 
                                            <div class="modal-footer"> 
                                                <a href="portraitpostAction.php?action_type=delete&id=<?php echo $row['id']; ?>"><input type="button" id="reject" value="DELETE"></a>
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
                    <div class="modal fade" id="modal_confirm" tabindex="-1"> 
						<div class="modal-dialog"> 
							<div class="modal-content"> 
								<div class="modal-header"> 
									<span id="table-header-text">CLEAR LIST</span>
									<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
								</div> 
								<div class="modal-body"> 
                                    <div class="frm-text">THIS ACTION CANNOT BE UNDONE. ARE YOU SURE YOU WANT TO CLEAR THIS LIST?</div>
								</div> 
								<div class="modal-footer"> 
									<a href="controllerUserData.php?clear-portrait=1"><input type="button" id="clear" value="CLEAR"></a>
								</div> 								 
							</div> 
						</div>
					</div>
                    <script>
                        $(document).ready(function() {
                            $('#table_idhel').DataTable( {
                                "scrollY": "100vh",
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