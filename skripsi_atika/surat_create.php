<?php require_once('Connections/koneksi.php'); ?>
<?php
date_default_timezone_set('Asia/Jakarta');
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tb_surat (id_surat, username, kategori_rt, kategori_rw, jenis_surat, lampiran, status_rt, status_rw, tanggal_input) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_surat'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['kategori_rt'], "text"),
                       GetSQLValueString($_POST['kategori_rw'], "text"),
                       GetSQLValueString($_POST['jenis_surat'], "text"),
                       GetSQLValueString($_POST['lampiran'], "text"),
                       GetSQLValueString($_POST['status_rt'], "text"),
                       GetSQLValueString($_POST['status_rw'], "text"),
                       GetSQLValueString($_POST['tanggal_input'], "date"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "surat_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rsSuratCreate = "-1";
if (isset($_GET['id_surat'])) {
  $colname_rsSuratCreate = $_GET['id_surat'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsSuratCreate = sprintf("SELECT * FROM tb_surat WHERE id_surat = %s", GetSQLValueString($colname_rsSuratCreate, "text"));
$rsSuratCreate = mysql_query($query_rsSuratCreate, $koneksi) or die(mysql_error());
$row_rsSuratCreate = mysql_fetch_assoc($rsSuratCreate);
$totalRows_rsSuratCreate = mysql_num_rows($rsSuratCreate);

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
$IDSurat="123456789987654321";
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
    <div class="w3-large w3-border-bottom" style="padding-bottom:8px;"><a href="home.php" class="w3-tag w3-green"><i class="fa fa-home"></i></a> | Buat Surat Pengantar</div>
   <div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small w3-center" style="margin-top:8px;">
        Silahkan Pilih Jenis Surat Pengantar Yang Akan Anda Buat<br>
Dan Tunggu Konfirmasi Selanjutnya Dari Ketua RT / RW
        </div>
  <?php do { ?>
   
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <div style="margin-top:8px;">
        
        <select name="jenis_surat" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
<option value="">Pilih Jenis Surat</option>
      <?php
  $dataSurat = mysql_query("SELECT * FROM tb_jenis ORDER BY surat ASC");
  if($dataSurat === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataSurat = mysql_fetch_array($dataSurat)){
		$surat = $hasil_dataSurat['surat'];
   ?>
        <option value="<?php echo $surat ?>" <?php if (!(strcmp("$surat", ""))) {echo "SELECTED";} ?>><?php echo $surat ?></option>
        
         <?php } ?>
      </select>
        </div>
        
          <table align="center" style="display:none">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Id_surat:</td>
              <td><input type="text" name="id_surat" value="<?php echo "SRT".substr(str_shuffle($IDSurat),0,7);?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Username:</td>
              <td><input type="text" name="username" value="<?php echo $row_rsTampilWarga['username']; ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Kategori_rt:</td>
              <td><input type="text" name="kategori_rt" value="<?php echo $row_rsTampilWarga['kategori_rt']; ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Kategori_rw:</td>
              <td><input type="text" name="kategori_rw" value="<?php echo $row_rsTampilWarga['kategori_rw']; ?>" size="32" /></td>
            </tr>
           
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Lampiran:</td>
              <td><input type="text" name="lampiran" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Status_rt:</td>
              <td><input type="text" name="status_rt" value="Pending" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Status_rw:</td>
              <td><input type="text" name="status_rw" value="Pending" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Tanggal_input:</td>
              <td><input type="text" name="tanggal_input" value="<?php echo date('Y-m-d'); ?>" size="32" /></td>
            </tr>
            
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
          <hr>
  <div class="w3-center">
  <a onClick="window.history.back()" style="cursor:pointer" class="w3-btn w3-small w3-red"><i class="fa fa-times-rectangle fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Simpan</button>
  </div>
        </form>
     
    <?php } while ($row_rsTampilWarga = mysql_fetch_assoc($rsTampilWarga)); ?>
<br>
</div>
    
    </div>
</div>
</body>
</html>

<?php
mysql_free_result($rsSuratCreate);

mysql_free_result($rsTampilWarga);
?>
