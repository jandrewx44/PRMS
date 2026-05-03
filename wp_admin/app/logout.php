<?php
date_default_timezone_set('Asia/Manila');
	include "includes/session.php";
	
	audit_log($conn,$user,'Logout');
	//session_start();
	session_destroy();
	header('location: ../index.php');


?>
