<?php
include "includes/session.php";

$sql="DELETE FROM history";
$query =$conn->query($sql);
audit_log($conn,$user,'History Cleared','All activity logs cleared');

header('location:history.php?home=history');

?>
