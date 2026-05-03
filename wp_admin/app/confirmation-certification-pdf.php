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
    $parts = array_values(array_filter(array_map('trim', $parts), function($part){ return $part !== ''; }));
    if(count($parts) === 0){ return array(safe_html($raw), ''); }
    $line1 = safe_html($parts[0]);
    $line2 = count($parts) > 1 ? safe_html(implode(', ', array_slice($parts, 1))) : '';
    return array($line1, $line2);
}

$CHILDNAME = $DOB_BAPTISM = $PLACE_OF_BAPTISM = $FATHER = $MOTHER = $PARENTS_ADDRESS = '';
$CHURCH_NAME = $CHURCH_ADDRESS = $CONFIRMED_DATE = $CONFIRMED_BY = $SPONSORS = $NOTATIONS = '';
$GIVEN_DAY = date('jS');
$GIVEN_MONTH = date('F');
$GIVEN_YEAR = date('Y');
$BOOK_NO = $PAGE_NO = $REG_NO = '';

if(isset($_GET['CONFID'])){
    $CONFID = intval($_GET['CONFID']);
    $sql = "SELECT * FROM tbl_confirmation_certificate WHERE CONFID= '".$CONFID."'";
    $query = $conn->query($sql);
    if($query->num_rows > 0){
        $smtrow = $query->fetch_assoc();
        $CHILDNAME = mysqli_real_escape_string($conn, ($smtrow['CHILDNAME']));
        $DOB_BAPTISM = mysqli_real_escape_string($conn, ($smtrow['DOB_BAPTISM']));
        $PLACE_OF_BAPTISM = mysqli_real_escape_string($conn, ($smtrow['PLACE_OF_BAPTISM']));
        $FATHER = mysqli_real_escape_string($conn, ($smtrow['FATHER']));
        $MOTHER = mysqli_real_escape_string($conn, ($smtrow['MOTHER']));
        $PARENTS_ADDRESS = mysqli_real_escape_string($conn, ($smtrow['PARENTS_ADDRESS']));
        $CHURCH_NAME = mysqli_real_escape_string($conn, ($smtrow['CHURCH_NAME']));
        $CHURCH_ADDRESS = mysqli_real_escape_string($conn, ($smtrow['CHURCH_ADDRESS']));
        $CONFIRMED_DATE = mysqli_real_escape_string($conn, ($smtrow['CONFIRMED_DATE']));
        $CONFIRMED_BY = mysqli_real_escape_string($conn, ($smtrow['CONFIRMED_BY']));
        $SPONSORS = mysqli_real_escape_string($conn, ($smtrow['SPONSORS']));
        $NOTATIONS = mysqli_real_escape_string($conn, ($smtrow['NOTATIONS']));
        $GIVEN_DAY = mysqli_real_escape_string($conn, ($smtrow['GIVEN_DAY']));
        $GIVEN_MONTH = mysqli_real_escape_string($conn, ($smtrow['GIVEN_MONTH']));
        $GIVEN_YEAR = mysqli_real_escape_string($conn, ($smtrow['GIVEN_YEAR']));
        $BOOK_NO = mysqli_real_escape_string($conn, ($smtrow['BOOK_NO']));
        $PAGE_NO = mysqli_real_escape_string($conn, ($smtrow['PAGE_NO']));
        $REG_NO = mysqli_real_escape_string($conn, ($smtrow['REG_NO']));
    }
}elseif(isset($_GET['CONFIRMATIONID'])){
    $CONFIRMATIONID = intval($_GET['CONFIRMATIONID']);
    $sql = "SELECT * FROM tbl_confirmation WHERE ID= '".$CONFIRMATIONID."'";
    $query = $conn->query($sql);
    if($query->num_rows > 0){
        $smtrow = $query->fetch_assoc();
        $CHILDNAME = mysqli_real_escape_string($conn, ($smtrow['CHILD_NAME']));
        $DOB_BAPTISM = mysqli_real_escape_string($conn, ($smtrow['DATE_OF_BAPTISM']));
        $PLACE_OF_BAPTISM = mysqli_real_escape_string($conn, ($smtrow['PLACE_OF_BAPTISM']));
        $FATHER = mysqli_real_escape_string($conn, ($smtrow['FATHER_NAME']));
        $MOTHER = mysqli_real_escape_string($conn, ($smtrow['MOTHER_NAME']));
        $PARENTS_ADDRESS = mysqli_real_escape_string($conn, ($smtrow['RESIDENT_OF']));
        $CHURCH_NAME = '';
        $CHURCH_ADDRESS = '';
        $CONFIRMED_DATE = mysqli_real_escape_string($conn, ($smtrow['DATE_CONFIRMED']));
        $CONFIRMED_BY = mysqli_real_escape_string($conn, ($smtrow['NAME_OF_PRIEST']));
        $SPONSORS = mysqli_real_escape_string($conn, ($smtrow['LIST_OF_SPONSORS']));
        $NOTATIONS = mysqli_real_escape_string($conn, ($smtrow['NOTATIONS']));
        $BOOK_NO = mysqli_real_escape_string($conn, ($smtrow['BOOK_NO']));
        $PAGE_NO = mysqli_real_escape_string($conn, ($smtrow['PAGE_NO']));
        $REG_NO = mysqli_real_escape_string($conn, ($smtrow['REG_NO']));
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

$sql = "SELECT PRIEST_NAME FROM tbl_priest WHERE PRIEST_DEFAULT = 'YES'";
$query = $conn->query($sql);
if($query->num_rows > 0){ $sig = $query->fetch_assoc(); $PRIEST_NAME = trim(preg_replace('/\s+/', ' ', (string)$sig['PRIEST_NAME'])); } else { $PRIEST_NAME=''; }

$sql = "SELECT * FROM tbl_system_setting";
$query = $conn->query($sql);
if($query->num_rows > 0){ $logo_setting = $query->fetch_assoc(); $right_logo = 'logo_right.jpg'; file_put_contents($right_logo, $logo_setting['SYS_LOGO']); $logo_left = 'logo_left.jpg'; file_put_contents($logo_left, $logo_setting['SYS_SECOND_LOGO']); $SYS_ADDRESS=$logo_setting['SYS_ADDRESS']; $SYS_DIOCESE=$logo_setting['SYS_DIOCESE']; $SYS_CHURCH_NAME=$logo_setting['SYS_CHURCH_NAME']; } else { $right_logo=''; $logo_left=''; }

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();
$pdf->SetDrawColor(70,70,70);
$pdf->SetLineWidth(0.45);
$pdf->RoundedRect(7, 7, 196, 283, 5, '1111');
$pdf->SetLineWidth(0.25);
$pdf->RoundedRect(9, 9, 192, 279, 4, '1111');
$pdf->SetY(15);

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
$diocese = safe_html(strtoupper($SYS_DIOCESE));
$parishName = $churchName !== '' ? $churchName : safe_html($SYS_CHURCH_NAME);
$parishAddress = $churchAddress !== '' ? $churchAddress : safe_html($SYS_ADDRESS);
$parishOffice = $parishName;
$baptismParts = date_parts($DOB_BAPTISM);

list($sponsorLine1, $sponsorLine2) = sponsor_lines($SPONSORS);

$crestHtml = ($right_logo !== '' && file_exists($right_logo)) ? '<img src="'.$right_logo.'" width="34">' : '';

$contents = '
<table width="100%" border="0" cellpadding="0">
  <tr>
    <td align="center" style="height:2mm;">'.$crestHtml.'</td>
  </tr>
  <tr>
    <td align="center" style="font-family:times; font-size:24px; font-weight:bold; color:#0B6B2E;">'.$diocese.'</td>
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
  <tr><td align="center" style="font-family:times; font-size:28px; font-weight:bold; color:#665f57;">CERTIFICATE OF CONFIRMATION</td></tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="1.1" style="font-family:times; font-size:13px;">
  <tr>
    <td width="24%">This is to certify that</td>
    <td width="76%" style="border-bottom:0.25px solid black;">'.$childName.'</td>
  </tr>
  <tr>
    <td width="12%">child of</td>
    <td width="43%" style="border-bottom:0.25px solid black;">'.$father.'</td>
    <td width="6%" align="center">and</td>
    <td width="39%" style="border-bottom:0.25px solid black;">'.$mother.'</td>
  </tr>
  <tr>
    <td width="20%">resident of</td>
    <td width="80%" style="border-bottom:0.25px solid black;">'.safe_html($PARENTS_ADDRESS).'</td>
  </tr>
  <tr>
    <td width="24%">was baptized at</td>
    <td width="76%" style="border-bottom:0.25px solid black;">'.$pob.'</td>
  </tr>
  <tr>
    <td width="14%">on the</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$baptismParts[0].'</td>
    <td width="12%">day of</td>
    <td width="40%" style="border-bottom:0.25px solid black;">'.$baptismParts[1].'</td>
    <td width="3%">,</td>
    <td width="13%" style="border-bottom:0.25px solid black;">'.$baptismParts[2].'</td>
  </tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="0">
  <tr><td align="center" style="font-family:times; font-size:15px; font-weight:bold; color:#665f57;">AND WAS CONFIRMED ACCORDING TO THE</td></tr>
  <tr><td align="center" style="font-family:times; font-size:15px; font-weight:bold; color:#665f57;">ROMAN CATHOLIC RITE</td></tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="1.1" style="font-family:times; font-size:13px;">
  <tr>
    <td width="14%">on the</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$confirmedDay.'</td>
    <td width="12%">day of</td>
    <td width="40%" style="border-bottom:0.25px solid black;">'.$confirmedMonth.'</td>
    <td width="3%">,</td>
    <td width="13%" style="border-bottom:0.25px solid black;">'.$confirmedYear.'</td>
  </tr>
  <tr>
    <td width="29%">in this Parish Church by Rev.</td>
    <td width="71%" style="border-bottom:0.25px solid black;">'.$confirmedBy.'</td>
  </tr>
  <tr>
    <td width="31%">Name of Parish</td>
    <td width="69%" style="border-bottom:0.25px solid black;">'.$parishName.'</td>
  </tr>
  <tr>
    <td width="31%">Address of Parish</td>
    <td width="69%" style="border-bottom:0.25px solid black;">'.$parishAddress.'</td>
  </tr>
  <tr>
    <td width="26%">and the sponsors were:</td>
    <td width="44%" style="border-bottom:0.25px solid black;">'.$sponsorLine1.'</td>
    <td width="6%">of</td>
    <td width="24%" style="border-bottom:0.25px solid black;"></td>
  </tr>
  <tr>
    <td width="26%"></td>
    <td width="44%" style="border-bottom:0.25px solid black;">'.$sponsorLine2.'</td>
    <td width="6%">of</td>
    <td width="24%" style="border-bottom:0.25px solid black;"></td>
  </tr>
  <tr>
    <td width="75%">The above is an authentic copy of the record as it appears on Page</td>
    <td width="25%" style="border-bottom:0.25px solid black;">'.$pageNo.'</td>
  </tr>
  <tr>
    <td width="12%">Volume</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$bookNo.'</td>
    <td width="8%">Line</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$regNo.'</td>
    <td width="44%">of the Confirmation records on file in</td>
  </tr>
  <tr>
    <td colspan="5">this Church.</td>
  </tr>
  <tr>
    <td width="30%">Given at the Parish office of</td>
    <td width="70%" colspan="4" style="border-bottom:0.25px solid black;">'.$parishOffice.'</td>
  </tr>
  <tr>
    <td width="10%">this</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$givenDay.'</td>
    <td width="10%">day of</td>
    <td width="36%" style="border-bottom:0.25px solid black;">'.$givenMonth.'</td>
    <td width="6%">,</td>
    <td width="20%" style="border-bottom:0.25px solid black;">'.$givenYear.'</td>
  </tr>
  <tr><td colspan="6">&nbsp;</td></tr>
  <tr><td colspan="6">Notations: '.$notations.'</td></tr>
</table>';

$pdf->writeHTML($contents,true, false, true, false, '');

$signaturePriestName = trim(preg_replace('/\s+/', ' ', str_replace(array("\r","\n"), ' ', (string)$CONFIRMED_BY)));
if($signaturePriestName === ''){ $signaturePriestName = $PRIEST_NAME; }

$sigBlockWidth = 58;
$margins = $pdf->getMargins();
$sigX = $pdf->getPageWidth() - $margins['right'] - $sigBlockWidth - 2;
$sigLineY = $pdf->getPageHeight() - $margins['bottom'] - 22;

if($signaturePriestName !== ''){
  $sigNameFont = 10;
  $pdf->SetFont('times', '', $sigNameFont);
  while($pdf->GetStringWidth($signaturePriestName) > ($sigBlockWidth - 2) && $sigNameFont > 7){ $sigNameFont -= 0.5; $pdf->SetFont('times', '', $sigNameFont); }
  $pdf->SetXY($sigX, $sigLineY - 7);
  $pdf->Cell($sigBlockWidth, 5, $signaturePriestName, 0, 0, 'C', false, '', 0, false, 'T', 'M');
}

$pdf->SetLineWidth(0.2);
$pdf->Line($sigX, $sigLineY, $sigX + $sigBlockWidth, $sigLineY);
$pdf->SetXY($sigX, $sigLineY + 1.5);
$pdf->SetFont('times', '', 11);
$pdf->Cell($sigBlockWidth, 5, 'Parish Priest', 0, 0, 'C');
if (ob_get_level() > 0) { ob_end_clean(); }
$pdf->Output('Confirmation.pdf', 'D');

?>
