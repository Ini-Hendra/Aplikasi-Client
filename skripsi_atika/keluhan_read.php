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

$maxRows_rsKeluhanRead = 1000;
$pageNum_rsKeluhanRead = 0;
if (isset($_GET['pageNum_rsKeluhanRead'])) {
  $pageNum_rsKeluhanRead = $_GET['pageNum_rsKeluhanRead'];
}
$startRow_rsKeluhanRead = $pageNum_rsKeluhanRead * $maxRows_rsKeluhanRead;

$colname_rsKeluhanRead = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsKeluhanRead = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsKeluhanRead = sprintf("SELECT * FROM tb_keluhan WHERE username = %s ORDER BY tanggal DESC", GetSQLValueString($colname_rsKeluhanRead, "text"));
$query_limit_rsKeluhanRead = sprintf("%s LIMIT %d, %d", $query_rsKeluhanRead, $startRow_rsKeluhanRead, $maxRows_rsKeluhanRead);
$rsKeluhanRead = mysql_query($query_limit_rsKeluhanRead, $koneksi) or die(mysql_error());
$row_rsKeluhanRead = mysql_fetch_assoc($rsKeluhanRead);

if (isset($_GET['totalRows_rsKeluhanRead'])) {
  $totalRows_rsKeluhanRead = $_GET['totalRows_rsKeluhanRead'];
} else {
  $all_rsKeluhanRead = mysql_query($query_rsKeluhanRead);
  $totalRows_rsKeluhanRead = mysql_num_rows($all_rsKeluhanRead);
}
$totalPages_rsKeluhanRead = ceil($totalRows_rsKeluhanRead/$maxRows_rsKeluhanRead)-1;
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
    	<div class="w3-col s12"><i class="fa fa-warning"></i>&nbsp;&nbsp; DATA KELUHAN</div>
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
    <div class="w3-large w3-border-bottom" style="padding-bottom:8px;"><a href="home.php" class="w3-tag w3-green"><i class="fa fa-home"></i></a> | Data Keluhan</div>
    <?php if ($totalRows_rsKeluhanRead > 0) { // Show if recordset not empty ?>
 <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><a style="margin-top:8px; height:36px;" class="w3-btn w3-block w3-green w3-small" href="keluhan_create.php"><i class="fa fa-plus fa-fw"></i> Lapor Keluhan</a></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#keluhan', '.keluhan', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Keluhan Anda<span class="w3-right"><?php echo $totalRows_rsKeluhanRead ?></span>
        </div></div>
</div>

        
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="keluhan" style="margin-top:8px;">
      <tr style="font-weight:bold" class="w3-hover-none">
      <td class="w3-border-right w3-center">No</td>
      <td class="w3-border-right">Nama</td>
      <td class="w3-border-right w3-center">RT</td>
      <td class="w3-border-right w3-center">Keluhan</td>
      <td class="w3-border-right w3-center">Tanggal</td>
      <td class="w3-center">Opsi</td>
    </tr>
    <?php do { ?><?php $tanggapan = $row_rsKeluhanRead['tanggapan']; ?>
      <tr class="keluhan <?php if($tanggapan == "" ){ echo "w3-pale-red"; } else { echo "w3-pale-green"; } ?>">
      	<td class="w3-border-right w3-center"><?php echo $nomor++; ?></td>
        <td class="w3-border-right"><?php echo $row_rsKeluhanRead['nama']; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsKeluhanRead['kategori_rt']; ?></td>
        <td class="w3-border-right w3-center w3-text-green" style="cursor:pointer" onclick="document.getElementById('<?php echo $row_rsKeluhanRead['id_keluhan']; ?>').style.display='block'"><i class="fa fa-search fa-fw"></i> Lihat Keluhan</td>
        <td class="w3-border-right w3-center"><?php echo $row_rsKeluhanRead['tanggal']; ?></td>
        <td class="w3-center"><a class="w3-tag w3-small w3-red" style="text-decoration:none" onclick="return confirm('Anda Yakin Ingin Menghapus?')" href="keluhan_delete.php?id_keluhan=<?php echo $row_rsKeluhanRead['id_keluhan']; ?>">Hapus</a></td>
      </tr>
      
      
      <div id="<?php echo $row_rsKeluhanRead['id_keluhan']; ?>" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('<?php echo $row_rsKeluhanRead['id_keluhan']; ?>').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <p><i class="fa fa-search fa-fw"></i> Detail Keluhan</p>
      <p>
	  <ul class="w3-ul w3-small w3-border">
  <li>Nama<span class="w3-right"><?php echo $row_rsKeluhanRead['nama']; ?></span></li>
  <li>Rukun Tetangga (RT)<span class="w3-right"><?php echo $row_rsKeluhanRead['kategori_rt']; ?></span></li>
  <li>Tanggal<span class="w3-right"><?php echo $row_rsKeluhanRead['tanggal']; ?></span></li>
</ul>
<ul class="w3-ul w3-small w3-border" style="margin-top:8px;">
<li><strong>Keluhan</strong></li>
  <li class="w3-justify w3-pale-yellow"><i><?php echo $row_rsKeluhanRead['keluhan']; ?></i></li>
  </ul>
  <ul class="w3-ul w3-small w3-border" style="margin-top:8px;">
  <li><strong>Tanggapan</strong></li>
  <li class="w3-justify w3-pale-yellow"><i><?php $tanggapan = $row_rsKeluhanRead['tanggapan'];
  if($tanggapan == ""){
	  echo "Belum Ditanggapi";
	  } else {
		  echo $tanggapan;
		  }
   ?></i></li>
  </ul>
	  </p>
      
    </div>
  </div>
</div>
      
      
      <?php } while ($row_rsKeluhanRead = mysql_fetch_assoc($rsKeluhanRead)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsKeluhanRead);
?>
<?php if ($totalRows_rsKeluhanRead == 0) { // Show if recordset empty ?>
  <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><a style="margin-top:8px; height:36px;" class="w3-btn w3-block w3-green w3-small" href="keluhan_create.php"><i class="fa fa-plus fa-fw"></i> Lapor Keluhan</a></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#keluhan', '.keluhan', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Keluhan Anda<span class="w3-right"><?php echo $totalRows_rsKeluhanRead ?></span>
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

