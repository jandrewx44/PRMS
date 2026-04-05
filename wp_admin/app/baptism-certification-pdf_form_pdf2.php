<?php
error_reporting(0);
include 'includes/conn.php';
ob_start();

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

$CHILDNAME = '';
$DOB = '';
$POB = '';
$FATHER = '';
$MOTHER = '';
$CHURCH_NAME = '';
$CHURCH_ADDRESS = '';
$DOB_BAPTISM = '';
$BAPTIZED_BY = '';
$SPONSORS = '';
$NOTATIONS = '';
$BOOK_NO = '';
$PAGE_NO = '';
$REG_NO = '';

if(isset($_GET['baptismid'])){
	$baptismId = intval($_GET['baptismid']);
	$sql = "SELECT * FROM tbl_baptismal WHERE ID = ".$baptismId;
	$query = $conn->query($sql);
	if($query && $query->num_rows > 0){
		$smtrow = $query->fetch_assoc();
		$CHILDNAME = $smtrow['CHILD_NAME'];
		$DOB = $smtrow['DATE_OF_BIRTH'];
		$POB = $smtrow['PLACE_OF_BIRTH'];
		$FATHER = $smtrow['FATHER_NAME'];
		$MOTHER = $smtrow['MOTHER_NAME'];
		$CHURCH_NAME = $smtrow['NAME_OF_CHURCH'];
		$CHURCH_ADDRESS = $smtrow['PLACE_OF_BAPTISM'];
		$DOB_BAPTISM = $smtrow['DATE_OF_BAPTISM'];
		$BAPTIZED_BY = $smtrow['NAME_OF_PRIEST'];
		$SPONSORS = $smtrow['LIST_OF_SPONSORS'];
		$NOTATIONS = $smtrow['NOTATIONS'];
		$BOOK_NO = $smtrow['BOOK_NO'];
		$PAGE_NO = $smtrow['PAGE_NO'];
		$REG_NO = $smtrow['REG_NO'];
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
$pdf->SetTitle('BAPTISMAL- '.$CHILDNAME);
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
if($query && $query->num_rows > 0){
	$sig = $query->fetch_assoc();
	$PRIEST_NAME = trim(preg_replace('/\s+/', ' ', str_replace(array("\r", "\n"), ' ', $sig['PRIEST_NAME'])));
} else {
	$PRIEST_NAME = '';
}

$right_logo = '';
$logo_left = '';
$SYS_ADDRESS = '';
$SYS_DIOCESE = 'DIOCESE OF DIPOLOG';
$SYS_CHURCH_NAME = '';

$sql = "SELECT * FROM tbl_system_setting";
$query = $conn->query($sql);
if($query && $query->num_rows > 0){
	$logo_setting = $query->fetch_assoc();
	$right_logo = 'logo_right.jpg';
	file_put_contents($right_logo, $logo_setting['SYS_LOGO']);
	$logo_left = 'logo_left.jpg';
	file_put_contents($logo_left, $logo_setting['SYS_SECOND_LOGO']);
	$SYS_ADDRESS = $logo_setting['SYS_ADDRESS'];
	$SYS_DIOCESE = $logo_setting['SYS_DIOCESE'];
	$SYS_CHURCH_NAME = $logo_setting['SYS_CHURCH_NAME'];
}

list($dobDay, $dobMonth, $dobYear) = date_parts($DOB);
list($bapDay, $bapMonth, $bapYear) = date_parts($DOB_BAPTISM);
list($sponsorLine1, $sponsorLine2) = sponsor_lines($SPONSORS);

$childName = safe_html($CHILDNAME);
$birthPlace = safe_html($POB);
$father = safe_html($FATHER);
$mother = safe_html($MOTHER);
$baptizedBy = safe_html($BAPTIZED_BY);
$notations = safe_html($NOTATIONS);
$pageNo = safe_html($PAGE_NO);
$bookNo = safe_html($BOOK_NO);
$regNo = safe_html($REG_NO);
$diocese = safe_html($SYS_DIOCESE);
$parishNameRaw = trim((string)$CHURCH_NAME) !== '' ? $CHURCH_NAME : $SYS_CHURCH_NAME;
$parishAddressRaw = trim((string)$CHURCH_ADDRESS) !== '' ? $CHURCH_ADDRESS : $SYS_ADDRESS;
$parishName = safe_html($parishNameRaw);
$parishAddress = safe_html($parishAddressRaw);
$crestHtml = ($right_logo !== '' && file_exists($right_logo)) ? '<img src="'.$right_logo.'" width="34">' : '';

$givenDay = date('jS');
$givenMonth = date('F');
$givenYear = date('Y');

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();
$pdf->SetLineStyle(array('width' => 0.4, 'color' => array(0, 0, 0)));
$pdf->Rect(7, 7, 196, 283);
$pdf->Rect(9, 9, 192, 279);
$pdf->SetY(13);

$notationsRow = '';
if($notations !== ''){
	$notationsRow = '
  <tr>
    <td colspan="7">Notations: '.$notations.'</td>
  </tr>';
}

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
<br>
<table width="100%" border="0" cellpadding="0">
  <tr><td align="center" style="font-family:times; font-size:24px; font-weight:bold; letter-spacing:0.6px;">CERTIFICATE OF BAPTISM</td></tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="1.1" style="font-family:times; font-size:13px;">
  <tr>
    <td width="24%">This is to certify that</td>
    <td width="76%" style="border-bottom:0.25px solid black;">'.$childName.'</td>
  </tr>
  <tr>
    <td width="22%">Son</td>
    <td width="4%">)</td>
    <td width="10%">of</td>
    <td width="64%" style="border-bottom:0.25px solid black;">'.$father.'</td>
  </tr>
  <tr>
    <td width="22%">Daughter</td>
    <td width="4%">)</td>
    <td width="10%">and</td>
    <td width="64%" style="border-bottom:0.25px solid black;">'.$mother.'</td>
  </tr>
  <tr>
    <td width="20%">was born in</td>
    <td width="80%" style="border-bottom:0.25px solid black;">'.$birthPlace.'</td>
  </tr>
  <tr>
    <td width="14%">on the</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$dobDay.'</td>
    <td width="12%">day of</td>
    <td width="40%" style="border-bottom:0.25px solid black;">'.$dobMonth.'</td>
    <td width="3%">,</td>
    <td width="13%" style="border-bottom:0.25px solid black;">'.$dobYear.'</td>
  </tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="0">
  <tr><td align="center" style="font-family:times; font-size:15px; font-weight:bold;">AND WAS BAPTIZED ACCORDING TO THE</td></tr>
  <tr><td align="center" style="font-family:times; font-size:15px; font-weight:bold;">ROMAN CATHOLIC RITE</td></tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="1.1" style="font-family:times; font-size:13px;">
  <tr>
    <td width="14%">on the</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$bapDay.'</td>
    <td width="12%">day of</td>
    <td width="40%" style="border-bottom:0.25px solid black;">'.$bapMonth.'</td>
    <td width="3%">,</td>
    <td width="13%" style="border-bottom:0.25px solid black;">'.$bapYear.'</td>
  </tr>
  <tr>
    <td width="29%">in this Parish Church by Rev.</td>
    <td width="71%" style="border-bottom:0.25px solid black;">'.$baptizedBy.'</td>
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
    <td colspan="7">The above is an authentic copy of the record as it appears on Page</td>
  </tr>
  <tr>
    <td width="8%">Page</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$pageNo.'</td>
    <td width="10%">Volume</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$bookNo.'</td>
    <td width="8%">Line</td>
    <td width="16%" style="border-bottom:0.25px solid black;">'.$regNo.'</td>
    <td width="22%">of the Baptismal</td>
  </tr>
  <tr>
    <td colspan="7">records on file in this Church.</td>
  </tr>
  <tr>
    <td width="30%">Given at the Parish office of</td>
    <td width="70%" colspan="6" style="border-bottom:0.25px solid black;">'.$parishName.'</td>
  </tr>
  <tr>
    <td width="10%">this</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$givenDay.'</td>
    <td width="10%">day of</td>
    <td width="36%" style="border-bottom:0.25px solid black;">'.$givenMonth.'</td>
    <td width="6%">,</td>
    <td width="20%" colspan="2" style="border-bottom:0.25px solid black;">'.$givenYear.'</td>
  </tr>
  <tr><td colspan="7">&nbsp;</td></tr>'.$notationsRow.'
</table>';

$pdf->writeHTML($contents, true, false, true, false, '');

$sigBlockWidth = 58;
$margins = $pdf->getMargins();
$sigX = $pdf->getPageWidth() - $margins['right'] - $sigBlockWidth - 2;
$sigLineY = $pdf->getPageHeight() - $margins['bottom'] - 22;

if($PRIEST_NAME !== ''){
	$sigNameFont = 10;
	$pdf->SetFont('times', '', $sigNameFont);
	while($pdf->GetStringWidth($PRIEST_NAME) > ($sigBlockWidth - 2) && $sigNameFont > 7){
		$sigNameFont -= 0.5;
		$pdf->SetFont('times', '', $sigNameFont);
	}
	$pdf->SetXY($sigX, $sigLineY - 7);
	$pdf->Cell($sigBlockWidth, 5, $PRIEST_NAME, 0, 0, 'C', false, '', 0, false, 'T', 'M');
}

$pdf->SetLineWidth(0.2);
$pdf->Line($sigX, $sigLineY, $sigX + $sigBlockWidth, $sigLineY);
$pdf->SetFont('times', '', 11);
$pdf->SetXY($sigX, $sigLineY + 1.5);
$pdf->Cell($sigBlockWidth, 5, 'Parish Priest', 0, 0, 'C');

if(ob_get_level() > 0){
	ob_end_clean();
}
$pdf->Output('Baptismal.pdf', 'I');
?>
