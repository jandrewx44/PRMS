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
            <h1 class="m-0">COMMUNION</h1>
          </div>
          <div class="col-sm-6">
            
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <div class="btn-group btn-group-sm" role="group" aria-label="Record filters">
              <a href="baptismal.php?home=baptismal" class="btn btn-outline-light text-dark bg-white">Baptism</a>
              <a href="confirmation.php?home=confirmation" class="btn btn-outline-light text-dark bg-white">Confirmation</a>
              <a href="marriage.php?home=marriage" class="btn btn-outline-light text-dark bg-white">Marriage</a>
              <a href="communion.php?home=communion" class="btn btn-primary text-white">Communion</a>
              <a href="conversion.php?home=conversion" class="btn btn-outline-light text-dark bg-white">Conversion</a>
              <a href="defunctorum.php?home=defunctorum" class="btn btn-outline-light text-dark bg-white">Death</a>
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
              <div class="btn-group">
              <a href="#add" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> NEW</a>
             <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#search_communion">
			  <i class="fas fa-solid fa-magnifying-glass"></i> SEARCH 
			  </button>
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
                <div class="row">
					
				<?php
				$currenturl="http://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				 if (isset($_GET['page_no']) && $_GET['page_no']!="") {
					$page_no = $_GET['page_no'];
					} else {
						$page_no = 1;
						}

					$total_records_per_page = 24;
					$offset = ($page_no-1) * $total_records_per_page;
					$previous_page = $page_no - 1;
					$next_page = $page_no + 1;
					$adjacents = "2"; 

					$result_count = mysqli_query($conn,"SELECT COUNT(DISTINCT DATE_FORMAT(DATE_OF_COMMUNION, '%Y')) As total_records FROM tbl_communion");
					$total_records = mysqli_fetch_array($result_count);
					$total_records = $total_records['total_records'];
					$total_no_of_pages = ceil($total_records / $total_records_per_page);
					$second_last = $total_no_of_pages - 1; // total page minus 1
		
					$news = "SELECT COUNT(DATE_OF_COMMUNION) As tTotal, DATE_FORMAT(DATE_OF_COMMUNION, '%Y') As tDate FROM tbl_communion GROUP BY DATE_FORMAT(DATE_OF_COMMUNION, '%Y') ORDER BY DATE_FORMAT(DATE_OF_COMMUNION, '%Y') DESC LIMIT $offset, $total_records_per_page"; 
					$news_run=$conn->query($news);
					if($news_run -> num_rows >0){
					foreach($news_run as $value){
						if($value['tDate']==""){
								$group='NULL';
							}else{
								$group=$value['tDate'];
							}
					
				?>
                    	<div class="col-lg-2 col-4">
						<!-- small box -->
						<div class="small-box bg-info">
						  <div class="inner">
						  <h4><?=$group;?></h4>
							<p><span class="badge bg-gradient-maroon"><?=$value['tTotal'];?></span></p>
						  </div>
						  <div class="icon">
							<i class="ion ion-person"></i>
						  </div>
						  <a data-mytooltip="tooltip" data-placement="top" title="VIEW RECORD" href="communion_view.php?year=<?=$group;?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
						</div>
					  </div>
      
                      
					<?php } ?>
					
					<?php }else{ ?>
						<div class="alert alert-default alert-dismissible" style="width:100%;text-align:center">
						  <h5><i class="icon fas fa-exclamation-triangle text-warning"></i>no record found</h5>
						</div>
					<?php } ?>

              </div>    
				
              </div>
			  <div class="card-footer">
					 <nav aria-label="Page navigation example">
						<ul class="pagination justify-content-center">
							<li class='page-item'><a href='?page_no=1' class='page-link'>First</a></li>
							<li <?php if($page_no <= 1){ echo "class='disabled page-item'"; } ?>>
							<a class='page-link' <?php if($page_no > 1){ echo "href='?page_no=$previous_page'"; } ?>>Previous</a>
							</li>
						<?php 
						if ($total_no_of_pages <= 24){  	 
							for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
								if ($counter == $page_no) {
							   echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";	
									}else{
							   echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
									}
							}
						}
						elseif($total_no_of_pages > 24){
							
						if($page_no <= 4) {			
						 for ($counter = 1; $counter < 8; $counter++){		 
								if ($counter == $page_no) {
							   echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";	
									}else{
							   echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
									}
							}
							echo "<li class='page-item'><a class='page-link'>...</a></li>";
							echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
							echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
							}

						 elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
							echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
							echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
							echo "<li class='page-item'><a class='page-link'>...</a></li>";
							for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
							   if ($counter == $page_no) {
							   echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";	
									}else{
							   echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
									}                  
						   }
						   echo "<li class='page-item'><a class='page-link'>...</a></li>";
						   echo "<li class='page-item'><a class='page-link' href='?page_no=$second_last'>$second_last</a></li>";
						   echo "<li class='page-item'><a class='page-link' href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
								}
							
							else {
							echo "<li class='page-item'><a class='page-link' href='?page_no=1'>1</a></li>";
							echo "<li class='page-item'><a class='page-link' href='?page_no=2'>2</a></li>";
							echo "<li class='page-item'><a class='page-link'>...</a></li>";

							for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
							  if ($counter == $page_no) {
							   echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";	
									}else{
							   echo "<li class='page-item'><a href='?page_no=$counter' class='page-link'>$counter</a></li>";
									}                   
									}
								}
						}
					?>
						
						<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled page-item'"; } ?>>
						<a class='page-link' <?php if($page_no < $total_no_of_pages) { echo "href='?page_no=$next_page'"; } ?>>Next</a>
						</li>
						<?php if($page_no < $total_no_of_pages){
							echo "<li class='page-item'><a href='?page_no=$total_no_of_pages' class='page-link'>Last</a></li>";
							} ?>
						
					</ul>
					</nav>
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
 <?php @include "includes/communion_modal.php";?>
 <?php @include "includes/footer.php";?>
 <style>
  .content-wrapper .small-box {
    min-height: 70px;
    padding: 6px 8px;
  }
  .content-wrapper .small-box .inner {
    padding: 4px 4px 2px;
  }
  .content-wrapper .small-box .inner h4 {
    font-size: 16px;
    margin-bottom: 2px;
  }
  .content-wrapper .small-box .inner p {
    font-size: 11px;
    margin-bottom: 2px;
  }
  .content-wrapper .small-box .icon {
    font-size: 26px;
    top: 8px;
  }
  .content-wrapper .small-box .small-box-footer {
    padding: 2px 6px;
    font-size: 10px;
  }
 </style>
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

