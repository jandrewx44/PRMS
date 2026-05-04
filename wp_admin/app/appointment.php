<?php include "includes/header.php";?>
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
            <h1>APPROVED APPOINTMENT</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">HOME</a></li>
              <li class="breadcrumb-item active">APPROVED</li>
            </ol>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <div class="btn-group btn-group-sm" role="group" aria-label="Appointment filters">
              <a href="appointment_pending.php?home=appointment_pending" class="btn btn-outline-light text-dark bg-white">Pending</a>
              <a href="appointment_rejected.php?home=appointment_rejected" class="btn btn-outline-light text-dark bg-white">Rejected</a>
              <a href="appointment.php?home=appointment_approved" class="btn btn-primary text-white">Approved</a>
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
             <i class="fa fa-calendar-alt"></i>
              List of Appointment
              </h3>
              <div class="card-tools">
                <form id="deleteAllForm" method="POST" action="appointment_delete_all.php" style="display:inline">
                  <input type="hidden" name="status" value="Approved">
                  <input type="hidden" name="return" value="appointment.php?home=appointment_approved">
                  <button type="button" class="btn btn-danger btn-sm" id="delete_all_btn"><i class="fa fa-trash"></i> DELETE ALL</button>
                </form>
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
                <table id="example1" class="table table-bordered table-striped table-hover table-sm">
                  <thead>
                  <tr>
                    <th>#</th> 
                    <th>STATUS</th>
					          <th>NAME</th>
                    <th>PURPOSE</th>
                    <th>MOBILE</th>
                    <th>BOOK DATE</th>
                    <th>BOOK TIME</th>
                    <th>DATE ACTION</th>
                    <th>ACTION</th>
                  </tr>
                  </thead>
                  <tbody>
					      <?php
                    $APP_STATUS="Approved";
					          $stmt=$conn->prepare("SELECT * FROM tbl_appointment WHERE APP_STATUS=? ORDER BY BOOK_DATE DESC");
                    $stmt->bind_param('s',$APP_STATUS);
                    $stmt->execute();
                    $result=$stmt->get_result();
				          	$cnt=1;
                    if($result->num_rows >0 ){
                    while($row = $result->fetch_assoc()){
                      if($row['APP_STATUS']=="Pending"){
                        $STATUS='<label class="text-warning">Pending</label>';
                       }elseif($row['APP_STATUS']=="Approved"){
                         $STATUS='<label class="text-success">Approved</label>';
                       }elseif($row['APP_STATUS']=="Completed"){
                        $STATUS='<label class="text-primary">Completed</label>';
                       }elseif($row['APP_STATUS']=="Rejected"){
                         $STATUS='<label class="text-danger">Rejected</label>';
                       }
                      ?>
                        <tr>
                          <td><?=$cnt++; ?></td>
                          <td><?=$STATUS;?></td>
						              <td style="font-size:10pt">
                          <label for=""><a href="<?='appointment_receipt.php?refnumber='.$row['AUTO_NUMBER'];?>" data-jario="tooltip" data-placement="top" title="PRINT RECEIPT">
                              [<?=$row['AUTO_NUMBER']; ?>] <?=$row['LASTNAME'].', '.$row['FIRSTNAME'].' '.$row['MIDDLENAME'];?>
                            </a></label>
                          </td>
                          <td style="text-transform: uppercase;"><?= ($row['REMARKS'] ?? '') !== '' ? $row['REMARKS'] : '—'; ?></td>
                          <td><?=$row['MOBILE']; ?></td>
                          <td><?=$row['BOOK_DATE']; ?></td>
                          <td><?=$row['BOOK_TIME']; ?></td>
                          <td><?=$row['DATE_ACTION'];?></td>
                          <td align="right">
                          <div class="btn-group">
                          <a href="appointment_information.php?appointment_information=<?=$row['APP_ID'];?>" class="btn btn-success btn-sm" data-jario="tooltip" data-placement="top" title="FULL INFORMATION"> <span class="fa fa-eye"></span></a>
                          <button 
                          data-appid="<?=$row['APP_ID'];?>" 
                          data-status="<?=$row['APP_STATUS'];?>" 
                          data-remarks="<?=$row['REMARKS'];?>" 
                          data-mobile="<?=$row['MOBILE'];?>"
                          data-date="<?=$row['BOOK_DATE'];?>" 
                          data-time="<?=$row['BOOK_TIME'];?>" 
                          data-number="<?=$row['AUTO_NUMBER'];?>"
                           data-name="<?=$row['LASTNAME'].', '.$row['FIRSTNAME']. ' '.$row['MIDDLENAME'];?>"
                          onclick="appAproved(this);" class="btn btn-primary btn-sm" data-jario="tooltip" data-placement="top" title="APPROVED"> <span class="fa fa-edit"></span></button>
                        </div>
                        </td>
                        </tr>
                      <?php
                    }
                    $stmt->close();
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
  <?php 
 @include "includes/appointment_modal.php"; 
 @include "includes/footer.php";?>

<script type="text/javascript">
     function appAproved(self) {
      var appid = self.getAttribute("data-appid");
      var type =self.getAttribute("data-status");
      var remarks =self.getAttribute("data-remarks");
      var date =self.getAttribute("data-date");
      var time =self.getAttribute("data-time");
      var number =self.getAttribute("data-number");
      var name =self.getAttribute("data-name");
      var mobile =self.getAttribute("data-mobile");
      document.getElementById("approved_appid").value = appid;
      document.getElementById("approved_return").value = window.location.pathname + window.location.search;
      document.querySelector('select[name="APP_STATUS"]').value = 'Approved';
      document.getElementsByClassName("remarks")[0].innerHTML = remarks;
      document.getElementById("sms_date").value = date;
      document.getElementById("sms_time").value = time;
      document.getElementById("sms_number").value = number;
      document.getElementById("sms_name").value = name;
      document.getElementById("sms_mobile").value = mobile;
      $("#approved_modal").modal("show");
    }
    function appReject(self) {
      var appid = self.getAttribute("data-appid");
      document.getElementById("appreject_appid").value = appid;
      $("#rejected_modal").modal("show");
  }
  document.getElementById('delete_all_btn').addEventListener('click', function(){
    Swal.fire({
      title: 'Delete All Approved?',
      text: 'This will permanently delete all approved appointments.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete all'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('deleteAllForm').submit();
      }
    });
  });
</script> 
</body>
</html>
