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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tb_temp (id_temp, id_berita, username) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_temp'], "int"),
                       GetSQLValueString($_POST['id_berita'], "text"),
                       GetSQLValueString($_POST['username'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  //$insertGoTo = "#";
  //if (isset($_SERVER['QUERY_STRING'])) {
    //$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    //$insertGoTo .= $_SERVER['QUERY_STRING'];
  //}
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rsBeritaRead = 100;
$pageNum_rsBeritaRead = 0;
if (isset($_GET['pageNum_rsBeritaRead'])) {
  $pageNum_rsBeritaRead = $_GET['pageNum_rsBeritaRead'];
}
$startRow_rsBeritaRead = $pageNum_rsBeritaRead * $maxRows_rsBeritaRead;

mysql_select_db($database_koneksi, $koneksi);
$query_rsBeritaRead = "SELECT * FROM tb_berita ORDER BY posting DESC";
$query_limit_rsBeritaRead = sprintf("%s LIMIT %d, %d", $query_rsBeritaRead, $startRow_rsBeritaRead, $maxRows_rsBeritaRead);
$rsBeritaRead = mysql_query($query_limit_rsBeritaRead, $koneksi) or die(mysql_error());
$row_rsBeritaRead = mysql_fetch_assoc($rsBeritaRead);

if (isset($_GET['totalRows_rsBeritaRead'])) {
  $totalRows_rsBeritaRead = $_GET['totalRows_rsBeritaRead'];
} else {
  $all_rsBeritaRead = mysql_query($query_rsBeritaRead);
  $totalRows_rsBeritaRead = mysql_num_rows($all_rsBeritaRead);
}
$totalPages_rsBeritaRead = ceil($totalRows_rsBeritaRead/$maxRows_rsBeritaRead)-1;

$colname_rsInputTemp = "-1";
if (isset($_GET['id_temp'])) {
  $colname_rsInputTemp = $_GET['id_temp'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsInputTemp = sprintf("SELECT * FROM tb_temp WHERE id_temp = %s", GetSQLValueString($colname_rsInputTemp, "int"));
$rsInputTemp = mysql_query($query_rsInputTemp, $koneksi) or die(mysql_error());
$row_rsInputTemp = mysql_fetch_assoc($rsInputTemp);
$totalRows_rsInputTemp = mysql_num_rows($rsInputTemp);
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
    	<div class="w3-col s12"><i class="fa fa-newspaper-o"></i>&nbsp;&nbsp; DATA BERITA</div>
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
    <div class="w3-large w3-border-bottom" style="padding-bottom:8px;"><a href="home.php" class="w3-tag w3-green"><i class="fa fa-home"></i></a> | Data Berita</div>
    <?php if ($totalRows_rsBeritaRead > 0) { // Show if recordset not empty ?>
    
  <div class="w3-row">
 	
	<div class="w3-col l3" style="padding-right:4px;"><input oninput="w3.filterHTML('#berita', '.berita', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l9" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Berita<span class="w3-right"><?php echo $totalRows_rsBeritaRead ?></span>
        </div></div>
</div>

        
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="berita" style="margin-top:8px;">
      <tr style="font-weight:bold" class="w3-hover-none">
      
      <td class="w3-border-right">Judul</td>
     
      
      <td class="w3-border-right w3-center">Komentar</td>
      <td class="w3-border-right w3-center">Tanggal</td>
      <td class="w3-center">Opsi</td>
    </tr>
    <?php do { ?>
	<?php $idBerita = $row_rsBeritaRead['id_berita']; ?>
    <?php $adaGa = mysql_num_rows(mysql_query("SELECT * FROM tb_temp WHERE id_berita='$idBerita' AND username='$_SESSION[MM_Username]'")); ?>
      <tr class="berita">
        
        <td class="w3-border-right"><?php if($adaGa == 0){
			echo "<span class='w3-text-red w3-small'><b>[BARU]</b></span>";
			} ?> <?php echo $row_rsBeritaRead['judul']; ?><input type="text" id="iniID<?php echo $row_rsBeritaRead['id_berita']; ?>" style="display:none" value="<?php echo $row_rsBeritaRead['id_berita']; ?>"></td>
      
        <td class="w3-border-right w3-center"><?php $jumKomentar = mysql_num_rows(mysql_query("SELECT * FROM tb_comment WHERE id_berita = '$idBerita'")) ?><i class="fa fa-comments"></i> <?php echo $jumKomentar ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsBeritaRead['posting']; ?></td>
        <td class="w3-center"><a onClick="document.getElementById('hasilNya').value=document.getElementById('iniID<?php echo $row_rsBeritaRead['id_berita']; ?>').value;document.getElementById('IniFormnya').submit()" class="w3-tag w3-small w3-green" style="text-decoration:none" href="berita_detail.php?id_berita=<?php echo $row_rsBeritaRead['id_berita']; ?>"><i class="fa fa-search fa-fw"></i> Lihat</a></td>
      </tr>
      <?php } while ($row_rsBeritaRead = mysql_fetch_assoc($rsBeritaRead)); ?>
  </table><br>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsBeritaRead);

mysql_free_result($rsInputTemp);
?>
<?php if ($totalRows_rsBeritaRead == 0) { // Show if recordset empty ?>
 <div class="w3-row">
 	
	<div class="w3-col l3" style="padding-right:4px;"><input oninput="w3.filterHTML('#berita', '.berita', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l9" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Berita<span class="w3-right"><?php echo $totalRows_rsBeritaRead ?></span>
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
<form method="post" id="IniFormnya" target="untukTemp" name="form1" action="<?php echo $editFormAction; ?>" style="display:none">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Id_berita:</td>
      <td><input type="text" name="id_berita" value="" id="hasilNya" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Username:</td>
      <td><input type="text" name="username" value="<?php echo $_SESSION['MM_Username'] ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="id_temp" value="">
  <input type="hidden" name="MM_insert" value="form1">
</form>
<iframe name="untukTemp" style="display:none"></iframe>
</body>
</html>

