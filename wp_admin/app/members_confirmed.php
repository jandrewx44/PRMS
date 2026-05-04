<?php
	
	include 'includes/session.php';

	if(isset($_GET['confirmed'])){
		$sql = "UPDATE tbl_users SET STATUS='1' WHERE ID=".$_GET['confirmed'];
		if($conn->query($sql)){
			$_SESSION['success'] = 'Successfully Confirmed!';
			audit_log($conn,$user,'User Enabled',audit_target_user($conn,$_GET['confirmed']));
			
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
