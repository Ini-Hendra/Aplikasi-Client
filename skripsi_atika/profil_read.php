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

$maxRows_rsProfilRead = 10;
$pageNum_rsProfilRead = 0;
if (isset($_GET['pageNum_rsProfilRead'])) {
  $pageNum_rsProfilRead = $_GET['pageNum_rsProfilRead'];
}
$startRow_rsProfilRead = $pageNum_rsProfilRead * $maxRows_rsProfilRead;

$colname_rsProfilRead = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsProfilRead = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsProfilRead = sprintf("SELECT * FROM tb_warga WHERE username = %s", GetSQLValueString($colname_rsProfilRead, "text"));
$query_limit_rsProfilRead = sprintf("%s LIMIT %d, %d", $query_rsProfilRead, $startRow_rsProfilRead, $maxRows_rsProfilRead);
$rsProfilRead = mysql_query($query_limit_rsProfilRead, $koneksi) or die(mysql_error());
$row_rsProfilRead = mysql_fetch_assoc($rsProfilRead);

if (isset($_GET['totalRows_rsProfilRead'])) {
  $totalRows_rsProfilRead = $_GET['totalRows_rsProfilRead'];
} else {
  $all_rsProfilRead = mysql_query($query_rsProfilRead);
  $totalRows_rsProfilRead = mysql_num_rows($all_rsProfilRead);
}
$totalPages_rsProfilRead = ceil($totalRows_rsProfilRead/$maxRows_rsProfilRead)-1;
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
    	<div class="w3-col s12"><i class="fa fa-user-circle"></i>&nbsp;&nbsp; KELOLA PROFIL</div>
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
    <div class="w3-large w3-border-bottom" style="padding-bottom:8px;"><a href="home.php" class="w3-tag w3-green"><i class="fa fa-home"></i></a> | Kelola Profil</div>
    <?php do { ?>
    <ul class="w3-border w3-ul w3-small" style="margin-top:8px;">
    	<li class="w3-pale-yellow"><strong>Identitas Warga</strong></li>
    	<li>Nama Lengkap<span class="w3-right"><strong><?php echo $row_rsProfilRead['nama_lengkap']; ?></strong></span></li>
        <li>No. KTP<span class="w3-right"><?php echo $row_rsProfilRead['no_ktp']; ?></span></li>
        <li>No. KK<span class="w3-right"><?php echo $row_rsProfilRead['no_kk']; ?></span></li>
        <li>Jenis Kelamin<span class="w3-right"><?php echo $row_rsProfilRead['jenis_kelamin']; ?></span></li>
        <li>Tempat Lahir<span class="w3-right"><?php echo $row_rsProfilRead['tempat_lahir']; ?></span></li>
        <li>Tanggal Lahir<span class="w3-right"><?php echo $row_rsProfilRead['tanggal_lahir']; ?></span></li>
        <li>Agama<span class="w3-right"><?php echo $row_rsProfilRead['agama']; ?></span></li>
        <li>Pendidikan<span class="w3-right"><?php echo $row_rsProfilRead['pendidikan']; ?></span></li>
        <li>Jenis Pekerjaan<span class="w3-right"><?php echo $row_rsProfilRead['jenis_pekerjaan']; ?></span></li>
        <li>Status Perkawinan<span class="w3-right"><?php echo $row_rsProfilRead['status_perkawinan']; ?></span></li>
        <li>Status Hubungan<span class="w3-right"><?php echo $row_rsProfilRead['status_hubungan']; ?></span></li>
        <li>Kewarganegaraan<span class="w3-right"><?php echo $row_rsProfilRead['kewarganegaraan']; ?></span></li>
        <li>Nama Ayah<span class="w3-right"><?php echo $row_rsProfilRead['nama_ayah']; ?></span></li>
        <li>Nama Ibu<span class="w3-right"><?php echo $row_rsProfilRead['nama_ibu']; ?></span></li>
        <li>Dari RT<span class="w3-right"><?php echo $row_rsProfilRead['kategori_rt']; ?></span></li>
        <li>Dari RW<span class="w3-right"><?php echo $row_rsProfilRead['kategori_rw']; ?></span></li>
        <li>Alamat<span class="w3-right"><?php echo $row_rsProfilRead['alamat']; ?></span></li>
    </ul>
     <ul class="w3-border w3-ul w3-small" style="margin-top:8px;">
    	<li class="w3-pale-yellow"><strong>Dokumen Imigrasi</strong></li>
        <li>No. Paspor<span class="w3-right"><?php echo $row_rsProfilRead['no_paspor']; ?></span></li>
        <li>No. KITAP<span class="w3-right"><?php echo $row_rsProfilRead['no_kitap']; ?></span></li>
     </ul>
     <ul class="w3-border w3-ul w3-small" style="margin-top:8px;">
     	<li class="w3-pale-yellow"><strong>Data Login</strong></li>
    	<li>Username<span class="w3-right"><?php echo $row_rsProfilRead['username']; ?></span></li>
        <li>Password<span class="w3-right"><?php echo base64_decode($row_rsProfilRead['password']); ?></span></li>
     </ul>
     
     <hr><div class="w3-center">
   <a class="w3-btn w3-green w3-small" href="profil_change_password.php?id_warga=<?php echo $row_rsProfilRead['id_warga']; ?>"><i class="fa fa-key fa-fw"></i> Ubah Password</a> <a class="w3-btn w3-green w3-small" style="display:none" href="profil_update.php?id_warga=<?php echo $row_rsProfilRead['id_warga']; ?>"><i class="fa fa-edit fa-fw"></i> Ubah Profil</a>
   </div>
    <?php } while ($row_rsProfilRead = mysql_fetch_assoc($rsProfilRead)); ?>
<br><br>

    </div>
    
    </div>
</div>
</body>
</html>

<?php
mysql_free_result($rsProfilRead);
?>
