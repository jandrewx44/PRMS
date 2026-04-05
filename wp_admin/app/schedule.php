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
            <h1>MANAGE SCHEDULE</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">HOME</a></li>
              <li class="breadcrumb-item active">SCHEDULE</li>
            </ol>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <div class="btn-group btn-group-sm" role="group" aria-label="Manage filters">
              <a href="holiday.php?home=manage_holiday" class="btn btn-outline-light text-dark bg-white">Holiday</a>
              <a href="schedule.php?home=manage_slots" class="btn btn-primary text-white">Schedule</a>
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
              <a href="#add_slot" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> NEW</a>
              <a href="#delete_all_slot" data-toggle="modal" class="btn btn-danger btn-sm ml-1"><i class="fa fa-trash"></i> DELETE ALL</a>
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
                    <th>SLOTS/AVAILABLE</th>
                    <th>SLOTS DATE</th>
                    <th>START TIME</th>
                    <th>END TIME</th>
                    <th>DURATION</th>
                    <th>ACTIONS</th>
                  </tr>
                  </thead>
                  <tbody>
				        <?php
                    $stmt=$conn->prepare("SELECT * FROM tbl_slot_date ORDER BY slots_date DESC");
                    if($stmt->execute()){
                    $result=$stmt->get_result();
				        	  $cnt=1;
                    if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                      $slots_date =$row['slots_date'];
                      $selected_time =$row['start_time'];
                      $totalbookings =$row['slots'];
                      $stmt_total=$conn->prepare("SELECT COUNT(*) as TotalBooked FROM tbl_appointment WHERE BOOK_DATE=? and BOOK_TIME=?");
                      $stmt_total->bind_param('ss',$slots_date,$selected_time);
                      $stmt_total->execute();
                      $rows_result=$stmt_total->get_result();
                      $results=$rows_result->fetch_assoc();
                      $bookingslots=(int)$results['TotalBooked'];
                      $totalbookings=(int)$totalbookings;
                      $availableSlots = max(0, $totalbookings - $bookingslots);

                      if($bookingslots >= $totalbookings || $availableSlots === 0){
                        $STATUS='<label class="text-danger">Fully Booked</label>';
                      }else{
                        $STATUS='<label class="text-primary">'.$totalbookings.'</label>/<label class="text-success">'.$availableSlots.' Available</label>';
                      }
                      ?>
                        <tr>
                          <td><?=$cnt++; ?></td>
                          <td><?=$STATUS;?></td>
                          <td><?=$row['slots_date'];?></td>
                          <td><?=$row['start_time'];?></td>
                          <td><?=$row['end_time'];?></td>
                          <td><?=$row['duration'];?></td>
                          <td align="right">
                          <div class="btn-group">
                            <button
                              data-id="<?=$row['slotid'];?>"
                              data-slots="<?=$row['slots'];?>"
                              data-date="<?=$row['slots_date'];?>"
                              data-start="<?=$row['start_time'];?>"
                              data-end="<?=$row['end_time'];?>"
                              data-duration="<?=$row['duration'];?>"
                              onclick="editSched(this);"
                              class="btn btn-primary btn-sm">
                              <i class="fa-solid fa fa-edit"></i>
                            </button>
                            <button data-slotid="<?=$row['slotid'];?>" onclick="delSched(this);" class="btn btn-danger btn-sm delete"><i class="fa-solid fa fa-trash"></i> </button>
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
  <?php include "includes/schedule_modal.php";?>
 <?php include "includes/footer.php";?>
 
 <script>
  function delSched(self){
    var slotid=self.getAttribute("data-slotid");
    document.getElementById("del_slotid").value=slotid;
    $("#sched_delete").modal("show");
  }
  function editSched(self){
    var id = self.getAttribute("data-id");
    var slots = self.getAttribute("data-slots");
    var date = self.getAttribute("data-date");
    var start = self.getAttribute("data-start");
    var end = self.getAttribute("data-end");
    var duration = self.getAttribute("data-duration");

    document.querySelector("#edit .id").value = id;
    document.getElementById("edit_slots").value = slots;
    document.getElementById("edit_slots_date").value = date;
    document.getElementById("edit_start_time").value = start;
    document.getElementById("edit_end_time").value = end;
    document.getElementById("edit_duration").value = duration;

    $("#edit").modal("show");
  }
</script> 
<script language="javascript">
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        $('.date_picker').attr('min',today);
    </script>
</body>
</html>

