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
  $updateSQL = sprintf("UPDATE tb_surat SET username=%s, kategori_rt=%s, kategori_rw=%s, jenis_surat=%s, lampiran=%s, status_rt=%s, status_rw=%s, tanggal_input=%s WHERE id_surat=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['kategori_rt'], "text"),
                       GetSQLValueString($_POST['kategori_rw'], "text"),
                       GetSQLValueString($_POST['jenis_surat'], "text"),
                       GetSQLValueString($_POST['lampiran'], "text"),
                       GetSQLValueString($_POST['status_rt'], "text"),
                       GetSQLValueString($_POST['status_rw'], "text"),
                       GetSQLValueString($_POST['tanggal_input'], "date"),
                       GetSQLValueString($_POST['id_surat'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "surat_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsSuratUpdate = "-1";
if (isset($_GET['id_surat'])) {
  $colname_rsSuratUpdate = $_GET['id_surat'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsSuratUpdate = sprintf("SELECT * FROM tb_surat WHERE id_surat = %s", GetSQLValueString($colname_rsSuratUpdate, "text"));
$rsSuratUpdate = mysql_query($query_rsSuratUpdate, $koneksi) or die(mysql_error());
$row_rsSuratUpdate = mysql_fetch_assoc($rsSuratUpdate);
$totalRows_rsSuratUpdate = mysql_num_rows($rsSuratUpdate);
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
<body onLoad="document.getElementById('form1').submit()">
<br>
<br>
<center>Mohon Menunggu</center>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" style="display:none">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_surat:</td>
      <td><?php echo $row_rsSuratUpdate['id_surat']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Username:</td>
      <td><input type="text" name="username" value="<?php echo htmlentities($row_rsSuratUpdate['username'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kategori_rt:</td>
      <td><input type="text" name="kategori_rt" value="<?php echo htmlentities($row_rsSuratUpdate['kategori_rt'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kategori_rw:</td>
      <td><input type="text" name="kategori_rw" value="<?php echo htmlentities($row_rsSuratUpdate['kategori_rw'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jenis_surat:</td>
      <td><input type="text" name="jenis_surat" value="<?php echo htmlentities($row_rsSuratUpdate['jenis_surat'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Lampiran:</td>
      <td><input type="text" name="lampiran" value="<?php echo htmlentities($row_rsSuratUpdate['lampiran'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status_rt:</td>
      <td><input type="text" name="status_rt" value="Diterima" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status_rw:</td>
      <td><input type="text" name="status_rw" value="<?php echo htmlentities($row_rsSuratUpdate['status_rw'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal_input:</td>
      <td><input type="text" name="tanggal_input" value="<?php echo htmlentities($row_rsSuratUpdate['tanggal_input'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_surat" value="<?php echo $row_rsSuratUpdate['id_surat']; ?>" />
</form>
</body>
</html>
<?php
mysql_free_result($rsSuratUpdate);
?>
