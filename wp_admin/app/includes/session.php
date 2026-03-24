<?php
	session_start();
	include 'conn.php';

	if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
		header('location: ../index.php');
		exit;
	}
	$sql = "SELECT * FROM tbl_users WHERE ID = '".$_SESSION['admin']."'";
	$query = $conn->query($sql);
	$user = $query ? $query->fetch_assoc() : null;
	function audit_log($conn,$user,$action,$data=''){
		if(!is_array($user)){
			return;
		}
		$fname=trim(($user['FIRSTNAME'] ?? '').' '.($user['MI'] ?? '').' '.($user['LASTNAME'] ?? ''));
		$type=$user['ROLE'] ?? '';
		if($type === ''){
			return;
		}
		$stmt=$conn->prepare("INSERT INTO history (data,action,date,user) VALUES (?,?,NOW(),?)");
		if(!$stmt){
			return;
		}
		$d=$data===''?$fname:$fname.' | '.$data;
		$stmt->bind_param('sss',$d,$action,$type);
		$stmt->execute();
	}
?>
