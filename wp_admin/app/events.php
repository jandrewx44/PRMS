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
            <h4>REMINDERS</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">HOME</a></li>
              <li class="breadcrumb-item active">REMINDERS</li>
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
              <?php
                $selected_date = isset($_GET['date']) ? $_GET['date'] : '';
                if($selected_date != ''){
                  $display_date = date('F d, Y', strtotime($selected_date));
                  echo "<div class=\"mb-2\"><strong>SCHEDULES FOR $display_date</strong> &nbsp; <a href=\"events.php\" class=\"btn btn-xs btn-default\">SHOW ALL</a></div>";
                }
              ?>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped mb-0" id="events-table">
                    <thead>
                      <tr class="bg-maroon text-center">
                        <th width="5%">#</th>
                        <th width="20%">TITLE</th>
                        <th width="20%">START DATE</th>
                        <th width="20%">END DATE</th>
                        <th width="25%">DESCRIPTION</th>
                        <th width="10%">ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        @include 'includes/conn.php';
                        $where = '';
                        if($selected_date != ''){
                          $sd = $conn->real_escape_string($selected_date);
                          $where = "WHERE DATE(start_datetime) = '{$sd}'";
                        }
                        $q = $conn->query("SELECT * FROM schedule_list {$where} ORDER BY start_datetime DESC");
                        $i = 1;
                        while($row = $q->fetch_assoc()):
                      ?>
                      <tr class="text-center">
                        <td><?php echo $i++; ?></td>
                        <td class="font-weight-bold text-maroon text-left"><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><small><?php echo date("M d, Y", strtotime($row['start_datetime'])); ?></small></td>
                        <td><small><?php echo date("M d, Y", strtotime($row['end_datetime'])); ?></small></td>
                        <td class="text-left"><small><?php echo htmlspecialchars($row['description']); ?></small></td>
                        <td>
                          <button type="button" class="btn btn-xs btn-info edit-event" data-id="<?php echo $row['id']; ?>"><i class="fa fa-edit"></i></button>
                          <button type="button" class="btn btn-xs btn-danger delete-event" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                      <?php endwhile; ?>
                      <?php for($j = $i; $j <= 10; $j++): ?>
                      <tr style="height: 45px;">
                        <td class="text-center text-muted"><?php echo $j; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <?php endfor; ?>
                    </tbody>
                  </table>
                </div>
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
  <?php include "includes/event_modal.php";?>
  <div class="modal fade" id="event_feedback_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="event_feedback_title">Notice</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="event_feedback_body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>
 <?php include "includes/footer.php";?>

 
<script>
// Wire Edit buttons to open modal and load data
$(function(){
  function showEventMessage(title, message){
    $('#event_feedback_title').text(title);
    $('#event_feedback_body').text(message);
    $('#event_feedback_modal').modal('show');
  }

  $(document).on('click', '.edit-event', function(){
    var id = $(this).data('id');
    $.ajax({
      url: 'events_row.php',
      method: 'POST',
      data: { id: id },
      dataType: 'json'
    }).done(function(row){
      if(!row || !row.id){
        showEventMessage('Notice', 'Unable to load event details.');
        return;
      }
      $('.id').val(row.id);
      $('#edit_title').val(row.title);
      $('#edit_description').val(row.description);
      $('#edit_date').val(String(row.start_datetime).split(' ')[0]);
      $('#edit_time').val(String(row.end_datetime).split(' ')[0]);
      $('#edit').modal('show');
    }).fail(function(){
      showEventMessage('Notice', 'Failed to load event.');
    });
  });

  $(document).on('click', '.delete-event', function(){
    var id = $(this).data('id');
    $('#delete_event_id').val(id);
    $('#delete_event').modal('show');
  });
});
</script>
</body>
</html>

