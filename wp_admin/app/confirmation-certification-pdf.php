<?php
error_reporting(0);
ob_start();
	include 'includes/conn.php';
	if(isset($_GET['CONFID'])){
  	$CONFID =$_GET['CONFID'];
   $sql = "SELECT * FROM tbl_confirmation_certificate WHERE CONFID= '".$CONFID."'";
	$query = $conn->query($sql);
	if($query->num_rows > 0){
		$smtrow = $query->fetch_assoc();
		$CHILDNAME   		  =mysqli_real_escape_string($conn,(ucwords($smtrow['CHILDNAME'])));
    $DOB_BAPTISM   	  =mysqli_real_escape_string($conn,(ucwords($smtrow['DOB_BAPTISM'])));
    $PLACE_OF_BAPTISM =mysqli_real_escape_string($conn,(ucwords($smtrow['PLACE_OF_BAPTISM'])));
		$FATHER   	      =mysqli_real_escape_string($conn,(ucwords($smtrow['FATHER'])));
		$MOTHER   	      =mysqli_real_escape_string($conn,(ucwords($smtrow['MOTHER'])));
		$PARENTS_ADDRESS  =mysqli_real_escape_string($conn,(ucwords($smtrow['PARENTS_ADDRESS'])));
		$CHURCH_NAME   	  =mysqli_real_escape_string($conn,(ucwords($smtrow['CHURCH_NAME'])));
		$CHURCH_ADDRESS   =mysqli_real_escape_string($conn,(ucwords($smtrow['CHURCH_ADDRESS'])));
		$CONFIRMED_DATE   =mysqli_real_escape_string($conn,($smtrow['CONFIRMED_DATE']));
		$CONFIRMED_BY   	=mysqli_real_escape_string($conn,(ucwords($smtrow['CONFIRMED_BY'])));
		$SPONSORS   	    =mysqli_real_escape_string($conn,(ucwords($smtrow['SPONSORS'])));
		$NOTATIONS   	    =mysqli_real_escape_string($conn,($smtrow['NOTATIONS']));
		$GIVEN_DAY   	    =mysqli_real_escape_string($conn,($smtrow['GIVEN_DAY']));
		$GIVEN_MONTH   	  =mysqli_real_escape_string($conn,(ucwords($smtrow['GIVEN_MONTH'])));
		$GIVEN_YEAR   	  =mysqli_real_escape_string($conn,($smtrow['GIVEN_YEAR']));
		$BOOK_NO   	      =mysqli_real_escape_string($conn,($smtrow['BOOK_NO']));
		$PAGE_NO   	      =mysqli_real_escape_string($conn,($smtrow['PAGE_NO']));
		$REG_NO   	      =mysqli_real_escape_string($conn,($smtrow['REG_NO']));
	}else{
		$CHILDNAME  ="";
    $DOB_BAPTISM   	="";
    $PLACE_OF_BAPTISM   	="";
		$FATHER  ="";
		$MOTHER  ="";
		$PARENTS_ADDRESS  ="";
		$CHURCH_NAME   	="";
		$CHURCH_ADDRESS ="";
		$CONFIRMED_DATE   	="";
		$CONFIRMED_BY   	="";
		$SPONSORS   	="";
		$NOTATIONS   	="";
		$GIVEN_DAY   	="";
		$GIVEN_MONTH   ="";
		$GIVEN_YEAR   ="";
		$BOOK_NO   	="";
		$PAGE_NO   ="";
		$REG_NO   	="";
  }
		
}

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
      <?php
      error_reporting(0);
      ob_start();
      include 'includes/conn.php';

      function safe_html($value){
          return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
      }

      function date_parts($dateValue){
          $ts = strtotime((string)$dateValue);
          if(!$ts){
              return array('', '', '');
          }
          return array(date('j', $ts), date('F', $ts), date('Y', $ts));
      }

      function sponsor_lines($value){
          $raw = trim((string)$value);
          if($raw === ''){
              return array('', '');
          }

          $parts = preg_split('/\r\n|\r|\n|,/', $raw);
          $parts = array_values(array_filter(array_map('trim', $parts), function($part){
              return $part !== '';
          }));

          if(count($parts) === 0){
              return array(safe_html($raw), '');
          }

          $line1 = safe_html($parts[0]);
          $line2 = '';
          if(count($parts) > 1){
              $line2 = safe_html(implode(', ', array_slice($parts, 1)));
          }
          return array($line1, $line2);
      }

      if(isset($_GET['CONFID'])){
          $CONFID = $_GET['CONFID'];
          $sql = "SELECT * FROM tbl_confirmation_certificate WHERE CONFID= '".$CONFID."'";
          $query = $conn->query($sql);
          if($query->num_rows > 0){
              $smtrow = $query->fetch_assoc();
              $CHILDNAME       = mysqli_real_escape_string($conn, ($smtrow['CHILDNAME']));
              $DOB_BAPTISM     = mysqli_real_escape_string($conn, ($smtrow['DOB_BAPTISM']));
              $PLACE_OF_BAPTISM= mysqli_real_escape_string($conn, ($smtrow['PLACE_OF_BAPTISM']));
              $FATHER          = mysqli_real_escape_string($conn, ($smtrow['FATHER']));
              $MOTHER          = mysqli_real_escape_string($conn, ($smtrow['MOTHER']));
              $PARENTS_ADDRESS = mysqli_real_escape_string($conn, ($smtrow['PARENTS_ADDRESS']));
              $CHURCH_NAME     = mysqli_real_escape_string($conn, ($smtrow['CHURCH_NAME']));
              $CHURCH_ADDRESS  = mysqli_real_escape_string($conn, ($smtrow['CHURCH_ADDRESS']));
              $CONFIRMED_DATE  = mysqli_real_escape_string($conn, ($smtrow['CONFIRMED_DATE']));
              $CONFIRMED_BY    = mysqli_real_escape_string($conn, ($smtrow['CONFIRMED_BY']));
              $SPONSORS        = mysqli_real_escape_string($conn, ($smtrow['SPONSORS']));
              $NOTATIONS       = mysqli_real_escape_string($conn, ($smtrow['NOTATIONS']));
              $GIVEN_DAY       = mysqli_real_escape_string($conn, ($smtrow['GIVEN_DAY']));
              $GIVEN_MONTH     = mysqli_real_escape_string($conn, ($smtrow['GIVEN_MONTH']));
              $GIVEN_YEAR      = mysqli_real_escape_string($conn, ($smtrow['GIVEN_YEAR']));
              $BOOK_NO         = mysqli_real_escape_string($conn, ($smtrow['BOOK_NO']));
              $PAGE_NO         = mysqli_real_escape_string($conn, ($smtrow['PAGE_NO']));
              $REG_NO          = mysqli_real_escape_string($conn, ($smtrow['REG_NO']));
          } else {
              $CHILDNAME = $DOB_BAPTISM = $PLACE_OF_BAPTISM = $FATHER = $MOTHER = $PARENTS_ADDRESS = '';
              $CHURCH_NAME = $CHURCH_ADDRESS = $CONFIRMED_DATE = $CONFIRMED_BY = $SPONSORS = $NOTATIONS = '';
              $GIVEN_DAY = $GIVEN_MONTH = $GIVEN_YEAR = $BOOK_NO = $PAGE_NO = $REG_NO = '';
          }
      }

      require_once('../tcpdf/tcpdf.php');

      class MYPDF extends TCPDF {
        public function Header() {
            $bMargin = $this->getBreakMargin();
            $auto_page_break = $this->AutoPageBreak;
            $this->SetAutoPageBreak(false, 0);
            $img_file = K_PATH_IMAGES.'..';
            $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            $this->setPageMark();
        }
        public function Footer() {
          $this->SetY(-15);
          $this->SetFont('helvetica', 'I', 8);
        }
      }

      $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetTitle('Confirmation- '.$CHILDNAME);
      $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $pdf->SetDefaultMonospacedFont('times');
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      $pdf->SetMargins(14, 12, 14);
      $pdf->setPrintHeader(FALSE);
      $pdf->setPrintFooter(TRUE);
      $pdf->SetAutoPageBreak(TRUE, 10);
      $pdf->SetFont('times', '', 11);

      $sigFont = 10;
      $sql = "SELECT PRIEST_NAME FROM tbl_priest WHERE PRIEST_DEFAULT = 'YES'";
      $query = $conn->query($sql);
      if($query->num_rows > 0){
          $sig = $query->fetch_assoc();
          $PRIEST_NAME = trim(preg_replace('/\s+/', ' ', (string)$sig['PRIEST_NAME']));
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
      $pdf->SetLineStyle(array('width' => 0.4, 'color' => array(0,0,0)));
      $pdf->Rect(7, 7, 196, 283);
      $pdf->Rect(9, 9, 192, 279);
      $pdf->SetY(13);

      list($confirmedDay, $confirmedMonth, $confirmedYear) = date_parts($CONFIRMED_DATE);

      $childName = safe_html($CHILDNAME);
      $pob = safe_html($PLACE_OF_BAPTISM);
      $father = safe_html($FATHER);
      $mother = safe_html($MOTHER);
      $churchName = safe_html($CHURCH_NAME);
      $churchAddress = safe_html($CHURCH_ADDRESS);
      $confirmedBy = safe_html($CONFIRMED_BY);
      $notations = safe_html($NOTATIONS);
      $givenDay = safe_html($GIVEN_DAY);
      $givenMonth = safe_html($GIVEN_MONTH);
      $givenYear = safe_html($GIVEN_YEAR);
      $pageNo = safe_html($PAGE_NO);
      $bookNo = safe_html($BOOK_NO);
      $regNo = safe_html($REG_NO);
      $diocese = safe_html($SYS_DIOCESE);
      $parishName = $churchName !== '' ? $churchName : safe_html($SYS_CHURCH_NAME);
      $parishAddress = $churchAddress !== '' ? $churchAddress : safe_html($SYS_ADDRESS);

      list($sponsorLine1, $sponsorLine2) = sponsor_lines($SPONSORS);

      $crestHtml = ($right_logo !== '' && file_exists($right_logo)) ? '<img src="'.$right_logo.'" width="34">' : '';

      $contents = '
      <table width="100%" border="0" cellpadding="0">
        <tr>
          <td align="center" style="height:2mm;">'.$crestHtml.'</td>
        </tr>
        <tr>
          <td align="center" style="font-family:times; font-size:20px; font-weight:bold; color:#0B6B2E; letter-spacing:0.4px;">'.$diocese.'</td>
        </tr>
      </table>
      <br>
      <table width="100%" border="0" cellpadding="1.4" style="font-family:times; font-size:12.5px;">
        <tr>
          <td width="19%" style="font-weight:bold;">PARISH OF</td>
          <td width="81%" style="border-bottom:0.25px solid black;">'.$parishName.'</td>
        </tr>
        <tr>
          <td width="19%"></td>
          <td width="81%" style="border-bottom:0.25px solid black;">'.$parishAddress.'</td>
        </tr>
      </table>
      <br><br>
      <table width="100%" border="0" cellpadding="0">
        <tr><td align="center" style="font-family:times; font-size:24px; font-weight:bold; letter-spacing:0.6px;">CERTIFICATE OF CONFIRMATION</td></tr>
      </table>
      <br><br>
      <table width="100%" border="0" cellpadding="1.1" style="font-family:times; font-size:13px;">
        <tr>
          <td width="24%">This is to certify that</td>
          <td width="76%" style="border-bottom:0.25px solid black;">'.$childName.'</td>
        </tr>
        <tr>
          <td width="22%">Date of Baptism</td>
          <td width="78%" style="border-bottom:0.25px solid black;">'.safe_html($DOB_BAPTISM).'</td>
        </tr>
        <tr>
          <td width="29%">Place of Baptism</td>
          <td width="71%" style="border-bottom:0.25px solid black;">'.$pob.'</td>
        </tr>
        <tr>
          <td width="26%">Name of Father</td>
          <td width="74%" style="border-bottom:0.25px solid black;">'.$father.'</td>
        </tr>
        <tr>
          <td width="26%">Maiden Name of Mother</td>
          <td width="74%" style="border-bottom:0.25px solid black;">'.$mother.'</td>
        </tr>
        <tr>
          <td width="26%">Address of Parents</td>
          <td width="74%" style="border-bottom:0.25px solid black;">'.safe_html($PARENTS_ADDRESS).'</td>
        </tr>
        <tr>
          <td colspan="2"><br>Solemnly received the Sacrament of Confirmation according to the Rite of the Roman Catholic Church at the</td>
        </tr>
        <tr>
          <td width="31%">Name of Parish</td>
          <td style="float:left;text-transform:capitalize">'.$churchName.'</td>
        </tr>
        <tr>
          <td width="31%">Address of Parish</td>
          <td>'.$churchAddress.'</td>
        </tr>
        <tr>
          <td width="31%">Date of Confirmation</td>
          <td style="border-bottom:0.25px solid black;">'.$confirmedMonth.' '.$confirmedDay.', '.$confirmedYear.'</td>
        </tr>
        <tr>
          <td>Confirmed by</td>
          <td style="border-bottom:0.25px solid black;">'.$confirmedBy.'</td>
        </tr>
        <tr>
          <td width="31%"><br>Sponsors</td>
          <td width="69%">'.$sponsorLine1.'</td>
        </tr>
        <tr>
          <td></td>
          <td style="border-bottom:0.25px solid black;">'.$sponsorLine2.'</td>
        </tr>
        <tr>
          <td colspan="2"><br>Notations: '.$notations.'</td>
        </tr>
        <tr>
          <td colspan="2"><br>In witness thereof, hereunto I affixed my signature and the seal of the Parish</td>
        </tr>
        <tr>
          <td width="10%">this</td>
          <td width="90%" style="border-bottom:0.25px solid black;">'.$givenDay.' day of '.$givenMonth.', '.$givenYear.'</td>
        </tr>
      </table>';

      $pdf->writeHTML($contents,true, false, true, false, '');

      $signaturePriestName = trim(preg_replace('/\s+/', ' ', str_replace(array("\r","\n"), ' ', (string)$CONFIRMED_BY)));
      if($signaturePriestName === ''){
        $signaturePriestName = $PRIEST_NAME;
      }

      $sigBlockWidth = 58;
      $margins = $pdf->getMargins();
      $sigX = $pdf->getPageWidth() - $margins['right'] - $sigBlockWidth - 2;
      $sigLineY = $pdf->getPageHeight() - $margins['bottom'] - 22;

      if($signaturePriestName !== ''){
        $sigNameFont = 10;
        $pdf->SetFont('times', '', $sigNameFont);
        while($pdf->GetStringWidth($signaturePriestName) > ($sigBlockWidth - 2) && $sigNameFont > 7){
          $sigNameFont -= 0.5;
          $pdf->SetFont('times', '', $sigNameFont);
        }
        $pdf->SetXY($sigX, $sigLineY - 7);
        $pdf->Cell($sigBlockWidth, 5, $signaturePriestName, 0, 0, 'C', false, '', 0, false, 'T', 'M');
      }

      $pdf->SetLineWidth(0.2);
      $pdf->Line($sigX, $sigLineY, $sigX + $sigBlockWidth, $sigLineY);
      $pdf->SetFont('times', '', 11);
      if (ob_get_level() > 0) { ob_end_clean(); }
      $pdf->Output('Confirmation.pdf', 'D');

      ?>
