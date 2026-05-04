<?php
$CI	= "REF";	//Example only
$CIcnt = strlen($CI);
$offset	= $CIcnt + 6;

// Get the current month and year as two-digit strings 
$month = date("m"); // e.g. 09 
$year = date("y"); // e.g. 23  

// Get the last reference number for this month/year only.
$number = "$CI-$month$year-0001";
$pattern = "$CI-$month$year-%";
$stmt = $conn->prepare("SELECT AUTO_NUMBER FROM tbl_autonumber WHERE AUTO_NUMBER LIKE ? ORDER BY AUTO_NUMBER DESC LIMIT 1");
if ($stmt) {
 $stmt->bind_param('s', $pattern);
 $stmt->execute();
 $result = $stmt->get_result();
 $row = $result ? $result->fetch_assoc() : null;
 $lastid = $row['AUTO_NUMBER'] ?? '';

 if (!empty($lastid)) {
  // Increment the last four digits by one.
  $idd = substr($lastid, $offset); // e.g. 0001
  $id = str_pad((int)$idd + 1, 4, 0, STR_PAD_LEFT); // e.g. 0002
  $number = "$CI-$month$year-$id";
 }
}
?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="wp_admin/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="wp_admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <link rel="stylesheet" href="wp_admin/plugins/toastr/toastr.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="wp_admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="wp_admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
 
  <!-- Theme style -->
  <link rel="stylesheet" href="wp_admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="wp_admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="wp_admin/plugins/daterangepicker/daterangepicker.css">
  
  <link rel="stylesheet" href="wp_admin/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="wp_admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- summernote -->
  <link rel="stylesheet" href="wp_admin/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="wp_admin/plugins/fullcalendar/main.css">
   <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">
      <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-thin.css">
      <link rel="stylesheet"href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-solid.css">
      <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-regular.css">
      <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/sharp-light.css">
