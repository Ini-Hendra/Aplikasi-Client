<?php require_once('Connections/koneksi.php');
error_reporting(0); ?>
<?php
date_default_timezone_set('Asia/Jakarta');
$bulan = date('m');
if($bulan == "01"){
	$fixBulan = "I";
	} elseif($bulan == "02"){
		$fixBulan = "II";
		} elseif($bulan == "03"){
		$fixBulan = "III";
		} elseif($bulan == "04"){
		$fixBulan = "IV";
		} elseif($bulan == "05"){
		$fixBulan = "V";
		} elseif($bulan == "06"){
		$fixBulan = "VI";
		} elseif($bulan == "07"){
		$fixBulan = "VII";
		} elseif($bulan == "08"){
		$fixBulan = "VIII";
		} elseif($bulan == "09"){
		$fixBulan = "IX";
		} elseif($bulan == "10"){
		$fixBulan = "X";
		} elseif($bulan == "11"){
		$fixBulan = "XI";
		} elseif($bulan == "12"){
		$fixBulan = "XII";
		}
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$MM_restrictGoTo = "index.php";
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

$maxRows_rsTampilSurat = 10;
$pageNum_rsTampilSurat = 0;
if (isset($_GET['pageNum_rsTampilSurat'])) {
  $pageNum_rsTampilSurat = $_GET['pageNum_rsTampilSurat'];
}
$startRow_rsTampilSurat = $pageNum_rsTampilSurat * $maxRows_rsTampilSurat;

$colname_rsTampilSurat = "-1";
if (isset($_GET['id_surat'])) {
  $colname_rsTampilSurat = $_GET['id_surat'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsTampilSurat = sprintf("SELECT * FROM tb_surat WHERE id_surat = %s", GetSQLValueString($colname_rsTampilSurat, "text"));
$query_limit_rsTampilSurat = sprintf("%s LIMIT %d, %d", $query_rsTampilSurat, $startRow_rsTampilSurat, $maxRows_rsTampilSurat);
$rsTampilSurat = mysql_query($query_limit_rsTampilSurat, $koneksi) or die(mysql_error());
$row_rsTampilSurat = mysql_fetch_assoc($rsTampilSurat);

if (isset($_GET['totalRows_rsTampilSurat'])) {
  $totalRows_rsTampilSurat = $_GET['totalRows_rsTampilSurat'];
} else {
  $all_rsTampilSurat = mysql_query($query_rsTampilSurat);
  $totalRows_rsTampilSurat = mysql_num_rows($all_rsTampilSurat);
}
$totalPages_rsTampilSurat = ceil($totalRows_rsTampilSurat/$maxRows_rsTampilSurat)-1;

$maxRows_rsTampilWarga = 10;
$pageNum_rsTampilWarga = 0;
if (isset($_GET['pageNum_rsTampilWarga'])) {
  $pageNum_rsTampilWarga = $_GET['pageNum_rsTampilWarga'];
}
$startRow_rsTampilWarga = $pageNum_rsTampilWarga * $maxRows_rsTampilWarga;

$colname_rsTampilWarga = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsTampilWarga = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsTampilWarga = sprintf("SELECT * FROM tb_warga WHERE username = %s", GetSQLValueString($colname_rsTampilWarga, "text"));
$query_limit_rsTampilWarga = sprintf("%s LIMIT %d, %d", $query_rsTampilWarga, $startRow_rsTampilWarga, $maxRows_rsTampilWarga);
$rsTampilWarga = mysql_query($query_limit_rsTampilWarga, $koneksi) or die(mysql_error());
$row_rsTampilWarga = mysql_fetch_assoc($rsTampilWarga);

if (isset($_GET['totalRows_rsTampilWarga'])) {
  $totalRows_rsTampilWarga = $_GET['totalRows_rsTampilWarga'];
} else {
  $all_rsTampilWarga = mysql_query($query_rsTampilWarga);
  $totalRows_rsTampilWarga = mysql_num_rows($all_rsTampilWarga);
}
$totalPages_rsTampilWarga = ceil($totalRows_rsTampilWarga/$maxRows_rsTampilWarga)-1;
?>
<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<!DOCTYPE html>
<html>
<head>
<title>CETAK SURAT</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/w3.css">
<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
</style>
</head>
<body onLoad="window.print() ">
<table border="1" style="display:none">
  <tr>
    <td>id_surat</td>
    <td>username</td>
    <td>kategori_rt</td>
    <td>kategori_rw</td>
    <td>jenis_surat</td>
    <td>lampiran</td>
    <td>status_rt</td>
    <td>status_rw</td>
    <td>tanggal_input</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsTampilSurat['id_surat']; ?></td>
      <td><?php echo $row_rsTampilSurat['username']; ?></td>
      <td><?php $kategoriRT = $row_rsTampilSurat['kategori_rt']; ?></td>
      <td><?php echo $row_rsTampilSurat['kategori_rw']; ?></td>
      <td><?php $jenisSurat = $row_rsTampilSurat['jenis_surat']; ?></td>
      <td><?php $lampiran = $row_rsTampilSurat['lampiran']; ?></td>
      <td><?php echo $row_rsTampilSurat['status_rt']; ?></td>
      <td><?php echo $row_rsTampilSurat['status_rw']; ?></td>
      <td><?php echo $row_rsTampilSurat['tanggal_input']; ?></td>
    </tr>
    <?php } while ($row_rsTampilSurat = mysql_fetch_assoc($rsTampilSurat)); ?>
</table>
<div class="w3-container">
<div class="w3-row w3-center w3-large">
<strong>PENGURUS RUKUN TETANGGA (RT) <?php echo $kategoriRT ?> RUKUN WARGA (RW) 03<br>
KELURAHAN PERIUK KECAMATAN PERIUK<br>
KOTA TANGERANG</strong>
<div class="w3-border-bottom" style="margin-top:8px;"></div>

</div>
<div class="w3-row" style="margin-top:8px;">
	<div class="w3-col s8 m8 l8">
    	<div class="w3-row">
        	<div class="w3-col s3 m3 l3">
            	Nomor<br>
				Lampiran<br>
				Perihal
            </div>
            <div class="w3-col s1 m1 l1">
            	:<br>
				:<br>
				:
            </div>
            <?php $metBSB = mysql_num_rows(mysql_query("SELECT * FROM tb_surat"));
			if($metBSB == 0 || $metBSB == ""){
				$noKwitansi = "000".($metBSB + 1);
				} elseif($metBSB > 0 && $metBSB <= 8){
				$jumlah = $metBSB + 1;
				$noKwitansi = "000".$jumlah;
				} elseif($metBSB >= 9 && $metBSB <= 98){
				$jumlah = $metBSB + 1;
				$noKwitansi = "00".$jumlah;
				} elseif($metBSB >= 99 && $metBSB <= 998){
				$jumlah = $metBSB + 1;
				$noKwitansi = "0".$jumlah;
				} elseif($metBSB >= 999 && $metBSB <= 9998){
				$jumlah = $metBSB + 1;
				$noKwitansi = "0".$jumlah;
				} ?>
            <div class="w3-col s8 m8 l8">
                <?php echo $noKwitansi ?>/SK/RT-<?php echo $kategoriRT ?>/<?php echo $fixBulan ?>/<?php echo date('Y'); ?><br>
				<?php if($lampiran == ""){
					echo "-";
					} else {
						echo $lampiran;
						} ?><br>
				<u><b>Surat Pengantar</b></u>
            </div>
        </div>
    </div>
    <div class="w3-col s4 m4 l4">
    Periuk.<br>
Kepada Yth:<br>
<b>Lurah Periuk</b><br>
Di-<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Periuk</u>
    </div>
</div><br>
<div class="w3-row w3-justify">
Yang bertanda tangan di bawah ini. Ketua RT <?php echo $kategoriRT ?> / RW 03 dengan ini menerangkan bahwa:<br>
<div class="w3-row" style="margin-top:8px;">
	<div class="w3-col s4 m4 l4">
    	1. Nama<br>
		2. Tempat, Tanggal Lahir<br>
		3. Status Perkawinan<br>
		4. Jenis Kelamin<br>
		5. Agama<br>
		6. Pekerjaan<br>
		7. KTP Nomor<br>
		8. KK Nomor<br>
		9. Alamat
    </div>
    <div class="w3-col s1 m1 l1 w3-right-align" style="padding-right:8px;">
    	:<br>
    	:<br>
        :<br>
        :<br>
        :<br>
        :<br>
        :<br>
        :<br>
        :
    </div>
    <div class="w3-col s7 m7 l7">
    	<?php do { ?>

     	<?php echo $row_rsTampilWarga['nama_lengkap']; ?><br>
		<?php echo $row_rsTampilWarga['tempat_lahir']; ?>, <?php
		$year = substr($row_rsTampilWarga['tanggal_lahir'],0,4);
		$mont = substr($row_rsTampilWarga['tanggal_lahir'],5,2);
		$day = substr($row_rsTampilWarga['tanggal_lahir'],8,2);
		 ?> <?php echo $day."-".$mont."-".$year; ?>
		 
		 <br>
		<?php echo $row_rsTampilWarga['status_perkawinan']; ?><br>
		<?php echo $row_rsTampilWarga['jenis_kelamin']; ?><br>
		<?php echo $row_rsTampilWarga['agama']; ?><br>
		<?php echo $row_rsTampilWarga['jenis_pekerjaan']; ?><br>
		<?php echo $row_rsTampilWarga['no_ktp']; ?><br>
		<?php echo $row_rsTampilWarga['no_kk']; ?><br>
		<?php echo $row_rsTampilWarga['alamat']; ?>
    <?php } while ($row_rsTampilWarga = mysql_fetch_assoc($rsTampilWarga)); ?>
    </div>
</div>
</div>
<br>
<div class="w3-row w3-justify">
Untuk mengurus surat. Membuat surat <b><?php echo $jenisSurat ?></b>.<br>
Demikian Surat Pengantar ini dibuat untuk bahan pertimbangan serta realisasinya sebagaimana mestinya.
</div>
<br>
<br>
<?php
  $dataNama = mysql_query("SELECT * FROM tb_pengurus WHERE jabatan='Ketua' AND kategori='RW'");
  if($dataNama === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataNama = mysql_fetch_array($dataNama)){
		$namaRW = $hasil_dataNama['nama_lengkap'];
	}
   ?>
   
   <?php
  $dataNama2 = mysql_query("SELECT * FROM tb_pengurus WHERE jabatan='Ketua' AND kategori='RT' AND nomor='$kategoriRT'");
  if($dataNama2 === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataNama2 = mysql_fetch_array($dataNama2)){
		$namaRT = $hasil_dataNama2['nama_lengkap'];
	}
   ?>

<div class="w3-row">
	<div class="w3-col s6 m6 l6 w3-center">
    	Mengetahui,<br>
		<b>Ketua RW 03</b><br>
    <img src="assets/ttd.png" width="96" height="90"><br>
 <u><strong><?php echo $namaRW ?></strong></u></div>
    <div class="w3-col s6 m6 l6 w3-center">
    Tangerang, <?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y') ?><br>
<b>Ketua RT <?php echo $kategoriRT ?></b><br>
<img src="assets/ttd2.png" width="96" height="90"><br>
<u><strong><?php echo $namaRT ?></strong></u>
    </div>
</div>
</div>
<br>
<br>

</body>
</html>

<?php
mysql_free_result($rsTampilSurat);

mysql_free_result($rsTampilWarga);
?>
