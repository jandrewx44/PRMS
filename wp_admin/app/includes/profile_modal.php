<!-- Add -->
<div class="modal fade" id="profile" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
			<h4 class="modal-title"> Update Profile</h4>
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="profile_update.php?return=<?php echo basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
				      <div class="row">
				        <div class="col-md-12">
                <div class="form-group">
                <input type="hidden" class="form-control" name="ID" value="<?php echo htmlspecialchars($user['ID'] ?? ''); ?>">
                    <label for="photo" class="control-label">Photo:</label>
                    <input class="form-control" name="image" type="file" id="formFile" onchange="preview()"><br>
                   <img id="frame" src="" class="img-fluid " style="border-radius:10px">
                </div>
                </div>
               
               </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
            	<button type="submit" class="btn bg-gradient-maroon btn-sm" name="upload"><i class="fa fa-check-square-o"></i> SUBMIT</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<div class="modal fade" id="logout" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Logout</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to logout now?</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fas fa-close"></i> CLOSE</button>
      <a href="logout.php" class="btn bg-gradient-maroon btn-sm"><i class="fa fa-check-square-o"></i> LOGOUT</a>
    </div>

    </div>
    <!-- /.modal-content -->
  </div>
<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="editProfile" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><span class="fa fa-edit"></span> Edit Details</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="edit_profile_update.php?return=<?php echo basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
          		  <div class="form-group">
                  	<label for="username" class="col-sm-3 control-label">USERNAME</label>

                  	<div class="col-sm-12">
                    	<input type="text" class="form-control" name="USERNAME" value="<?php echo htmlspecialchars($user['USERNAME'] ?? ''); ?>">
                  	</div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">PASSWORD</label>

                    <div class="col-sm-12"> 
                      <input type="password" class="form-control" name="PASSWORD" value="<?php echo htmlspecialchars($user['PASSWORD'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-group">
                  	<label for="firstname" class="col-sm-3 control-label">FIRST NAME</label>

                  	<div class="col-sm-12">
                    	<input type="text" class="form-control" name="FIRSTNAME" value="<?php echo htmlspecialchars($user['FIRSTNAME'] ?? ''); ?>">
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="lastname" class="col-sm-3 control-label">M.I</label>

                  	<div class="col-sm-12">
                    	<input type="text" class="form-control" name="MI" value="<?php echo htmlspecialchars($user['MI'] ?? ''); ?>">
                  	</div>
                </div>

                <div class="form-group">
                  	<label for="lastname" class="col-sm-3 control-label">LAST NAME</label>

                  	<div class="col-sm-12">
                    	<input type="text" class="form-control" name="LASTNAME" value="<?php echo htmlspecialchars($user['LASTNAME'] ?? ''); ?>">
                  	</div>
                </div>
    
                <div class="form-group">
                    <label for="curr_password" class="col-sm-12 control-label">CURRENT PASSWORD <i> input current password to save changes</i></label>

                    <div class="col-sm-12">
                      <input type="password" class="form-control" name="curr_password" placeholder="input current password to save changes" required>
                    </div>
                </div>
				
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-close"></i> CLOSE</button>
              <button type="submit" class="btn bg-gradient-maroon btn-sm" name="save"><i class="fa fa-check-square-o"></i> SUBMIT</button>
            </div>
			  </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->  
