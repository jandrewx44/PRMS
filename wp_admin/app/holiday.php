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
        <div class="row mb-1">
          <div class="col-sm-6">
            <h1>MANAGE HOLIDAYS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">HOME</a></li>
              <li class="breadcrumb-item active">HOLIDAYS</li>
            </ol>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <div class="btn-group btn-group-sm" role="group" aria-label="Manage filters">
              <a href="holiday.php?home=manage_holiday" class="btn btn-primary text-white">Holiday</a>
              <a href="schedule.php?home=manage_slots" class="btn btn-outline-light text-dark bg-white">Schedule</a>
              <a href="sms.php?home=sms" class="btn btn-outline-light text-dark bg-white">SMS</a>
              <a href="requirements.php?home=requirements" class="btn btn-outline-light text-dark bg-white">Requirements</a>
              <a href="services.php?home=services" class="btn btn-outline-light text-dark bg-white">Services</a>
              <a href="contact_us.php?home=contactus" class="btn btn-outline-light text-dark bg-white">Inquiries</a>
              <a href="reviews.php" class="btn btn-outline-light text-dark bg-white">Reviews</a>
              <a href="priest.php?=priest" class="btn btn-outline-light text-dark bg-white">Priest</a>
            </div>
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
              <a href="#add" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> NEW</a>
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
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>DATE</th>
                    <th>DESCRIPTION </th>
                    <th>ACTIONS</th>
                  </tr>
                  </thead>
                  <tbody>
				        	<?php
                    $stmt=$conn->prepare("SELECT * FROM tbl_blocked_days ORDER BY blocked_date DESC");
                    if($stmt->execute()){
				        	  $cnt=1;
                    $result=$stmt->get_result();
                    if($result->num_rows>0){
                    while($row = $result->fetch_assoc()){
                      ?>
                        <tr>
                          <td><?=$cnt++; ?></td>
                          <td><?=date('Y-'.$row['blocked_date']); ?></td>
                          <td><?=$row['blocked_name']; ?></td>
                          <td align="right">
                          <div class="btn-group">
                            <button data-holid="<?=$row['id'];?>" data-blockeday="<?=$row['blocked_date'];?>" data-description="<?=$row['blocked_name'];?>" onclick="editHoliday(this);"  class="btn bg-primary btn-sm edit"><i class="fa-solid fa fa-edit"></i> </button>
                            <button data-holid="<?=$row['id'];?>" onclick="deleteHoliday(this);" class="btn btn-danger btn-sm"><i class="fa-solid fa fa-trash"></i></button>
                           </div>
                          </td>
                        </tr>
                      <?php
                    }
                  }
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
  <?php include "includes/holiday_modal.php";?>
 <?php include "includes/footer.php";?>

 <script>
  function editHoliday(self){
    var holid=self.getAttribute("data-holid");
    var blockeday=self.getAttribute("data-blockeday");
    var description=self.getAttribute("data-description");
    document.getElementById("edit_holid").value=holid;
    document.getElementById("edit_blocked_date").value=blockeday;
    document.getElementById("edit_description").value=description;
    $("#edit_holiday").modal("show");
  }

  function deleteHoliday(self){
    var holid=self.getAttribute("data-holid");
    document.getElementById("del_holid").value=holid;
    $("#delete_holiday").modal("show");
  }
</script> 
</body>
</html>

