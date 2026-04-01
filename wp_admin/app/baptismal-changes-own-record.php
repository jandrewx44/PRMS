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
            <h4>Personal Request</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Baptism Record</li>
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
                    <th>REQUEST NO</th>
                    <th>FROM</th>
                    <th>INTO</th>
                    <th>DATE ISSUED</th>
                    <th>DATE UPDATED</th>
                    <th>ACTIONS</th>
                  </tr>
                  </thead>
                  <tbody>
					      <?php
                    $sql = "SELECT * FROM tbl_baptismal_changes";
                    $query = $conn->query($sql);
				          	$cnt=1;
                    while($row = $query->fetch_assoc()){
                      ?>
                        <tr>
                          <td><?=$cnt; ?></td>
                          <td><?=$row['AUTONUM']; ?></td>
                          <td><?=$row['NOT_ONE']; ?></td>
                          <td><?=$row['NAME_NOWBE']; ?></td>
                          <td><?=$row['DATE_ISSUED']; ?></td>
                          <td><?=$row['DATE_UPDATED']; ?></td>
                          <td align="right">
                          <div class="btn-group">
                          <a data-mytooltip="tooltip" data-placement="top" title="PRINT BAPTISM" href="<?='baptismal-changes-own-pdf-corrected.php?corrected='.$row['AUTONUM'];?>" class="btn bg-gradient-info btn-sm"><i class="text-white fas fa-sharp fa-solid fa-print"></i> </a>
                          <a data-mytooltip="tooltip" data-placement="top" title="VIEW CORRECTION" href="<?='baptismal-changes-own-pdf-print.php?AUTONUM='.$row['AUTONUM'];?>" class="btn bg-gradient-teal btn-sm"><i class="fa-solid fa fa-eye"></i> </a>
                          <a data-mytooltip="tooltip" data-placement="top" title="EDIT CORRECTION" href="<?='baptismal-changes-own-update.php?edit='.$row['ID'];?>" class="btn bg-gradient-success btn-sm"><i class="fa-solid fa fa-edit"></i> </a>
                          <a data-mytooltip="tooltip" data-placement="top" title="DELETE CORRECTION" href="<?='baptismal-changes-own-delete.php?q='.$row['ID'];?>" class="btn bg-gradient-danger btn-sm" onclick="return confirm('Delete this record?');"><i class="fa fa-trash"></i> </a>
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
 <?php include "includes/certification_modal.php";?>
 <?php @include "includes/footer.php";?>
</body>
</html>

