<?php
include 'includes/conn.php';
header('Content-Type: application/json');

if (!isset($_POST['id'])) {
	echo json_encode(array());
	exit;
}

$id = (int)$_POST['id'];
$stmt = $conn->prepare("SELECT * FROM schedule_list WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
if ($stmt->execute()) {
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
	echo json_encode($row ? $row : array());
	exit;
}

echo json_encode(array());
?>
