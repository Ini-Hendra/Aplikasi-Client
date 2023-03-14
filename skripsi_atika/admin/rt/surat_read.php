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

mysql_select_db($database_koneksi, $koneksi);
$query_rsSuratRead = "SELECT * FROM tb_surat WHERE kategori_rt='$_SESSION[MM_Username]' ORDER BY tanggal_input DESC";
$rsSuratRead = mysql_query($query_rsSuratRead, $koneksi) or die(mysql_error());
$row_rsSuratRead = mysql_fetch_assoc($rsSuratRead);
$totalRows_rsSuratRead = mysql_num_rows($rsSuratRead);
$nomor = 1;
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
        
		<div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Permintaan Surat Pengantar</div>
<?php if ($totalRows_rsSuratRead > 0) { // Show if recordset not empty ?>
 <div class="w3-row">
 	
	<div class="w3-col l3" style="padding-right:4px;"><input oninput="w3.filterHTML('#supeng', '.supeng', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l9" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Permintaan Surat Pengantar<span class="w3-right"><?php echo $totalRows_rsSuratRead ?></span>
        </div></div>
</div>

        
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="supeng" style="margin-top:8px;">
      <tr style="font-weight:bold" class="w3-hover-none">
      <td class="w3-border-right w3-center">No</td>
      <td class="w3-border-right">Nama</td>
	<td class="w3-border-right">Jenis Surat</td>
      
      <td class="w3-border-right w3-center">Status</td>
     
      <td class="w3-border-right w3-center">Tanggal</td>
      <td class="w3-center">Opsi</td>
    </tr>
    <?php do { ?>
    <?php $status = $row_rsSuratRead['status_rt']; ?>
    	
      <tr class="supeng<?php if($status == "Diterima"){ echo " w3-pale-yellow"; } else { echo " w3-pale-green"; } ?>">
        <td class="w3-border-right w3-center"><?php echo $nomor++; ?></td>
        <td class="w3-border-right"><?php $userNya = $row_rsSuratRead['username']; ?>
        <?php
  $dataSektor = mysql_query("SELECT * FROM tb_warga WHERE username='$userNya'");
  if($dataSektor === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataSektor = mysql_fetch_array($dataSektor)){
		echo $sektor = $hasil_dataSektor['nama_lengkap'];
	}
   ?></td>
        <td class="w3-border-right"><?php echo $row_rsSuratRead['jenis_surat']; ?></td>
       
        <td class="w3-border-right w3-center"><?php echo $status ?></td>
        
        <td class="w3-border-right w3-center"><?php
		$year = substr($row_rsSuratRead['tanggal_input'],0,4);
		$mont = substr($row_rsSuratRead['tanggal_input'],5,2);
		$day = substr($row_rsSuratRead['tanggal_input'],8,2);
		 ?> <?php echo $day."-".$mont."-".$year; ?></td>
        <td class="w3-center"><?php if($status == "Diterima"){
			?>
            <a class="w3-tag w3-small w3-grey" style="text-decoration:none" href="#">Diterima</a> 
            <?php
			} else {
				?>
                <a class="w3-tag w3-small w3-green" style="text-decoration:none" href="surat_update.php?id_surat=<?php echo $row_rsSuratRead['id_surat']; ?>" onClick="return confirm('Anda Yakin Ingin Menerima Permintaan Surat Dari:\nNama  : <?php echo $sektor; ?>\nJenis    : <?php echo $row_rsSuratRead['jenis_surat']; ?>')">Terima</a> 
                <?php
				} ?><a class="w3-tag w3-small w3-red" style="text-decoration:none" onclick="return confirm('Anda Yakin Ingin Menghapus?\nNama  : <?php echo $sektor; ?>\nJenis    : <?php echo $row_rsSuratRead['jenis_surat']; ?>')" href="surat_delete.php?id_surat=<?php echo $row_rsSuratRead['id_surat']; ?>">Hapus</a></td>
      </tr>
      <?php } while ($row_rsSuratRead = mysql_fetch_assoc($rsSuratRead)); ?>
  </table><br>

  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsSuratRead);
?>
<?php if ($totalRows_rsSuratRead == 0) { // Show if recordset empty ?>
  <div class="w3-row">
 	
	<div class="w3-col l3" style="padding-right:4px;"><input oninput="w3.filterHTML('#supeng', '.supeng', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l9" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Permintaan Surat Pengantar<span class="w3-right"><?php echo $totalRows_rsSuratRead ?></span>
        </div></div>
</div>
<table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Data Masih Kosong</td>
      </tr>
    </table>
  <?php } // Show if recordset empty ?>

		<!-- InstanceEndEditable -->
        
       
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>