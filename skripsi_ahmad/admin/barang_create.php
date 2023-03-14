<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<?php require_once('../Connections/koneksi.php'); ?>
<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
$iniTanggal = date('d');
$iniBulan = date('m');
$iniTahun = date('y');
$kodeBarang2 = mysql_num_rows(mysql_query("SELECT * FROM tb_barang"));
$kodeBarang = $kodeBarang2 + 1;
			if($kodeBarang2 == 0 || $kodeBarang2 == ""){
				$noKwitansi = "00".($kodeBarang2 + 1);
				} elseif($kodeBarang2 > 0 && $kodeBarang2 <= 8){
				$jumlah = $kodeBarang2 + 1;
				$noKwitansi = "00".$jumlah;
				} elseif($kodeBarang2 >= 9 && $kodeBarang2 <= 98){
				$jumlah = $kodeBarang2 + 1;
				$noKwitansi = "0".$jumlah;
				}
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
  $insertSQL = sprintf("INSERT INTO tb_barang (id_barang, kode_barang, nama_barang, jenis, ukuran) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_barang'], "text"),
                       GetSQLValueString($_POST['kode_barang'], "text"),
                       GetSQLValueString($_POST['nama_barang'], "text"),
                       GetSQLValueString($_POST['jenis'], "text"),
                       GetSQLValueString($_POST['ukuran'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "barang_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rsBarangCreate = "-1";
if (isset($_GET['id_barang'])) {
  $colname_rsBarangCreate = $_GET['id_barang'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsBarangCreate = sprintf("SELECT * FROM tb_barang WHERE id_barang = %s", GetSQLValueString($colname_rsBarangCreate, "text"));
$rsBarangCreate = mysql_query($query_rsBarangCreate, $koneksi) or die(mysql_error());
$row_rsBarangCreate = mysql_fetch_assoc($rsBarangCreate);
$totalRows_rsBarangCreate = mysql_num_rows($rsBarangCreate);
$IDBarang = "1234567899987654321";
?>


<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/template-admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>AHMAD</title>
<!-- InstanceEndEditable -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/w3.css">
<link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../assets/w3.js"></script>
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
    	<div class="w3-col s12"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp; ADMINISTRATOR</div>
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
            	<li class="w3-hover-light-grey"><a href="barang_read.php" style="text-decoration:none"><i class="fa fa-database fa-fw"></i> Data Produk</a></li>
                <li class="w3-hover-light-grey"><a href="gudang_read.php" style="text-decoration:none"><i class="fa fa-home fa-fw"></i> Data Gudang</a></li>
                <li class="w3-hover-light-grey"><a href="aktivasi_read.php" style="text-decoration:none"><i class="fa fa-key fa-fw"></i> Data Kode Aktivasi</a></li>
            	<li class="w3-hover-light-grey"><a href="pemilik_read.php" style="text-decoration:none"><i class="fa fa-user-circle"></i> Data Pemilik</a></li>
                <li class="w3-hover-light-grey"><a href="admin_read.php" style="text-decoration:none"><i class="fa fa-user-secret fa-fw"></i> Data Admin</a></li>
               
                <li class="w3-hover-light-grey"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
            </ul>
        </div>
        <div class="w3-col l9 w3-padding"><!-- InstanceBeginEditable name="EditRegion1" -->
        <div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Tambah Produk</div>
        
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<div style="margin-top:8px;">
<input type="text" class="w3-input w3-border w3-small" required placeholder="Nama Produk" name="nama_barang" value="" size="32">
</div>

<div style="margin-top:8px;">
<input type="text" class="w3-input w3-border w3-small" required placeholder="Jenis" name="jenis" value="" size="32">
</div>

<div style="margin-top:8px;">
<select name="ukuran" class="w3-input w3-border w3-small" required style="cursor:pointer">
      <option value="">Pilih Ukurang Barang</option>
      <option value="Normal" <?php if (!(strcmp("Normal", ""))) {echo "SELECTED";} ?>>Normal</option>
        <option value="Besar" <?php if (!(strcmp("Besar", ""))) {echo "SELECTED";} ?>>Besar</option>
        <option value="Kecil" <?php if (!(strcmp("Kecil", ""))) {echo "SELECTED";} ?>>Kecil</option>
      </select>
</div>


  <table align="center" style="display:none">
    <tr valign="baseline">
      <td nowrap align="right">Id_barang:</td>
      <td><input type="text" name="id_barang" value="<?php echo "BRG".substr(str_shuffle($IDBarang),0,7) ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Kode_barang:</td>
      <td><input type="text" name="kode_barang" value="<?php echo $noKwitansi ?>" size="32"></td>
    </tr>
  
  </table>
  <hr>
  <div class="w3-center">
  <a onClick="window.history.back()" style="cursor:pointer" class="w3-btn w3-small w3-red"><i class="fa fa-times-rectangle fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Simpan</button>
  </div>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<br>

<?php
mysql_free_result($rsBarangCreate);
?>

		<!-- InstanceEndEditable -->
        
        
        
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>