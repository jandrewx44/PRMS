<footer id="footer" class="footer light-background" style="border:none">
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="wp_admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="wp_admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>


<!-- Bootstrap 4 -->
<script src="wp_admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="wp_admin/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
<script src="wp_admin/plugins/select2/js/select2.full.min.js"></script>
<!-- ChartJS -->
<script src="wp_admin/plugins/chart.js/Chart.min.js"></script>
<script src="wp_admin/plugins/sweetalert2/sweetalert2.min.js"></script>

<script src="wp_admin/plugins/toastr/toastr.min.js"></script>
<!-- Sparkline -->
<script src="wp_admin/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="wp_admin/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="wp_admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="wp_admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="wp_admin/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="wp_admin/plugins/moment/moment.min.js"></script>
<script src="wp_admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="wp_admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="wp_admin/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="wp_admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="wp_admin/plugins/fullcalendar/lib/main.min.js"></script>
<!-- AdminLTE App -->
<script src="wp_admin/dist/js/adminlte.js"></script>

<script src="wp_admin/dist/js/pages/dashboard.js"></script>
<script src="wp_admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<script>
  $(function () {
  $('[data-jario="tooltip"]').tooltip()
})
</script>
  <script type="text/javascript">  
        $.ajax({
            url:"calendar.php",
            type:"POST",
            data: { 'month':'<?=date('m');?>','year':'<?=date('Y');?>'},
            success:function(data){
                $("#calendar").html(data);
            }
        });
        $(document).on('click','.changemonth',function(){
            $.ajax({
                url:"calendar.php",
                type:"POST",
                data: {'month':$(this).data('month'),'year':$(this).data('year')},
                success:function(data){
                    $("#calendar").html(data);
                }
            });
        });
        $(document).on('change','#office_select',function(){
            $.ajax({
                url:"calendar.php",
                type:"POST",
                data: { 'month':$('#current_month').data('month'),'year':$('#current_month').data('year')},
                success:function(data){
                    $("#calendar").html(data);
                }
            });
        });
    </script>
  <script type="text/javascript">  
   function bookDate(self) {
      var sdate = self.getAttribute("data-sdate");
	  var dataddd = self.getAttribute("data-ddd");
      document.getElementById("sdate").value = sdate;
	  document.getElementById("dataddd").innerHTML = dataddd;
        $.ajax({
            url:"calendar_slots.php",
            type:"POST",
            data: "sdate=" + $('#sdate').val(),
            success:function(data){
                $(".list_time").html(data);
                $(".select_time_now").hide();
                $("#dataddd").show();
                $(".list_time").fadeIn();
				$("#registerform").fadeOut();
            },
            error: function() {
                alert('Error occurs!');
            }
        });
  }
</script>

<script type="text/javascript">   
   $("#link2").click(function(event){
    if( $("#termsCheckbox").is(':checked') ){
      
    }else {
      event.preventDefault();
    }
    console.log("link2");

  });

  $("#next").click(function(event){

    if (!$("input[name='SELECTED_TIME']:checked").val()) {
         $(function() {
        $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Warning',
        autohide: true,
        delay: 3000,
        body: 'Please select available time to proceed appointment'
      })
      });
        return false;
    }else {
      event.preventDefault();
        $("#registerform").slideToggle();
		
		
    }

  });
</script>
<script>
   function getTime(self) {
      var stime=self.getAttribute("data-stime");
      document.getElementById("stime").value = stime;
	  $("#registerform").fadeIn();
      // Fetch next reference number for selected date
      var sdate = document.getElementById('sdate').value;
      $.ajax({
        url: "generate_reference.php",
        type: "POST",
        data: {date: sdate},
        success: function(data){
          try{
            if(typeof data === 'string'){ data = JSON.parse(data); }
            if(data && data.number){
              var autoEl = document.querySelector('input[name="AUTO_NUMBER"]');
              if(autoEl){ autoEl.value = data.number; }
              var ref = document.getElementById('dataddd');
              if(ref){ ref.innerHTML = ref.innerHTML + " | REF: " + data.number; }
            }
          }catch(e){}
        }
      });
  }
</script>
<script>
  (function(){
    function showHint(input, text, cls){
      var group = input.closest('.form-group');
      var hint = group ? group.querySelector('.file-size-hint') : null;
      if(!hint && group){
        hint = document.createElement('small');
        hint.className = 'file-size-hint text-muted d-block mt-1';
        hint.textContent = 'Max 2MB. Allowed: JPG, JPEG, PNG, GIF.';
        group.appendChild(hint);
      }
      if(hint){
        hint.classList.remove('text-muted','text-danger','text-success');
        hint.classList.add(cls);
        hint.textContent = text;
      }
    }
    function checkFile(input){
      var f = input.files && input.files[0];
      if(!f){
        showHint(input,'Max 2MB. Allowed: JPG, JPEG, PNG, GIF.','text-muted');
        return true;
      }
      var mb = (f.size/1048576).toFixed(2);
      if(f.size > 2097152){
        showHint(input,'Selected file is '+mb+'MB. Max 2MB.','text-danger');
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Attachment Too Large',
          autohide: true,
          delay: 3000,
          body: 'Each image must be 2MB or less.'
        });
        input.value = '';
        return false;
      } else {
        showHint(input,'File size: '+mb+'MB (OK).','text-success');
        return true;
      }
    }
    $(document).on('change','#UPLOAD_ID',function(){ checkFile(this); });
    $(document).on('change','#exampleInputFile',function(){ checkFile(this); });
  })();
</script>
<script type="text/javascript">
 // Bootstrap 4 Validation
 $(".needs-validation").submit(function (event) {
    var form = $(this);
    if (form[0].checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
    }else{
      var file1 = document.getElementById('UPLOAD_ID');
      var file2 = document.getElementById('exampleInputFile');
      var tooLarge = false;
      if (file1 && file1.files && file1.files[0] && file1.files[0].size > 2097152) tooLarge = true;
      if (file2 && file2.files && file2.files[0] && file2.files[0].size > 2097152) tooLarge = true;
      if (tooLarge) {
        event.preventDefault();
        $(function() {
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Attachment Too Large',
            autohide: true,
            delay: 3000,
            body: 'Each image must be 2MB or less.'
          })
        });
        return false;
      }
      //$("#LoadingImage").show();
            $.ajax({
                url:"calendar_process.php",
                type:"POST",
                data:  new FormData(this),
        contentType: false,
        	    cache: false,
    			processData: false,
          beforeSend : function(){
            $('#LoadingImage').show();
          },
                success:function(data){
                    try {
                      if (typeof data === 'string') {
                        data = JSON.parse(data);
                      }
                      if (data && data.status === 'success') {
                        Swal.fire({
                          title: "SUCCESS!",
                          text: data.message || "Your application has been successfully submitted.",
                          icon: "success",
                          showConfirmButton: false,
                          timer: 1500
                        }).then(function(){
                          if (data.receipt_url) {
                            window.open(data.receipt_url, "_blank");
                          }
                        });
                        $('input[type="text"], input[type="file"], input[type="date"], input[type="email"], input[type="radio"], select').val('');
                        $(".list_time").fadeOut();
                        $("#dataddd").fadeOut();
                        $("#registerform").fadeOut();
                        $(".select_time_now").fadeIn(300);
                      } else if (data && data.status === 'error') {
                        Swal.fire({
                          title: "ERROR!",
                          text: data.message || "Submission failed.",
                          icon: "error",
                          showConfirmButton: false,
                          timer: 2000
                        });
                      } else {
                        $("#success_message").html(data);
                      }
                    } catch(e) {
                      $("#success_message").html(data);
                    }
                    $('#LoadingImage').hide();
                  },
                error: function(data){
                    console.log("error");
                    console.log(data);
                    $('#LoadingImage').hide();
                  }
            });
			// to prevent refreshing the whole page page
			return false;
        
    }
    form.addClass("was-validated");
  });
</script>
<script>
    function disableButton() {
         $('#disabled').prop('disabled', true);
 setTimeout(function() {
       $('#disabled').prop('disabled', false);
         
 }, 5000);
    }
</script>

<script>
  $('.select2').select2({
      theme: 'bootstrap4'
    })
</script>
<script type="text/javascript">   
  $("#link").click(function(){
      Swal.fire({
        icon: "info",
        title:"TERMS AND CONDITIONS",
        text: "By continuing this application, I agree that my personal info can be used for the NORSU Bais Campus Appointment Scheduling System. I understand that this means I'm giving up some privacy rights regarding how my info is used, based on the rules in the NORSU Bais Appointment and Scheduling System Website and other relevant regulations.",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Agree"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "register_form.php?register_form";
        }
      });
    console.log("link2");

  });
</script>


<script type="text/javascript">
 // Bootstrap 4 Validation
 $(".view_form").submit(function (event) {
    var form = $(this);
    if (form[0].checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
    }else{
            $.ajax({
                url:"view_form_process.php",
                type:"POST",
                data:  new FormData(this),
        contentType: false,
        	    cache: false,
    			processData: false,
                success:function(data){
                    $("#view_form").html(data);
                    //$("#view_form_modal").modal("show");
                },
                error: function(data){
                    console.log("error");
                    console.log(data);
                  }
            });
			// to prevent refreshing the whole page page
			return false;
        
    }
    form.addClass("was-validated");
  });
</script>

<script type="text/javascript">
    $(document).ready(function()
    {
        $('#DATE_OF_BIRTH').change(function()
        {
            console.log("change");
            var dob = new Date(document.getElementById('DATE_OF_BIRTH').value);
            var today = new Date();
            var age = Math.floor((today-dob)/(365.25*24*60*60*1000));
            document.getElementById('AGE').value = age;
        });
    });
</script>
