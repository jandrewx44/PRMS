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

$fromMarriageRecord = false;
$GROOM_NAME = $GROOM_RESIDENCE = $GROOM_FATHER = $GROOM_MOTHER = '';
$BRIDE_NAME = $BRIDE_RESIDENCE = $BRIDE_FATHER = $BRIDE_MOTHER = '';
$PLACE_OF_MARRIAGE = $DATE_OF_MARRIAGE = $NAME_OF_WITNESS = $SOLEMNIZING_PRIEST = '';
$GIVEN_DAY = date('jS');
$GIVEN_MONTH = date('F');
$GIVEN_YEAR = date('Y');
$BOOK_NO = $PAGE_NO = $REG_NO = '';

if(isset($_GET['MARRIAGEID'])){
    $MARRIAGEID = intval($_GET['MARRIAGEID']);
    $sql = "SELECT * FROM tbl_marriage_certificate WHERE MARRIAGEID= '".$MARRIAGEID."'";
    $query = $conn->query($sql);
    if($query->num_rows > 0){
        $smtrow = $query->fetch_assoc();
        $GROOM_NAME = mysqli_real_escape_string($conn, ($smtrow['GROOM_NAME']));
        $GROOM_RESIDENCE = mysqli_real_escape_string($conn, ($smtrow['GROOM_RESIDENCE']));
        $GROOM_FATHER = mysqli_real_escape_string($conn, ($smtrow['GROOM_FATHER']));
        $GROOM_MOTHER = mysqli_real_escape_string($conn, ($smtrow['GROOM_MOTHER']));
        $BRIDE_NAME = mysqli_real_escape_string($conn, ($smtrow['BRIDE_NAME']));
        $BRIDE_RESIDENCE = mysqli_real_escape_string($conn, ($smtrow['BRIDE_RESIDENCE']));
        $BRIDE_FATHER = mysqli_real_escape_string($conn, ($smtrow['BRIDE_FATHER']));
        $BRIDE_MOTHER = mysqli_real_escape_string($conn, ($smtrow['BRIDE_MOTHER']));
        $PLACE_OF_MARRIAGE = mysqli_real_escape_string($conn, ($smtrow['PLACE_OF_MARRIAGE']));
        $DATE_OF_MARRIAGE = mysqli_real_escape_string($conn, ($smtrow['DATE_OF_MARRIAGE']));
        $NAME_OF_WITNESS = mysqli_real_escape_string($conn, ($smtrow['NAME_OF_WITNESS']));
        $SOLEMNIZING_PRIEST = mysqli_real_escape_string($conn, ($smtrow['SOLEMNIZING_PRIEST']));
        $GIVEN_DAY = mysqli_real_escape_string($conn, ($smtrow['GIVEN_DAY']));
        $GIVEN_MONTH = mysqli_real_escape_string($conn, ($smtrow['GIVEN_MONTH']));
        $GIVEN_YEAR = mysqli_real_escape_string($conn, ($smtrow['GIVEN_YEAR']));
        $BOOK_NO = mysqli_real_escape_string($conn, ($smtrow['BOOK_NO']));
        $PAGE_NO = mysqli_real_escape_string($conn, ($smtrow['PAGE_NO']));
        $REG_NO = mysqli_real_escape_string($conn, ($smtrow['REG_NO']));
    }
}elseif(isset($_GET['MARRIAGERECORDID'])){
    $fromMarriageRecord = true;
    $MARRIAGERECORDID = intval($_GET['MARRIAGERECORDID']);
    $sql = "SELECT * FROM tbl_marriage WHERE ID= '".$MARRIAGERECORDID."'";
    $query = $conn->query($sql);
    if($query->num_rows > 0){
        $smtrow = $query->fetch_assoc();
        $GROOM_NAME = mysqli_real_escape_string($conn, ($smtrow['NAME_MALE']));
        $GROOM_RESIDENCE = mysqli_real_escape_string($conn, ($smtrow['ACTUAL_ADDRESS_MALE']));
        $GROOM_FATHER = mysqli_real_escape_string($conn, ($smtrow['PARENTS_MALE']));
        $GROOM_MOTHER = '';
        $BRIDE_NAME = mysqli_real_escape_string($conn, ($smtrow['NAME_FEMALE']));
        $BRIDE_RESIDENCE = mysqli_real_escape_string($conn, ($smtrow['ACTUAL_ADDRESS_FEMALE']));
        $BRIDE_FATHER = mysqli_real_escape_string($conn, ($smtrow['PARENTS_FEMALE']));
        $BRIDE_MOTHER = '';
        $PLACE_OF_MARRIAGE = '';
        $DATE_OF_MARRIAGE = mysqli_real_escape_string($conn, ($smtrow['DATE_OF_MARRIAGE']));
        $NAME_OF_WITNESS = trim((string)$smtrow['SPONSORS_MALE']);
        if(trim((string)$smtrow['SPONSORS_FEMALE']) !== ''){
            $NAME_OF_WITNESS .= ($NAME_OF_WITNESS !== '' ? ', ' : '').trim((string)$smtrow['SPONSORS_FEMALE']);
        }
        $SOLEMNIZING_PRIEST = mysqli_real_escape_string($conn, ($smtrow['MARRIAGE_MINISTER']));
        $BOOK_NO = mysqli_real_escape_string($conn, ($smtrow['BOOK_NO']));
        $PAGE_NO = mysqli_real_escape_string($conn, ($smtrow['PAGE_NO']));
        $REG_NO = mysqli_real_escape_string($conn, ($smtrow['REG_NO']));
    }
}

require_once('../tcpdf/tcpdf.php');

class MYPDF extends TCPDF { public function Header(){ $bMargin = $this->getBreakMargin(); $auto_page_break = $this->AutoPageBreak; $this->SetAutoPageBreak(false,0); $img_file = K_PATH_IMAGES.'..'; $this->Image($img_file,0,0,210,297,'','','',false,300,'',false,false,0); $this->SetAutoPageBreak($auto_page_break,$bMargin); $this->setPageMark(); } public function Footer(){ $this->SetY(-15); $this->SetFont('helvetica','I',8); } }

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Marriage Certificate- '.$GROOM_NAME.' & '.$BRIDE_NAME);
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
if($query->num_rows > 0){ $sig = $query->fetch_assoc(); $PRIEST_NAME = trim(preg_replace('/\s+/', ' ', (string)$sig['PRIEST_NAME'])); } else { $PRIEST_NAME=''; }

$sql = "SELECT * FROM tbl_system_setting";
$query = $conn->query($sql);
if($query->num_rows > 0){ $logo_setting = $query->fetch_assoc(); $right_logo = 'logo_right.jpg'; file_put_contents($right_logo, $logo_setting['SYS_LOGO']); $logo_left = 'logo_left.jpg'; file_put_contents($logo_left, $logo_setting['SYS_SECOND_LOGO']); $SYS_ADDRESS=$logo_setting['SYS_ADDRESS']; $SYS_DIOCESE=$logo_setting['SYS_DIOCESE']; $SYS_CHURCH_NAME=$logo_setting['SYS_CHURCH_NAME']; } else { $right_logo=''; $logo_left=''; }

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->AddPage();
$pdf->SetLineStyle(array('width' => 0.4, 'color' => array(0,0,0)));
$pdf->Rect(7, 7, 196, 283);
$pdf->Rect(9, 9, 192, 279);
$pdf->SetY(13);

$groom = safe_html($GROOM_NAME);
$groomRes = safe_html($GROOM_RESIDENCE);
$groomFather = safe_html($GROOM_FATHER);
$groomMother = safe_html($GROOM_MOTHER);
$bride = safe_html($BRIDE_NAME);
$brideRes = safe_html($BRIDE_RESIDENCE);
$brideFather = safe_html($BRIDE_FATHER);
$brideMother = safe_html($BRIDE_MOTHER);
$placeMarriage = safe_html($PLACE_OF_MARRIAGE);
$dateMarriageParts = date_parts($DATE_OF_MARRIAGE);
$witness = safe_html($NAME_OF_WITNESS);
$solemnPriest = safe_html($SOLEMNIZING_PRIEST);
$givenDay = safe_html($GIVEN_DAY);
$givenMonth = safe_html($GIVEN_MONTH);
$givenYear = safe_html($GIVEN_YEAR);

if($fromMarriageRecord){
  $groomParentRows = '
  <tr>
    <td>Parents of Groom</td>
    <td style="border-bottom:0.25px solid black;">'.$groomFather.'</td>
  </tr>';
  $brideParentRows = '
  <tr>
    <td>Parents of Bride</td>
    <td style="border-bottom:0.25px solid black;">'.$brideFather.'</td>
  </tr>';
}else{
  $groomParentRows = '
  <tr>
    <td>Name of Father</td>
    <td style="border-bottom:0.25px solid black;">'.$groomFather.'</td>
  </tr>
  <tr>
    <td>Name of Mother</td>
    <td style="border-bottom:0.25px solid black;">'.$groomMother.'</td>
  </tr>';
  $brideParentRows = '
  <tr>
    <td>Name of Father</td>
    <td style="border-bottom:0.25px solid black;">'.$brideFather.'</td>
  </tr>
  <tr>
    <td>Name of Mother</td>
    <td style="border-bottom:0.25px solid black;">'.$brideMother.'</td>
  </tr>';
}

$diocese = safe_html($SYS_DIOCESE);
$crestHtml = ($right_logo !== '' && file_exists($right_logo)) ? '<img src="'.$right_logo.'" width="34">' : '';

$contents = '
<table width="100%" border="0" cellpadding="0">
  <tr>
    <td align="center" style="height:2mm;">'.$crestHtml.'</td>
  </tr>
  <tr>
    <td align="center" style="font-family:times; font-size:20px; font-weight:bold; color:#0B6B2E; letter-spacing:0.4px;">'.safe_html($SYS_DIOCESE).'</td>
  </tr>
</table>
<br>
<table width="100%" border="0" cellpadding="1.4" style="font-family:times; font-size:12.5px;">
  <tr>
    <td width="19%" style="font-weight:bold;">PARISH OF</td>
    <td width="81%" style="border-bottom:0.25px solid black;">'.safe_html($SYS_CHURCH_NAME).'</td>
  </tr>
  <tr>
    <td width="19%"></td>
    <td width="81%" style="border-bottom:0.25px solid black;">'.safe_html($SYS_ADDRESS).'</td>
  </tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="0">
  <tr><td align="center" style="font-family:times; font-size:24px; font-weight:bold; letter-spacing:0.6px;">CERTIFICATE OF MARRIAGE</td></tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="1.1" style="font-family:times; font-size:13px;">
  <tr>
    <td width="31%">Name of Groom</td>
    <td width="69%" style="border-bottom:0.25px solid black;">'.$groom.'</td>
  </tr>
  <tr>
    <td>Residence</td>
    <td style="border-bottom:0.25px solid black;">'.$groomRes.'</td>
  </tr>
  '.$groomParentRows.'
  <tr>
    <td colspan="2"><br>And</td>
  </tr>
  <tr>
    <td width="31%">Name of Bride</td>
    <td width="69%" style="border-bottom:0.25px solid black;">'.$bride.'</td>
  </tr>
  <tr>
    <td>Residence</td>
    <td style="border-bottom:0.25px solid black;">'.$brideRes.'</td>
  </tr>
  '.$brideParentRows.'
  <tr>
    <td colspan="2"><br>Were solemnly married according to the Rites of the Roman Catholic Church</td>
  </tr>
  <tr>
    <td width="31%">Place of Marriage</td>
    <td style="border-bottom:0.25px solid black;">'.$placeMarriage.'</td>
  </tr>
  <tr>
    <td width="31%">Date of Marriage</td>
    <td style="border-bottom:0.25px solid black;">'.$dateMarriageParts[1].' '.$dateMarriageParts[0].', '.$dateMarriageParts[2].'</td>
  </tr>
  <tr>
    <td width="31%">Name of Witness(es)</td>
    <td style="border-bottom:0.25px solid black;">'.$witness.'</td>
  </tr>
  <tr>
    <td width="31%">Solemnizing Priest</td>
    <td style="border-bottom:0.25px solid black;">'.$solemnPriest.'</td>
  </tr>
  <tr>
    <td colspan="2"><br>In witness thereof, hereunto I affixed my signature and the seal of the Parish this '.$givenDay.' day of '.$givenMonth.', '.$givenYear.'</td>
  </tr>
</table>';

$pdf->writeHTML($contents,true, false, true, false, '');

$signaturePriestName = trim(preg_replace('/\s+/', ' ', str_replace(array("\r","\n"), ' ', (string)$SOLEMNIZING_PRIEST)));
if($signaturePriestName === ''){ $signaturePriestName = $PRIEST_NAME; }

$sigBlockWidth = 58;
$margins = $pdf->getMargins();
$sigX = $pdf->getPageWidth() - $margins['right'] - $sigBlockWidth - 2;
$sigLineY = $pdf->getPageHeight() - $margins['bottom'] - 22;

if($signaturePriestName !== ''){
  $sigNameFont = 10; $pdf->SetFont('times', '', $sigNameFont);
  while($pdf->GetStringWidth($signaturePriestName) > ($sigBlockWidth - 2) && $sigNameFont > 7){ $sigNameFont -= 0.5; $pdf->SetFont('times', '', $sigNameFont); }
  $pdf->SetXY($sigX, $sigLineY - 7); $pdf->Cell($sigBlockWidth, 5, $signaturePriestName, 0, 0, 'C', false, '', 0, false, 'T', 'M');
}

$pdf->SetLineWidth(0.2); $pdf->Line($sigX, $sigLineY, $sigX + $sigBlockWidth, $sigLineY);
$pdf->SetFont('times', '', 11);
if (ob_get_level() > 0) { ob_end_clean(); }
$pdf->Output('Marriage Certificate.pdf', 'D');

?>
