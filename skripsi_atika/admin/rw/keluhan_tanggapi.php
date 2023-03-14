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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tb_keluhan SET username=%s, nama=%s, kategori_rt=%s, keluhan=%s, tanggapan=%s, tanggal=%s WHERE id_keluhan=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['kategori_rt'], "text"),
                       GetSQLValueString($_POST['keluhan'], "text"),
                       GetSQLValueString($_POST['tanggapan'], "text"),
                       GetSQLValueString($_POST['tanggal'], "date"),
                       GetSQLValueString($_POST['id_keluhan'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "keluhan_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsKeluhanTanggapi = "-1";
if (isset($_GET['id_keluhan'])) {
  $colname_rsKeluhanTanggapi = $_GET['id_keluhan'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsKeluhanTanggapi = sprintf("SELECT * FROM tb_keluhan WHERE id_keluhan = %s", GetSQLValueString($colname_rsKeluhanTanggapi, "text"));
$rsKeluhanTanggapi = mysql_query($query_rsKeluhanTanggapi, $koneksi) or die(mysql_error());
$row_rsKeluhanTanggapi = mysql_fetch_assoc($rsKeluhanTanggapi);
$totalRows_rsKeluhanTanggapi = mysql_num_rows($rsKeluhanTanggapi);
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
        <div class="w3-col l9 w3-padding"><!-- InstanceBeginEditable name="EditRegion1" -->
        
<div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Tanggapi Keluhan</div>
<ul class="w3-ul w3-small w3-border" style="margin-top:8px;">
	<li>Nama Warga<span class="w3-right"><?php echo $row_rsKeluhanTanggapi['nama']; ?></span></li>
    <li>Dari RT<span class="w3-right"><?php echo $row_rsKeluhanTanggapi['kategori_rt']; ?></span></li>
    <li><strong>Keluhan</strong><br>
<span class="w3-justify"><i><?php echo $row_rsKeluhanTanggapi['keluhan']; ?></i></span></li>
    <li>Tanggal Kirim<span class="w3-right"><?php echo $row_rsKeluhanTanggapi['tanggal']; ?></span></li>
</ul>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<div style="margin-top:8px;">
<textarea name="tanggapan" autofocus style="max-width:100%;min-width:100%;max-height:100px;min-height:100px;" class="w3-input w3-border w3-small" required placeholder="Tanggapan Anda" cols="50" rows="5"><?php echo htmlentities($row_rsKeluhanTanggapi['tanggapan'], ENT_COMPAT, ''); ?></textarea>
</div>
  <table align="center" style="display:none">
    <tr valign="baseline">
      <td nowrap align="right">Id_keluhan:</td>
      <td><?php echo $row_rsKeluhanTanggapi['id_keluhan']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Username:</td>
      <td><input type="text" name="username" value="<?php echo htmlentities($row_rsKeluhanTanggapi['username'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nama:</td>
      <td><input type="text" name="nama" value="<?php echo htmlentities($row_rsKeluhanTanggapi['nama'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Kategori_rt:</td>
      <td><input type="text" name="kategori_rt" value="<?php echo htmlentities($row_rsKeluhanTanggapi['kategori_rt'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Keluhan:</td>
      <td><input type="text" name="keluhan" value="<?php echo htmlentities($row_rsKeluhanTanggapi['keluhan'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right">Tanggal:</td>
      <td><input type="text" name="tanggal" value="<?php echo htmlentities($row_rsKeluhanTanggapi['tanggal'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    
  </table>
  <hr>
  <div class="w3-center">
  <a onClick="window.history.back()" style="cursor:pointer" class="w3-btn w3-small w3-red"><i class="fa fa-times-rectangle fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Kirim Tanggapan</button>
  </div>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_keluhan" value="<?php echo $row_rsKeluhanTanggapi['id_keluhan']; ?>">
</form>
<br>

<?php
mysql_free_result($rsKeluhanTanggapi);
?>

		
		<!-- InstanceEndEditable -->
        
        
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>