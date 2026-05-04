<?php
	include 'includes/session.php';

	if(isset($_GET['return'])){
		$return = $_GET['return'];
		
	}
	else{
		$return = 'home.php';
	}

	if(isset($_POST['save'])){
		$curr_password = $_POST['curr_password'];
		$username = $_POST['USERNAME'];
		$password = $_POST['PASSWORD'];
		$firstname = str_replace('ñ', 'Ñ', strtoupper($_POST['FIRSTNAME']));
		$mi = str_replace('ñ', 'Ñ', strtoupper($_POST['MI']));
		$lastname = str_replace('ñ', 'Ñ', strtoupper($_POST['LASTNAME']));

		if($curr_password== $user['PASSWORD']){
			if($password == $user['PASSWORD']){
				$password = $user['PASSWORD'];
			}
			else{
				$password = password_hash($password, PASSWORD_DEFAULT);
			}

			$sql = "UPDATE tbl_users SET USERNAME = '$username', PASSWORD = '$password', FIRSTNAME = '$firstname', LASTNAME = '$lastname', MI = '$mi' WHERE ID = '".$user['ID']."'";
			if($conn->query($sql)){
				$_SESSION['success'] = 'Admin profile updated successfully';
				audit_log($conn,$user,'Profile Updated',"$firstname $mi $lastname ($username)");
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
			
		}
		else{
			$_SESSION['error'] = 'Incorrect password';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up required details first';
	}

	header('location:'.$return);

?>
