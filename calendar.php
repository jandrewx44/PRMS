<?php
date_default_timezone_set('Asia/Manila');
function build_calendar($month, $year) {
     include "wp_admin/app/includes/conn.php";
    $stmt = $conn->prepare("SELECT * FROM tbl_blocked_days");
    $bookings = array();
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $bookings[] = date('Y-'.$row['blocked_date']);
                ///$blocked_name = $row['blocked_name'];
            }
            
            $stmt->close();
        }
    }
     $curYear =date('Y');

     $daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);
     $numberDays = date('t',$firstDayOfMonth);
     $dateComponents = getdate($firstDayOfMonth);
     $monthName = $dateComponents['month'];
     $dayOfWeek = $dateComponents['wday'];
    $datetoday = date('Y-m-d');
    
    $prev_month = date('m',mktime(0,0,0,$month-1,1,$year));
    $prev_year = date('Y',mktime(0,0,0,$month-1,1,$year));
    $next_month = date('m',mktime(0,0,0,$month+1,1,$year));
    $next_year = date('Y',mktime(0,0,0,$month+1,1,$year));
    
    $calendar = "<table class='table table-bordered table-sm table-clickable'>";
    $calendar .= "<center><h2 class='text-uppercase'>$monthName $year</h2>
    <a class='changemonth btn btn-primary btn-sm' data-month='".date('m',mktime(0,0,0,$month-1,1,$year))."' data-year='".date('Y',mktime(0,0,0,$month-1,1,$year))."'><i class='fas fa-angle-left left'></i></a>
   <a class='changemonth btn btn-primary btn-sm' id='current_month' data-month='".date('m')."' data-year='".date('Y')."'>TODAY</a>
   <a class='changemonth btn btn-primary btn-sm' data-month='".date('m',mktime(0,0,0,$month+1,1,$year))."' data-year='".date('Y',mktime(0,0,0,$month+1,1,$year))."'><i class='fas fa-angle-right right'></i></a>
   <br><br>
   ";  
      $calendar .= "<tr>";

     // Create the calendar headers

     foreach($daysOfWeek as $day) {
          $calendar .= "<th class='header'>$day</th>";
     } 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

     $currentDay = 1;

     $calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

     if ($dayOfWeek > 0) { 
         for($k=0;$k<$dayOfWeek;$k++){
                $calendar .= "<td  class='empty'></td>"; 

         }
     }
    
     
     $month = str_pad($month, 2, "0", STR_PAD_LEFT);
  
     while ($currentDay <= $numberDays) {
        
          // Seventh column (Saturday) reached. Start a new row.

          if ($dayOfWeek == 7) {

               $dayOfWeek = 0;
               $calendar .= "</tr><tr>";

          }
          
          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
          $date = "$year-$month-$currentDayRel";
          
            $dayname = strtolower(date('l', strtotime($date)));
            $eventNum = 0;
            $today = $date==date('Y-m-d')? "today" : "";

      
          
            if(in_array($date, $bookings)){
					
                $blockdays = $conn->prepare("SELECT * FROM tbl_blocked_days");
                    if($blockdays->execute()){
                        $result = $blockdays->get_result();
                        if($result->num_rows>0){
                            while($blockeddate = $result->fetch_assoc()){
    
                                $blocked_d= $blockeddate['blocked_date'];
                                $blocked_n= $blockeddate['blocked_name'];
                                $blocked_y= date('Y-'.$blocked_d);
                                    if($blocked_y ==$date){
                                        $calendar.="<td class='bg-0A7B41'><h4>$currentDay</h4> 
                                        <a class='bg-0A7B41'> <span class=''>$blocked_n</span></a>
                                        ";
                                    }
                           }
                        }
                   }
                   
            }elseif($curYear!=$year){
                $calendar.="<td><h4 class='text-muted'>$currentDay</h4> <a class='btn btn-default prevent-select' style='border:none;background:none;pointer-events: none;color:'></a>";
            }elseif($dayname=='saturday' || $dayname=='sunday'){
                $calendar.="<td><h4 class='text-muted'>$currentDay</h4>";
            }elseif($date<date('Y-m-d')){
                $calendar.="<td><h4>$currentDay</h4> <a class='btn btn-default prevent-select' style='border:none;background:none;pointer-events: none;color:'></a>";
            }else{
                $totalbookings=checkSlots($conn, $date);
                $stmts = $conn->prepare("SELECT * FROM tbl_slot_date WHERE slots_date = ?");
                $stmts->bind_param('s', $date);
                if($stmts->execute()){
                    $results = $stmts->get_result();
                    if($results->num_rows>0){
                        $results_row = $results->fetch_assoc();
                        $start_time =$results_row['start_time'];
                        // $stmt = $mysqli->prepare("SELECT COUNT(*) as TotalBooked FROM tbl_appointment WHERE DATETIME=? and offid=?");
                        $stmt=$conn->prepare("SELECT COUNT(*) as TotalBooked FROM tbl_appointment WHERE BOOK_DATE=?");
                        $stmt->bind_param('s', $date);
                        $stmt->execute();
                        $result =$stmt->get_result();
                        $resource = $result->fetch_assoc();
                        $bookingslots = (int)$resource['TotalBooked'];
                        $totalbookings = (int)$totalbookings;
                        $availableSlots = max(0, $totalbookings - $bookingslots);

                        if($bookingslots >= $totalbookings || $availableSlots === 0){
                            $calendar.="<td class='$today bg-001685'><h4>$currentDay</h4>Fully Booked";
                        }else{
                            $calendar.="<td class='$today text-nowrap bg-00856F' id='showslots' data-ddd='$date' data-sdate='$date' onclick='bookDate(this);' style='cursor:pointer'><h4>$currentDay</h4>$availableSlots Available"; 
                        }    
                
                    }else{  
                      
                         $calendar.="<td class='text-nowrap bg-005885'><h4>$currentDay</h4>No Slots Available";
                    }
                }
            }
          $calendar .="</td>";
          // Increment counters
 
          $currentDay++;
          $dayOfWeek++;

     }
     
     

     // Complete the row of the last week in month, if necessary

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
            for($l=0;$l<$remainingDays;$l++){
                $calendar .= "<td class='empty'></td>"; 

         }

     }
     
     $calendar .= "</tr>";

     $calendar .= "</table>";

     echo $calendar;

}

function checkSlots($conn,$date){
	
    // $stmt = $mysqli->prepare("SELECT * FROM tbl_slot_date WHERE slots_date =? and offid=?");

    $stmt = $conn->prepare("SELECT SUM(slots) as TotalSlots FROM tbl_slot_date WHERE slots_date =?");
    $stmt->bind_param('s', $date);
    $totalbookings = 0;
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $totalbookings=$row['TotalSlots'];
            }
            
            $stmt->close();
        }
    }

return $totalbookings;

}
$dateComponents = getdate();
if(isset($_POST['month']) && isset($_POST['year'])){
    $month = $_POST['month']; 			     
    $year = $_POST['year'];
    //$offid =$_POST['offid'];
}else{
    $month = $dateComponents['mon']; 			     
    $year = $dateComponents['year'];
    ///$offid =0;
   
}
echo build_calendar($month, $year);
?>
