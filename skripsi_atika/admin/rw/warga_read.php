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

$maxRows_rsWargaRead = 100;
$pageNum_rsWargaRead = 0;
if (isset($_GET['pageNum_rsWargaRead'])) {
  $pageNum_rsWargaRead = $_GET['pageNum_rsWargaRead'];
}
$startRow_rsWargaRead = $pageNum_rsWargaRead * $maxRows_rsWargaRead;

mysql_select_db($database_koneksi, $koneksi);
$query_rsWargaRead = "SELECT * FROM tb_warga ORDER BY tgl_input DESC";
$query_limit_rsWargaRead = sprintf("%s LIMIT %d, %d", $query_rsWargaRead, $startRow_rsWargaRead, $maxRows_rsWargaRead);
$rsWargaRead = mysql_query($query_limit_rsWargaRead, $koneksi) or die(mysql_error());
$row_rsWargaRead = mysql_fetch_assoc($rsWargaRead);

if (isset($_GET['totalRows_rsWargaRead'])) {
  $totalRows_rsWargaRead = $_GET['totalRows_rsWargaRead'];
} else {
  $all_rsWargaRead = mysql_query($query_rsWargaRead);
  $totalRows_rsWargaRead = mysql_num_rows($all_rsWargaRead);
}
$totalPages_rsWargaRead = ceil($totalRows_rsWargaRead/$maxRows_rsWargaRead)-1;
$nomor = 1;
?>

<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/template-rw.dwt.php" codeOutsideHTMLIsLocked="false" -->
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
    	<div class="w3-col s12"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp; RUKUN WARGA 03</div>
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
        <div class="w3-col l9 w3-padding"><!-- InstanceBeginEditable name="EditRegion1" --><div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Data Warga</div>
<?php if ($totalRows_rsWargaRead > 0) { // Show if recordset not empty ?>
  <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><a style="margin-top:8px; height:36px;" class="w3-btn w3-block w3-green w3-small" href="warga_create.php"><i class="fa fa-plus fa-fw"></i> Tambah Data</a></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#warga', '.warga', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Data Warga<span class="w3-right"><?php echo $totalRows_rsWargaRead ?></span>
        </div></div>
</div>

        
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="warga" style="margin-top:8px;">
      <tr style="font-weight:bold" class="w3-hover-none">
      <td class="w3-border-right w3-center">No</td>
      <td class="w3-border-right w3-center">Username</td>
      <td class="w3-border-right w3-center">Password</td>
      <td class="w3-border-right w3-center">No. KTP</td>
      <td class="w3-border-right">Nama Lengkap</td>
      <td class="w3-border-right w3-center">Dari RT</td>
      <td class="w3-center">Opsi</td>
    </tr>
    <?php do { ?>
      <tr class="warga">
        <td class="w3-border-right w3-center"><?php echo $nomor++; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsWargaRead['username']; ?></td>
        <td class="w3-border-right w3-center"><?php echo base64_decode($row_rsWargaRead['password']); ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsWargaRead['no_ktp']; ?></td>
        <td class="w3-border-right w3-text-green" style="cursor:pointer" onclick="document.getElementById('<?php echo $row_rsWargaRead['id_warga']; ?>').style.display='block'"><?php echo $row_rsWargaRead['nama_lengkap']; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsWargaRead['kategori_rt']; ?></td>
        <td class="w3-center"><a class="w3-tag w3-small w3-green" style="text-decoration:none" href="warga_update.php?id_warga=<?php echo $row_rsWargaRead['id_warga']; ?>">Ubah</a> <a class="w3-tag w3-small w3-red" style="text-decoration:none" onclick="return confirm('Anda Yakin Ingin Menghapus?\n<?php echo $row_rsWargaRead['nama_lengkap']; ?>')" href="warga_delete.php?id_warga=<?php echo $row_rsWargaRead['id_warga']; ?>">Hapus</a></td>
      </tr>
      
      
      
      <div id="<?php echo $row_rsWargaRead['id_warga']; ?>" class="w3-modal">
  <div class="w3-modal-content" style="margin-top:-65px;">
    <div class="w3-container">
      <span onclick="document.getElementById('<?php echo $row_rsWargaRead['id_warga']; ?>').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <p><i class="fa fa-search fa-fw"></i> Detail Warga</p>
      
     <div class="w3-row" style="margin-top:8px;">
     	<div class="w3-col l2" style="padding-right:2px;">
        <div class="w3-center w3-padding w3-small w3-border-top w3-border-right w3-border-left">Foto Warga</div>
        <img class="w3-border" src="../foto_warga/<?php echo $row_rsWargaRead['foto']; ?>" height="160px" width="100%">
        </div>
        <div class="w3-col l5" style="padding-right:2px; padding-left:2px;">
        <ul class="w3-ul w3-small w3-border">
  <li>Nama Lengkap<span class="w3-right"><?php echo $row_rsWargaRead['nama_lengkap']; ?></span></li>
  <li>No. KTP<span class="w3-right"><?php echo $row_rsWargaRead['no_ktp']; ?></span></li>
  <li>No. KK<span class="w3-right"><?php echo $row_rsWargaRead['no_kk']; ?></span></li>
  <li>Jenis Kelamin<span class="w3-right"><?php echo $row_rsWargaRead['jenis_kelamin']; ?></span></li>
  <li>Tempat Lahir<span class="w3-right"><?php echo $row_rsWargaRead['tempat_lahir']; ?></span></li>
  <li>Tanggal Lahir<span class="w3-right"><?php echo $row_rsWargaRead['tanggal_lahir']; ?></span></li>
  <li>Agama<span class="w3-right"><?php echo $row_rsWargaRead['agama']; ?></span></li>
  <li>Pendidikan<span class="w3-right"><?php echo $row_rsWargaRead['pendidikan']; ?></span></li>
  <li>Jenis Pekerjaan<span class="w3-right"><?php echo $row_rsWargaRead['jenis_pekerjaan']; ?></span></li>
  <li>Status Perkawinan<span class="w3-right"><?php echo $row_rsWargaRead['status_perkawinan']; ?></span></li>
  
  
  
</ul>
        </div>
        <div class="w3-col l5" style="padding-left:2px;">
        <ul class="w3-ul w3-small w3-border">
        <li>Dari RT<span class="w3-right"><?php echo $row_rsWargaRead['kategori_rt']; ?></span></li>
        <li>Status Hubungan Keluarga<span class="w3-right"><?php echo $row_rsWargaRead['status_hubungan']; ?></span></li>
  <li>Kewarganegaraan<span class="w3-right"><?php echo $row_rsWargaRead['kewarganegaraan']; ?></span></li>
        <li>Nama Ayah<span class="w3-right"><?php echo $row_rsWargaRead['nama_ayah']; ?></span></li>
  <li>Nama Ibu<span class="w3-right"><?php echo $row_rsWargaRead['nama_ibu']; ?></span></li>
  <li>No. Paspor<span class="w3-right"><?php echo $row_rsWargaRead['no_paspor']; ?></span></li>
  <li>No. KITAP<span class="w3-right"><?php echo $row_rsWargaRead['no_kitap']; ?></span></li>
  <li>Username<span class="w3-right"><?php echo $row_rsWargaRead['username']; ?></span></li>
  <li>Foto<span class="w3-right"><a target="_blank" href="../foto_warga/<?php echo $row_rsWargaRead['foto']; ?>" style="text-decoration:none" class="w3-text-green"><i class="fa fa-image fa-fw"></i> Perbesar</a></span></li>
  <li>Tanggal Daftar<span class="w3-right"><?php echo $row_rsWargaRead['tgl_input']; ?></span></li>
  
  </ul>
        </div>
     </div>
      <br>

    </div>
  </div>
</div>
      
      
      <?php } while ($row_rsWargaRead = mysql_fetch_assoc($rsWargaRead)); ?>
  </table><br>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsWargaRead);
?>
<?php if ($totalRows_rsWargaRead == 0) { // Show if recordset empty ?>
  <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><a style="margin-top:8px; height:36px;" class="w3-btn w3-block w3-green w3-small" href="warga_create.php"><i class="fa fa-plus fa-fw"></i> Tambah Data</a></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#warga', '.warga', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Data Warga<span class="w3-right"><?php echo $totalRows_rsWargaRead ?></span>
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