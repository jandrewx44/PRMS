<?php
	date_default_timezone_set('Asia/Manila');
	session_start();
	include 'conn.php';
	function login_history_limit($value,$max){
		$value=(string)$value;
		return function_exists('mb_substr') ? mb_substr($value,0,$max,'UTF-8') : substr($value,0,$max);
	}
	function login_history($conn,$data,$action,$actor){
		$stmt=$conn->prepare("INSERT INTO history (data,action,date,user) VALUES (?,?,NOW(),?)");
		if(!$stmt){
			return;
		}
		$data=login_history_limit($data,30);
		$action=login_history_limit($action,50);
		$actor=login_history_limit($actor,20);
		$stmt->bind_param('sss',$data,$action,$actor);
		try{
			$stmt->execute();
		}
		catch(mysqli_sql_exception $e){
			return;
		}
	}

	if(isset($_POST['login'])){
		$username = trim($_POST['username']);
		$password = $_POST['password'];

		$sql = "SELECT * FROM tbl_users WHERE TRIM(USERNAME) = '$username'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find account with the username';
			login_history($conn,'Attempted username: '.$username,'Login Failed','SYSTEM');
		}
		else{
			$row = $query->fetch_assoc();
			if($row['STATUS'] != 1){
				$_SESSION['error'] = 'Account is disabled. Please contact administrator.';
				login_history($conn,$row['FIRSTNAME'].' '.$row['MI'].' '.$row['LASTNAME'],'Login Blocked',$row['USERNAME']);
			}
			elseif($password==$row['PASSWORD']){
				$_SESSION['admin'] = $row['ID'];
				$_SESSION['last_login_timestamp'] = time(); 
                $fname=$row['FIRSTNAME'].' '. $row['MI'].' '.$row['LASTNAME'];
                login_history($conn,$fname,'Login',$row['USERNAME']);
			}
			else{
				$_SESSION['error'] = 'Incorrect password';
				login_history($conn,$row['FIRSTNAME'].' '.$row['MI'].' '.$row['LASTNAME'],'Login Failed',$row['USERNAME']);
			}
		}
		
	}
	else{
		$_SESSION['error'] = 'Input admin credentials first';
	}

	header('location: index.php');

?>
