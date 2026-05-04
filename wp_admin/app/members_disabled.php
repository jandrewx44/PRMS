<?php
	
	include 'includes/session.php';

	if(isset($_GET['confpending'])){
		$sql = "UPDATE tbl_users SET STATUS='0' WHERE ID=".$_GET['confpending'];
		if($conn->query($sql)){
			$_SESSION['success'] = 'Successfully Updated!';
			audit_log($conn,$user,'User Disabled',audit_target_user($conn,$_GET['confpending']));
			
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Opps!! somthing went wrong!!';
	}
header('location: members.php');
?>
