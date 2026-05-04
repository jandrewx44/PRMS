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
            <h4>DEATH</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">HOME</a></li>
              <li class="breadcrumb-item active">DEATH</li>
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
              <a href="defunctorum.php" class="btn btn-primary btn-sm"><i class="fa fa-sharp fa-solid fa-left"></i> BACK</a>
              
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
                <table id="example1" class="table table-bordered table-striped table-hover">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>RECORD NO</th>
                    <th>NAME OF DECEASED</th>
                    <th>NAME OF PARENTS, WIFE, OR HUSBAND</th>
                    <th>ACTIONS</th>
                  </tr>
                  </thead>
                  <tbody>
					      <?php
                    $ShowYear='';
					$ShowYear = $_GET['year'];
					if($ShowYear=='NULL'){
						$sql = "SELECT * FROM tbl_death WHERE DATE_OF_DEATH IS NULL ORDER BY NAME_OF_DECEASED ASC";
						$query = $conn->query($sql);
					}else{
						$sql = "SELECT * FROM tbl_death WHERE DATE_FORMAT(DATE_OF_DEATH, '%Y')='".$ShowYear."' ORDER BY NAME_OF_DECEASED ASC";
						$query = $conn->query($sql);
					}
				          	$cnt=1;
                    while($row = $query->fetch_assoc()){
                      ?>
                        <tr>
                          <td><?=$cnt; ?></td>
                          <td><?=$row['RECORD_NO']; ?></td>
                          <td><?=ucwords(strtolower($row['NAME_OF_DECEASED'])); ?></td>
                          <td><?=ucwords(strtolower($row['PARENTS_WIFE_HUSBAND'])); ?></td>
                          <td align="right">
                            <div class="btn-group">
                            <a href="<?='defunctorum_update.php?q='.urlencode(base64_encode($row['ID']));?>&year=<?=$ShowYear;?>" class="btn btn-primary btn-sm"><i class="fa-solid fa fa-edit"></i> </a>
                            <a href="<?='defunctorum_info.php?q='.urlencode(base64_encode($row['ID']));?>&year=<?=$ShowYear;?>" class="btn btn-success btn-sm"><i class="fa-solid fa fa-eye"></i> </a>
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
 <?php @include "includes/defunctorum_modal.php";?>
 <?php @include "includes/footer.php";?>

</body>
</html>
