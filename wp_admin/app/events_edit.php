<?php
	include 'includes/session.php';
	$return = isset($_GET['return']) ? urldecode($_GET['return']) : 'events.php?home=events';
	if (strpos($return, 'events.php') !== 0) {
		$return = 'events.php?home=events';
	}

	if(isset($_POST['submit'])){
		$ID = (int)($_POST['id'] ?? 0);
		$TITLE = trim((string)($_POST['title'] ?? ''));
		$OTHER_TITLE = trim((string)($_POST['other_title'] ?? ''));
		$DESCRIPTION = trim((string)($_POST['description'] ?? ''));
		$DATE = trim((string)($_POST['start_datetime'] ?? ''));
		$TIME = trim((string)($_POST['end_datetime'] ?? ''));

		if($TITLE === 'OTHERS'){
			$TITLE = $OTHER_TITLE;
		}

		if($ID <= 0){
			$_SESSION['error'] = 'Invalid event selected.';
		} elseif($TITLE === '' || $DESCRIPTION === '' || $DATE === '' || $TIME === ''){
			$_SESSION['error'] = 'Please fill in all required fields.';
		} elseif(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $DATE) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $TIME)){
			$_SESSION['error'] = 'Invalid date format.';
		} elseif($TIME < $DATE){
			$_SESSION['error'] = 'End date must be the same as or after start date.';
		} else {
			$stmt = $conn->prepare("UPDATE schedule_list SET title=?, description=?, start_datetime=?, end_datetime=? WHERE id=?");
			$stmt->bind_param("ssssi",$TITLE,$DESCRIPTION,$DATE,$TIME,$ID);
			if($stmt->execute()){
				$_SESSION['success'] = 'Event updated successfully';
				audit_log($conn,$user,'Event Updated',"$TITLE $DATE to $TIME");
			}
			else{
				$_SESSION['error'] = 'Unable to update event right now.';
			}
		}

	}
	else{
		$_SESSION['error'] = 'Select record to edit first';
	}

	header('location:'.$return);
	exit;
?>
