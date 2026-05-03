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
$pdf->SetDrawColor(70,70,70);
$pdf->SetLineWidth(0.45);
$pdf->RoundedRect(7, 7, 196, 283, 5, '1111');
$pdf->SetLineWidth(0.25);
$pdf->RoundedRect(9, 9, 192, 279, 4, '1111');
$pdf->SetY(15);

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
$pageNo = safe_html($PAGE_NO);
$bookNo = safe_html($BOOK_NO);
$regNo = safe_html($REG_NO);
$groomParentLine = $groomMother !== '' ? $groomFather.' and '.$groomMother : $groomFather;
$brideParentLine = $brideMother !== '' ? $brideFather.' and '.$brideMother : $brideFather;
$parishName = safe_html($SYS_CHURCH_NAME);
$parishAddress = safe_html($SYS_ADDRESS);
$parishOffice = $parishName;
$diocese = safe_html(strtoupper($SYS_DIOCESE));
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
  <tr><td align="center" style="font-family:times; font-size:28px; font-weight:bold; color:#665f57;">CERTIFICATE OF MARRIAGE</td></tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="1.1" style="font-family:times; font-size:13px;">
  <tr>
    <td width="23%">This is to certify that</td>
    <td width="33%" style="border-bottom:0.25px solid black;">'.$groom.'</td>
    <td width="8%" align="center">and</td>
    <td width="36%" style="border-bottom:0.25px solid black;">'.$bride.'</td>
  </tr>
  <tr>
    <td width="17%">Son of</td>
    <td width="83%" style="border-bottom:0.25px solid black;">'.$groomParentLine.'</td>
  </tr>
  <tr>
    <td width="17%">Daughter of</td>
    <td width="83%" style="border-bottom:0.25px solid black;">'.$brideParentLine.'</td>
  </tr>
  <tr>
    <td width="18%">Groom residence</td>
    <td width="82%" style="border-bottom:0.25px solid black;">'.$groomRes.'</td>
  </tr>
  <tr>
    <td width="18%">Bride residence</td>
    <td width="82%" style="border-bottom:0.25px solid black;">'.$brideRes.'</td>
  </tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="0">
  <tr><td align="center" style="font-family:times; font-size:15px; font-weight:bold; color:#665f57;">WERE MARRIED ACCORDING TO THE</td></tr>
  <tr><td align="center" style="font-family:times; font-size:15px; font-weight:bold; color:#665f57;">ROMAN CATHOLIC RITE</td></tr>
</table>
<br><br>
<table width="100%" border="0" cellpadding="1.1" style="font-family:times; font-size:13px;">
  <tr>
    <td width="14%">on the</td>
    <td width="18%" style="border-bottom:0.25px solid black;">'.$dateMarriageParts[0].'</td>
    <td width="12%">day of</td>
    <td width="40%" style="border-bottom:0.25px solid black;">'.$dateMarriageParts[1].'</td>
    <td width="3%">,</td>
    <td width="13%" style="border-bottom:0.25px solid black;">'.$dateMarriageParts[2].'</td>
  </tr>
  <tr>
    <td width="29%">in this Parish Church by Rev.</td>
    <td width="71%" style="border-bottom:0.25px solid black;">'.$solemnPriest.'</td>
  </tr>
  <tr>
    <td width="24%">Place of Marriage</td>
    <td width="76%" style="border-bottom:0.25px solid black;">'.$placeMarriage.'</td>
  </tr>
  <tr>
    <td width="30%">and the witnesses were:</td>
    <td width="70%" style="border-bottom:0.25px solid black;">'.$witness.'</td>
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
    <td width="44%">of the Marriage records on file in</td>
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
$pdf->SetXY($sigX, $sigLineY + 1.5);
$pdf->SetFont('times', '', 11);
$pdf->Cell($sigBlockWidth, 5, 'Parish Priest', 0, 0, 'C');
if (ob_get_level() > 0) { ob_end_clean(); }
$pdf->Output('Marriage Certificate.pdf', 'D');

?>
