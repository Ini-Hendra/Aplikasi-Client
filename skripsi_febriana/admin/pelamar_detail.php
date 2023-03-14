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

$maxRows_rsPelamarDetail = 10;
$pageNum_rsPelamarDetail = 0;
if (isset($_GET['pageNum_rsPelamarDetail'])) {
  $pageNum_rsPelamarDetail = $_GET['pageNum_rsPelamarDetail'];
}
$startRow_rsPelamarDetail = $pageNum_rsPelamarDetail * $maxRows_rsPelamarDetail;

$colname_rsPelamarDetail = "-1";
if (isset($_GET['id_pelamar'])) {
  $colname_rsPelamarDetail = $_GET['id_pelamar'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsPelamarDetail = sprintf("SELECT * FROM tb_pelamar WHERE id_pelamar = %s", GetSQLValueString($colname_rsPelamarDetail, "text"));
$query_limit_rsPelamarDetail = sprintf("%s LIMIT %d, %d", $query_rsPelamarDetail, $startRow_rsPelamarDetail, $maxRows_rsPelamarDetail);
$rsPelamarDetail = mysql_query($query_limit_rsPelamarDetail, $koneksi) or die(mysql_error());
$row_rsPelamarDetail = mysql_fetch_assoc($rsPelamarDetail);

if (isset($_GET['totalRows_rsPelamarDetail'])) {
  $totalRows_rsPelamarDetail = $_GET['totalRows_rsPelamarDetail'];
} else {
  $all_rsPelamarDetail = mysql_query($query_rsPelamarDetail);
  $totalRows_rsPelamarDetail = mysql_num_rows($all_rsPelamarDetail);
}
$totalPages_rsPelamarDetail = ceil($totalRows_rsPelamarDetail/$maxRows_rsPelamarDetail)-1;
?>
<p>DETAIL PELAMAR<a href="<?php echo $logoutAction ?>">Log out</a></p>
<table border="1">
  <tr>
    <td>id_pelamar</td>
    <td>username</td>
    <td>nama</td>
    <td>jenis_kelamin</td>
    <td>tempat_lahir</td>
    <td>tanggal_lahir</td>
    <td>ukuran_baju</td>
    <td>ukuran_sepatu</td>
    <td>tinggi_badan</td>
    <td>berat_badan</td>
    <td>status_kawin</td>
    <td>status_keluarga</td>
    <td>agama</td>
    <td>gol_darah</td>
    <td>no_hp</td>
    <td>email</td>
    <td>nik</td>
    <td>negara</td>
    <td>provinsi</td>
    <td>alamat</td>
    <td>kota</td>
    <td>kode_pos</td>
    <td>no_npwp</td>
    <td>no_bpjs_kesehatan</td>
    <td>no_bpjs_tenagakerja</td>
    <td>no_kk</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsPelamarDetail['id_pelamar']; ?></td>
      <td><?php echo $row_rsPelamarDetail['username']; ?></td>
      <td><?php echo $row_rsPelamarDetail['nama']; ?></td>
      <td><?php echo $row_rsPelamarDetail['jenis_kelamin']; ?></td>
      <td><?php echo $row_rsPelamarDetail['tempat_lahir']; ?></td>
      <td><?php echo $row_rsPelamarDetail['tanggal_lahir']; ?></td>
      <td><?php echo $row_rsPelamarDetail['ukuran_baju']; ?></td>
      <td><?php echo $row_rsPelamarDetail['ukuran_sepatu']; ?></td>
      <td><?php echo $row_rsPelamarDetail['tinggi_badan']; ?></td>
      <td><?php echo $row_rsPelamarDetail['berat_badan']; ?></td>
      <td><?php echo $row_rsPelamarDetail['status_kawin']; ?></td>
      <td><?php echo $row_rsPelamarDetail['status_keluarga']; ?></td>
      <td><?php echo $row_rsPelamarDetail['agama']; ?></td>
      <td><?php echo $row_rsPelamarDetail['gol_darah']; ?></td>
      <td><?php echo $row_rsPelamarDetail['no_hp']; ?></td>
      <td><?php echo $row_rsPelamarDetail['email']; ?></td>
      <td><?php echo $row_rsPelamarDetail['nik']; ?></td>
      <td><?php echo $row_rsPelamarDetail['negara']; ?></td>
      <td><?php echo $row_rsPelamarDetail['provinsi']; ?></td>
      <td><?php echo $row_rsPelamarDetail['alamat']; ?></td>
      <td><?php echo $row_rsPelamarDetail['kota']; ?></td>
      <td><?php echo $row_rsPelamarDetail['kode_pos']; ?></td>
      <td><?php echo $row_rsPelamarDetail['no_npwp']; ?></td>
      <td><?php echo $row_rsPelamarDetail['no_bpjs_kesehatan']; ?></td>
      <td><?php echo $row_rsPelamarDetail['no_bpjs_tenagakerja']; ?></td>
      <td><?php echo $row_rsPelamarDetail['no_kk']; ?></td>
    </tr>
    <?php } while ($row_rsPelamarDetail = mysql_fetch_assoc($rsPelamarDetail)); ?>
</table>
<?php
mysql_free_result($rsPelamarDetail);
?>
