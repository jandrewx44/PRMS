<?php
	
	include 'includes/session.php';

	if(isset($_GET['resetpass'])){

        $letters = '012345678911223344556677889900';
        $numbers = '!@#$%*&abcdefghijklmnpqrstuwxyzABCDEFGHJKLMNPQRSTUWXYZ23456789';
        foreach (range('A', 'Z') as $char) {
            $letters .= $char;
        }
        for($i = 0; $i < 10; $i++){
            $numbers .= $i;
        }
        $randomPass= substr(str_shuffle($letters), 0, 6).substr(str_shuffle($numbers), 0, 9);

		$sql = "UPDATE tbl_users SET PASSWORD='$randomPass' WHERE ID=".$_GET['resetpass'];
		if($conn->query($sql)){
			$_SESSION['success'] = 'Successfully reset!';
			audit_log($conn,$user,'User Password Reset',audit_target_user($conn,$_GET['resetpass']));
			
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

