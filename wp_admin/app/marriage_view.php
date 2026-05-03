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
            <h4>MERRIAGE RECORDS</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">HOME</a></li>
              <li class="breadcrumb-item active">MARRIAGE</li>
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
			  <a href="marriage.php" class="btn btn-primary btn-sm"><i class="fa fa-sharp fa-solid fa-left"></i> BACK</a>
              <!--<a href="#add" data-toggle="modal" class="btn bg-gradient-maroon btn-sm"><i class="fa fa-plus"></i>NEW</a>-->
              <!---<a href="export/ListofBaptism_export.php" class="btn bg-gradient-success btn-sm"><i class="fa fa-file-excel"></i> Excel</a>
              <a href="export/ListofBaptism_worddoc.php" class="btn btn-primary btn-sm"><i class="fa fa-file-word"></i> Word</a>
              <a href="export/ListofBaptism_pdf.php" class="btn bg-purple btn-sm"><i class="fa fa-file-pdf"></i> PDF</a>---->
              
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
                    <th>LICENSE</th>
                    <th>CONTRACTING PARTIES</th>
                    <th>PARENTS (GROOM)</th>
                    <th>PARENTS (BRIDE)</th>
                    <th>ACTIONS</th>
                  </tr>
                  </thead>
                  <tbody>
					      <?php
						  $ShowYear='';
              $ShowYear = $_GET['year'];
              if($ShowYear=='NULL'){
                $sql = "SELECT * FROM tbl_marriage WHERE DATE_OF_MARRIAGE='".$ShowYear."' ORDER BY DATE_OF_MARRIAGE ASC";
                $query = $conn->query($sql);
              }else{
                $sql = "SELECT * FROM tbl_marriage WHERE DATE_FORMAT(DATE_OF_MARRIAGE, '%Y')='".$ShowYear."' ORDER BY DATE_OF_MARRIAGE ASC";
                $query = $conn->query($sql);
              }
				       $cnt=1;
                    while($row = $query->fetch_assoc()){
                      ?>
                        <tr>
                          <td><?=$cnt; ?></td>
                          <td><?=$row['RECORD_NO']; ?></td>
                          <td><?=$row['LICENSE_NO']; ?></td>
                          <td><?=ucwords(strtolower($row['NAME_MALE'])); ?> <br><?=ucwords(strtolower($row['NAME_FEMALE'])); ?></td>
                          <td><?=ucwords(strtolower($row['PARENTS_MALE'])); ?></td>
                          <td><?=ucwords(strtolower($row['PARENTS_FEMALE'])); ?></td>
                          <td align="right">
                            <div class="btn-group">
                            <a href="<?='marriage_update.php?q='.urlencode(base64_encode($row['ID']));?>&year=<?=$ShowYear;?>" class="btn btn-success btn-sm"><i class="fa-solid fa fa-edit"></i> </a>
                            <a href="<?='marriage_info.php?q='.urlencode(base64_encode($row['ID']));?>&year=<?=$ShowYear;?>" class="btn btn-primary btn-sm "><i class="fa-solid fa fa-eye"></i> </a>
                            <a data-mytooltip="tooltip" data-placement="top" title="PRINT" href="<?='marriage-certification-pdf-print.php?MARRIAGERECORDID='.$row['ID'].'&year='.$ShowYear;?>" target="_blank" class="btn bg-gradient-teal btn-sm"><i class="fa-solid fa fa-print"></i> </a>
                            <a data-mytooltip="tooltip" data-placement="top" title="DELETE RECORD" href="<?='marriage_delete.php?q='.$row['ID'].'&year='.$ShowYear;?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this record?');"><i class="fa-solid fa fa-trash"></i> </a>
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
 <?php @include "includes/marriage_modal.php";?>
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
   url: 'marriage_row.php',
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

