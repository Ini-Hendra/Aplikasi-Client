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
<body class="w3-light-gray">
<br>
<div class="w3-container w3-light-gray">
	<div class="w3-row">
    	<div class="w3-col l1">&nbsp;</div>
        <div class="w3-col l10 w3-white">
        	<div class="w3-container"><br>
            	<div class="w3-row">
                	<div class="w3-col l6">
                    	<div class="w3-xlarge">MANAGER</div>
                    </div>
                    <div class="w3-col l6">
                    	
                    </div>
                </div>
                <hr>
            </div>
            
            <div class="w3-container">
            	<div class="w3-row">
                	<div class="w3-col l3">
                    	<div>
                        	<ul class="w3-ul w3-hoverable w3-border">
      <a href="home.php" style="text-decoration:none;">
        <li style="border-bottom:1px solid #DDD;"><i class="fa fa-home fa-fw"></i> Beranda</li>
      </a>
      <li style="border-bottom:1px solid #DDD; width:100%" class="w3-dropdown-hover"><i class="fa fa-book fa-fw"></i> Data Absensi
        <div class="w3-dropdown-content w3-bar-block w3-border" style="margin-top:10px; width:100%"> <a href="absensi_hariini.php" class="w3-bar-item w3-button">1. Absensi Hari Ini <span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_absensi WHERE tanggal='$harini'")); ?></span></a> <a href="absensi_read.php" class="w3-bar-item w3-button">2. Semua Absensi<span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_absensi")); ?></span></a> </div>
      </li>
      <a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none">
        <li><i class="fa fa-sign-out fa-fw"></i> Keluar</li>
      </a>
    </ul>
                        </div>
                    </div>
                    <div class="w3-col l9" style="padding-left:8px;">
                    	<div class="w3-border w3-padding">
                        
   <div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-book"></i> DATA ABSENSI HARI INI</strong></div>  
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
                        
                        </div>
                    
                    </div>
                </div>
            </div><br>

        </div>
        <div class="w3-col l1">&nbsp;</div>
    </div>
</div><br>
<br>
<div class="w3-center w3-small">Copyright @ 2020 <strong>Aplikasi Absensi</strong><br>
All Right Reserved</div>
<br>
</body>
</html>

