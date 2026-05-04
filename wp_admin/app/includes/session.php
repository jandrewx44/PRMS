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
	if(!is_array($user)){
		unset($_SESSION['admin']);
		$_SESSION['error'] = 'Your login session is no longer valid. Please sign in again.';
		header('location: ../index.php');
		exit;
	}
	$GLOBALS['audit_log_written'] = false;
	function audit_limit($value,$max){
		$value=(string)$value;
		return function_exists('mb_substr') ? mb_substr($value,0,$max,'UTF-8') : substr($value,0,$max);
	}
	function audit_title_from_script($script){
		$name=preg_replace('/\.php$/i','',basename($script));
		$name=str_replace(array('-', '_'), ' ', $name);
		return audit_limit(ucwords($name),50);
	}
	function audit_should_auto_log($script,$method){
		$base=basename($script);
		if($method === 'GET' && empty($_GET)){
			return false;
		}
		if($method === 'GET'){
			return (bool)preg_match('/(^|[-_])(delete|clear|confirmed|disabled|reset|complete|cancel|open)([-_]|\.|$)/i',$base);
		}
		return (bool)preg_match('/(^|[-_])(add|save|edit|update|delete|clear|confirmed|disabled|reset|complete|cancel|open|setting|logo|submit)([-_]|\.|$)/i',$base);
	}
	function audit_actor_label($user){
		if(!is_array($user)){
			return 'SYSTEM';
		}
		$username=trim($user['USERNAME'] ?? '');
		$role=trim($user['ROLE'] ?? '');
		if($username !== ''){
			return $username;
		}
		return $role !== '' ? $role : 'USER';
	}
	function audit_target_user($conn,$id){
		$id=(int)$id;
		if($id <= 0){
			return 'ID: '.$id;
		}
		$stmt=$conn->prepare("SELECT FIRSTNAME, MI, LASTNAME, USERNAME, ROLE FROM tbl_users WHERE ID=? LIMIT 1");
		if(!$stmt){
			return 'ID: '.$id;
		}
		$stmt->bind_param('i',$id);
		if(!$stmt->execute()){
			return 'ID: '.$id;
		}
		$res=$stmt->get_result();
		$row=$res ? $res->fetch_assoc() : null;
		if(!$row){
			return 'ID: '.$id;
		}
		$name=trim(($row['FIRSTNAME'] ?? '').' '.($row['MI'] ?? '').' '.($row['LASTNAME'] ?? ''));
		$username=trim($row['USERNAME'] ?? '');
		$role=trim($row['ROLE'] ?? '');
		$label=$name !== '' ? $name : 'ID: '.$id;
		if($username !== ''){
			$label.=' ('.$username.')';
		}
		if($role !== ''){
			$label.=' '.$role;
		}
		return $label;
	}
	function audit_log($conn,$user,$action,$data=''){
		if(!is_array($user)){
			return;
		}
		$fname=trim(($user['FIRSTNAME'] ?? '').' '.($user['MI'] ?? '').' '.($user['LASTNAME'] ?? ''));
		$actor=audit_actor_label($user);
		$stmt=$conn->prepare("INSERT INTO history (data,action,date,user) VALUES (?,?,NOW(),?)");
		if(!$stmt){
			return;
		}
		$d=audit_limit($data===''?$fname:$data,30);
		$action=audit_limit($action,50);
		$actor=audit_limit($actor,20);
		$stmt->bind_param('sss',$d,$action,$actor);
		try{
			$stmt->execute();
			$GLOBALS['audit_log_written'] = true;
		}
		catch(mysqli_sql_exception $e){
			return;
		}
	}
	register_shutdown_function(function() use (&$conn,&$user){
		if(!empty($GLOBALS['audit_log_written'])){
			return;
		}
		$method=$_SERVER['REQUEST_METHOD'] ?? '';
		$script=$_SERVER['SCRIPT_NAME'] ?? '';
		if(!in_array($method,array('GET','POST'),true) || $script === ''){
			return;
		}
		if(!audit_should_auto_log($script,$method)){
			return;
		}
		audit_log($conn,$user,audit_title_from_script($script),basename($script));
	});
?>
