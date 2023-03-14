<?php require_once('../Connections/koneksi.php'); ?>
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
date_default_timezone_set('Asia/Jakarta');
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
  $insertSQL = sprintf("INSERT INTO tb_absensi (id_absensi, nik, nama_karyawan, keterangan, tanggal) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_absensi'], "text"),
                       GetSQLValueString($_POST['nik'], "text"),
                       GetSQLValueString($_POST['nama_karyawan'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['tanggal'], "date"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rsAbsensiCreateIzin = 10;
$pageNum_rsAbsensiCreateIzin = 0;
if (isset($_GET['pageNum_rsAbsensiCreateIzin'])) {
  $pageNum_rsAbsensiCreateIzin = $_GET['pageNum_rsAbsensiCreateIzin'];
}
$startRow_rsAbsensiCreateIzin = $pageNum_rsAbsensiCreateIzin * $maxRows_rsAbsensiCreateIzin;

$colname_rsAbsensiCreateIzin = "-1";
if (isset($_GET['id_karyawan'])) {
  $colname_rsAbsensiCreateIzin = $_GET['id_karyawan'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsAbsensiCreateIzin = sprintf("SELECT * FROM tb_karyawan WHERE id_karyawan = %s", GetSQLValueString($colname_rsAbsensiCreateIzin, "text"));
$query_limit_rsAbsensiCreateIzin = sprintf("%s LIMIT %d, %d", $query_rsAbsensiCreateIzin, $startRow_rsAbsensiCreateIzin, $maxRows_rsAbsensiCreateIzin);
$rsAbsensiCreateIzin = mysql_query($query_limit_rsAbsensiCreateIzin, $koneksi) or die(mysql_error());
$row_rsAbsensiCreateIzin = mysql_fetch_assoc($rsAbsensiCreateIzin);

if (isset($_GET['totalRows_rsAbsensiCreateIzin'])) {
  $totalRows_rsAbsensiCreateIzin = $_GET['totalRows_rsAbsensiCreateIzin'];
} else {
  $all_rsAbsensiCreateIzin = mysql_query($query_rsAbsensiCreateIzin);
  $totalRows_rsAbsensiCreateIzin = mysql_num_rows($all_rsAbsensiCreateIzin);
}
$totalPages_rsAbsensiCreateIzin = ceil($totalRows_rsAbsensiCreateIzin/$maxRows_rsAbsensiCreateIzin)-1;
$IDAbs = "12345678987654321";
?>
<html>
<head></head>
<body onLoad="document.getElementById('form1').submit()">
<table border="1" style="display:none">
  <tr>
    <td>id_karyawan</td>
    <td>nik</td>
    <td>nama_karyawan</td>
    <td>bagian</td>
    <td>jenis_kelamin</td>
    <td>status</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsAbsensiCreateIzin['id_karyawan']; ?></td>
      <td><?php echo $row_rsAbsensiCreateIzin['nik']; ?></td>
      <td><?php echo $row_rsAbsensiCreateIzin['nama_karyawan']; ?></td>
      <td><?php echo $row_rsAbsensiCreateIzin['bagian']; ?></td>
      <td><?php echo $row_rsAbsensiCreateIzin['jenis_kelamin']; ?></td>
      <td><?php echo $row_rsAbsensiCreateIzin['status']; ?></td>
    </tr>
    <tr>
      <td colspan="6">
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table align="center">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Id_absensi:</td>
              <td><input type="text" name="id_absensi" value="<?php echo "ABS".substr(str_shuffle($IDAbs),0,7); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Nik:</td>
              <td><input type="text" name="nik" value="<?php echo $row_rsAbsensiCreateIzin['nik']; ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Nama_karyawan:</td>
              <td><input type="text" name="nama_karyawan" value="<?php echo $row_rsAbsensiCreateIzin['nama_karyawan']; ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Keterangan:</td>
              <td><input type="text" name="keterangan" value="Izin" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Tanggal:</td>
              <td><input type="text" name="tanggal" value="<?php echo date('Y-m-d'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="submit" value="Insert record" /></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
        </form>
      <p>&nbsp;</p></td>
    </tr>
    <?php } while ($row_rsAbsensiCreateIzin = mysql_fetch_assoc($rsAbsensiCreateIzin)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsAbsensiCreateIzin);
?>
