<?php @include "includes/header.php";
if(isset($_GET['q'])){
  $q =base64_decode(urldecode($_GET['q']));
  $sql = "SELECT * FROM tbl_confirmation WHERE ID = '$q'";
	$query = $conn->query($sql);
	if($query->num_rows > 0){
		$row = $query->fetch_assoc();
    $ID    	  =$row['ID'];
    $RECORD_NUMBER    	  =$row['RECORD_NUMBER'];
    $CHILD_NAME     	    =$row['CHILD_NAME'];
    $GENDER               =$row['GENDER'];
    $DATE_OF_BAPTISM      =$row['DATE_OF_BAPTISM'];
    $PLACE_OF_BAPTISM   	=$row['PLACE_OF_BAPTISM'];
    $FATHER_NAME		      =$row['FATHER_NAME'];
    $MOTHER_NAME    	    =$row['MOTHER_NAME'];
    $NAME_OF_PRIEST       =$row['NAME_OF_PRIEST'];
    $RESIDENT_OF          =$row['RESIDENT_OF'];
    $DATE_CONFIRMED       =$row['DATE_CONFIRMED'];
    $LIST_OF_SPONSORS     =$row['LIST_OF_SPONSORS'];
    $DATE_CREATED         =$row['DATE_CREATED'];
    $BOOK_NO    		      =$row['BOOK_NO'];
    $PAGE_NO    		      =$row['PAGE_NO'];
    $REG_NO    			      =$row['REG_NO'];
    $SERIES_NO    		    =$row['SERIES_NO'];
    $NOTATIONS    		    =$row['NOTATIONS'];
	
	}else{
	  header("location:confirmation.php");
	}
}
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
            <h1>Confirmed Information</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Information</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

     <!-- Main content -->
	 <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-----
          <div class="col-md-3">
            <!-- Profile Image 
            <div class="card card-maroon card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                <?php 
                  if($row['PROFILE']==""){
                  ?>
                    <img class="profile-user-img img-fluid img-circle" src="../images/profile.jpg" alt="User profile picture">
                  <?php }else{ ?>
                    <img src="data:image/jpg;charset=utf8;base64,<?=base64_encode($row['PROFILE']); ?>" width="60" height="60" class="profile-user-img img-fluid img-circle">
                  <?php }?>
                  <a href="#baptised" data-toggle="modal" class="editphoto" data-id="<?=$ID;?>"><span class="fa fa-camera"></span></a>
                </div>
                <h3 class="profile-username text-center"><?=$CHILD_NAME;?></h3>
                <p class="text-muted text-center">Record #: <?=$ID;?></p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                 Registered Number<a class="float-right"><?=$RECORD_NUMBER;?></a>
                  </li>
                </ul>
              </div>
              /.card-body 
            </div>
           
          </div>---->
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
              <h3 class="card-title"><i class="fa fa-info-circle"></i> Personal Information</h3>
              <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <table id="customers" class="table table-bordered table-striped table-hover">
                  <tr>
                    <th colspan="2">BOOK_NO: <?=$BOOK_NO;?> / PAGE_NO: <?=$PAGE_NO;?> / REG_NO: <?=$REG_NO;?> / SERIES_NO: <?=$SERIES_NO;?></th>
                    <th colspan="2">PARENTS</th>
                  </tr>
                  <tr>
                    <td width="150">Name</td>
                    <td width="400"><?=$CHILD_NAME;?></td>
                    <td width="150">Father Name </td>
                    <td width="250"><?=$FATHER_NAME;?></td>
                  </tr>
                  <tr>
                  <td>Resident of</td>
                    <td><?=$RESIDENT_OF;?></td>
                    <td>Mother Name </td>
                    <td><?=$MOTHER_NAME;?></td>
                  </tr>

                  <tr>
                  <td>Date Confirmed</td>
                    <td><?= date('l dS \o\f F Y',strtotime($DATE_CONFIRMED));?></td>
                    <th colspan="2"> SPONSORS</th>
                  </tr>
                  <tr>
                    <td> Name of Minister</td>
                    <td><?=$NAME_OF_PRIEST;?></td>
                    <td colspan="2" rowspan="4"><?=$LIST_OF_SPONSORS;?></td>
                  </tr>
                  <tr>
                    <td> Date of Baptism</td>
                    <td>
                      <?php 
                        if($DATE_OF_BAPTISM==""){
                          echo "N/A";
                        }else{
                          echo date('l dS \o\f F Y',strtotime($DATE_OF_BAPTISM));
                        }
                      ?>
                    </td>
                  </tr>

                  <tr>
                    <td> Place of Baptism</td>
                    <td><?=$PLACE_OF_BAPTISM;?></td>
                  </tr>
                  <tr>
                    <td> Date Recorded</td>
                    <td><?=$DATE_CREATED;?></td>
                  </tr>
				  <tr>
                    <td> Notations</td>
                    <td colspan="3"><?=$NOTATIONS;?></td>
                  </tr>
                </table>
              </div><!-- /.card-body -->
              <div class="card-footer text-muted">
              <div class="float-right">
        <a data-mytooltip="tooltip" data-placement="top" title="PRINT" href="<?='confirmation-certification-pdf-print.php?CONFID='.$ID;?>" target="_blank" class="btn bg-gradient-teal btn-sm"><i class="fa-solid fa fa-print"></i> Print</a>
        <a href="confirmationn_View.php?year=<?=$_GET['year'];?>" class="btn bg-gradient-success btn-sm"><i class="fa-solid fa fa-arrow-left text-white"></i> Back</a>
            </div>
          	</div>
            </div>
            <!-- /.card -->
            
          </div>
		  
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
	
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="baptised">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
			<h4 class="modal-title"> <span class="fa-solid fa fa-user"></span> Change Photo</h4>
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="baptised_profile_update.php" enctype="multipart/form-data">
				<div class="row">
				<div class="col-md-12">
                <div class="form-group">
                <input type="hidden" class="form-control" value="<?=$ID;?>" name="ID">
                    <label for="photo" class="control-label">Photo:</label>
                    <input class="form-control" name="image" type="file" id="formFileBaptised" onchange="previeww()"><br>
                   <img id="frameBaptised" src="" class="img-fluid " style="border-radius:10px">
                </div>
                </div>
               
               </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
            	<button type="submit" class="btn bg-maroon btn-sm" name="upload"><i class="fa fa-check-square-o"></i> Save</button>
            	</form>
          	</div>
        </div>
    </div>
</div>
 <?php @include "includes/footer.php";?>
<script>
      function previeww() {
        frameBaptised.src = URL.createObjectURL(event.target.files[0]);
      }
      function clearImagee() {
          document.getElementById('formFileBaptised').value = null;
          frameBaptised.src = "";
      }
  </script>

</body>
</html>

