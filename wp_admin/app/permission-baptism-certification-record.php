<?php @include "includes/header.php";?>
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
            <h4>Permission for Baptism</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Permission Record</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		  
		  <?php
				if(isset($_SESSION['error'])){
				  echo "
					<div id='alert' class='alert alert-danger' id='alert'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					  <h4><i class='icon fa fa-warning'></i> ERROR!</h4>
					  ".$_SESSION['error']."
					</div>
				  ";
				  unset($_SESSION['error']);
				}
				if(isset($_SESSION['success'])){
				  echo "
					<div id='alert' class='alert alert-success' id='alert'>
					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					  <h4><i class='icon fa fa-check'></i> SUCCESS!</h4>
					  ".$_SESSION['success']."
					</div>
				  ";
				  unset($_SESSION['success']);
				}
			  ?>
		  
            <div class="card">
              <div class="card-header">
             <h3 class="card-title"> 
             <i class="fa fa-solid fa-folder-open"></i> Records
			  
              </h3>
			      	<div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-hover text-nowrap">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>ISSUED TO</th>
                    <th>GIVEN D/M/Y</th>
                    <th>PRIEST NAME</th>
                    <th>PARISHIONER</th>
                    <th>ISSUED DATE</th>
                    <th>UPDATED DATE</th>
                    <th>ACTIONS</th>
                  </tr>
                  </thead>
                  <tbody>
					      <?php
                    $sql = "SELECT * FROM tbl_permission_baptism_certificate ORDER BY DATE_ISSUED DESC";
                    $query = $conn->query($sql);
				          	$cnt=1;
                    while($row = $query->fetch_assoc()){
                      ?>
                        <tr>
                          <td><?=$cnt; ?></td>
                          <td><?=$row['CHILDNAME']; ?></td>
                          <td><?=$row['GIVEN_DAY']; ?> <?=$row['GIVEN_MONTH']; ?>, <?=$row['GIVEN_YEAR']; ?></td>
                          <td><?=$row['PRIEST_NAME']; ?></td>
                          <td><?=$row['PARISHIONER']; ?></td>
                          <td><?=$row['DATE_ISSUED']; ?></td>
                          <td><?=$row['DATE_UPDATED']; ?></td>
                          <td align="right">
                          <div class="btn-group">
                          <a data-mytooltip="tooltip" data-placement="top" title="PRINT" href="<?='permission-baptism-certification-pdf-print.php?PERID='.$row['PERID'];?>" class="btn bg-gradient-teal btn-sm"><i class="fa-solid fa fa-print"></i> </a>
                          <a data-mytooltip="tooltip" data-placement="top" title="EDIT " href="<?='permission-baptism-certification-update.php?PERID='.$row['PERID'];?>" class="btn bg-gradient-success btn-sm"><i class="fa-solid fa fa-edit"></i> </a>
                          <a data-mytooltip="tooltip" data-placement="top" title="DELETE" href="<?='permission-baptism-certification-delete.php?PERID='.$row['PERID'];?>" class="btn bg-gradient-danger btn-sm" onclick="return confirm('Delete this record?');"><i class="fa fa-trash"></i> </a>
                          </div>
                          </td>
                        </tr>
                      <?php
					       $cnt++;
                    }
                  ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php @include "includes/baptismal_modal.php";?>
 <?php @include "includes/footer.php";?>
</body>
</html>

