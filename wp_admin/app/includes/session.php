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
		$limit=function($value,$max){
			$value=(string)$value;
			return function_exists('mb_substr') ? mb_substr($value,0,$max,'UTF-8') : substr($value,0,$max);
		};
		$stmt=$conn->prepare("INSERT INTO history (data,action,date,user) VALUES (?,?,NOW(),?)");
		if(!$stmt){
			return;
		}
		$d=$limit($data===''?$fname:$fname.' | '.$data,30);
		$action=$limit($action,50);
		$type=$limit($type,20);
		$stmt->bind_param('sss',$d,$action,$type);
		try{
			$stmt->execute();
		}
		catch(mysqli_sql_exception $e){
			return;
		}
	}
?>
