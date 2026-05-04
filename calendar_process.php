<?php
session_start();
include "wp_admin/app/includes/conn.php";

            $BOOK_DATE =$_POST["BOOK_DATE"];
            $BOOK_TIME =$_POST["BOOK_TIME"];
            $FIRSTNAME = $conn -> real_escape_string(strtoupper($_POST['FIRSTNAME']));
            $MIDDLENAME = $conn -> real_escape_string(strtoupper($_POST["MIDDLENAME"]));
            $LASTNAME =$conn -> real_escape_string(strtoupper($_POST["LASTNAME"]));
            $GENDER = $conn -> real_escape_string(strtoupper($_POST["GENDER"]));
            $DATE_OF_BIRTH =$_POST["DATE_OF_BIRTH"];
            $AGE = $_POST["AGE"];
            $MOBILE = $conn -> real_escape_string($_POST["MOBILE"]);
            $ADDRESS = $conn -> real_escape_string(strtoupper($_POST["ADDRESS"]));
            $PURPOSE = isset($_POST["PURPOSE"]) ? $conn -> real_escape_string(strtoupper($_POST["PURPOSE"])) : '';
            $VALID_ID_NUMBER =  $conn -> real_escape_string(strtoupper($_POST["VALID_ID_NUMBER"]));
            // Generate reference number based on selected booking date (month+year sequence)
            $prefix = "REF";
            $ts = strtotime($BOOK_DATE ?: date('Y-m-d'));
            $month = date("m", $ts);
            $year = date("y", $ts);
            $pattern = "$prefix-$month$year-%";
            $stmtLast = $conn->prepare("SELECT AUTO_NUMBER FROM tbl_autonumber WHERE AUTO_NUMBER LIKE ? ORDER BY AUTO_NUMBER DESC LIMIT 1");
            $stmtLast->bind_param('s', $pattern);
            $stmtLast->execute();
            $lastRes = $stmtLast->get_result();
            if($lastRes && $lastRes->num_rows){
                $lastid = $lastRes->fetch_assoc()['AUTO_NUMBER'];
                $offset = strlen($prefix)+6;
                $idd = intval(substr($lastid, $offset));
                $id = str_pad($idd + 1, 4, "0", STR_PAD_LEFT);
                $AUTO_NUMBER = "$prefix-$month$year-$id";
            }else{
                $AUTO_NUMBER = "$prefix-$month$year-0001";
            }
            $TERMS_OF_SERVICE=$_POST['TERMS_OF_SERVICE'];
            $APP_STATUS = 'Pending';
            $DATE_ACTION = '';
            $DATE_COMPLETED = '';


            $UPLOAD_IDS = basename($_FILES["UPLOAD_ID"]["name"]); 
            $UPLOAD_SIZE = $_FILES["UPLOAD_ID"]["size"]; 
            $UPLOAD_ID_TYPE = pathinfo($UPLOAD_IDS, PATHINFO_EXTENSION); 

            $UPLOAD_WITH_SELFIES = basename($_FILES["UPLOAD_WITH_SELFIE"]["name"]); 
            $UPLOAD_WITH_SELFIE_SIZE =$_FILES["UPLOAD_WITH_SELFIE"]["size"]; 
            $UPLOAD_WITH_SELFIE_TYPE = pathinfo($UPLOAD_WITH_SELFIES, PATHINFO_EXTENSION); 
            
            $uploadfile_now =array($UPLOAD_ID_TYPE, $UPLOAD_WITH_SELFIE_TYPE);

            // Require both attachments to be <= 2MB
            if($UPLOAD_SIZE <= 2097152 && $UPLOAD_WITH_SELFIE_SIZE <= 2097152){

            $allowTypes = array('jpg','JPG','png','PNG','jpeg','JPEG','gif','GIF'); 
            if(in_array($UPLOAD_ID_TYPE, $allowTypes) || in_array($UPLOAD_WITH_SELFIE_TYPE, $allowTypes)){ 
                $IMAGE_ID = $_FILES['UPLOAD_ID']['tmp_name']; 
                // $UPLOAD_ID = addslashes(file_get_contents($IMAGE_ID)); 
                $UPLOAD_ID =file_get_contents($IMAGE_ID);
                $WITH_SELFIE = $_FILES['UPLOAD_WITH_SELFIE']['tmp_name']; 
                // $UPLOAD_WITH_SELFIE = addslashes(file_get_contents($WITH_SELFIE)); 
                $UPLOAD_WITH_SELFIE = file_get_contents($WITH_SELFIE);

                $stmt=$conn->prepare("INSERT INTO `tbl_appointment`(`BOOK_DATE`, `BOOK_TIME`, `FIRSTNAME`, `MIDDLENAME`, `LASTNAME`, `GENDER`, `DATE_OF_BIRTH`, `AGE`, `MOBILE`, `ADDRESS`, `REMARKS`, `VALID_ID_NUMBER`, `UPLOAD_ID`, `UPLOAD_WITH_SELFIE`, `TERMS_OF_SERVICE`, `AUTO_NUMBER`, `APP_STATUS`, `DATE_ACTION`, `DATE_COMPLETED`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->bind_param('sssssssssssssssssss',$BOOK_DATE,$BOOK_TIME,$FIRSTNAME,$MIDDLENAME,$LASTNAME,$GENDER,$DATE_OF_BIRTH,$AGE,$MOBILE,$ADDRESS,$PURPOSE,$VALID_ID_NUMBER,$UPLOAD_ID,$UPLOAD_WITH_SELFIE,$TERMS_OF_SERVICE,$AUTO_NUMBER,$APP_STATUS,$DATE_ACTION,$DATE_COMPLETED);
                if($stmt->execute()){
					$NOTFICATION_SMS ="Hi $LASTNAME , we received your appointment request for date: $BOOK_DATE  $BOOK_TIME Ref: $AUTO_NUMBER. It’s currently pending approval. We’ll update you shortly. St.Philip Benizi Parish";
                    $response = [
                        'status' => 'success',
                        'message' => 'Your application has been successfully submitted and is waiting for confirmation.',
                        'receipt_url' => 'calendar_appointment_receipt.php?AUTO_NUMBER='.$AUTO_NUMBER.'&FIRSTNAME='.$FIRSTNAME.'&LASTNAME='.$LASTNAME
                    ];
                    // Fire-and-forget SMS call (non-blocking)
                    $postData = http_build_query([
                        'mobile' => $MOBILE,
                        'message' => $NOTFICATION_SMS
                    ]);
                    $hostHeader = $_SERVER['HTTP_HOST'];
                    $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
                    $path = $base.'/wp_admin/app/sms_async.php';
                    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
                    $host = $hostHeader;
                    $port = $isHttps ? 443 : 80;
                    if (strpos($hostHeader, ':') !== false) {
                        list($host, $portStr) = explode(':', $hostHeader, 2);
                        $port = (int)$portStr;
                    }
                    $transportHost = ($isHttps ? 'ssl://' : '').$host;
                    $fp = @fsockopen($transportHost, $port, $errno, $errstr, 1);
                    if ($fp) {
                        $out = "POST ".$path." HTTP/1.1\r\n";
                        $out .= "Host: ".$hostHeader."\r\n";
                        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
                        $out .= "Content-Length: ".strlen($postData)."\r\n";
                        $out .= "Connection: Close\r\n\r\n";
                        $out .= $postData;
                        fwrite($fp, $out);
                        fclose($fp);
                    }
                    $autonum= "INSERT INTO `tbl_autonumber`(AUTO_NUMBER)VALUES ('$AUTO_NUMBER')";
                    $conn->query($autonum);
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }else{
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Opps! we have error while saving your information'
                    ]);
                }


            }else{ 
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload'
                ]);
            } 
        }else{
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'error',
                'message' => 'Attachment image is too large. Please choose a smaller size (max 2MB each).'
            ]);
        
        }


?>
