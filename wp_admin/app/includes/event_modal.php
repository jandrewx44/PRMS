<!---FOR ADD---->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          	<div class="modal-header">
			  <h4 class="modal-title"><span class="fa fa-plus"></span> New Event</h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="events_add.php" enctype="multipart/form-data">
          		  <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group">
                             <label for="lastname" class="control-label">TITLE</label>
                            <select class="form-control" name="title" required>
                              <option value="">-- Select Title --</option>
                              <option value="MARRIAGE">MARRIAGE</option>
                              <option value="BAPTISM">BAPTISM</option>
                              <option value="MASS">MASS</option>
                              <option value="OTHERS">OTHERS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                       <div class="form-group">
                             <label for="lastname" class="control-label">DESCRIPTION</label>
                            <input type="text" class="form-control" name="description" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                       <div class="form-group">
                             <label for="lastname" class="control-label">START DATE</label>
                            <input type="date" class="form-control"  name="start_datetime" required>
                        </div>
                    </div>

                    <div class="col-sm-12">
                       <div class="form-group">
                             <label for="lastname" class="control-label">END DATE</label>
                             <input type="date" class="form-control" name="end_datetime" required>
                        </div>
                    </div>
                </div><!----row-->
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> CLOSE</button>
            	<button type="submit" class="btn bg-gradient-maroon btn-sm" name="submit"><i class="fa fa-save"></i> SUBMIT</button>
            	</form>
          	</div>
        </div>
    </div>
</div>
<!---FOR EDIT---->
<div class="modal fade" id="edit" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg card card-maroon card-outline">
        <div class="modal-content">
          	<div class="modal-header">
			  <h4 class="modal-title"><span class="fa fa-edit"></span> Edit </h4>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="events_edit.php" enctype="multipart/form-data">
          		  <div class="row">
                    <div class="col-sm-12">
                       <div class="form-group">
                             <label for="lastname" class="control-label">TITLE</label>
                             <input type="hidden" class="form-control id" name="id" required>
                            <select class="form-control" id="edit_title" name="title" required>
                              <option value="">-- Select Title --</option>
                              <option value="MARRIAGE">MARRIAGE</option>
                              <option value="BAPTISM">BAPTISM</option>
                              <option value="MASS">MASS</option>
                              <option value="OTHERS">OTHERS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                       <div class="form-group">
                             <label for="lastname" class="control-label">DESCRIPTION</label>
                            <input type="text" class="form-control" id="edit_description" name="description" required>
                        </div>
                    </div>
                    <div class="col-sm-12">
                       <div class="form-group">
                             <label for="lastname" class="control-label">START DATE</label>
                            <input type="date" class="form-control" id="edit_date" name="start_datetime" required>
                        </div>
                    </div>

                    <div class="col-sm-12">
                       <div class="form-group">
                             <label for="lastname" class="control-label">END DATE</label>
                             <input type="date" class="form-control" id="edit_time" name="end_datetime" required>
                        </div>
                    </div>

                </div><!----row-->
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> CLOSE</button>
            	<button type="submit" class="btn bg-gradient-maroon btn-sm" name="submit"><i class="fa fa-save"></i> SUBMIT</button>
            	</form>
          	</div>
        </div>
    </div>
</div>
<!---FOR DELETE---->
<div class="modal fade" id="delete_event" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"><span class="fa fa-question-circle"></span> Please Confirm</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="POST" action="events_delete.php?return=<?php echo basename($_SERVER['PHP_SELF']); ?>">
              <div class="modal-body">
                <input type="hidden" name="ID" id="delete_event_id">
                <p>Are you sure you want to delete this event?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> CLOSE</button>
                <button type="submit" class="btn btn-danger btn-sm" name="submit"><i class="fa fa-trash"></i> DELETE</button>
              </div>
            </form>
        </div>
    </div>
</div>


