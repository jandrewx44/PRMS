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
                $selected_date = '';
                if (isset($_GET['date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['date'])) {
                  $selected_date = $_GET['date'];
                }

                if($selected_date !== ''){
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
                        $rows = array();

                        if($selected_date !== ''){
                          $stmt = $conn->prepare("SELECT * FROM schedule_list WHERE DATE(start_datetime) = ? ORDER BY start_datetime DESC");
                          $stmt->bind_param('s', $selected_date);
                          if ($stmt->execute()) {
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                              $rows[] = $row;
                            }
                          }
                        } else {
                          $query = $conn->query("SELECT * FROM schedule_list ORDER BY start_datetime DESC");
                          if ($query) {
                            while ($row = $query->fetch_assoc()) {
                              $rows[] = $row;
                            }
                          }
                        }

                        $i = 1;
                        if (count($rows) === 0):
                      ?>
                      <tr>
                        <td colspan="6" class="text-center text-muted">No events found.</td>
                      </tr>
                      <?php else: ?>
                      <?php foreach($rows as $row): ?>
                      <?php
                        $title = htmlspecialchars((string)$row['title'], ENT_QUOTES, 'UTF-8');
                        $description = htmlspecialchars((string)$row['description'], ENT_QUOTES, 'UTF-8');
                        $startDateValue = substr((string)$row['start_datetime'], 0, 10);
                        $endDateValue = substr((string)$row['end_datetime'], 0, 10);

                        $startDateLabel = $startDateValue !== '' ? date("M d, Y", strtotime($startDateValue)) : 'N/A';
                        $endDateLabel = $endDateValue !== '' ? date("M d, Y", strtotime($endDateValue)) : 'N/A';
                      ?>
                      <tr class="text-center">
                        <td><?php echo $i++; ?></td>
                        <td class="font-weight-bold text-maroon text-left"><?php echo $title; ?></td>
                        <td><small><?php echo $startDateLabel; ?></small></td>
                        <td><small><?php echo $endDateLabel; ?></small></td>
                        <td class="text-left"><small><?php echo $description; ?></small></td>
                        <td>
                          <button
                            type="button"
                            class="btn btn-xs btn-info edit-event"
                            data-id="<?php echo (int)$row['id']; ?>"
                            data-title="<?php echo $title; ?>"
                            data-description="<?php echo $description; ?>"
                            data-start="<?php echo htmlspecialchars($startDateValue, ENT_QUOTES, 'UTF-8'); ?>"
                            data-end="<?php echo htmlspecialchars($endDateValue, ENT_QUOTES, 'UTF-8'); ?>">
                            <i class="fa fa-edit"></i>
                          </button>
                          <button type="button" class="btn btn-xs btn-danger delete-event" data-id="<?php echo (int)$row['id']; ?>"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                      <?php endforeach; ?>
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
                      <?php endif; ?>
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
// Wire Events page buttons and form validation.
$(function(){
  function showEventMessage(title, message){
    $('#event_feedback_title').text(title);
    $('#event_feedback_body').text(message);
    $('#event_feedback_modal').modal('show');
  }

  function isDateRangeValid(startDate, endDate){
    if (!startDate || !endDate) {
      return false;
    }
    return startDate <= endDate;
  }

  function syncEndDateMin(startSelector, endSelector){
    var startDate = $(startSelector).val();
    $(endSelector).attr('min', startDate || '');
    if (startDate && $(endSelector).val() && $(endSelector).val() < startDate) {
      $(endSelector).val(startDate);
    }
  }

  $('#add').on('show.bs.modal', function(){
    var addForm = document.getElementById('add_event_form');
    if (addForm) {
      addForm.reset();
    }
    $('#add_end_date').attr('min', '');
  });

  $('#add_start_date').on('change', function(){
    syncEndDateMin('#add_start_date', '#add_end_date');
  });

  $('#edit_start_date').on('change', function(){
    syncEndDateMin('#edit_start_date', '#edit_end_date');
  });

  $('#add_event_form').on('submit', function(e){
    var startDate = $('#add_start_date').val();
    var endDate = $('#add_end_date').val();
    if (!isDateRangeValid(startDate, endDate)) {
      e.preventDefault();
      showEventMessage('Invalid Dates', 'End date must be the same as or after start date.');
    }
  });

  $('#edit_event_form').on('submit', function(e){
    var startDate = $('#edit_start_date').val();
    var endDate = $('#edit_end_date').val();
    if (!isDateRangeValid(startDate, endDate)) {
      e.preventDefault();
      showEventMessage('Invalid Dates', 'End date must be the same as or after start date.');
    }
  });

  $(document).on('click', '.edit-event', function(){
    var id = $(this).data('id');
    if(!id){
      showEventMessage('Notice', 'Unable to load event details.');
      return;
    }

    $('#edit_event_id').val(id);
    $('#edit_title').val($(this).data('title') || '');
    $('#edit_description').val($(this).data('description') || '');
    $('#edit_start_date').val($(this).data('start') || '');
    $('#edit_end_date').val($(this).data('end') || '');
    syncEndDateMin('#edit_start_date', '#edit_end_date');
    $('#edit').modal('show');
  });

  $(document).on('click', '.delete-event', function(){
    var id = $(this).data('id');
    if(!id){
      showEventMessage('Notice', 'Unable to select event for deletion.');
      return;
    }
    $('#delete_event_id').val(id);
    $('#delete_event').modal('show');
  });
});
</script>
</body>
</html>

