<?php
    include 'includes/session.php';
    $return = isset($_GET['return']) ? urldecode($_GET['return']) : 'events.php?home=events';
    if (strpos($return, 'events.php') !== 0) {
        $return = 'events.php?home=events';
    }

    if(isset($_POST['submit'])){
        $ID = (int)($_POST['ID'] ?? 0);
        if($ID <= 0){
            $_SESSION['error'] = "Please select a valid event to delete.";
        } else {
            $stmt = $conn->prepare("DELETE FROM schedule_list WHERE id=?");
            $stmt->bind_param('i', $ID);
            if($stmt->execute() && $stmt->affected_rows > 0){
                $_SESSION['success'] = "Record has been successfully deleted";
                audit_log($conn,$user,'Event Deleted',"ID $ID");
            }else{
                $_SESSION['error'] = "No record deleted!";
            }
        }
    }else{
        $_SESSION['error'] ="Please select first the record to delete";
    }
    header('location:'.$return);
    exit;
?>
