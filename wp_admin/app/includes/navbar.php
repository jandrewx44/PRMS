<!-- 
  <div class="preloader flex-column justify-content-center align-items-center" style="background-color:rgba(0, 0, 0,0.30)">
    <div class="spinner-border text-maroon" role="status" style="width: 4rem; height: 4rem;" >
      <span class="visually-hidden"></span>
    </div>
  </div> -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center" style="background-color:rgba(0, 0, 0,0.40)">
    <div class="spinner-border text-maroon" role="status" style="width: 4rem; height: 4rem;" >
      <span class="visually-hidden"></span>
    </div>
  </div>--->

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-teal navbar-dark" style="border:none;background-color:rgba(24, 44, 97,1.0)">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link text-uppercase"><?=$SYS_NAME;?></a>
      </li>
      <!---<li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>---->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
	  <div class="btn-group">
	<button type="button" class="btn bg-default">
      <span class="hidden-xs text-white"><?php echo htmlspecialchars(trim(($user['LASTNAME'] ?? '').', '.($user['FIRSTNAME'] ?? ''), ', ')); ?></span>
	</button>
      
      <?php if(($user['ROLE'] ?? '')=="DEMO") { ?>
       
       <?php }else{ ?>
	<button type="button" class="btn bg-default dropdown-toggle dropdown-icon text-white" data-toggle="dropdown">
	  <span class="sr-only">Toggle Dropdown</span>
	</button>
	<div class="dropdown-menu" role="menu">
	  <a class="dropdown-item" data-toggle="modal" href="#editProfile"> <i class="fa fa-info-circle"></i> Edit Details</a>
	  <a class="dropdown-item" data-toggle="modal" href="#profile"> <i class="fa fa-edit"></i> Edit Profile</a>
	  <a class="dropdown-item" data-toggle="modal" href="#" data-target="#logout"><i class="fa fa-power-off"></i> Sign out</a>
	</div>
      <?php } ?>
  </div>
     <!---- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>----->
    </ul>
  </nav>
