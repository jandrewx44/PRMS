<?php
 include "wp_admin/app/includes/conn.php";
$sdate = $conn->real_escape_string($_POST["sdate"]);

$stmt=$conn->prepare("SELECT *, slots_date,start_time FROM tbl_slot_date WHERE slots_date=?");
$stmt->bind_param('s',$sdate);
if($stmt->execute()){
$result=$stmt->get_result();
$totalbookings = 0;
if($result->num_rows >0){
while($row=$result->fetch_assoc()){
    $selected_time =$row['start_time'];
    $totalbookings =$row['slots'];

    $sqlslots=$conn->prepare("SELECT COUNT(*) as TotalBooked FROM tbl_appointment WHERE BOOK_DATE=? and BOOK_TIME=?");
    $sqlslots->bind_param('ss',$sdate,$selected_time);
    if($sqlslots->execute()){
    $slot_row=$sqlslots->get_result();
    $resultss=$slot_row->fetch_assoc();
    $bookingslots=(int)$resultss['TotalBooked'];
    $totalbookings=(int)$totalbookings;
    $availableSlots = max(0, $totalbookings - $bookingslots);

    if($bookingslots >= $totalbookings || $availableSlots === 0){
      echo '
      <div class="form-check">
      <input class="form-check-input" type="radio" disabled>
      <strong><label class="text-danger form-check-label">'.$selected_time.' - Fully Booked</span></label></strong>
    </div>
      ';
    }else{
      echo "
      <div class='form-check'>
        <input type='radio' id='timeCheckbox' data-stime='$selected_time' onclick='getTime(this);' class='form-check-input' name='SELECTED_TIME' required>
        <strong><label class='text-success form-check-label'>$selected_time - Available: $availableSlots</label></strong>
      </div>";
    }
  }

  }
}else{
  echo"<strong><label class='text-success form-check-label'>Please select date</label></strong>";
}
}
?>




