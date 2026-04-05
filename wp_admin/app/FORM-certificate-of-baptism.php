<?php
require_once('includes/conn.php');
ob_start();
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
      $img_file = K_PATH_IMAGES.'..';
      $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
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
    $this->Cell(0, 10, 'Generated on '.date('l F d, Y').' Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	
	
}
}

    //$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);  
    $pdf->SetTitle('CERTIFICATE OF BAPTISM');  
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

    
$sql = "SELECT PRIEST_NAME FROM tbl_priest WHERE PRIEST_DEFAULT = 'YES'";
$query = $conn->query($sql);
if($query->num_rows > 0){
    $sig = $query->fetch_assoc();
    $PRIEST_NAME=$sig['PRIEST_NAME'];
    $PRIEST_NAME = preg_replace('/\s+/', ' ', $PRIEST_NAME);
    $PRIEST_NAME = str_replace(' ', '&nbsp;', $PRIEST_NAME);
} else {
  $PRIEST_NAME='';
}
$sql = "SELECT * FROM tbl_system_setting";
$query = $conn->query($sql);
if($query->num_rows > 0){
    $logo_setting = $query->fetch_assoc();
    $right_logo = 'logo_right.jpg';
    file_put_contents($right_logo, $logo_setting['SYS_LOGO']);
	$logo_left = 'logo_left.jpg';
    file_put_contents($logo_left, $logo_setting['SYS_SECOND_LOGO']);
	
	$SYS_ADDRESS=$logo_setting['SYS_ADDRESS'];
	$SYS_DIOCESE=$logo_setting['SYS_DIOCESE'];
	$SYS_CHURCH_NAME=$logo_setting['SYS_CHURCH_NAME'];
	} else {
	  $right_logo='';
	  $logo_left='';
	}
	
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->AddPage(); 
	$pdf->SetAlpha(0.1);
    $img_file = file_get_contents($logo_left);
	$pdf->Image('@' . $img_file, 25, 50, 160, '', '', '', '', false, 50, '', false);
	$pdf->SetAlpha(1);
	
    $contents = '
    <table width="100%" border="0">
      <tr>
        <td align="center"><img src="'.$right_logo.'" width="24"></td>
      </tr>
      <tr>
        <td align="center" style="font-size:22px; font-weight:bold; color:#0B6B2E;">'.$SYS_DIOCESE.'</td>
      </tr>
    </table>
    <table width="100%" border="0">
      <tr>
        <td width="20%" style="font-size:14px;">PARISH OF</td>
        <td width="80%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td width="20%"></td>
        <td width="80%" style="border-bottom:0.1px solid black;"></td>
      </tr>
    </table>
    <br><br>
    <table width="100%" border="0">
      <tr><td align="center" style="font-size:24px; font-weight:bold;">CERTIFICATE OF BAPTISM</td></tr>
    </table>
    <br>
    <table width="100%" border="0" style="font-size:12px;">
      <tr>
        <td width="28%">This is to certify that</td>
        <td width="72%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td width="22%">Son</td>
        <td width="4%">)</td>
        <td width="10%">of</td>
        <td width="64%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td width="22%">Daughter</td>
        <td width="4%">)</td>
        <td width="10%">and</td>
        <td width="64%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td width="20%">was born in</td>
        <td width="80%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td width="14%">on the</td>
        <td width="18%" style="border-bottom:0.1px solid black;"></td>
        <td width="12%">day of</td>
        <td width="40%" style="border-bottom:0.1px solid black;"></td>
        <td width="3%">,</td>
        <td width="13%" style="border-bottom:0.1px solid black;"></td>
      </tr>
    </table>
    <br>
    <table width="100%" border="0">
      <tr><td align="center" style="font-size:14px; font-weight:bold;">AND WAS BAPTIZED ACCORDING TO THE</td></tr>
      <tr><td align="center" style="font-size:14px; font-weight:bold;">ROMAN CATHOLIC RITE</td></tr>
    </table>
    <br>
    <table width="100%" border="0" style="font-size:12px;">
      <tr>
        <td width="14%">on the</td>
        <td width="18%" style="border-bottom:0.1px solid black;"></td>
        <td width="12%">day of</td>
        <td width="40%" style="border-bottom:0.1px solid black;"></td>
        <td width="3%">,</td>
        <td width="13%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td width="29%">in this Parish Church by Rev.</td>
        <td width="71%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td width="26%">and the sponsors were:</td>
        <td width="44%" style="border-bottom:0.1px solid black;"></td>
        <td width="6%">of</td>
        <td width="24%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td width="26%"></td>
        <td width="44%" style="border-bottom:0.1px solid black;"></td>
        <td width="6%">of</td>
        <td width="24%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td colspan="4">The above is an authentic copy of the record as it appears on Page</td>
      </tr>
      <tr>
        <td width="14%">Page</td>
        <td width="20%" style="border-bottom:0.1px solid black;"></td>
        <td width="14%">Volume</td>
        <td width="20%" style="border-bottom:0.1px solid black;"></td>
        <td width="10%">Line</td>
        <td width="22%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td colspan="6">of the Baptismal records on file in this Church.</td>
      </tr>
      <tr>
        <td width="30%">Given at the Parish office of</td>
        <td width="70%" style="border-bottom:0.1px solid black;"></td>
      </tr>
      <tr>
        <td width="10%">this</td>
        <td width="20%" style="border-bottom:0.1px solid black;"></td>
        <td width="12%">day of</td>
        <td width="40%" style="border-bottom:0.1px solid black;"></td>
        <td width="3%">,</td>
        <td width="15%" style="border-bottom:0.1px solid black;"></td>
      </tr>
    </table>
    <br><br><br>
    <table width="100%" border="0" style="font-size:12px;">
      <tr>
        <td width="62%"></td>
        <td width="38%" align="center" style="border-top:0.1px solid black;">Parish Priest</td>
      </tr>
    </table>';
    $pdf->writeHTML($contents,true, false, true, false, '');
    if (ob_get_level() > 0) {
      ob_end_clean();
    }
    $pdf->Output('FORM-CERTIFICATE OF BAPTISM.pdf', 'D');

?>
