<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
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

mysql_select_db($database_koneksi, $koneksi);
$query_rsBarangRead = "SELECT * FROM tb_barang ORDER BY nama_barang ASC";
$rsBarangRead = mysql_query($query_rsBarangRead, $koneksi) or die(mysql_error());
$row_rsBarangRead = mysql_fetch_assoc($rsBarangRead);
$totalRows_rsBarangRead = mysql_num_rows($rsBarangRead);
$nomor = 1;
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
        
		<div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Data Produk</div>
<?php if ($totalRows_rsBarangRead > 0) { // Show if recordset not empty ?>
  <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><a style="margin-top:8px; height:36px;" class="w3-btn w3-block w3-green w3-small" href="barang_create.php"><i class="fa fa-plus fa-fw"></i> Tambah Produk</a></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#barang', '.barang', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Produk<span class="w3-right"><?php echo $totalRows_rsBarangRead ?></span>
        </div></div>
</div>

        
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="barang" style="margin-top:8px;">
      <tr style="font-weight:bold" class="w3-hover-none">
      <td class="w3-border-right w3-center">No</td>
      <td class="w3-border-right w3-center">Kode Produk</td>
      <td class="w3-border-right">Nama Produk</td>
      <td class="w3-border-right w3-center">Jenis</td>
      <td class="w3-border-right w3-center">Ukuran</td>
      
      <td class="w3-center">Opsi</td>
    </tr>
    <?php do { ?>
      <tr class="barang">
        <td class="w3-border-right w3-center"><?php echo $nomor++; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsBarangRead['kode_barang']; ?></td>
        <td class="w3-border-right"><?php echo $row_rsBarangRead['nama_barang']; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsBarangRead['jenis']; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsBarangRead['ukuran']; ?></td>
        <td style="display:none"><?php $IDPemilik = $row_rsBarangRead['id_pemilik'];
		if($IDPemilik == ""){
			echo "Tidak Aktif";
			} else {
				echo $IDPemilik;
				}
		 ?></td>
        <td class="w3-center"><a class="w3-tag w3-small w3-green" style="text-decoration:none" href="barang_update.php?id_barang=<?php echo $row_rsBarangRead['id_barang']; ?>">Ubah</a> <a class="w3-tag w3-small w3-red" style="text-decoration:none" onClick="return confirm('Anda Yakin Ingin Menghapus?\n<?php echo $row_rsBarangRead['nama_barang']; ?>')" href="barang_delete.php?id_barang=<?php echo $row_rsBarangRead['id_barang']; ?>">Hapus</a></td>
      </tr>
      <?php } while ($row_rsBarangRead = mysql_fetch_assoc($rsBarangRead)); ?>
  </table><br>

  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsBarangRead);
?>
<?php if ($totalRows_rsBarangRead == 0) { // Show if recordset empty ?>
  <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><a style="margin-top:8px; height:36px;" class="w3-btn w3-block w3-green w3-small" href="barang_create.php"><i class="fa fa-plus fa-fw"></i> Tambah Produk</a></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#barang', '.barang', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Produk<span class="w3-right"><?php echo $totalRows_rsBarangRead ?></span>
        </div></div>
</div>
<table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Data Masih Kosong</td>
      </tr>
    </table>
  <?php } // Show if recordset empty ?>


		<!-- InstanceEndEditable -->
        
        
        
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>