<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<?php require_once('../../Connections/koneksi.php'); ?>
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
	
  $logoutGoTo = "../index.php";
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

$maxRows_rsBeritaDetail = 10;
$pageNum_rsBeritaDetail = 0;
if (isset($_GET['pageNum_rsBeritaDetail'])) {
  $pageNum_rsBeritaDetail = $_GET['pageNum_rsBeritaDetail'];
}
$startRow_rsBeritaDetail = $pageNum_rsBeritaDetail * $maxRows_rsBeritaDetail;

$colname_rsBeritaDetail = "-1";
if (isset($_GET['id_berita'])) {
  $colname_rsBeritaDetail = $_GET['id_berita'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsBeritaDetail = sprintf("SELECT * FROM tb_berita WHERE id_berita = %s", GetSQLValueString($colname_rsBeritaDetail, "text"));
$query_limit_rsBeritaDetail = sprintf("%s LIMIT %d, %d", $query_rsBeritaDetail, $startRow_rsBeritaDetail, $maxRows_rsBeritaDetail);
$rsBeritaDetail = mysql_query($query_limit_rsBeritaDetail, $koneksi) or die(mysql_error());
$row_rsBeritaDetail = mysql_fetch_assoc($rsBeritaDetail);

if (isset($_GET['totalRows_rsBeritaDetail'])) {
  $totalRows_rsBeritaDetail = $_GET['totalRows_rsBeritaDetail'];
} else {
  $all_rsBeritaDetail = mysql_query($query_rsBeritaDetail);
  $totalRows_rsBeritaDetail = mysql_num_rows($all_rsBeritaDetail);
}
$totalPages_rsBeritaDetail = ceil($totalRows_rsBeritaDetail/$maxRows_rsBeritaDetail)-1;

$colname_rsTampilKomentar = "-1";
if (isset($_GET['id_berita'])) {
  $colname_rsTampilKomentar = $_GET['id_berita'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsTampilKomentar = sprintf("SELECT * FROM tb_comment WHERE id_berita = %s", GetSQLValueString($colname_rsTampilKomentar, "text"));
$rsTampilKomentar = mysql_query($query_rsTampilKomentar, $koneksi) or die(mysql_error());
$row_rsTampilKomentar = mysql_fetch_assoc($rsTampilKomentar);
$totalRows_rsTampilKomentar = mysql_num_rows($rsTampilKomentar);
?>

<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/template-rt.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>ATIKAH</title>
<!-- InstanceEndEditable -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../assets/w3.css">
<link href="../../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../../assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
</style>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>
<body>
<div class="w3-container w3-top w3-text-white" style="background-color:#118eea;">
	<div class="w3-row w3-padding-16">
    	<div class="w3-col s12"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp; RUKUN TETANGGA <?php echo $_SESSION['MM_Username'] ?></div>
    </div>
    </div>
    <br>
<br>
<br>
<div class="w3-container">
	<div class="w3-row">
    	<div class="w3-col l3 w3-padding">
        	<ul class="w3-border w3-ul">
            	<li class="w3-hover-light-grey"><a href="home.php" style="text-decoration:none"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
            	<li class="w3-hover-light-grey"><a href="warga_read.php" style="text-decoration:none"><i class="fa fa-user-circle fa-fw"></i> Data Warga</a></li>
                <li class="w3-hover-light-grey"><a href="surat_read.php" style="text-decoration:none"><i class="fa fa-file fa-fw"></i> Data Surat Pengantar</a></li>
            	<li class="w3-hover-light-grey"><a href="admin_read.php" style="text-decoration:none"><i class="fa fa-user-circle-o fa-fw"></i> Data Admin</a></li>
                <li class="w3-hover-light-grey"><a href="pengurus_read.php" style="text-decoration:none"><i class="fa fa-user-circle-o fa-fw"></i> Data Pengurus</a></li>
                <li class="w3-hover-light-grey"><a href="berita_read.php" style="text-decoration:none"><i class="fa fa-newspaper-o fa-fw"></i> Data Berita</a></li>
                <li class="w3-hover-light-grey"><a href="keluhan_read.php" style="text-decoration:none"><i class="fa fa-warning fa-fw"></i> Data Keluhan</a></li>
                <li class="w3-hover-light-grey"><a href="laporan_read.php" style="text-decoration:none"><i class="fa fa-print fa-fw"></i> Cetak Laporan</a></li>
                <li class="w3-hover-light-grey"><a href="jenis_read.php" style="text-decoration:none"><i class="fa fa-database fa-fw"></i> Data Jenis Surat</a></li>
                <li class="w3-hover-light-grey"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
            </ul>
        </div>
        <div class="w3-col l9 w3-padding"><!-- InstanceBeginEditable name="EditRegion1" -->
        <?php do { ?>
		<div class="w3-large w3-border-bottom" style="padding-bottom:8px;"><?php echo $row_rsBeritaDetail['judul']; ?></div>
        <div style="margin-top:8px;" class="w3-center">
        <img src="../foto_berita/<?php echo $row_rsBeritaDetail['gambar']; ?>" class="w3-image w3-padding w3-border" />
        </div>
        <div class="w3-center w3-small" style="margin-top:8px;">Penulis : <?php echo $row_rsBeritaDetail['author']; ?> | Tanggal : <?php echo $row_rsBeritaDetail['posting']; ?></div><br>

        <div class="w3-justify w3-small" style="white-space:pre-wrap"><?php echo $row_rsBeritaDetail['isi']; ?></div>

    <?php } while ($row_rsBeritaDetail = mysql_fetch_assoc($rsBeritaDetail)); ?>
<br>
<?php if ($totalRows_rsTampilKomentar > 0) { // Show if recordset not empty ?>
  
  
  
  
  <ul class="w3-ul w3-border w3-small" style="margin-top:8px;">
<?php do { ?>
<?php $userNya = $row_rsTampilKomentar['username']; ?>
<?php
  $dataNama = mysql_query("SELECT * FROM tb_warga WHERE username='$userNya'");
  if($dataNama === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataNama = mysql_fetch_array($dataNama)){
		$namaLengkap = $hasil_dataNama['nama_lengkap'];
		$dariRT = $hasil_dataNama['kategori_rt'];
	}
   ?>
	<li>
    <div><strong><?php echo $namaLengkap ?></strong> dari RT <?php echo $dariRT ?><span class="w3-right"><?php echo $row_rsTampilKomentar['tanggal']; ?></span></div>
    <div class="w3-small w3-text-grey"><i><?php echo $row_rsTampilKomentar['comment']; ?></i></div>
    </li>
<?php } while ($row_rsTampilKomentar = mysql_fetch_assoc($rsTampilKomentar)); ?>
</ul>
  
  
  
  
  <br>

  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsTampilKomentar == 0) { // Show if recordset empty ?>
  <table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Tidak Ada Komentar</td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>
<?php
mysql_free_result($rsBeritaDetail);

mysql_free_result($rsTampilKomentar);
?>

		<!-- InstanceEndEditable -->
        
       
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>