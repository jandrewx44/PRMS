<?php
	include 'includes/session.php';
	if(isset($_POST['btnsubmit'])){			
		$FIRSTNAME = str_replace('ñ', 'Ñ', strtoupper($_POST['FIRSTNAME']));
		$MI = str_replace('ñ', 'Ñ', strtoupper($_POST['MI']));
		$LASTNAME = str_replace('ñ', 'Ñ', strtoupper($_POST['LASTNAME']));
		$ROLE = strtoupper($_POST['ROLE']);
		$USERNAME= $_POST['USERNAME'];
		$PASSWORD= $_POST['PASSWORD'];
		$DESIGNATION ='';

		$sql = "SELECT * FROM tbl_users WHERE USERNAME = '$USERNAME' OR PASSWORD='$PASSWORD'";
		$query = $conn->query($sql);
		if($query->num_rows > 0){
			$_SESSION['error'] = "password  or username is already exist!!";
		
		}
		else{
			$sql= "INSERT INTO tbl_users(FIRSTNAME, MI, LASTNAME, DESIGNATION, USERNAME, PASSWORD, ROLE, STATUS, PROFILE)VALUES('$FIRSTNAME','$MI','$LASTNAME','$DESIGNATION','$USERNAME','$PASSWORD','$ROLE',1,'')";
			if($conn->query($sql)){
				$_SESSION['success'] = 'Account have been created.';
				audit_log($conn,$user,'User Added',"$FIRSTNAME $MI $LASTNAME ($USERNAME) $ROLE");
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
		}

	}	
	else{
		$_SESSION['error'] = 'Fill up add form first';
		
	}
	//header('location: clientAccount.php?q='.$_POST['id']);
	header('location:members.php');
?>
