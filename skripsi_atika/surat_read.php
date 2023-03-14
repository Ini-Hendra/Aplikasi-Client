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

$colname_rsSuratRead = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsSuratRead = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsSuratRead = sprintf("SELECT * FROM tb_surat WHERE username = %s", GetSQLValueString($colname_rsSuratRead, "text"));
$rsSuratRead = mysql_query($query_rsSuratRead, $koneksi) or die(mysql_error());
$row_rsSuratRead = mysql_fetch_assoc($rsSuratRead);
$totalRows_rsSuratRead = mysql_num_rows($rsSuratRead);
$nomor = 1;
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
</style>
</head>
<body>
<div class="w3-container w3-top w3-text-white" style="background-color:#118eea;">
	<div class="w3-row w3-padding-16">
    	<div class="w3-col s12"><i class="fa fa-file"></i>&nbsp;&nbsp; SURAT PENGANTAR</div>
    </div>
    </div>
    <br>
<br>
<br>
<div class="w3-container">
	<div class="w3-row">
    <div class="w3-col s12 m3 l3" style="padding-right:8px;">
    	<div class="w3-container w3-row w3-center w3-border">
        <?php
  $dataWarga = mysql_query("SELECT * FROM tb_warga WHERE username='$_SESSION[MM_Username]'");
  if($dataWarga === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataWarga = mysql_fetch_array($dataWarga)){
		$namaLengkap = $hasil_dataWarga['nama_lengkap'];
		$kategoriRT = $hasil_dataWarga['kategori_rt'];
		$noKTP = $hasil_dataWarga['no_ktp'];
		$foto = $hasil_dataWarga['foto'];
	}
   ?>
        
        <br>
    	<img src="admin/foto_warga/<?php echo $foto ?>" style="padding:4px; border:1px solid gray" width="118" height="118" class="w3-image w3-circle">
        <div style="margin-top:12px;" class="w3-small">Warga RT <?php echo $kategoriRT ?></div>
      	<div class="w3-large"><?php echo strtoupper($namaLengkap); ?></div>
        <div class="w3-small"><?php echo $noKTP ?></div>
        
       
         <hr style="margin-top:12px;">
        <div class="w3-bar-block" style="margin-top:-8px;">
    <a href="profil_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user-circle fa-fw"></i> Kelola Profil</a>
    <a href="surat_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-file fa-fw"></i> Surat Pengantar</a>
    <a href="keluhan_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-warning fa-fw"></i> Lapor Keluhan</a>
    
    <a href="pengurus_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user-circle-o fa-fw"></i> Data Pengurus</a>
    <a href="berita_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-newspaper-o fa-fw"></i> Berita</a>
    <a onClick="return confirm('Anda Yakin Ingin Keluar?')" href="<?php echo $logoutAction ?>" class="w3-bar-item w3-button w3-padding"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
    <div style="padding-bottom:8px;"></div>
    
  </div>
  </div>
    </div>
    <div class="w3-col s12 m9 l9">
    
<div class="w3-large w3-border-bottom" style="padding-bottom:8px;"><a href="home.php" class="w3-tag w3-green"><i class="fa fa-home"></i></a> | Surat Pengantar</div>
<?php if ($totalRows_rsSuratRead > 0) { // Show if recordset not empty ?>
 <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><a style="margin-top:8px; height:36px;" class="w3-btn w3-block w3-green w3-small" href="surat_create.php"><i class="fa fa-plus fa-fw"></i> Buat Baru</a></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#surat', '.surat', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Surat Pengantar Anda<span class="w3-right"><?php echo $totalRows_rsSuratRead ?></span>
        </div></div>
</div>

        
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="surat" style="margin-top:8px;">
      <tr style="font-weight:bold" class="w3-hover-none">
      <td class="w3-border-right w3-center">No</td>
      <td class="w3-border-right w3-center">Jenis Surat</td>
      
      <td class="w3-border-right w3-center">Status RT</td>
      <td class="w3-border-right w3-center">Status RW</td>
      <td class="w3-border-right w3-center">Tanggal</td>
      <td class="w3-center">Opsi</td>
    </tr>
    <?php do { ?>
      <tr class="surat">
        <td class="w3-border-right w3-center"><?php echo $nomor++; ?></td>
        <td class="w3-border-right"><?php echo $row_rsSuratRead['jenis_surat']; ?></td>
        <td class="w3-border-right w3-center"><?php $statusRT = $row_rsSuratRead['status_rt']; echo $statusRT ?></td>
        <td class="w3-border-right w3-center"><?php $statusRW = $row_rsSuratRead['status_rw']; echo $statusRW ?></td>
        <td class="w3-border-right w3-center"><?php
		$year = substr($row_rsSuratRead['tanggal_input'],0,4);
		$mont = substr($row_rsSuratRead['tanggal_input'],5,2);
		$day = substr($row_rsSuratRead['tanggal_input'],8,2);
		 ?> <?php echo $day."-".$mont."-".$year; ?></td>
        <td class="w3-center"><a onClick="return confirm('Anda Yakin Ingin Menghapus?\nSurat <?php echo $row_rsSuratRead['jenis_surat']; ?>')" class="w3-tag w3-small w3-red" style="text-decoration:none"
 href="surat_delete.php?id_surat=<?php echo $row_rsSuratRead['id_surat']; ?>">Hapus</a> 
 <?php if($statusRT == "Pending" || $statusRW == "Pending"){
	 ?>
     <a class="w3-tag w3-small w3-grey" style="text-decoration:none;cursor:no-drop"
href="#">Cetak</a>
     <?php
	 } else {
		 ?>
         <a class="w3-tag w3-small w3-green" style="text-decoration:none"
 target="_blank" href="surat_cetak.php?id_surat=<?php echo $row_rsSuratRead['id_surat']; ?>">Cetak</a>
 <?php
		 } ?>
 </td>
      </tr>
      <?php } while ($row_rsSuratRead = mysql_fetch_assoc($rsSuratRead)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsSuratRead);
?>
<?php if ($totalRows_rsSuratRead == 0) { // Show if recordset empty ?>
 <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><a style="margin-top:8px; height:36px;" class="w3-btn w3-block w3-green w3-small" href="surat_create.php"><i class="fa fa-plus fa-fw"></i> Buat Baru</a></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#penga', '.penga', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Surat Pengantar Anda<span class="w3-right"><?php echo $totalRows_rsSuratRead ?></span>
        </div></div>
</div>
<table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Data Masih Kosong</td>
      </tr>
    </table>
  <?php } // Show if recordset empty ?>

    </div>
    
    </div>
</div>
</body>
</html>