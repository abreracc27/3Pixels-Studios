<?php
// Start session
session_start();

// Include and initialize DB class
require_once 'db.class.php';
$db = new DB();

$tblName = 'imgproduct';

// File upload path
$uploadDir = "../uploads/imgproduct/";

// Allow file formats
$allowTypes = array('JPG','jpg','PNG','png','JPEG','jpeg','GIF','gif');

// Max file size
$maxSize = 41943040; //40MB

// Set default redirect url
$redirectURL = 'list-product.php';

$statusMsg = '';
$sessData = array();
$statusType = 'danger';
if(isset($_POST['imgSubmit'])){
	
	 // Set redirect url
    $redirectURL = 'addEditproduct.php';

    // Get submitted data
    $image	= $_FILES['image'];
	$title	= $_POST['title'];
	$id		= $_POST['id'];
    
    // Submitted user data
    $imgData = array(
        'title'  => $title
    );
    
    // Store submitted data into session
    $sessData['postData'] = $imgData;
    $sessData['postData']['id'] = $id;
    
    // ID query string
    $idStr = !empty($id)?'?id='.$id:'';
    
    // If the data is not empty
    if((!empty($image['name']) && !empty($title)) || (!empty($id) && !empty($title))){
		
		if(!empty($image)){
			$fileName = basename($image["name"]);
			$targetFilePath = $uploadDir . $fileName;
			$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			
			if(in_array($fileType, $allowTypes)){
				if($image['size'] < $maxSize){
					// Upload file to server
					if(move_uploaded_file($image["tmp_name"], $targetFilePath)){
						$imgData['file_name'] = $fileName;
					}else{
						$statusMsg = "THERE WAS AN ERROR UPLOADING YOUR FILE!";
					}
				}else{
					$statusMsg = "SORRY, YOUR FILE EXCEEDS THE SIZE LIMIT! [40MB]";
				}
			}else{
				$statusMsg = "SORRY, ONLY JPG, JPEG, PNG & GIF FILES ARE ALLOWED TO UPLOAD.";
			}
		}

		if(!empty($id)){
			// Previous file name
			$conditions['where'] = array(
				'id' => $_GET['id'],
			);
			$conditions['return_type'] = 'single';
			$prevData = $db->getRows('imgproduct', $conditions);
			
			// Update data
			$condition = array('id' => $id);
			$update = $db->update($tblName, $imgData, $condition);
			
			if($update){
				$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

				if(in_array($fileType, $allowTypes)){
					if($image['size'] < $maxSize){
						// Remove old file from server
						if(!empty($imgData['file_name'])){
							@unlink($uploadDir.$prevData['file_name']);
						}
						
						$statusType = 'success';
						$statusMsg = 'IMAGE DATA HAS BEEN UPDATED!';
						$sessData['postData'] = '';
						
						$redirectURL .= $idStr;
					}else{
						$statusMsg = "SORRY, YOUR FILE EXCEEDS THE SIZE LIMIT! [40MB]";
					}
				}else{
					$statusMsg = "SORRY, ONLY JPG, JPEG, PNG & GIF FILES ARE ALLOWED TO UPLOAD.";
					$sessData['postData'] = '';
					$redirectURL .= $idStr;
				}
			}else{
				$statusMsg = 'SOME PROBLEM OCCURRED. PLEASE TRY AGAIN.';
				// Set redirect url
				$redirectURL .= $idStr;
			}
		}elseif(!empty($imgData['file_name'])){
			// Insert data
			$insert = $db->insert($tblName, $imgData);
			
			if($insert){
				$statusType = 'success';
				$statusMsg = 'NEW IMAGE DATA HAS BEEN UPLOADED!';
				$sessData['postData'] = '';
				
				$redirectURL = 'addEditproduct.php';
			}else{
				$statusMsg =  'SOME PROBLEM OCCURRED. PLEASE TRY AGAIN.';
			}
		}
	}else{
		$statusMsg = 'ALL FIELDS ARE MANDATORY. PLEASE FILL ALL THE FIELDS.';
	}
	
	// Status message
	$sessData['status']['type'] = $statusType;
    $sessData['status']['msg']  = $statusMsg;
}elseif(($_REQUEST['action_type'] == 'block') && !empty($_GET['id'])){
    // Update data
	$imgData = array('status' => 0);
    $condition = array('id' => $_GET['id']);
    $update = $db->update($tblName, $imgData, $condition);
    if($update){
        $statusType = 'success';
        $statusMsg  = 'IMAGE DATA HAS BEEN BLOCKED!';
    }else{
        $statusMsg  = 'SOME PROBLEM OCCURRED. PLEASE TRY AGAIN.';
    }
	
	// Status message
	$sessData['status']['type'] = $statusType;
    $sessData['status']['msg']  = $statusMsg;
}elseif(($_REQUEST['action_type'] == 'unblock') && !empty($_GET['id'])){
    // Update data
	$imgData = array('status' => 1);
    $condition = array('id' => $_GET['id']);
    $update = $db->update($tblName, $imgData, $condition);
    if($update){
        $statusType = 'success';
        $statusMsg  = 'IMAGE DATA HAS BEEN ACTIVATED!';
    }else{
        $statusMsg  = 'SOME PROBLEM OCCURRED. PLEASE TRY AGAIN.';
    }
	
	// Status message
	$sessData['status']['type'] = $statusType;
    $sessData['status']['msg']  = $statusMsg;
}elseif(($_REQUEST['action_type'] == 'delete') && !empty($_GET['id'])){
	// Previous file name
	$conditions['where'] = array(
		'id' => $_GET['id'],
	);
	$conditions['return_type'] = 'single';
	$prevData = $db->getRows('imgproduct', $conditions);
				
    // Delete data
    $condition = array('id' => $_GET['id']);
    $delete = $db->delete($tblName, $condition);
    if($delete){
		// Remove old file from server
		@unlink($uploadDir.$prevData['file_name']);
		
        $statusType = 'success';
        $statusMsg  = 'IMAGE DATA HAS BEEN DELETED SUCCESSFULLY!';
    }else{
        $statusMsg  = 'SOME PROBLEM OCCURRED. PLEASE TRY AGAIN.';
    }
	
	// Status message
	$sessData['status']['type'] = $statusType;
    $sessData['status']['msg']  = $statusMsg;
}

// Store status into the session
$_SESSION['sessData'] = $sessData;
	
// Redirect the user
header("Location: ".$redirectURL);
exit();
?>