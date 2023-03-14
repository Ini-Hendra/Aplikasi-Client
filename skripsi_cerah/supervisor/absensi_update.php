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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tb_absensi SET nik=%s, nama_karyawan=%s, keterangan=%s, tanggal=%s WHERE id_absensi=%s",
                       GetSQLValueString($_POST['nik'], "text"),
                       GetSQLValueString($_POST['nama_karyawan'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['tanggal'], "date"),
                       GetSQLValueString($_POST['id_absensi'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "absensi_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsAbsensiUpdate = "-1";
if (isset($_GET['id_absensi'])) {
  $colname_rsAbsensiUpdate = $_GET['id_absensi'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsAbsensiUpdate = sprintf("SELECT * FROM tb_absensi WHERE id_absensi = %s", GetSQLValueString($colname_rsAbsensiUpdate, "text"));
$rsAbsensiUpdate = mysql_query($query_rsAbsensiUpdate, $koneksi) or die(mysql_error());
$row_rsAbsensiUpdate = mysql_fetch_assoc($rsAbsensiUpdate);
$totalRows_rsAbsensiUpdate = mysql_num_rows($rsAbsensiUpdate);
?>
<!DOCTYPE html>
<html>
<head>
<title>SUPERVISOR</title>
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
                    	<div class="w3-xlarge">SUPERVISOR</div>
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
                        
   <div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-edit"></i> UBAH DATA ABSENSI</strong></div>  
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<div style="margin-top:8px;">
<label>NIK</label>
<input type="text" class="w3-input w3-border w3-small" required name="nik" value="<?php echo htmlentities($row_rsAbsensiUpdate['nik'], ENT_COMPAT, ''); ?>" size="32" />
</div>

<div style="margin-top:8px;">
<label>Nama Karyawan</label>
<input type="text" class="w3-input w3-border w3-small" required name="nama_karyawan" value="<?php echo htmlentities($row_rsAbsensiUpdate['nama_karyawan'], ENT_COMPAT, ''); ?>" size="32" />
</div>

<div style="margin-top:8px;">
<label>Tanggal</label>
<input class="w3-input w3-border w3-small" type="date" name="tanggal" value="<?php echo htmlentities($row_rsAbsensiUpdate['tanggal'], ENT_COMPAT, ''); ?>" size="32" />
</div>

<div style="margin-top:8px;">
<label>Keterangan</label>
<select name="keterangan" class="w3-input w3-border w3-small">
        <option value="Hadir" <?php if (!(strcmp("Hadir", htmlentities($row_rsAbsensiUpdate['keterangan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Hadir</option>
        <option value="Alpha" <?php if (!(strcmp("Alpha", htmlentities($row_rsAbsensiUpdate['keterangan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Alpha</option>
        <option value="Izin" <?php if (!(strcmp("Izin", htmlentities($row_rsAbsensiUpdate['keterangan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Izin</option>
        <option value="Sakit" <?php if (!(strcmp("Sakit", htmlentities($row_rsAbsensiUpdate['keterangan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Sakit</option>
        <option value="Cuti" <?php if (!(strcmp("Cuti", htmlentities($row_rsAbsensiUpdate['keterangan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Cuti</option>
      </select>
</div>
  <table align="center" style="display:none">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_absensi:</td>
      <td><?php echo $row_rsAbsensiUpdate['id_absensi']; ?></td>
    </tr>
    
  </table>
  <hr>
  <div class="w3-center">
  <a onClick="window.history.back()" style="cursor:pointer" class="w3-btn w3-small w3-red"><i class="fa fa-chevron-left fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Simpan Perubahan</button>
  </div>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_absensi" value="<?php echo $row_rsAbsensiUpdate['id_absensi']; ?>" />
</form><br />
                        
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

<?php
mysql_free_result($rsAbsensiUpdate);
?>
