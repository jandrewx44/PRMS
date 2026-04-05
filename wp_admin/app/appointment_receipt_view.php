<?php
	//ob_start();
	session_start();
	if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
		header('location: register.php?register=form');
	}

	include 'includes/conn.php';
  $GET=$conn->real_escape_string($_GET['refnumber']);
  if(isset($GET)){
    $stmt =$conn->prepare("SELECT * FROM tbl_appointment WHERE AUTO_NUMBER=?");
    $stmt->bind_param('s', $GET);
    if($stmt->execute()){
    $result=$stmt->get_result();
    if($result->num_rows > 0){
        
        while($value = $result->fetch_assoc()){
          $APP_ID    	        =$value['APP_ID'];
          $NAME               =$value['LASTNAME'].', '.$value['FIRSTNAME'].' '.$value['MIDDLENAME'];
          $BOOK_DATE   			  =$value['BOOK_DATE'];
          $APP_STATUS    		  =$value['APP_STATUS'];
          $DATE_ACTION    		=$value['DATE_ACTION'];
          $AUTO_NUMBER        =$value['AUTO_NUMBER'];
          $BOOK_TIME          =$value['BOOK_TIME'];
          $MOBILE             =$value['MOBILE'];
          $ADDRESS            =$value['ADDRESS'];
          $VALID_ID_NUMBER    =$value['VALID_ID_NUMBER'];
          if($value['APP_STATUS']=="Pending"){
            $STATUS='<label class="text-warning" style="color:orange">Pending</label>';
          }elseif($value['APP_STATUS']=="Approved"){
              $STATUS='<label class="text-success" style="color:green">Approved</label>';
          }elseif($value['APP_STATUS']=="Completed"){
            $STATUS='<label class="text-primary" style="color:blue">Completed</label>';
          }elseif($value['APP_STATUS']=="Rejected"){
              $STATUS='<label class="text-danger" style="color:red">Rejected</label>';
          }
        }
    }
  }
}
  

  
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
require_once('../tcpdf/tcpdf.php');  

  // Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
  //Page header
  public function Header() {
      // get the current page break margin
      $bMargin = $this->getBreakMargin();
      // get current auto-page-break mode
      $auto_page_break = $this->AutoPageBreak;
      // disable auto-page-break
      $this->SetAutoPageBreak(false, 0);
      // set bacground image
      $img_file = file_get_contents('../images/logo.png');
	  $pdf->Image('@' . $img_file, 25, 50, 160, '', '', '', '', false, 50, '', false);
	  
      // restore auto-page-break status
      $this->SetAutoPageBreak($auto_page_break, $bMargin);
      // set the starting point for the page content
      $this->setPageMark();
  }
  public function Footer() {
    // Position at 15 mm from bottom
    $this->SetY(-15);
    // Set font
    $this->SetFont('helvetica', 'I', 8);
    // Page number
    //$this->Cell(0, 10, 'Generated on '.date('l F d, Y').' Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
}
}

    //$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', array(200.9, 200.2), true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('REFERENCE: '.$AUTO_NUMBER);  
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
    $pdf->SetDefaultMonospacedFont('helvetica');  
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
    $pdf->setPrintHeader(FALSE);  
    $pdf->setPrintFooter(TRUE);  
    $pdf->SetAutoPageBreak(TRUE, 10);  
    $pdf->SetFont('helvetica', '', 11);  
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	$pdf->AddPage(); 
	
	$pdf->SetAlpha(0.1);
	$img_file = file_get_contents('../images/logo.png');
	$pdf->Image('@' . $img_file, 25, 40, 150, '', '', '', '', false, 50, 'C', false);
	$pdf->SetAlpha(1);
	
	

	
  $style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(128,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);
// $pdf->write2DBarcode($AUTO_NUMBER, 'C128', 80, 170, 50, 50, $style, 'N');
$pdf->write1DBarcode($AUTO_NUMBER, 'C128', 70, 160, '', 18, 0.4, $style, 'N');
$pdf->SetY(-280);
$contents = '<br>
<br>
<table>
<td align="center"><img src="../images/logo.png" alt="" class="float-left" width="100"></td>
</table>
<h1 align="center">APPOINTMENT RECEIPT</h1>
<div style="border-bottom:1px solid #000"></div>
<br>
<br>
<br>
<br>
<table cellspacing="5" width="100%" border="">
<tbody>
<tr>
  <td>REFERENCE NO:</td>
  <td>'.$AUTO_NUMBER.'</td>
</tr>
<tr>
  <td>CLEINT NAME:</td>
  <td>'.$NAME.'</td>
</tr>
<tr>
  <td>CONTACT:</td>
  <td>'.$MOBILE.'</td>
</tr>
<tr>
  <td>ADDRESS:</td>
  <td>'.$ADDRESS.'</td>
</tr>
<tr>
  <td>TIME OF APPOINTMENT:</td>
  <td>'.$BOOK_TIME.'</td>
</tr>
<tr>
  <td>DATE OF APPOINTMENT:</td>
  <td>'.date('l F d, Y',strtotime($BOOK_DATE)).'</td>
</tr>
<tr>
  <td>VALID ID:</td>
  <td>'.$VALID_ID_NUMBER.'</td>
</tr>
<tr>
  <td>STATUS:</td>
  <td>'.$STATUS.'</td>
</tr>
<tr>
  <td colspan="2" align="center">
  <br><br><br>
*****************<i>NOTHING FOLLOWS</i>*****************
</td>
</tr>
</tbody>
</table>
<div align="center">

<h1>'.$AUTO_NUMBER.'</h1>
</div>


    ';
    $pdf->writeHTML($contents);  
    //$pdf->writeHTML($contents,true, false, true, false, '');
    ob_end_clean();
    $pdf->Output('_receipt.pdf', 'I');

?>
