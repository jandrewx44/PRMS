<?php
	include 'includes/session.php';
	$return = isset($_GET['return']) ? urldecode($_GET['return']) : 'events.php?home=events';
	if (strpos($return, 'events.php') !== 0) {
		$return = 'events.php?home=events';
	}

	if(isset($_POST['submit'])){
		$TITLE = trim((string)($_POST['title'] ?? ''));
		$DESCRIPTION = trim((string)($_POST['description'] ?? ''));
		$DATE = trim((string)($_POST['start_datetime'] ?? ''));
		$TIME = trim((string)($_POST['end_datetime'] ?? ''));

		if($TITLE === '' || $DESCRIPTION === '' || $DATE === '' || $TIME === ''){
			$_SESSION['error'] = 'Please fill in all required fields.';
		} elseif(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $DATE) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $TIME)){
			$_SESSION['error'] = 'Invalid date format.';
		} elseif($TIME < $DATE){
			$_SESSION['error'] = 'End date must be the same as or after start date.';
		} else {
			$stmt = $conn->prepare("INSERT INTO schedule_list(title, description, start_datetime, end_datetime) VALUES (?,?,?,?)");
			$stmt->bind_param("ssss",$TITLE,$DESCRIPTION,$DATE,$TIME);
			if($stmt->execute()){
				$_SESSION['success'] = 'New event has been created.';
				audit_log($conn,$user,'Event Added',"$TITLE $DATE to $TIME");
			}
			else{
				$_SESSION['error'] = 'Unable to save event right now.';
			}
		}

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location:'.$return);
	exit;
?>
