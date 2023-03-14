<?php require_once('Connections/koneksi.php'); ?>
<?php
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

$maxRows_rsTampilBerita = 5;
$pageNum_rsTampilBerita = 0;
if (isset($_GET['pageNum_rsTampilBerita'])) {
  $pageNum_rsTampilBerita = $_GET['pageNum_rsTampilBerita'];
}
$startRow_rsTampilBerita = $pageNum_rsTampilBerita * $maxRows_rsTampilBerita;

mysql_select_db($database_koneksi, $koneksi);
$query_rsTampilBerita = "SELECT * FROM tb_berita ORDER BY posting DESC";
$query_limit_rsTampilBerita = sprintf("%s LIMIT %d, %d", $query_rsTampilBerita, $startRow_rsTampilBerita, $maxRows_rsTampilBerita);
$rsTampilBerita = mysql_query($query_limit_rsTampilBerita, $koneksi) or die(mysql_error());
$row_rsTampilBerita = mysql_fetch_assoc($rsTampilBerita);

if (isset($_GET['totalRows_rsTampilBerita'])) {
  $totalRows_rsTampilBerita = $_GET['totalRows_rsTampilBerita'];
} else {
  $all_rsTampilBerita = mysql_query($query_rsTampilBerita);
  $totalRows_rsTampilBerita = mysql_num_rows($all_rsTampilBerita);
}
$totalPages_rsTampilBerita = ceil($totalRows_rsTampilBerita/$maxRows_rsTampilBerita)-1;
?>
<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<!DOCTYPE html>
<html>
<head>
<title>ATIKA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/w3.css">
<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
body{
	background-image:url(assets/bg.jpg);
	background-size:cover;
	background-repeat:no-repeat;
}
</style>
</head>
<body>
<!-- LOADING -->
<div id="loading" class="w3-modal">
<div class="w3-row w3-animate-top">
  <div class="w3-col s3"><p></p></div>
  <div class="w3-col s6 w3-round-large w3-center w3-text-white">
<i class="fa fa-spin fa-spinner fa-3x" style="color:white"></i>
<div style="margin-top:10px;">LOADING</div>
  </div>
  <div class="w3-col s3"><p></p></div>
</div>
</div>

<!-- LOADING 2 -->
<div id="loading2" class="w3-modal" style="z-index:9999">
<div class="w3-row w3-animate-top">
  <div class="w3-col s3"><p></p></div>
  <div class="w3-col s6 w3-round-large w3-center w3-text-white">
<i class="fa fa-spin fa-spinner fa-3x" style="color:white"></i>
<div style="margin-top:10px;">LOADING</div>
  </div>
  <div class="w3-col s3"><p></p></div>
</div>
</div>
<table border="1" style="display:none">
  <tr>
    <td>id_warga</td>
    <td>nama_lengkap</td>
    <td>no_ktp</td>
    <td>no_kk</td>
    <td>jenis_kelamin</td>
    <td>tempat_lahir</td>
    <td>tanggal_lahir</td>
    <td>agama</td>
    <td>pendidikan</td>
    <td>jenis_pekerjaan</td>
    <td>status_perkawinan</td>
    <td>status_hubungan</td>
    <td>kewarganegaraan</td>
    <td>no_paspor</td>
    <td>no_kitap</td>
    <td>nama_ayah</td>
    <td>nama_ibu</td>
    <td>alamat</td>
    <td>kategori_rt</td>
    <td>kategori_rw</td>
    <td>foto</td>
    <td>username</td>
    <td>password</td>
    <td>tgl_input</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsTampilWarga['id_warga']; ?></td>
      <td><?php $namaLengkap = $row_rsTampilWarga['nama_lengkap']; ?></td>
      <td><?php $nik = $row_rsTampilWarga['no_ktp']; ?></td>
      <td><?php echo $row_rsTampilWarga['no_kk']; ?></td>
      <td><?php echo $row_rsTampilWarga['jenis_kelamin']; ?></td>
      <td><?php echo $row_rsTampilWarga['tempat_lahir']; ?></td>
      <td><?php echo $row_rsTampilWarga['tanggal_lahir']; ?></td>
      <td><?php echo $row_rsTampilWarga['agama']; ?></td>
      <td><?php echo $row_rsTampilWarga['pendidikan']; ?></td>
      <td><?php echo $row_rsTampilWarga['jenis_pekerjaan']; ?></td>
      <td><?php echo $row_rsTampilWarga['status_perkawinan']; ?></td>
      <td><?php echo $row_rsTampilWarga['status_hubungan']; ?></td>
      <td><?php echo $row_rsTampilWarga['kewarganegaraan']; ?></td>
      <td><?php echo $row_rsTampilWarga['no_paspor']; ?></td>
      <td><?php echo $row_rsTampilWarga['no_kitap']; ?></td>
      <td><?php echo $row_rsTampilWarga['nama_ayah']; ?></td>
      <td><?php echo $row_rsTampilWarga['nama_ibu']; ?></td>
      <td><?php echo $row_rsTampilWarga['alamat']; ?></td>
      <td><?php echo $row_rsTampilWarga['kategori_rt']; ?></td>
      <td><?php echo $row_rsTampilWarga['kategori_rw']; ?></td>
      <td><?php $foto = $row_rsTampilWarga['foto']; ?></td>
      <td><?php echo $row_rsTampilWarga['username']; ?></td>
      <td><?php echo $row_rsTampilWarga['password']; ?></td>
      <td><?php echo $row_rsTampilWarga['tgl_input']; ?></td>
    </tr>
    <?php } while ($row_rsTampilWarga = mysql_fetch_assoc($rsTampilWarga)); ?>
</table>

	<br>
<div class="w3-container w3-top w3-text-white" style="background-color:#118eea;">
	<div class="w3-row w3-padding-16">
    	<div class="w3-col s12"><i class="fa fa-home"></i>&nbsp;&nbsp; WELCOME<span class="w3-right"><marquee scrollamount="5" direction="left" width="1000px">SISTEM INFORMASI LAYANAN KEPENDUDUKAN. KP. PERIUK RW 03 TANGERANG | <i class="fa fa-clock-o"></i> <?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y') ?></marquee></span></div>
    </div>
    </div>
<br>
<div class="w3-row"><br>

<div class="w3-padding w3-center">
<div class="w3-center w3-jumbo" style="font-family:arial black"><strong><i class="fa fa-home fa-3x"></i></strong></div>
<div class="w3-center w3-jumbo" style="font-family:arial black;margin-top:-30px;"><strong>RW 03</strong></div>
</div>
<div style="padding-bottom:15px;"></div>
</div>

<div class="w3-container" style="margin-top:14px;">
	
    
    <div class="w3-row">
    	<div class="w3-col w3-hide-small m4 l3 w3-center">&nbsp;</div>
        <div class="w3-col s12 m4 l6 w3-center">
        	
        	<div class="w3-row w3-padding">
            <div class="w3-padding w3-border w3-pale-yellow w3-round-large">
            	<div>Selamat Datang <strong><?php echo $namaLengkap ?></strong></div>
            </div>
            	<div class="w3-col s4" style="padding-right:4px; margin-top:15px;"><a href="surat_read.php" class="w3-block w3-round-large w3-blue w3-small w3-btn w3-hover-green" style="border:1px solid white; box-shadow:0 1px 6px 0 rgba(32, 33, 36, .28);">
                    <div style="margin-top:8px;"><i class="fa fa-file fa-4x"></i></div>
                    <div style="margin-top:8px; margin-bottom:8px;">Surat Pengantar</div></a></div>
                <div class="w3-col s4" style="padding-left:4px; padding-right:4px; margin-top:15px;"><a href="keluhan_read.php" class="w3-block w3-round-large w3-blue w3-small w3-btn w3-hover-green" style="border:1px solid white; box-shadow:0 1px 6px 0 rgba(32, 33, 36, .28);">
                    <div style="margin-top:8px;"><i class="fa fa-warning fa-4x"></i></div>
                    <div style="margin-top:8px; margin-bottom:8px;">Lapor Keluhan</div></a></div>
                <div class="w3-col s4" style="padding-left:4px;margin-top:15px;"><a href="pengurus_read.php" class="w3-block w3-round-large w3-blue w3-small w3-btn w3-hover-green" style="border:1px solid white; box-shadow:0 1px 6px 0 rgba(32, 33, 36, .28);">
                    <div style="margin-top:8px;"><i class="fa fa-user-circle-o fa-4x"></i></div>
                    <div style="margin-top:8px; margin-bottom:8px;">Data Pengurus</div></a></div>
            </div>
            
            
          
            
            <!-- MENU KE 3 -->
            <div class="w3-row w3-padding">
            	
                <div class="w3-col s4" style="padding-right:4px;"><a href="berita_read.php" class="w3-block w3-round-large w3-blue w3-small w3-btn w3-hover-green" style="border:1px solid white; box-shadow:0 1px 6px 0 rgba(32, 33, 36, .28);">
                    <div style="margin-top:8px;"><i class="fa fa-newspaper-o fa-4x"></i></div>
                    <div style="margin-top:8px; margin-bottom:8px;">Berita</div></a></div>
                    
                    <div class="w3-col s4" style="padding-right:4px; padding-left:4px"><a href="profil_read.php" class="w3-block w3-round-large w3-blue w3-small w3-btn w3-hover-green" style="border:1px solid white; box-shadow:0 1px 6px 0 rgba(32, 33, 36, .28);">
                    <div style="margin-top:8px;"><i class="fa fa-user-circle fa-4x"></i></div>
                    <div style="margin-top:8px; margin-bottom:8px;">Kelola Profil</div></a></div>
                    
                <div class="w3-col s4" style="padding-left:4px;"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" class="w3-block w3-round-large w3-blue w3-small w3-btn w3-hover-red" style="border:1px solid white; box-shadow:0 1px 6px 0 rgba(32, 33, 36, .28);">
                    <div style="margin-top:8px;"><i class="fa fa-sign-out fa-4x"></i></div>
                    <div style="margin-top:8px; margin-bottom:8px;">Keluar</div></a></div>
            </div>
            
<div style="margin-top:20px;" class="w3-tiny w3-center">Copyright &copy; 2021 Siti Atikah Salia<br>
    <strong>Sistem Informasi Layanan Kependudukan</strong><br>
All Right Reserved</div>
        </div>
        <div class="w3-col w3-hide-small m4 l3 w3-center">&nbsp;</div>
    </div>
   
    
</div>
<br>


</body>
</html>
<?php
mysql_free_result($rsTampilWarga);

mysql_free_result($rsTampilBerita);
?>
   