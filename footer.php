<footer id="footer" class="footer light-background" style="border:none">
    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">BKB and Manta Style</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Developed by <a href="https://www.facebook.com/profile.php?id=61574859879807">St.Philip Benizi and Students</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>
  <script src="wp_admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="wp_admin/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>


<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="wp_admin/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <script type="text/javascript">
	$(document).ready(function () {
	window.setTimeout(function() {
		$("#alert").fadeTo(1000, 0).slideUp(1000, function(){
			$(this).remove(); 
		});
	}, 5000);

	});
</script>
<script>
  $(function () {
    // Summernote
    $('.summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  })
</script>
<script>
    function userAvailability() {
    $("<span class='fa fa-star'></span>").show();
    jQuery.ajax({
    url: "email_availability.php",
    data:'email='+$("#email").val(),
    type: "POST",
    success:function(data){
    $("#user-availability-status1").html(data);
    $("#loaderIcon").hide();
    },
    error:function (){}
    });
    }
</script>
<script>
    $(document).ready(function(){
        $("#ConfirmPassword").keyup(function(){
             if ($("#Password").val() != $("#ConfirmPassword").val()) {
                 $("#msg").html("Password do not match").css("color","red");
                 $('#submit').prop('disabled',true);
             }else{
                 $("#msg").html("Password matched").css("color","green");
                 $('#submit').prop('disabled',false);
            }
      });
});
</script> 
<script>
$(document).ready(function(){
   
	var rating_data = 0;

    $('#add_review').click(function(){

        $('#review_modal').modal('show');

    });

    $(document).on('mouseenter', '.submit_star', function(){

        var rating = $(this).data('rating');

        reset_background();

        for(var count = 1; count <= rating; count++)
        {

            $('#submit_star_'+count).addClass('text-warning');

        }

    });

    function reset_background()
    {
        for(var count = 1; count <= 5; count++)
        {

            $('#submit_star_'+count).addClass('star-light');

            $('#submit_star_'+count).removeClass('text-warning');

        }
    }

    $(document).on('mouseleave', '.submit_star', function(){

        reset_background();

        for(var count = 1; count <= rating_data; count++)
        {

            $('#submit_star_'+count).removeClass('star-light');

            $('#submit_star_'+count).addClass('text-warning');
        }

    });

    $(document).on('click', '.submit_star', function(){

        rating_data = $(this).data('rating');

    });

    $('#save_review').click(function(){

        var user_name = $('#user_name').val();

        var user_review = $('#user_review').val();

        if(user_name == '' || user_review == '')
        {
            alert("Please Fill Both Field");
            return false;
        }
        else
        {
            $.ajax({
                url:"submit_ratings.php",
                method:"POST",
                data:{rating_data:rating_data, user_name:user_name, user_review:user_review},
                success:function(data)
                {
                    if (typeof data === 'string' && data.indexOf('Successfully Submitted') !== -1) {
                        $('#review_modal').modal('hide');
                        load_rating_data();
                        alert('Your Review & Rating Successfully Submitted');
                    } else {
                        alert('Unable to submit review right now. Please try again later.');
                    }
                },
                error:function()
                {
                    alert('Unable to submit review right now. Please try again later.');
                }
            })
        }

    });

    load_rating_data();

    function load_rating_data()
    {
        $.ajax({
            url:"submit_ratings.php",
            method:"POST",
            data:{action:'load_data'},
            dataType:"JSON",
            success:function(data) {
                if (!data || typeof data !== 'object') {
                    return;
                }
                $('#average_rating').text(data.average_rating);
                $('#total_review').text(data.total_review);

                var count_star = 0;

                $('.main_star').each(function(){
                    count_star++;
                    if(Math.ceil(data.average_rating) >= count_star)
                    {
                        $(this).addClass('text-warning');
                        $(this).addClass('star-light');
                    }
                });

                $('#total_five_star_review').text(data.five_star_review);

                $('#total_four_star_review').text(data.four_star_review);

                $('#total_three_star_review').text(data.three_star_review);

                $('#total_two_star_review').text(data.two_star_review);

                $('#total_one_star_review').text(data.one_star_review);

                var safeTotal = data.total_review > 0 ? data.total_review : 1;
                $('#five_star_progress').css('width', (data.five_star_review/safeTotal) * 100 + '%');
                $('#four_star_progress').css('width', (data.four_star_review/safeTotal) * 100 + '%');
                $('#three_star_progress').css('width', (data.three_star_review/safeTotal) * 100 + '%');
                $('#two_star_progress').css('width', (data.two_star_review/safeTotal) * 100 + '%');
                $('#one_star_progress').css('width', (data.one_star_review/safeTotal) * 100 + '%');

                if(data.review_data.length > 0)
                {
                    var html = '';

                    for(var count = 0; count < data.review_data.length; count++)
                    {
                        html += '<div class="row">';

                        html += '<div class="col-sm-1 hidden-xs d-none d-sm-block"><div class="img-thumbnail bg-light text-white pt-2 pb-2"><h3 class="text-center">'+data.review_data[count].user_name.charAt(0)+''+data.review_data[count].user_name.charAt(1)+'</h3></div></div>';

                        html += '<div class="col-sm-11">';

                        html += '<div class="cards">';

                        html += '<div class="card-headers"><b>'+data.review_data[count].user_name+'</b></div>';

                        html += '<div class="card-bodys">';

                        for(var star = 1; star <= 5; star++)
                        {
                            var class_name = '';

                            if(data.review_data[count].rating >= star)
                            {
                                class_name = 'text-warning';
                            }
                            else
                            {
                                class_name = 'star-light';
                            }

                            html += '<i class="fas fa-star '+class_name+' mr-1"></i>';
                        }

                        html += '<br />';

                        html += data.review_data[count].user_review;

                        html += '</div>';

                        html += '<div class="card-footer text-right">On '+data.review_data[count].datetime+'</div>';

                        html += '</div>';

                        html += '</div>';

                        html += '</div>';
                    }

                    $('#review_content').html(html);
                }
            },
            error:function() {
                // Keep UI stable without exposing backend responses.
            }
        })
    }

});

</script>
</body>
</html>
