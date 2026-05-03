<?php
@include "includes/header.php";

$pdfParams = array();
$backUrl = 'marriage-certification-record.php';

if(isset($_GET['MARRIAGERECORDID'])){
  $pdfParams['MARRIAGERECORDID'] = intval($_GET['MARRIAGERECORDID']);
  $backUrl = 'marriage.php';
  if(isset($_GET['year']) && $_GET['year'] !== ''){
    $backUrl = 'marriage_view.php?year='.urlencode($_GET['year']);
  }
}else{
  $pdfParams['MARRIAGEID'] = isset($_GET['MARRIAGEID']) ? intval($_GET['MARRIAGEID']) : 0;
}

$pdfSrc = 'marriage-certification-pdf.php?'.http_build_query($pdfParams);
?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- .navbar -->
  <?php @include "includes/navbar.php";?>
  <!-- /.navbar -->
  <?php @include "includes/sidebar.php";?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4> Marriage Certificate <a href="<?=htmlspecialchars($backUrl, ENT_QUOTES, 'UTF-8');?>" class="btn bg-maroon btn-xs"><i class="fa fa-sharp fa-solid fa-left"></i> Back</a></h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">Home</li>
              <li class="breadcrumb-item active"> Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
		<div class="row">
		<div class="col-md-12">
             <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="<?=htmlspecialchars($pdfSrc, ENT_QUOTES, 'UTF-8');?>" allowfullscreen></iframe>
                </div>

          </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php @include "includes/footer.php";?>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
</body>
</html>

