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
            <h4>BAPTISM RECORDS</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">HOME</a></li>
              <li class="breadcrumb-item active">BAPTISM</li>
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
              <div class="btn-group">
              <!-- <a href="#add" data-toggle="modal" class="btn bg-gradient-maroon btn-sm"><i class="fa fa-plus"></i> NEW</a> -->
			        <a href="baptismal.php" class="btn btn-primary btn-sm"><i class="fa fa-sharp fa-solid fa-left"></i> BACK</a>
              </div>
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
                    <th>RECORD NO.</th>
                    <th>NAME OF CHILD</th>
                    <th>DATE OF BIRTH</th>
                    <th>FATHER_NAME</th>
                    <th>MOTHER_NAME</th>
                    <th>ACTIONS</th>
                  </tr>
                  </thead>
                  <tbody>
					<?php
					$ShowYear = isset($_GET['year']) ? $_GET['year'] : 'NULL';
					if($ShowYear=='NULL'){
						$sql = "SELECT * FROM tbl_baptismal WHERE DATE_OF_BIRTH='".$ShowYear."' ORDER BY CHILD_NAME ASC";
						$query = $conn->query($sql);
					}else{
						$sql = "SELECT * FROM tbl_baptismal WHERE DATE_FORMAT(DATE_OF_BIRTH, '%Y')='".$ShowYear."' ORDER BY CHILD_NAME ASC";
						$query = $conn->query($sql);
					}
                    
				    $cnt=1;
                    while($row = $query->fetch_assoc()){
                      ?>
                        <tr>
                          <td><?=$cnt; ?></td>
                          <td><?=$row['RECORD_NUMBER']; ?></td>
                          <td><?=ucwords(strtolower($row['CHILD_NAME'])); ?></td>
                          <td><?=$row['DATE_OF_BIRTH']; ?></td>
                          <td><?=ucwords(strtolower($row['FATHER_NAME'])); ?></td>
                          <td><?=ucwords(strtolower($row['MOTHER_NAME'])); ?></td>
                          <td align="right">
							            <div class="btn-group">
							              <a data-mytooltip="tooltip" data-placement="top" title="PRINT" target="_blank" href="baptism-certification-pdf_form_pdf2.php?baptismid=<?=$row['ID'];?>" class="btn bg-pink btn-sm"><i class="fa-solid fa fa-print text-white"></i> </a>
                            <a data-mytooltip="tooltip" data-placement="top" title="EDIT RECORD" href="<?='baptismal_update.php?q='.urlencode(base64_encode($row['ID']));?>&year=<?=$ShowYear;?>" class="btn btn-success btn-sm"><i class="fa-solid fa fa-edit"></i> </a>
                            <a data-mytooltip="tooltip" data-placement="top" title="VIEW RECORD" href="<?='baptismal_info.php?q='.urlencode(base64_encode($row['ID']));?>&year=<?=$ShowYear;?>" class="btn btn-primary btn-sm "><i class="fa-solid fa fa-eye"></i> </a>
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
<script>
$(function(){
 $('body').on('click','.edit',function(e){
   e.preventDefault();
   $('#editperson').modal('show');
   var id = $(this).data('id');
   getRow(id);
 });

 $('body').on('click','.delete',function(e){
   e.preventDefault();
   $('#deleted').modal('show');
   var id = $(this).data('id');
   getRow(id);
 });

 $('body').on('click','.info',function(e){
   e.preventDefault();
   $('#infoarticle').modal('show');
   var id = $(this).data('id');
   getRow(id);
 });
 

});

function getRow(id){
 $.ajax({
   type: 'POST',
   url: 'baptismal_row.php',
   data: {id:id},
   dataType: 'json',
   success: function(response){
     $('.id').val(response.ID);
     $('.empid').val(response.RECORD_NUMBER);
     $('.del_emp_name').html(response.RECORD_NUMBER);
     $('.del_emp_code').html(response.RECORD_NUMBER);

     $('#edit_emp_name').val(response.RECORD_NUMBER);

   }
 });
}
</script> 
</body>
</html>

