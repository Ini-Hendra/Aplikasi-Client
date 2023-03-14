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
date_default_timezone_set('Asia/Jakarta');
$harini = date('Y-m-d');
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

$maxRows_rsAbsensiHariIni = 1000;
$pageNum_rsAbsensiHariIni = 0;
if (isset($_GET['pageNum_rsAbsensiHariIni'])) {
  $pageNum_rsAbsensiHariIni = $_GET['pageNum_rsAbsensiHariIni'];
}
$startRow_rsAbsensiHariIni = $pageNum_rsAbsensiHariIni * $maxRows_rsAbsensiHariIni;

mysql_select_db($database_koneksi, $koneksi);
$query_rsAbsensiHariIni = "SELECT * FROM tb_absensi WHERE tanggal='$harini' ORDER BY nik ASC";
$query_limit_rsAbsensiHariIni = sprintf("%s LIMIT %d, %d", $query_rsAbsensiHariIni, $startRow_rsAbsensiHariIni, $maxRows_rsAbsensiHariIni);
$rsAbsensiHariIni = mysql_query($query_limit_rsAbsensiHariIni, $koneksi) or die(mysql_error());
$row_rsAbsensiHariIni = mysql_fetch_assoc($rsAbsensiHariIni);

if (isset($_GET['totalRows_rsAbsensiHariIni'])) {
  $totalRows_rsAbsensiHariIni = $_GET['totalRows_rsAbsensiHariIni'];
} else {
  $all_rsAbsensiHariIni = mysql_query($query_rsAbsensiHariIni);
  $totalRows_rsAbsensiHariIni = mysql_num_rows($all_rsAbsensiHariIni);
}
$totalPages_rsAbsensiHariIni = ceil($totalRows_rsAbsensiHariIni/$maxRows_rsAbsensiHariIni)-1;
?>
<!DOCTYPE html>
<html>
<head>
<title>MANAGER</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/w3.css">
<link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../assets/w3.js"></script>
</head>
<body>
<?php if ($totalRows_rsAbsensiHariIni > 0) { // Show if recordset not empty ?>
  <input oninput="w3.filterHTML('#hendra7', '.item7', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-small" style="outline:none; margin-top:8px;" autofocus>
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="hendra7" style="margin-top:8px;">
    <tr style="font-weight:bold">
      
      <td>NIK</td>
      <td>Nama Karyawan</td>
      <td>Keterangan</td>
      <td>Tanggal</td>
    </tr>
    <?php do { ?>
      <tr class="item7">
       
        <td><?php echo $row_rsAbsensiHariIni['nik']; ?></td>
        <td><?php echo $row_rsAbsensiHariIni['nama_karyawan']; ?></td>
        <td><?php echo $row_rsAbsensiHariIni['keterangan']; ?></td>
        <td><?php echo $row_rsAbsensiHariIni['tanggal']; ?></td>
      </tr>
      <?php } while ($row_rsAbsensiHariIni = mysql_fetch_assoc($rsAbsensiHariIni)); ?>
  </table><br>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsAbsensiHariIni);
?>
<?php if ($totalRows_rsAbsensiHariIni == 0) { // Show if recordset empty ?>
  <table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Data Masih Kosong</td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>
</body>
</html>

