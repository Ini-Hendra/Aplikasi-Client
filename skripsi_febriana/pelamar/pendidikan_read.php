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

mysql_select_db($database_koneksi, $koneksi);
$query_rsPendidikanRead = "SELECT * FROM tb_pendidikan WHERE username='$_SESSION[MM_Username]' ORDER BY id_pendidikan DESC";
$rsPendidikanRead = mysql_query($query_rsPendidikanRead, $koneksi) or die(mysql_error());
$row_rsPendidikanRead = mysql_fetch_assoc($rsPendidikanRead);
$totalRows_rsPendidikanRead = mysql_num_rows($rsPendidikanRead);
?>
<p>DATA PENDIDIKAN | <a href="<?php echo $logoutAction ?>">Log out</a></p>
<?php if ($totalRows_rsPendidikanRead > 0) { // Show if recordset not empty ?>
  <table border="1">
    <tr>
      <td>id_pendidikan</td>
      <td>username</td>
      <td>nama_institusi</td>
      <td>bidang_studi</td>
      <td>jurusan</td>
      <td>bulan_lulus</td>
      <td>tahun_lulus</td>
      <td>kualifikasi</td>
      <td>nilai</td>
      <td>Opsi</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rsPendidikanRead['id_pendidikan']; ?></td>
        <td><?php echo $row_rsPendidikanRead['username']; ?></td>
        <td><?php echo $row_rsPendidikanRead['nama_institusi']; ?></td>
        <td><?php echo $row_rsPendidikanRead['bidang_studi']; ?></td>
        <td><?php echo $row_rsPendidikanRead['jurusan']; ?></td>
        <td><?php echo $row_rsPendidikanRead['bulan_lulus']; ?></td>
        <td><?php echo $row_rsPendidikanRead['tahun_lulus']; ?></td>
        <td><?php echo $row_rsPendidikanRead['kualifikasi']; ?></td>
        <td><?php echo $row_rsPendidikanRead['nilai']; ?></td>
        <td><a href="pendidikan_update.php?id_pendidikan=<?php echo $row_rsPendidikanRead['id_pendidikan']; ?>">Ubah</a> | <a onclick="return confirm('Anda Yakin Ingin Menghapus?')" href="pendidikan_delete.php?id_pendidikan=<?php echo $row_rsPendidikanRead['id_pendidikan']; ?>">Hapus</a></td>
      </tr>
      <?php } while ($row_rsPendidikanRead = mysql_fetch_assoc($rsPendidikanRead)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsPendidikanRead);
?>
<?php if ($totalRows_rsPendidikanRead == 0) { // Show if recordset empty ?>
  <table width="100%" border="1">
    <tr>
      <td>Masih Kosong</td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>
