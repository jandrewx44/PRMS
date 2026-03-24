<?php 
require_once('includes/conn.php');
if($_SERVER['REQUEST_METHOD'] !='POST'){
 	 $_SESSION['error'] = 'Error: No data to save.';
    $conn->close();
    exit;
}
extract($_POST);

if(empty($id)){
    $sql = "INSERT INTO `schedule_list` (`title`,`description`,`start_datetime`,`end_datetime`) VALUES ('$title','$description','$start_datetime','$end_datetime')";
}else{
    $sql = "UPDATE `schedule_list` set `title` = '{$title}', `description` = '{$description}', `start_datetime` = '{$start_datetime}', `end_datetime` = '{$end_datetime}' where `id` = '{$id}'";
}
$save = $conn->query($sql);
if($save){
	$_SESSION['success'] = 'Schedule Successfully updated!.';
}else{
	$_SESSION['error'] = 'somthing went wrong!!';
}
$conn->close();
header("location:home.php");
?>
