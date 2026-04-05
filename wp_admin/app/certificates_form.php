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
            <h4>CERTIFICATES MENU</h4>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">HOME</a></li>
              <li class="breadcrumb-item active">CERTIFICATES</li>
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
			  <div id="accordion">
              <style>
                #accordion .card:not(.allowed-cert){display:none !important;}
              </style>
              <div class="card card-default allowed-cert">
                <div class="card-header">
                  <h4 class="card-title w-100a">
                    <a class="d-block w-100a text-uppercase">CERTIFICATE OF BAPTISM</a>
                  </h4>
                  <div class="card-tools">
                    <a href="baptism-certification-record.php" class="btn btn-tool text-primary">
                      <i class="fa fa-sharp fa-solid fa-users"></i> VIEW RECORDS
                    </a>
                    <a href="FORM-certificate-of-baptism.php" class="btn btn-tool text-primary">
                      <i class="fa fa-sharp fa-solid fa-download"></i> DOWNLOAD
                    </a>
                  </div>
                </div>
              </div>
              <div class="card card-default allowed-cert">
                <div class="card-header">
                  <h4 class="card-title w-100a">
                    <a class="d-block w-100a text-uppercase">CERTIFICATE OF CONFIRMATION</a>
                  </h4>
                  <div class="card-tools">
                    <a href="confirmation-certification-record.php" class="btn btn-tool text-primary">
                      <i class="fa fa-sharp fa-solid fa-users"></i> VIEW RECORDS
                    </a>
                    <a href="FORM-certificate-of-confirmation.php" class="btn btn-tool text-primary">
                      <i class="fa fa-sharp fa-solid fa-download"></i> DOWNLOAD
                    </a>
                  </div>
                </div>
              </div>
              <div class="card card-default allowed-cert">
                <div class="card-header">
                  <h4 class="card-title w-100a">
                    <a class="d-block w-100a text-uppercase">CERTIFICATE OF GOOD MORAL</a>
                  </h4>
                  <div class="card-tools">
                    <a href="good-moral-certification-record.php" class="btn btn-tool text-primary">
                      <i class="fa fa-sharp fa-solid fa-users"></i> VIEW RECORDS
                    </a>
                    <a href="good-moral-certification-record.php" class="btn btn-tool text-primary">
                      <i class="fa fa-sharp fa-solid fa-download"></i> DOWNLOAD
                    </a>
                  </div>
                </div>
              </div>
              <div class="card card-default allowed-cert">
                <div class="card-header">
                  <h4 class="card-title w-100a">
                    <a class="d-block w-100a text-uppercase">CERTIFICATE OF MARRIAGE</a>
                  </h4>
                  <div class="card-tools">
                    <a href="marriage-certification-record.php" class="btn btn-tool text-primary">
                      <i class="fa fa-sharp fa-solid fa-users"></i> VIEW RECORDS
                    </a>
                    <a href="FROM-certification-of-marriage-2021.php" class="btn btn-tool text-primary">
                      <i class="fa fa-sharp fa-solid fa-download"></i> DOWNLOAD
                    </a>
                  </div>
                </div>
              </div>
			  <!----START---->
				<div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseOne">
						<i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Affidavit for Partial Changes in the Baptismal
                        </a>
                      </h4>
                      <div class="card-tools">
						  <div class="btn-groups">
					  	  <!---<a href="#baptism_no_correction" class="btn btn-tool text-primary" data-toggle="modal">
						  <i class="fa fa-sharp fa-solid fa-edit text-pink"></i> NO CORRECTIONS OF BATISM
						  </a>
						  
						  <a href="#baptism_has_correction" class="btn btn-tool text-primary" data-toggle="modal">
						  <i class="fa fa-sharp fa-solid fa-edit text-warning"></i> WITH CORRECTIONS
						  </a>
						  <a href="#baptism_correction" class="btn btn-tool text-primary" data-toggle="modal">
						  <i class="fa fa-sharp fa-sharp fa-solid fa-edit text-success"></i>  LIST OF CORRECTIONS
						  </a>
						  --->
						  <a href="baptismal-changes-own-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-solid fa-users"></i> VIEW RECORDS 
						  </a>

						  <a href="FORM-affidavit-for-partial-changes-in-the-baptismal.php" class="btn btn-tool text-primary">
						  <i class="fas fa-sharp fa-solid fa-download"></i> DOWNLOAD
						  </a>
						</div>
					  </div>
                    </div>
                    <div id="collapseOne" class="collapse" data-parent="#accordion">
					<form class="form-horizontal" method="POST" action="baptismal-changes-own-save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
                         <div class="col-sm-6">
          		  		<div class="form-group">
							<span>I, the undersigned</span>
							<select name="UNDERSIGNED" type="text" class="form-control select2" data-dropdown-css-class="select2-maroon" class="form-control select2">
								<option selected>-select name-</option>
								<?php
									$sql ="SELECT * FROM tbl_baptismal ORDER BY CHILD_NAME ASC";
									$smt = $conn->query($sql);
									if($smt->num_rows >0){
										while($smt_row =$smt->fetch_assoc()){
											$child =ucwords(strtolower($smt_row['CHILD_NAME']));
											$sponsors="";
											$sponsors = $smt_row['LIST_OF_SPONSORS'];
									?>
									 
									 <option 
										 REG_NO="<?=$smt_row['REG_NO']; ?>"
										 PAGE_NO="<?=$smt_row['PAGE_NO']; ?>"
										 RESIDING="<?=ucwords(strtolower($smt_row['PERMANENT_ADDRESS']));?>"
										 SERIES_OF="<?=$smt_row['SERIES_NO'];?>"
										 CHILD_NAME="<?=ucwords(strtolower($smt_row['CHILD_NAME']));?>"
									   PLACE_OF_BIRTH="<?=ucwords(strtolower($smt_row['PLACE_OF_BIRTH']));?>"
									   DATE_OF_BIRTH="<?=$smt_row['DATE_OF_BIRTH']; ?>"
									   FATHER_NAME="<?=ucwords(strtolower($smt_row['FATHER_NAME']));?>"
									   MOTHER_NAME="<?=ucwords(strtolower($smt_row['MOTHER_NAME']));?>"
									   LIST_OF_SPONSORS="<?=strip_tags($smt_row['LIST_OF_SPONSORS']);?>"
									 value="<?=$smt_row['ID'];?>"><?=$child;?></option>
	  
										<?php } }else{ ?>
									<option>No record </option>
									<?php } ?>
							</select>
							
							
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
						<span>, of legal age, residing in </span>
                    		<input type="text" class="form-control text-capitalize RESIDING" name="RESIDING" readonly>
                  		</div>
                	</div> 
					<div class="col-sm-12">
          		  		<div class="form-group">
						<span>do hereby declare under oath that:</span>
                  		</div>
                	</div> 
					<div class="col-sm-12">
          		  		<div class="form-group">
						<span>The following changes be done and not as it appears in the Baptism </span>
                  		</div>
                	</div> 
					
				  <div class="col-sm-4">
          		  		<div class="form-group">
							<span>Register No.,</span>
                    		<input type="text" class="form-control text-capitalize REG_NO" name="REG_NO" readonly>
                  		</div>
                	</div>
					
					<div class="col-sm-4">
          		  		<div class="form-group">
						<span>Page No.</span>
                    		<input type="text" class="form-control text-capitalize PAGE_NO" name="PAGE_NO" readonly>
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
						<span>, Series of </span>
                    		<input type="text" class="form-control text-capitalize SERIES_OF" name="SERIES_OF" readonly>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
						<span>My Name shall now be </span>
                    		<input type="text" class="form-control text-capitalize CHILD_NAME" name="NAME_NOWBE">
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
						<span>and not</span>
                    		<input type="text" class="form-control text-capitalize CHILD_NAME" name="NOT_ONE" readonly>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>My Place of Birth shall now be </span>
                    		<input type="text" class="form-control text-capitalize PLACE_OF_BIRTH" name="POB">
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>and not </span>
                    		<input type="text" class="form-control text-capitalize PLACE_OF_BIRTH" name="NOT_TWO" readonly>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>My Date of Birth shall now be </span>
                    		<input type="date" class="form-control DATE_OF_BIRTH" name="DOB">
                  		</div>
                	</div> 
					
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>and not </span>
                    		<input type="date" class="form-control text-capitalize DATE_OF_BIRTH" name="NOT_THREE" readonly>
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>My Father’s Name shall now be</span>
                    		<input type="text" class="form-control text-capitalize FATHER_NAME" name="FATHER_NAME">
                  		</div>
                	</div> 
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>and not </span>
                    		<input type="text" class="form-control text-capitalize FATHER_NAME" name="NOT_FOUR" readonly>
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>My Mother’s Name shall now be </span>
                    		<input type="text" class="form-control text-capitalize MOTHER_NAME" name="MOTHER_NAME">
                  		</div>
                	</div> 
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>and not </span>
                    		<input type="text" class="form-control text-capitalize MOTHER_NAME" name="NOT_FIVE" readonly>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>My Sponsors shall now be </span>
                    		<textarea rows="8" class="form-control text-capitalize LIST_OF_SPONSORS" name="SPONSOR"></textarea>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>and not </span>
                    		<textarea rows="8" class="form-control text-capitalize LIST_OF_SPONSORS" name="NOT_SIX" readonly></textarea>
                  		</div>
                	</div>

					<div class="col-sm-12">
						<div class="form-group">
							<span>I have attached herewith the following documents: </span>
						</div>
					</div>
					<div class="col-sm-6">
                      <div class="form-group">
                          <input type="checkbox" name="BIRTH_CERT" value="YES"> <label>Birth Certificate</label><br>
                          <input type="checkbox" name="JOINT_AFFIDAVIT" value="YES"> <label>Joint Affidavit</label><br>
                      </div>
                    </div>
					<div class="col-sm-6">
                      <div class="form-group">
                          <input type="checkbox" name="MARRIAGE_CONTRACT_PARENTS" value="YES"> <label>Marriage Contract of my Parents</label><br>
                          <input type="checkbox" name="CERT_OF_BAPTISM" value="YES"> <label>Certificate of Baptism</label><br>	
                      </div>
                    </div>
					<!--<div class="col-sm-12">
						<div class="form-group">
							<span>
							( ) Birth Certificate				
							( ) Joint Affidavit
							( ) Marriage Contract of my Parents		
							( ) Certificate of Baptism
							</span>
						</div>
					</div>---->

					<div class="col-sm-12">
						<div class="form-group">
							<span>( ) Others, pls. specify 	</span>
							<input type="text" class="form-control text-capitalize" name="OTHERS" placeholder="">
						</div>
					</div>

						<div class="col-sm-12">
						<div class="form-group">
							<span>
							Negligence on the pleasantries and transcription of the Parish Secretary’s recording was perhaps the reason for this error.

							I certify that the foregoing statement is the truth and not being made for the purpose of fraud or committing any crime and that I hold myself solely liable for any consequence that may arise from any correction of the entry in the Register of Baptism. I hereunto sign this AFFIDAVIT at the Office of St.Philip Benizi Parish, Dipolog, Zamboanga del Norte, Philippines 
							</span>
						</div>
					</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>this</span>
                    		<input type="text" class="form-control" name="THIS" value="<?= date('jS');?>">
                  		</div>
                	</div> 
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>of </span>
                    		<input type="text" class="form-control" name="OF" value="<?= date('F');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
                    		<input type="text" class="form-control" name="YEAR" value="<?= date('Y');?>">
                  		</div>
                	</div>.
					
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Name of Petitioner</span>
                    		<input type="text" class="form-control text-capitalize" name="PETITIONER" placeholder="" required>
                  		</div>
                	</div>									
			
					</div>
					
                      </div>
					  <div class="card-footer">
					 <button type="submit" name="baptism_changes_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
					</div>
					</form>
                    </div>
                  </div>
				  <!----END---->
				  <!----START---->
				<div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseTwo">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Affidavit for Partial Changes in the Baptismal if Other Person
                        </a>
                      </h4>
					  <div class="card-tools">
					     <!---<a href="#baptism_hasother_correction" class="btn btn-tool text-primary" data-toggle="modal">
						  <i class="fa fa-sharp fa-solid fa-edit text-warning"></i> WITH CORRECTIONS
						  </a>
						  <a href="#baptism_other_person_correction" class="btn btn-tool text-primary" data-toggle="modal">
						  <i class="fa fa-sharp fa-sharp fa-solid fa-edit text-success"></i> LIST OF CORRECTIONS
						  </a>
						  --->
						  <a href="baptismal-changes-otherperson-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-solid fa-users"></i> VIEW RECORDS 
						  </a>
						  <a href="FROM-affidavit-for-partial-changes-in-the-baptismalif-other-person.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download text-primary"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
					<form class="form-horizontal" method="POST" action="baptismal-changes-otherperson-save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
                         <div class="col-sm-6">
          		  		<div class="form-group">
							<span>I, the undersigned</span>
							<select name="UNDERSIGNEDD" type="text" class="form-control select2" data-dropdown-css-class="select2-maroon" class="form-control select2">
								<option selected>-select name-</option>
								<?php
									$sql ="SELECT * FROM tbl_baptismal ORDER BY CHILD_NAME ASC";
									$smt = $conn->query($sql);
									if($smt->num_rows >0){
										while($smt_row =$smt->fetch_assoc()){
											$child =ucwords(strtolower($smt_row['CHILD_NAME']));
											$sponsors="";
											$sponsors = $smt_row['LIST_OF_SPONSORS'];
									?>
									 
									 <option 
										 REG_NOD="<?=$smt_row['REG_NO']; ?>"
										 PAGE_NOD="<?=$smt_row['PAGE_NO']; ?>"
										 RESIDINGD="<?=ucwords(strtolower($smt_row['PERMANENT_ADDRESS'])); ?>"
										 SERIES_OFD="<?=$smt_row['SERIES_NO'];?>"
										 CHILD_NAMED="<?=ucwords(strtolower($smt_row['CHILD_NAME'])); ?>"
									   PLACE_OF_BIRTHD="<?=ucwords(strtolower($smt_row['PLACE_OF_BIRTH'])); ?>"
									   DATE_OF_BIRTHD="<?=$smt_row['DATE_OF_BIRTH']; ?>"
									   FATHER_NAMED="<?=ucwords(strtolower($smt_row['FATHER_NAME'])); ?>"
									   MOTHER_NAMED="<?=ucwords(strtolower($smt_row['MOTHER_NAME'])); ?>"
									   LIST_OF_SPONSORSD="<?=strip_tags($smt_row['LIST_OF_SPONSORS']); ?>"
									 value="<?=$smt_row['ID'];?>"><?=$child;?></option>
	  
										<?php } }else{ ?>
									<option>No record </option>
									<?php } ?>
							</select>
							
							
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
						<span>, of legal age, residing in </span>
                    		<input type="text" class="form-control text-capitalize RESIDINGD" name="RESIDING" readonly>
                  		</div>
                	</div> 
					<div class="col-sm-12">
          		  		<div class="form-group">
						<span>do hereby declare under oath that:</span>
                  		</div>
                	</div> 
					<div class="col-sm-12">
          		  		<div class="form-group">
						<span>The following changes be done and not as it appears in the Baptism </span>
                  		</div>
                	</div> 
					
				  <div class="col-sm-4">
          		  		<div class="form-group">
							<span>Register No.,</span>
                    		<input type="text" class="form-control text-capitalize REG_NOD" name="REG_NO" readonly>
                  		</div>
                	</div>
					
					<div class="col-sm-4">
          		  		<div class="form-group">
						<span>Page No.</span>
                    		<input type="text" class="form-control text-capitalize PAGE_NOD" name="PAGE_NO" readonly>
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
						<span>, Series of </span>
                    		<input type="text" class="form-control text-capitalize SERIES_OFD" name="SERIES_OF" readonly>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
						<span>His/her Name shall now be </span>
                    		<input type="text" class="form-control text-capitalize CHILD_NAMED" name="NAME_NOWBE">
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
						<span>and not</span>
                    		<input type="text" class="form-control text-capitalize CHILD_NAMED" name="NOT_ONE" readonly>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>His/her Place of Birth shall now be  </span>
                    		<input type="text" class="form-control text-capitalize PLACE_OF_BIRTHD" name="POB">
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>and not </span>
                    		<input type="text" class="form-control text-capitalize PLACE_OF_BIRTHD" name="NOT_TWO" readonly>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>His/her Date of Birth shall now be </span>
                    		<input type="date" class="form-control text-capitalize DATE_OF_BIRTHD" name="DOB">
                  		</div>
                	</div> 
					
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>and not </span>
                    		<input type="date" class="form-control text-capitalize DATE_OF_BIRTHD" name="NOT_THREE" readonly>
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>His/her Father’s Name shall now be  </span>
                    		<input type="text" class="form-control text-capitalize FATHER_NAMED" name="FATHER_NAME">
                  		</div>
                	</div> 
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>and not </span>
                    		<input type="text" class="form-control text-capitalize FATHER_NAMED" name="NOT_FOUR" readonly>
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>His/her Mother’s Name shall now be  </span>
                    		<input type="text" class="form-control text-capitalize MOTHER_NAMED" name="MOTHER_NAME">
                  		</div>
                	</div> 
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>and not </span>
                    		<input type="text" class="form-control text-capitalize MOTHER_NAMED" name="NOT_FIVE" readonly>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>My Sponsors shall now be  </span>
                    		<textarea rows="8" class="form-control text-capitalize LIST_OF_SPONSORSD" name="SPONSOR"></textarea>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>and not </span>
                    		<textarea rows="8" class="form-control text-capitalize LIST_OF_SPONSORSD" name="NOT_SIX" readonly></textarea>
                  		</div>
                	</div>

					<div class="col-sm-12">
						<div class="form-group">
							<span>I have attached herewith the following documents: </span>
						</div>
					</div>
					<div class="col-sm-6">
                      <div class="form-group">
                          <input type="checkbox" name="BIRTH_CERT" value="YES"> <label>Birth Certificate</label><br>
                          <input type="checkbox" name="JOINT_AFFIDAVIT" value="YES"> <label>Joint Affidavit</label><br>
                      </div>
                    </div>
					<div class="col-sm-6">
                      <div class="form-group">
                          <input type="checkbox" name="MARRIAGE_CONTRACT_PARENTS" value="YES"> <label>Marriage Contract of my Parents</label><br>
                          <input type="checkbox" name="CERT_OF_BAPTISM" value="YES"> <label>Certificate of Baptism</label><br>	
                      </div>
                    </div>


					<div class="col-sm-12">
						<div class="form-group">
							<span>( ) Others, pls. specify 	</span>
							<input type="text" class="form-control text-capitalize" name="OTHERS" placeholder="">
						</div>
					</div>

						<div class="col-sm-12">
						<div class="form-group">
							<span>
							Negligence on the pleasantries and transcription of the Parish Secretary’s recording was perhaps the reason for this error.

							I certify that the foregoing statement is the truth and not being made for the purpose of fraud or committing any crime and that I hold myself solely liable for any consequence that may arise from any correction of the entry in the Register of Baptism. I hereunto sign this AFFIDAVIT at the Office of St.Philip Benizi Parish, Dipolog, Zamboanga del Norte, Philippines 
							</span>
						</div>
					</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>this</span>
                    		<input type="text" class="form-control" name="THIS" value="<?= date('jS');?>">
                  		</div>
                	</div> 
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>of </span>
                    		<input type="text" class="form-control" name="OF" value="<?= date('F');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
                    		<input type="text" class="form-control" name="YEAR" value="<?= date('Y');?>">
                  		</div>
                	</div>.
					
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Name of Petitioner</span>
                    		<input type="text" class="form-control text-capitalize" name="PETITIONER" placeholder="" required>
                  		</div>
                	</div>									
			
					</div>
					
                      </div>
					  <div class="card-footer">
					  <button type="submit" name="other_person_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
					</div>
					</form>
                      </div><!---ACORDION--->
                    </div>
                  <!----END---->
				  <!----START---->
                  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseThree">
                         <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Affidavit Letter of Request for Partial Changes
                        </a>
                      </h4>
					  <div class="card-tools">
						<!---<a href="#find_request" class="btn btn-tool text-primary" data-toggle="modal">
						  <i class="fas fa-sharp fa-solid fa-nfc-magnifying-glass text-success"></i>  SEARCH REQUEST
						  </a>
						  --->
						  <a href="baptism_letter_of_request-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-solid fa-users"></i>  VIEW RECORDS
						  </a>
						  <a href="FORM-affidavit-letter-of-request-for-partial-changes.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download text-primary"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                      <form class="form-horizontal" method="POST" action="baptism_letter_of_request_save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
                      <div class="col-sm-12">
						<div class="form-group">
							<span>
								His Excellency<br>
								<strong>MOST REV. JULITO B. CORTES, D.D.</strong><br>
								Bishop of Dipolog<br>
								Office of the Bishop, 2/F Diocesan Pastoral Center<br>
								Dipolog City, Zamboanga del Norte, Philippines<br>
							</span>
						</div>
					</div>  

					<div class="col-sm-12">
					<span>I, the undersigned </span>
					<div class="input-group mb-3">
					<div class="input-group-prepend">
					<button type="button" class="form-control btn bg-gradient-maroon btn-sm" data-toggle="modal" data-target=".REQUEST_FOR_PARTIAL">
					<i class="fa fa-plus fa-fade"></i> PICK A NAME
							</button>
					</div>
						<input type="text" class="form-control text-capitalize PICK_NAME" name="MY_NAME" required>
					</div>
					</div>
					
					<div class="col-sm-12">
					<span>Parish Priest/ Team Moderator/ Parochial Vicar/ Team Minister/ Priest in Charge of St.Philip Benizi Parish, do hereby respectfully request Your Excellency to issue a written decree authorizing me to effect in accordance with the affidavit hereto attached the necessary changes or correction in the record of Baptism of </span>	
					<div class="input-group mb-3">
					<div class="input-group-prepend">
					<button type="button" class="form-control btn bg-gradient-maroon btn-sm" data-toggle="modal" data-target=".REQUEST_FOR_PARTIAL_">
								<i class="fa fa-plus fa-fade"></i> PICK A NAME
					</button>
					</div>
					<input type="text" class="form-control text-capitalize PICK_NAME_OF" name="NAME_OF" required>
					</div>
					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<span>The changes to be made are as follows: </span>
						</div>
					</div>
					
					<div class="col-sm-6">
                      <div class="form-group">
                          <input type="checkbox" name="CNAME" value="YES"> <label>Name</label><br>
                          <input type="checkbox" name="CFNAME" value="YES"> <label>Father’s Name</label><br>
                          <input type="checkbox" name="CMNAME" value="YES"> <label>Mother’s Name</label><br>	
                      </div>
                    </div>
					<div class="col-sm-6">
                      <div class="form-group">
                          <input type="checkbox" name="CPOB" value="YES"> <label>Place of Birth</label><br>
                          <input type="checkbox" name="CDOB" value="YES"> <label>Date of Birth</label><br>
                          <input type="checkbox" name="CSPONSORS" value="YES"> <label>Sponsors</label><br>		
                      </div>
                    </div>
					
						<div class="col-sm-12">
						<div class="form-group">
							<span>
							Sincerely imploring your favorable response to this request, ever willing to abide Your Excellency pastoral decision and seeking for your blessing.
							</span>
						</div>
					</div>
					</div>
					
                      </div>
					  <div class="card-footer">
					  <button type="submit" name="request_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
					</div>
					</form>
                    </div>
                  </div>
				  <!----END---->
				  <!----START---->
				  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseFour">
                         <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Certificate of Attendace Pre-Cana
                        </a>
                      </h4>
					  <div class="card-tools">
					  <a href="pre-cana-attendance-record.php" class="btn btn-tool text-primary">
					  <i class="fa fa-solid fa-users"></i> VIEW RECORDS
						  </a>
						  <a href="FORM-certificate-of-attendace-pre-cana.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseFour" class="collapse" data-parent="#accordion">
	
					<form class="form-horizontal" method="POST" action="pre-cana-attendance_save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">

					<div class="col-sm-6">
					<span>Name of Groom</span>
					<div class="input-group mb-3">
					<div class="input-group-prepend">
					<button type="button" class="form-control btn bg-gradient-maroon btn-sm" data-toggle="modal" data-target=".find_groom">
							<i class="fa fa-plus fa-fade"></i> GROOM
						</button>
					</div>
					<input type="text" class="form-control text-capitalize GROOM" name="GROOM" required>	
					</div>
					</div>

					<div class="col-sm-6">
					<span>Name of Bride </span>
					<div class="input-group mb-3">
					<div class="input-group-prepend">
					<button type="button" class="form-control btn bg-gradient-maroon btn-sm" data-toggle="modal" data-target=".find_bride">
							<i class="fa fa-plus fa-fade"></i> BRIDE
						</button>
					</div>
					<input type="text" class="form-control text-capitalize BRIDE" name="BRIDE" required>
					</div>
					</div>

					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Groom Residence </span>
                    		<input type="text" class="form-control text-capitalize GROOM_ADDRESS" name="G_RESIDENCE">
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Bride Residence </span>
                    		<input type="text" class="form-control text-capitalize BRIDE_ADDRESS" name="B_RESIDENCE">
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Groom Age </span>
							 <select class="form-control" name="G_AGE" required>
				            	<option value="" selected disabled>-Select-</option>
								  <?php 
								  for($value = 1; $value <= 100; $value++){ 
									echo('<option value="' . $value . '">' . $value . '</option>');
								  }
								  ?>
							</select>
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Bride Age </span>

							<select class="form-control" name="B_AGE" required>
				            	<option value="" selected disabled>-Select-</option>
								  <?php 
								  for($value = 1; $value <= 100; $value++){ 
									echo('<option value="' . $value . '">' . $value . '</option>');
								  }
								  ?>
							</select>
                  		</div>
                	</div>
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Who desire to get married</span>
                  		</div>
                	</div>
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>On </span>
                    		<input type="date" class="form-control" name="ON_MARRIED" required>
                  		</div>
                	</div>
					
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>At </span>
                    		<input type="text" class="form-control text-capitalize" name="AT_MARRIED">
                  		</div>
                	</div>
					
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Have received the Pre-Cana Formation Program of the Parish</span>
                  		</div>
                	</div>
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>On</span>
                    		<input type="date" class="form-control" name="ON_PARISH" required>
                  		</div>
                	</div>
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>At</span>
                    		<input type="text" class="form-control text-capitalize" name="AT_PARISH">
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>In witness thereof, here unto I affixed my signature and the seal of the parish this </span>
                  		</div>
                	</div>
					<div class="col-sm-2">
          		  		<div class="form-group">
							<input type="text" class="form-control text-capitalize" name="THIS" value="<?=date('jS');?>">
                  		</div>
                	</div>
					<div class="col-sm-1">
          		  		<div class="form-group">
							<span>day of</span>
                  		</div>
                	</div>
					<div class="col-sm-2">
          		  		<div class="form-group">
							<input type="text" class="form-control text-capitalize" name="OF" value="<?=date('F');?>">
                  		</div>
                	</div>
					
					<div class="col-sm-1">
          		  		<div class="form-group">
							<input type="text" class="form-control text-capitalize" name="YEAR" value="<?= date('Y');?>">
                  		</div>
                	</div>
					
					</div>
                      </div>
					  <div class="card-footer">
					  <button type="submit" name="precana_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
					</div>
					</form>
                    </div>
                  </div>
				  <!----END---->
				  <!----START---->
				  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseFive">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Certificate of Attendace Pre-Jordan
                        </a>
                      </h4>
					  <div class="card-tools">

						  <a href="pre-jordan-attendance-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-solid fa-users"></i>  VIEW RECORDS 
						  </a>
						  <a href="FORM-certificate-of-attendace-pre-jordan.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download text-primary"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseFive" class="collapse" data-parent="#accordion">
					<form class="form-horizontal" method="POST" action="pre-jordan-attendance_save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
						
					<div class="col-sm-12">
					<span>Certificate of attendance to </span>
					<div class="input-group mb-3">
					<div class="input-group-prepend">
					<button type="button" class="form-control btn bg-gradient-maroon btn-sm" data-toggle="modal" data-target=".select_jordan">
							<i class="fa fa-plus fa-fade"></i> PICK NAME
						</button>
					</div>
					<input type="text" class="form-control text-capitalize PICK_JORDAN" name="CERTIFICATE_TO" required>	
					</div>
					</div>

					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Conducted by the Family Life Apostolate Of the Parish of St.Philip Benizi Parish</span>
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>On </span>
                    		<input type="date" class="form-control" name="CERTIFICATE_ON" required>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>At </span>
                    		<input type="text" class="form-control text-capitalize" name="CERTIFICATE_AT">
                  		</div>
                	</div>
				
					<div class="col-sm-4">
          		  		<div class="form-group">
							 <span>Given this </span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_THIS" value="<?=date('jS');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>day of</span>
							<input type="text" class="form-control text-capitalize" name="DAY_OF" value="<?=date('F');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
							<input type="text" class="form-control text-capitalize" name="YEAR" value="<?= date('Y');?>">
                  		</div>
                	</div>
					
					</div>
                      </div>
					  <div class="card-footer">
					  <button type="submit" name="prejordan_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
					</div>
					</form>
                    </div>
                  </div>
				  <!----END---->
				  <!----START---->
				  
				  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseSix">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Certificate of Baptism
                        </a>
                      </h4>
					  <div class="card-tools">
					  	<a href="baptism-certification-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-users"></i> VIEW RECORDS
						  </a>
						  <a href="FORM-certificate-of-baptism.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseSix" class="collapse" data-parent="#accordion">
					<form class="form-horizontal" method="POST" action="baptism-certification-save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
						
					<div class="col-sm-6">
					<span>Name of Child </span>
					<div class="input-group mb-3">
					<div class="input-group-prepend">
						<button type="button" class="form-control btn bg-gradient-maroon btn-sm" data-toggle="modal" data-target=".select_name_baptism">
							<i class="fa fa-plus fa-fade"></i> PICK NAME
						</button>
					</div>
					<input type="text" class="form-control text-capitalize PICK_BAPTISM_NAME" name="CHILDNAME" required>	
					</div>
					</div>

					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Date of Birth</span>
							<input type="date" class="form-control PICK_BAPTISM_DOB" name="DOB">	
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Place of Birth</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_POB" name="POB">	
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Name of Father</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_FATHER" name="FATHER">	
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Maiden Name of Mother</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_MOTHER" name="MOTHER">	
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Address of Parents</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_PARENTS_ADDRESS" name="PARENTS_ADDRESS">	
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Name of Church</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_CHURCH_NAME" name="CHURCH_NAME">	
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Address of Parish</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_CHURCH_ADDRESS" name="CHURCH_ADDRESS">	
                  		</div>
                	</div>

					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Date of Baptism</span>
							<input type="date" class="form-control PICK_BAPTISM_DOB_BAPTISM" name="DOB_BAPTISM" required>	
                  		</div>
                	</div>

					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Baptized by</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_BAPTIZED_BY" name="BAPTIZED_BY">	
                  		</div>
                	</div>

					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Sponsors</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_SPONSORS" name="SPONSORS">	
                  		</div>
                	</div>

					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Notations:</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_NOTATIONS" name="NOTATIONS">	
                  		</div>
                	</div>

					<div class="col-sm-4">
          		  		<div class="form-group">
							 <span>Given this </span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_DAY" value="<?=date('jS');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>day of</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_MONTH" value="<?=date('F');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_YEAR" value="<?=date('Y');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Book No.</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_BOOK_NO" name="BOOK_NO">
                  		</div>
                	</div>

					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Page No.</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_PAGE_NO" name="PAGE_NO">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Reg. No.</span>
							<input type="text" class="form-control text-capitalize PICK_BAPTISM_REG_NO" name="REG_NO">
                  		</div>
                	</div>

					
					
					</div>
                      </div>
					   <div class="card-footer">
					  	<button type="submit" name="baptism_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
						</div>
					</form>
                    </div>
                  </div>
				  
				  <!----END---->
				  <!----START---->
				  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseSeven">
                         <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Certificate of Confirmation
                        </a>
                      </h4>
					  <div class="card-tools">
					  	<a href="confirmation-certification-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-users"></i> VIEW RECORDS
						  </a>
                          <a href="FORM-certificate-of-confirmation.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseSeven" class="collapse" data-parent="#accordion">
					<form class="form-horizontal" method="POST" action="confirmation-certification-save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
						
					<div class="col-sm-6">
					<span>Name of Confirmand</span>
					<div class="input-group mb-3">
					<div class="input-group-prepend">
						<button type="button" class="form-control btn bg-gradient-maroon btn-sm" data-toggle="modal" data-target=".select_name_confirm">
							<i class="fa fa-plus fa-fade"></i> PICK NAME
						</button>
					</div>
					<input type="text" class="form-control text-capitalize PICK_CONFIRM_NAME" name="CHILDNAME" required>	
					</div>
					</div>

					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Date of Baptism</span>
							<input type="date" class="form-control PICK_CONFIRM_DOB_BAPTISM" name="DOB_BAPTISM">	
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Place of Baptism</span>
							<input type="text" class="form-control text-capitalize PICK_CONFIRM_PLACE_OF_BAPTISM" name="PLACE_OF_BAPTISM">	
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Name of Father</span>
							<input type="text" class="form-control text-capitalize PICK_CONFIRM_FATHER" name="FATHER">	
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Maiden Name of Mother</span>
							<input type="text" class="form-control text-capitalize PICK_CONFIRM_MOTHER" name="MOTHER">	
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Address of Parents</span>
							<input type="text" class="form-control text-capitalize PICK_CONFIRM_PARENTS_ADDRESS" name="PARENTS_ADDRESS">	
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Name of Church</span>
							<input type="text" class="form-control text-capitalize" name="CHURCH_NAME">	
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Address of Parish</span>
							<input type="text" class="form-control text-capitalize" name="CHURCH_ADDRESS">	
                  		</div>
                	</div>

					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Date of Confirmation</span>
							<input type="date" class="form-control PICK_CONFIRM_CONFIRMED_DATE" name="CONFIRMED_DATE">	
                  		</div>
                	</div>

					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Confirmed by</span>
							<input type="text" class="form-control text-capitalize PICK_CONFIRM_CONFIRMED_BY" name="CONFIRMED_BY">	
                  		</div>
                	</div>

					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Sponsors</span>
							<input type="text" class="form-control text-capitalize PICK_CONFIRM_SPONSORS" name="SPONSORS">	
                  		</div>
                	</div>

					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Notations:</span>
							<input type="text" class="form-control text-capitalize PICK_CONFIRM_NOTATIONS" name="NOTATIONS">	
                  		</div>
                	</div>

					<div class="col-sm-4">
          		  		<div class="form-group">
							 <span>Given this </span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_DAY" value="<?=date('jS');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>day of</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_MONTH" value="<?=date('F');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_YEAR" value="<?=date('Y');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Book No.</span>
							<input type="text" class="form-control text-capitalize PICK_CONFIRM_BOOK_NO" name="BOOK_NO">
                  		</div>
                	</div>

					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Page No.</span>
							<input type="text" class="form-control text-capitalize PICK_CONFIRM_PAGE_NO" name="PAGE_NO">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Reg. No.</span>
							<input type="text" class="form-control text-capitalize PICK_CONFIRM_REG_NO" name="REG_NO">
                  		</div>
                	</div>

					
					
					</div>
                      </div>
					   <div class="card-footer">
					  	<button type="submit" name="confirm_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
						</div>
					</form>
                    </div>
                  </div>
				  
				  <!----END---->
				  <!----START---->
				  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseEight">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Certificate of Good moral
                        </a>
                      </h4>
					  <div class="card-tools">
					  <a href="good-moral-certification-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-users"></i> VIEW RECORDS
						  </a>
						  <a href="FORM-certificate-of-good-moral.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseEight" class="collapse" data-parent="#accordion">
                    
					<form class="form-horizontal" method="POST" action="good-moral-certification-save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
					
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Name</span>
							<input type="text" class="form-control text-capitalize" name="CHILDNAME" required>	
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Name of Father</span>
							<input type="text" class="form-control text-capitalize" name="FATHER">	
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Name of Mother</span>
							<input type="text" class="form-control text-capitalize" name="MOTHER">	
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Address of Parents</span>
							<input type="text" class="form-control text-capitalize" name="PARENTS_ADDRESS">	
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>He/She finished his/her in</span>
							<input type="text" class="form-control text-capitalize" name="FINISHED_IN">	
                  		</div>
                	</div>

					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>On</span>
							<input type="Text" class="form-control text-capitalize" name="MONTH" value="<?=date('F');?>">	
                  		</div>
                	</div>

					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>Year</span>
							<input type="text" class="form-control text-capitalize" name="YEAR" value="<?=date('Y');?>">	
                  		</div>
                	</div>

					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Degree of</span>
							<input type="text" class="form-control text-capitalize" name="DEGREE_OF">	
                  		</div>
                	</div>

					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>This certification is issued upon his/her request for </span>
							<input type="text" class="form-control text-capitalize" name="REQUEST_FOR">	
                  		</div>
                	</div>

					<div class="col-sm-4">
          		  		<div class="form-group">
							 <span>Given this </span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_DAY" value="<?=date('jS');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>day of</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_MONTH" value="<?=date('F');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_YEAR" value="<?=date('Y');?>">
                  		</div>
                	</div>
					
					
					
					</div>
                      </div>
					   <div class="card-footer">
					  	<button type="submit" name="moral_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
						</div>
					</form>

                    </div>
                  </div>
				  <!----END---->
				  <!----START---->
				  
				  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseNine">
                         <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Certificate of Marriage
                        </a>
                      </h4>
					  <div class="card-tools">
					 	 <a href="marriage-certification-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-solid fa-users"></i> VIEW RECORDS 
						  </a>
						  <a href="FROM-certification-of-marriage-2021.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download text-primary"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseNine" class="collapse" data-parent="#accordion">
					<form class="form-horizontal" method="POST" action="marriage-certification-save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">

					<div class="col-sm-6">
					<span>Name of Groom</span>
					<div class="input-group mb-3">
					<input type="text" class="form-control text-capitalize GROOM_NAME" name="GROOM_NAME" required>
					<div class="input-group-prepend">
					<button type="button" class="form-control btn bg-gradient-maroon btn-sm" data-toggle="modal" data-target=".find_groom_marriage">
							<i class="fa fa-plus fa-fade"></i> GROOM
						</button>
					</div>
						
					</div>
					</div>

					<div class="col-sm-6">
					<span>Name of Bride </span>
					<div class="input-group mb-3">
					<input type="text" class="form-control text-capitalize BRIDE_NAME" name="BRIDE_NAME" required>
					<div class="input-group-prepend">
					<button type="button" class="form-control btn bg-gradient-maroon btn-sm" data-toggle="modal" data-target=".find_bride_marriage">
							<i class="fa fa-plus fa-fade"></i> BRIDE
						</button>
					</div>
					
					</div>
					</div>

					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Groom Residence </span>
                    		<input type="text" class="form-control text-capitalize GROOM_RESIDENCE" name="GROOM_RESIDENCE">
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Bride Residence </span>
                    		<input type="text" class="form-control text-capitalize BRIDE_RESIDENCE" name="BRIDE_RESIDENCE">
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Groom Name of Father </span>
							<input type="text" class="form-control text-capitalize GROOM_FATHER" name="GROOM_FATHER">
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Bride Name of Father  </span>
							<input type="text" class="form-control text-capitalize BRIDE_FATHER" name="BRIDE_FATHER">
                  		</div>
                	</div>

					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Groom Maiden Name of Mother </span>
							<input type="text" class="form-control text-capitalize GROOM_MOTHER" name="GROOM_MOTHER">
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Bride Maiden Name of Mother  </span>
							<input type="text" class="form-control text-capitalize BRIDE_MOTHER" name="BRIDE_MOTHER">
                  		</div>
                	</div>

					<div class="col-sm-12">
          		  		<div class="form-group">
							<label>Were solemnly married according to the Rites of the Roman Catholic Church</label>
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Place of Marriage </span>
                    		<input type="text" class="form-control PLACE_OF_MARRIAGE" name="PLACE_OF_MARRIAGE" required>
                  		</div>
                	</div>
					
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Date of Marriage </span>
                    		<input type="date" class="form-control DATE_OF_MARRIAGE" name="DATE_OF_MARRIAGE">
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Name of Witness(es)</span>
                    		<input type="text" class="form-control text-capitalize" name="NAME_OF_WITNESS">
                  		</div>
                	</div>
					<div class="col-sm-6">
          		  		<div class="form-group">
							<span>Solemnizing Priest</span>
                    		<input type="text" class="form-control text-capitalize" name="SOLEMNIZING_PRIEST">
                  		</div>
                	</div>
	
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Given Day</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_DAY" value="<?=date('jS');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Month</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_MONTH" value="<?=date('F');?>">
                  		</div>
                	</div>
					
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_YEAR" value="<?= date('Y');?>">
                  		</div>
                	</div>
					
					</div>
                      </div>
					  <div class="card-footer">
					  <button type="submit" name="marriage_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
					</div>
					</form>
                    </div>
                  </div>
				  
				  <!----END---->
				  <!----START---->
				  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseTen">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> No Record of Baptism
                        </a>
                      </h4>
					  <div class="card-tools">
						  <a href="no-baptism-record-certification-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-solid fa-users"></i> VIEW RECORDS 
						  </a>
						  <a href="FORM-no-record-of-baptism.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download text-primary"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseTen" class="collapse" data-parent="#accordion">
					<form class="form-horizontal" method="POST" action="no-baptism-record-certification-save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>This is to certify that</span>
							<input type="text" class="form-control text-capitalize" name="NO_BAP_NAME" required>
							<span>has no record of BAPTISM in our parish, hence we cannot issue upon a certificate of baptism as humbly requested.</span>
                  		</div>
                	</div>
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>This certification is issued upon the request of </span>
							<input type="text" class="form-control text-capitalize" name="NO_BAP_REQUEST_OF" required>
							<span>for whatever purposes it may serve him/her best.</span>
                  		</div>
                	</div>

					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Given Day</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_DAY" value="<?=date('jS');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Month</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_MONTH" value="<?=date('F');?>">
                  		</div>
                	</div>
					
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_YEAR" value="<?= date('Y');?>">
                  		</div>
                	</div>
					
					</div>
                      </div>
					  <div class="card-footer">
					  <button type="submit" name="nobaptism_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
					</div>
					</form>
                    </div>
                  </div>
				  
				  <!----END---->
				  <!----START---->
				  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseEleven">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> No Record of Confirmation
                        </a>
                      </h4>
					  <div class="card-tools">
					  <a href="no-confirmation-record-certification-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-solid fa-users"></i> VIEW RECORDS 
						  </a>
						  <a href="FORM-NO-RECORD-OF-CONFIRMATION.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download text-primary"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseEleven" class="collapse" data-parent="#accordion">
					<form class="form-horizontal" method="POST" action="no-confirmation-record-certification-save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>This is to certify that</span>
							<input type="text" class="form-control text-capitalize" name="NO_BAP_NAME" required>
							<span>has no record of CONFIRMATION in our parish, hence we cannot issue upon a certificate of baptism as humbly requested.</span>
                  		</div>
                	</div>
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>This certification is issued upon the request of  </span>
							<input type="text" class="form-control text-capitalize" name="NO_BAP_REQUEST_OF" required>
							<span>for whatever purposes it may serve him/her best.</span>
                  		</div>
                	</div>

					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Given Day</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_DAY" value="<?=date('jS');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Month</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_MONTH" value="<?=date('F');?>">
                  		</div>
                	</div>
					
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_YEAR" value="<?= date('Y');?>">
                  		</div>
                	</div>
					
					</div>
                      </div>
					  <div class="card-footer">
					  <button type="submit" name="noconfirmation_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
					</div>
					</form>
                    </div>
                  </div>
				  
				  <!----END---->
				  <!----START---->
				  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseTwelve">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Permission for Baptism
                        </a>
                      </h4>
					  <div class="card-tools">
					  	<a href="permission-baptism-certification-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-solid fa-users"></i> VIEW RECORDS 
						  </a>
						  <a href="FORM-permission-for-BAPTISM.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download text-primary"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseTwelve" class="collapse" data-parent="#accordion">
					<form class="form-horizontal" method="POST" action="permission-baptism-certification-save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>1. </span>
							<input type="text" class="form-control text-capitalize" style="border-bottom:1px solid #000" name="ENTRY_ONE">
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>2. </span>
							<input type="text" class="form-control text-capitalize" style="border-bottom:1px solid #000" name="ENTRY_TWO">
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>3. </span>
							<input type="text" class="form-control text-capitalize" style="border-bottom:1px solid #000" name="ENTRY_THREE">
                  		</div>
                	</div>
					<div class="col-sm-3">
          		  		<div class="form-group">
							<span>4.</span>
							<input type="text" class="form-control text-capitalize" style="border-bottom:1px solid #000" name="ENTRY_FOUR">
                  		</div>
                	</div>

					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Dear Rev. Fr. </span>
							<input type="text" class="form-control text-capitalize" name="PRIEST_NAME" required>
                  		</div>
                	</div>
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>This is to respectfully grant our parishioner, </span>
							<input type="text" class="form-control text-capitalize" name="PARISHIONER" required>
							<span>to have the baptism of his/ her child </span>
                  		</div>
                	</div>
					<div class="col-sm-12">
          		  		<div class="form-group">
							<input type="text" class="form-control text-capitalize" name="CHILDNAME" required>
							<span>administered in your Church.</span>
                  		</div>
                	</div>

					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Please do the necessary things that need to be done so the said parishioner complies with the requirements prescribed in the Code of Canon Law and our Diocesan Statutes. </span>
                  		</div>
                	</div>

					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Given Day</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_DAY" value="<?=date('jS');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Month</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_MONTH" value="<?=date('F');?>">
                  		</div>
                	</div>
					
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_YEAR" value="<?= date('Y');?>">
                  		</div>
                	</div>
					
					</div>
                      </div>
					  <div class="card-footer">
					  <button type="submit" name="permession_baptism_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
					</div>
					</form>
                    </div>
                  </div>
				  <!----END---->
				  <!----START---->
				  <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseThrten">
                         <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> Permission for MARRIAGE OUTSIDE THE PARISH
                        </a>
                      </h4>
					  <div class="card-tools">
					  <a href="marriage-outside-certification-record.php" class="btn btn-tool text-primary">
						  <i class="fa fa-solid fa-users"></i> VIEW RECORDS 
						  </a>
						  <a href="FORM-permission-for-MARRIGE-OUTSIDE-THE-PARISH.php" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-download text-primary"></i> DOWNLOAD
						  </a>
					  </div>
                    </div>
                    <div id="collapseThrten" class="collapse" data-parent="#accordion">
					<form class="form-horizontal" method="POST" action="marriage-outside-certification-save.php?return=<?=basename($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                      <div class="card-body">
					<div class="row">
					

					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>Dear Rev. Fr. </span>
							<input type="text" class="form-control text-capitalize" name="PRIEST_NAME" required>
                  		</div>
                	</div>
					<div class="col-sm-12">
          		  		<div class="form-group">
							<span>I am hereby granting the request of my parishioner, </span>
							<input type="text" class="form-control text-capitalize" name="PARISHIONER" required>
							<span>to have their marriage celebrated outside the parish. </span>
                  		</div>
                	</div>
					<div class="col-sm-12">
                      <div class="form-group">
                          <input type="checkbox" name="CHECKBOX_ONE" value="YES"> <label>I have already conducted the interview and found no impediment</label><br>
                          <input type="checkbox" name="CHECKBOX_TWO" value="YES"> <label>I have not yet done the interview. Please conduct the necessary investigation.</label><br>	
                      </div>
                    </div>

					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Given Day</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_DAY" value="<?=date('jS');?>">
                  		</div>
                	</div>
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Month</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_MONTH" value="<?=date('F');?>">
                  		</div>
                	</div>
					
					<div class="col-sm-4">
          		  		<div class="form-group">
							<span>Year</span>
							<input type="text" class="form-control text-capitalize" name="GIVEN_YEAR" value="<?= date('Y');?>">
                  		</div>
                	</div>
					
					</div>
                      </div>
					  <div class="card-footer">
					  <button type="submit" name="outside_marriage_submit" class="btn bg-gradient-maroon btn-sm">SUBMIT</button>
					</div>
					</form>
                    </div>
                  </div>
				  <!----END---->
				  <!----START---->
				  <!-- <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseFourteen">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> permission for mass outside parish
                        </a>
                      </h4>
					  <div class="card-tools">
						  <a href="#" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-folder-plus"></i> FOR NO RECORD
						  </a>
					  </div>
                    </div>
                    <div id="collapseFourteen" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        3
                        wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                        laborum
                        eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                        nulla
                        assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                        nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                        beer
                        farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                        labore sustainable VHS.
                      </div>
                    </div>
                  </div> -->
				  <!----END---->
				  <!----START---->
				  <!-- <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseFifteen">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> publication of banns
                        </a>
                      </h4>
					  <div class="card-tools">
						  <a href="#" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-folder-plus"></i> FOR NO RECORD
						  </a>
					  </div>
                    </div>
                    <div id="collapseFifteen" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        3
                        wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                        laborum
                        eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                        nulla
                        assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                        nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                        beer
                        farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                        labore sustainable VHS.
                      </div>
                    </div>
                  </div> -->
				  
				  <!----END---->
				  <!----START---->
				  <!-- <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseSixteen">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> reply notice for publication of banns
                        </a>
                      </h4>
					  <div class="card-tools">
						  <a href="#" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-folder-plus"></i> FOR NO RECORD
						  </a>
					  </div>
                    </div>
                    <div id="collapseSixteen" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        3
                        wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                        laborum
                        eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                        nulla
                        assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                        nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                        beer
                        farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                        labore sustainable VHS.
                      </div>
                    </div>
                  </div> -->
				  <!----END---->
				  <!----START---->
				  <!-- <div class="card card-default">
                    <div class="card-header">
                      <h4 class="card-title w-100a">
                        <a class="d-block w-100a text-uppercase" data-toggle="collapse" href="#collapseSeventeen">
                          <i class="fa-solid fa-hand-point-right fa-fade text-success"></i> STATUS OF LIBERTY
                        </a>
                      </h4>
					  <div class="card-tools">
						  <a href="#" class="btn btn-tool text-primary">
						  <i class="fa fa-sharp fa-solid fa-folder-plus"></i> FOR NO RECORD
						  </a>
					  </div>
                    </div>
                    <div id="collapseSeventeen" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                        3
                        wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                        laborum
                        eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee
                        nulla
                        assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                        nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                        beer
                        farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                        labore sustainable VHS.
                      </div>
                    </div>
                  </div> -->
				 <!----END---->
				  <!----START---->
				 </div><!--coordoon--->

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
 <?php 
 include "includes/footer.php"; 
 include "includes/certification_modal.php";
 require_once ('myscripts.php');
?>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>
</body>
</html>

