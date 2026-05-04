<?php
include 'includes/session.php';
	
if (isset($_POST['btnsubmit'])) {	

		$ID = mysqli_real_escape_string($conn, $_POST['ID']);
		$FIRSTNAME = str_replace('ñ', 'Ñ', strtoupper($_POST['FIRSTNAME']));
		$MI = str_replace('ñ', 'Ñ', strtoupper($_POST['MI']));
		$LASTNAME = str_replace('ñ', 'Ñ', strtoupper($_POST['LASTNAME']));
		$ROLE = strtoupper($_POST['ROLE']);

		
		$sql = "UPDATE tbl_users
		SET FIRSTNAME ='$FIRSTNAME', 
		MI ='$MI', 
		LASTNAME ='$LASTNAME',
		ROLE ='$ROLE'
		WHERE ID = '$ID'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'information updated successfully';
			audit_log($conn,$user,'User Updated',"$FIRSTNAME $MI $LASTNAME (ID: $ID) $ROLE");
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Select user to edit first';
	}
	//header('location:members_update.php?update='.$memid.'','_self');
	header('location:members.php');
	?>	
