<?php require_once('../../Connections/koneksi.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rsSuratBulanan = "-1";
$colname_rsSuratBulanan2 = "-1";
if (isset($_POST['bulanNya']) && isset($_POST['tahunNya'])) {
  $colname_rsSuratBulanan = $_POST['bulanNya'];
  $colname_rsSuratBulanan2 = $_POST['tahunNya'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsSuratBulanan = sprintf("SELECT * FROM tb_surat WHERE MONTH(tanggal_input) = %s AND YEAR(tanggal_input)=%s ORDER BY tanggal_input DESC", GetSQLValueString($colname_rsSuratBulanan, "date"),GetSQLValueString($colname_rsSuratBulanan2, "date"));
$rsSuratBulanan = mysql_query($query_rsSuratBulanan, $koneksi) or die(mysql_error());
$row_rsSuratBulanan = mysql_fetch_assoc($rsSuratBulanan);
$totalRows_rsSuratBulanan = mysql_num_rows($rsSuratBulanan);
$nomor = 1;
?>
<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<!DOCTYPE html>
<html>
<head>
<title>CETAK LAPORAN SURAT</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../assets/w3.css">
<link href="../../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../../assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
</style>
</head>
<body onLoad="window.print() ">

<div class="w3-container">
  <div class="w3-row">
    <div class="w3-center">
    	<div class="w3-large">LAPORAN DATA SURAT PENGANTAR RW 03</div>
        <div class="w3-large">BULAN <?php if($colname_rsSuratBulanan == "01"){
	echo "JANUARI"." TAHUN ".$colname_rsSuratBulanan2;
	} elseif($colname_rsSuratBulanan == "02"){
		echo "FEBRUARI"." TAHUN ".$colname_rsSuratBulanan2;
		} elseif($colname_rsSuratBulanan == "03"){
		echo "MARET"." TAHUN ".$colname_rsSuratBulanan2;
		} elseif($colname_rsSuratBulanan == "04"){
		echo "APRIL"." TAHUN ".$colname_rsSuratBulanan2;
		} elseif($colname_rsSuratBulanan == "05"){
		echo "MEI"." TAHUN ".$colname_rsSuratBulanan2;
		} elseif($colname_rsSuratBulanan == "06"){
		echo "JUNI"." TAHUN ".$colname_rsSuratBulanan2;
		} elseif($colname_rsSuratBulanan == "07"){
		echo "JULI"." TAHUN ".$colname_rsSuratBulanan2;
		} elseif($colname_rsSuratBulanan == "08"){
		echo "AGUSTUS"." TAHUN ".$colname_rsSuratBulanan2;
		} elseif($colname_rsSuratBulanan == "09"){
		echo "SEPTEMBER"." TAHUN ".$colname_rsSuratBulanan2;
		} elseif($colname_rsSuratBulanan == "10"){
		echo "OKTOBER"." TAHUN ".$colname_rsSuratBulanan2;
		} elseif($colname_rsSuratBulanan == "11"){
		echo "NOVEMBER"." TAHUN ".$colname_rsSuratBulanan2;
		} elseif($colname_rsSuratBulanan == "12"){
		echo "DESEMBER"." TAHUN ".$colname_rsSuratBulanan2;
		} ?></div>
<div class="w3-small">Kelurahan Periuk Kecamatan Periuk Kota Tangerang</div>
    </div>
    <hr>
    <?php if ($totalRows_rsSuratBulanan > 0) { // Show if recordset not empty ?>
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" style="margin-top:8px;">
      <tr style="font-weight:bold" class="w3-hover-none">
      <td class="w3-border-right w3-center">No</td>
      <td class="w3-border-right">Nama Lengkap</td>
      
      <td class="w3-border-right w3-center">Jenis Surat</td>
      
      <td class="w3-center">Tanggal</td>
    </tr>
    <?php do { ?>
      <tr>
        <td class="w3-border-right w3-center"><?php echo $nomor++; ?></td>
        <td class="w3-border-right"><?php $userNya = $row_rsSuratBulanan['username']; ?><?php
  $dataSektor = mysql_query("SELECT * FROM tb_warga WHERE username='$userNya'");
  if($dataSektor === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataSektor = mysql_fetch_array($dataSektor)){
		echo $sektor = $hasil_dataSektor['nama_lengkap'];
	}
   ?></td>
        
        <td class="w3-border-right"><?php echo $row_rsSuratBulanan['jenis_surat']; ?></td>
       
        <td class="w3-center"><?php echo $row_rsSuratBulanan['tanggal_input']; ?></td>
      </tr>
      <?php } while ($row_rsSuratBulanan = mysql_fetch_assoc($rsSuratBulanan)); ?>
  </table>
  <div style="margin-top:8px;" class="w3-small">Dicetak Pada : <?php echo date('d-m-Y H:i:s'); ?><span class="w3-right">Jumlah Data : <?php echo $totalRows_rsSuratBulanan ?></span></div>
  <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_rsSuratBulanan == 0) { // Show if recordset empty ?>
      <table class="w3-table w3-border" style="margin-top:8px;">
        <tr>
          <td class="w3-center">Data Masih Kosong</td>
        </tr>
      </table>
      <?php } // Show if recordset empty ?>
  </div>
</div>
</body>
</html>


<?php
mysql_free_result($rsSuratBulanan);
?>
