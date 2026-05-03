<?php @include "includes/header.php";
if(isset($_GET['q'])){
  $q =base64_decode(urldecode($_GET['q']));


  $sql = "SELECT * FROM tbl_marriage WHERE ID = '$q'";
	$query = $conn->query($sql);
	if($query->num_rows > 0){
		$row = $query->fetch_assoc();
        $ID                   =$row['ID'];
        $RECORD_NO    	      =$row['RECORD_NO'];
        $LICENSE_NO     	    =$row['LICENSE_NO'];
        $NAME_MALE  	        =$row['NAME_MALE'];
        $NAME_FEMALE   	      =$row['NAME_FEMALE'];
        $LEGAL_STATUS_MALE	  =$row['LEGAL_STATUS_MALE'];
        $LEGAL_STATUS_FEMALE  =$row['LEGAL_STATUS_FEMALE'];
        $ACTUAL_ADDRESS_MALE  =$row['ACTUAL_ADDRESS_MALE'];
        $ACTUAL_ADDRESS_FEMALE=$row['ACTUAL_ADDRESS_FEMALE'];
        $DATE_OF_BIRTH_MALE   =$row['DATE_OF_BIRTH_MALE'];
        $DATE_OF_BIRTH_FEMALE =$row['DATE_OF_BIRTH_FEMALE'];
        $POB_MALE   			    =$row['POB_MALE'];
        $POB_FEMALE           =$row['POB_FEMALE'];
        $DATE_BAPTISM_MALE    =$row['DATE_BAPTISM_MALE'];
        $DATE_BAPTISM_FEMALE  =$row['DATE_BAPTISM_FEMALE'];
        $PLACE_BAPTISM_MALE   =$row['PLACE_BAPTISM_MALE'];
        $PLACE_BAPTISM_FEMALE =$row['PLACE_BAPTISM_FEMALE'];
        $PARENTS_MALE         =$row['PARENTS_MALE'];
        $PARENTS_FEMALE       =$row['PARENTS_FEMALE'];
        $SPONSORS_MALE   			=$row['SPONSORS_MALE'];
        $SPONSORS_FEMALE      =$row['SPONSORS_FEMALE'];
        $MARRIAGE_MINISTER    =$row['MARRIAGE_MINISTER'];
        $DATE_OF_MARRIAGE     =$row['DATE_OF_MARRIAGE'];
        $BOOK_NO    		      =$row['BOOK_NO'];
        $PAGE_NO    		      =$row['PAGE_NO'];
        $REG_NO    			      =$row['REG_NO'];
        $SERIES_NO    		    =$row['SERIES_NO'];
        $NOTATIONS    		    =$row['NOTATIONS'];
	}else{
	  header("location:marriage.php");
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
            <h1>Marriage Information</h1>
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
         <!--  <div class="col-md-3">
            Profile Image 
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
            
          </div>----->
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
              <h3 class="card-title"><i class="fa fa-info-circle"></i> Contracting Parties</h3>
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
                    <th colspan="4">BOOK_NO: <?=$BOOK_NO;?> / PAGE_NO: <?=$PAGE_NO;?> / REG_NO: <?=$REG_NO;?> / SERIES_NO: <?=$SERIES_NO;?></th>
                  </tr>
                  <tr>
                    <th colspan="2">GROOM</th>
                    <th colspan="2">BRIDE</th>
                  </tr>
                  <tr>
                    <td>Name</td>
                    <td><?=$NAME_MALE;?></td>
                    <td>Name </td>
                    <td><?=$NAME_FEMALE;?></td>
                  </tr>
                  <tr>
                    <td>Legal Status</td>
                    <td><?=$LEGAL_STATUS_MALE;?></td>
                    <td>Legal Status </td>
                    <td><?=$LEGAL_STATUS_FEMALE;?></td>
                  </tr>
                  <tr>
                    <td>Actual Address</td>
                    <td><?=$ACTUAL_ADDRESS_MALE;?></td>
                    <td>Acctual Address </td>
                    <td><?=$ACTUAL_ADDRESS_FEMALE;?></td>
                  </tr>
                  <tr>
                    <td>Date of Birth</td>
                    <td><?= date('l dS \o\f F Y',strtotime($DATE_OF_BIRTH_MALE));?></td>
                    <td>Date of Birth </td>
                    <td><?= date('l dS \o\f F Y',strtotime($DATE_OF_BIRTH_FEMALE));?></td>
                  </tr>
                  <tr>
                    <td>Place of Birth</td>
                    <td><?=$POB_MALE;?></td>
                    <td>Place of Birth </td>
                    <td><?=$POB_FEMALE;?></td>
                  </tr>
                  
                  <tr>
                    <td>Date of Baptism</td>
                    <td><?= date('l dS \o\f F Y',strtotime($DATE_BAPTISM_MALE));?></td>
                    <td>Date of Baptism </td>
                    <td><?= date('l dS \o\f F Y',strtotime($DATE_BAPTISM_FEMALE));?></td>
                  </tr>
                  <tr>
                    <td>Place of Baptism</td>
                    <td><?=$PLACE_BAPTISM_MALE;?></td>
                    <td>Place of Baptism </td>
                    <td><?=$PLACE_BAPTISM_FEMALE;?></td>
                  </tr>
                  <tr>
                    <td>Parents Name</td>
                    <td><?=$PARENTS_MALE;?></td>
                    <td>Parents Name</td>
                    <td><?=$PARENTS_FEMALE;?></td>
                  </tr>
                  <tr>
                    <td>List of Sponsors</td>
                    <td><?=$SPONSORS_MALE;?></td>
                    <td>List of Sponsors </td>
                    <td><?=$SPONSORS_FEMALE;?></td>
                  </tr>
                  <tr>
                    <td>Name of Minister</td>
                    <td colspan="3"><?=$MARRIAGE_MINISTER;?></td>
                  </tr>
                  <tr>
                    <td>Date of Marriage</td>
                    <td colspan="3"><?= date('l dS \o\f F Y',strtotime($DATE_OF_MARRIAGE));?></td>
                  </tr>
				    <tr>
                    <td>Notations</td>
                    <td colspan="3"><?=$NOTATIONS;?></td>
                  </tr>
                </table>
              </div><!-- /.card-body -->
              <div class="card-footer text-muted">
              <div class="float-right">
        <a data-mytooltip="tooltip" data-placement="top" title="PRINT" href="<?='marriage-certification-pdf-print.php?MARRIAGERECORDID='.$ID.'&year='.(isset($_GET['year']) ? urlencode($_GET['year']) : '');?>" target="_blank" class="btn bg-gradient-teal btn-sm"><i class="fa-solid fa fa-print"></i> Print</a>
        <a href="<?='marriage_view.php?year='.$_GET['year'];?>" class="btn bg-gradient-maroon btn-sm"><i class="fa-solid fa fa-arrow-left text-white"></i> BACK</a>
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

