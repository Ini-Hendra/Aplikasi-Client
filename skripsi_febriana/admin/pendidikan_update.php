<?php require_once('../Connections/koneksi.php'); ?>
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
  $updateSQL = sprintf("UPDATE tb_pendidikan SET username=%s, nama_institusi=%s, bidang_studi=%s, jurusan=%s, bulan_lulus=%s, tahun_lulus=%s, kualifikasi=%s, nilai=%s WHERE id_pendidikan=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['nama_institusi'], "text"),
                       GetSQLValueString($_POST['bidang_studi'], "text"),
                       GetSQLValueString($_POST['jurusan'], "text"),
                       GetSQLValueString($_POST['bulan_lulus'], "text"),
                       GetSQLValueString($_POST['tahun_lulus'], "text"),
                       GetSQLValueString($_POST['kualifikasi'], "text"),
                       GetSQLValueString($_POST['nilai'], "double"),
                       GetSQLValueString($_POST['id_pendidikan'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "pendidikan_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsPendidikanUpdate = "-1";
if (isset($_GET['id_pendidikan'])) {
  $colname_rsPendidikanUpdate = $_GET['id_pendidikan'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsPendidikanUpdate = sprintf("SELECT * FROM tb_pendidikan WHERE id_pendidikan = %s", GetSQLValueString($colname_rsPendidikanUpdate, "text"));
$rsPendidikanUpdate = mysql_query($query_rsPendidikanUpdate, $koneksi) or die(mysql_error());
$row_rsPendidikanUpdate = mysql_fetch_assoc($rsPendidikanUpdate);
$totalRows_rsPendidikanUpdate = mysql_num_rows($rsPendidikanUpdate);
?>

<p>UBAH PENDIDIKAN<a href="<?php echo $logoutAction ?>">Log out</a></p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Username:</td>
      <td><input type="text" name="username" value="<?php echo htmlentities($row_rsPendidikanUpdate['username'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama_institusi:</td>
      <td><input type="text" name="nama_institusi" value="<?php echo htmlentities($row_rsPendidikanUpdate['nama_institusi'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Bidang_studi:</td>
      <td><input type="text" name="bidang_studi" value="<?php echo htmlentities($row_rsPendidikanUpdate['bidang_studi'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jurusan:</td>
      <td><input type="text" name="jurusan" value="<?php echo htmlentities($row_rsPendidikanUpdate['jurusan'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Bulan_lulus:</td>
      <td><input type="text" name="bulan_lulus" value="<?php echo htmlentities($row_rsPendidikanUpdate['bulan_lulus'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tahun_lulus:</td>
      <td><input type="text" name="tahun_lulus" value="<?php echo htmlentities($row_rsPendidikanUpdate['tahun_lulus'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kualifikasi:</td>
      <td><input type="text" name="kualifikasi" value="<?php echo htmlentities($row_rsPendidikanUpdate['kualifikasi'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nilai:</td>
      <td><input type="text" name="nilai" value="<?php echo htmlentities($row_rsPendidikanUpdate['nilai'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="id_pendidikan" value="<?php echo $row_rsPendidikanUpdate['id_pendidikan']; ?>" />
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_pendidikan" value="<?php echo $row_rsPendidikanUpdate['id_pendidikan']; ?>" />
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($rsPendidikanUpdate);
?>
