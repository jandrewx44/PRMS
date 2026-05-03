<?php @include "includes/header.php";?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php @include "includes/navbar.php";?>
  <?php @include "includes/sidebar.php";?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-1">
          <div class="col-sm-6">
            <h1 class="m-0">BAPTISM</h1>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12">
            <div class="btn-group btn-group-sm" role="group">
              <a href="baptismal.php?home=baptismal" class="btn btn-outline-light text-dark bg-white">Baptism</a>
              <a href="confirmation.php?home=confirmation" class="btn btn-outline-light text-dark bg-white">Confirmation</a>
              <a href="marriage.php?home=marriage" class="btn btn-outline-light text-dark bg-white">Marriage</a>
              <a href="defunctorum.php?home=defunctorum" class="btn btn-outline-light text-dark bg-white">Death</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		  
          <?php
            if(isset($_SESSION['error'])){
              echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4><i class='icon fa fa-warning'></i> ERROR!</h4>".$_SESSION['error']."</div>";
              unset($_SESSION['error']);
            }
            if(isset($_SESSION['success'])){
              echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><h4><i class='icon fa fa-check'></i> SUCCESS!</h4>".$_SESSION['success']."</div>";
              unset($_SESSION['success']);
            }
          ?>
		  
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> 
                  <div class="btn-group">
                    <a href="#add" data-toggle="modal" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> NEW</a>
                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#search_baptism_no_correction">
                      <i class="fas fa-solid fa-magnifying-glass"></i> SEARCH 
                    </button>
                  </div>
                </h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
              </div>

              <div class="card-body">
                <div class="row">
					
                <?php
                  // Pagination Logic
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

                  // Count distinct years for grouped year cards
                  $result_count = mysqli_query($conn,"SELECT COUNT(DISTINCT DATE_FORMAT(DATE_OF_BAPTISM, '%Y')) As total_records FROM tbl_baptismal");
                  $total_records_data = mysqli_fetch_array($result_count);
                  $total_records = $total_records_data['total_records'];
                  $total_no_of_pages = ceil($total_records / $total_records_per_page);
                  $second_last = $total_no_of_pages - 1;

                  // Fetch one card per year
                  $query = "SELECT COUNT(DATE_OF_BAPTISM) As tTotal, DATE_FORMAT(DATE_OF_BAPTISM, '%Y') As tDate FROM tbl_baptismal GROUP BY DATE_FORMAT(DATE_OF_BAPTISM, '%Y') ORDER BY DATE_FORMAT(DATE_OF_BAPTISM, '%Y') DESC LIMIT $offset, $total_records_per_page";
                  $result = $conn->query($query);

                  if ($result && $result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          $year = $row['tDate'] == "" ? 'NULL' : $row['tDate'];
                ?>
                    <div class="col-lg-2 col-4">
                      <div class="small-box bg-gradient-info">
                        <div class="inner">
                          <h4><?= $year; ?></h4>
                          <p><span class="badge bg-gradient-maroon"><?= $row['tTotal']; ?></span></p>
                        </div>
                        <div class="icon">
                          <i class="ion ion-person"></i>
                        </div>
                        <a href="baptismal_acView.php?year=<?= $year; ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                <?php 
                      } 
                  } else { ?>
                    <div class="alert alert-default text-center" style="width:100%">
                      <h5><i class="icon fas fa-exclamation-triangle text-warning"></i> No records found</h5>
                    </div>
                <?php } ?>

                </div>    
              </div>

              <div class="card-footer">
                <nav>
                  <ul class="pagination justify-content-center">
                    <li class='page-item'><a href='?page_no=1' class='page-link'>First</a></li>
                    <li class="page-item <?= ($page_no <= 1) ? 'disabled' : ''; ?>">
                      <a class='page-link' href="<?= ($page_no > 1) ? "?page_no=$previous_page" : '#'; ?>">Previous</a>
                    </li>

                    <?php 
                    // Dynamic Pagination Numbers
                    for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                      if ($counter == $page_no) {
                        echo "<li class='active page-item'><a class='page-link'>$counter</a></li>";	
                      } else {
                        if($counter > $page_no - 3 && $counter < $page_no + 3) {
                          echo "<li class='page-item'><a class='page-link' href='?page_no=$counter'>$counter</a></li>";
                        }
                      }
                    }
                    ?>
						
                    <li class="page-item <?= ($page_no >= $total_no_of_pages) ? 'disabled' : ''; ?>">
                      <a class='page-link' href="<?= ($page_no < $total_no_of_pages) ? "?page_no=$next_page" : '#'; ?>">Next</a>
                    </li>
                    <?php if($page_no < $total_no_of_pages) {
                      echo "<li class='page-item'><a href='?page_no=$total_no_of_pages' class='page-link'>Last</a></li>";
                    } ?>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php @include "includes/baptismal_modal.php";?>
  <?php @include "includes/footer.php";?>
</body>
</html>
