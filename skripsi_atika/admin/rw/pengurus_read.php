<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
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

mysql_select_db($database_koneksi, $koneksi);
$query_rsPengurusRead = "SELECT * FROM tb_pengurus ORDER BY nama_lengkap ASC";
$rsPengurusRead = mysql_query($query_rsPengurusRead, $koneksi) or die(mysql_error());
$row_rsPengurusRead = mysql_fetch_assoc($rsPengurusRead);
$totalRows_rsPengurusRead = mysql_num_rows($rsPengurusRead);
$nomor = 1;
?>

<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/template-rw.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>ATIKAH</title>
<!-- InstanceEndEditable -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../assets/w3.css">
<link href="../../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../../assets/w3.js"></script>
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
    	<div class="w3-col s12"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp; RUKUN WARGA 03</div>
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
            	<li class="w3-hover-light-grey"><a href="warga_read.php" style="text-decoration:none"><i class="fa fa-user-circle fa-fw"></i> Data Warga</a></li>
                <li class="w3-hover-light-grey"><a href="surat_read.php" style="text-decoration:none"><i class="fa fa-file fa-fw"></i> Data Surat Pengantar</a></li>
            	<li class="w3-hover-light-grey"><a href="admin_read.php" style="text-decoration:none"><i class="fa fa-user-circle-o fa-fw"></i> Data Admin</a></li>
                <li class="w3-hover-light-grey"><a href="pengurus_read.php" style="text-decoration:none"><i class="fa fa-user-circle-o fa-fw"></i> Data Pengurus</a></li>
                <li class="w3-hover-light-grey"><a href="berita_read.php" style="text-decoration:none"><i class="fa fa-newspaper-o fa-fw"></i> Data Berita</a></li>
                <li class="w3-hover-light-grey"><a href="keluhan_read.php" style="text-decoration:none"><i class="fa fa-warning fa-fw"></i> Data Keluhan</a></li>
                <li class="w3-hover-light-grey"><a href="laporan_read.php" style="text-decoration:none"><i class="fa fa-print fa-fw"></i> Cetak Laporan</a></li>
                <li class="w3-hover-light-grey"><a href="jenis_read.php" style="text-decoration:none"><i class="fa fa-database fa-fw"></i> Data Jenis Surat</a></li>
                <li class="w3-hover-light-grey"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
            </ul>
        </div>
        <div class="w3-col l9 w3-padding"><!-- InstanceBeginEditable name="EditRegion1" -->
        
		<div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Data Pengurus</div>
<?php if ($totalRows_rsPengurusRead > 0) { // Show if recordset not empty ?>
  <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><a style="margin-top:8px; height:36px;" class="w3-btn w3-block w3-green w3-small" href="pengurus_create.php"><i class="fa fa-plus fa-fw"></i> Tambah Pengurus</a></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#pengurus', '.pengurus', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Pengurus<span class="w3-right"><?php echo $totalRows_rsPengurusRead ?></span>
        </div></div>
</div>

        
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="pengurus" style="margin-top:8px;">
      <tr style="font-weight:bold" class="w3-hover-none">
      <td class="w3-border-right w3-center">No</td>
      <td class="w3-border-right w3-center">Foto</td>
      <td class="w3-border-right">Nama</td>
      <td class="w3-border-right w3-center">Jabatan</td>
      <td class="w3-border-right w3-center">Pada</td>
     <td class="w3-border-right w3-center">No. HP</td>
      
      <td class="w3-center">Opsi</td>
    </tr>
    <?php do { ?>
      <tr class="pengurus">
        <td class="w3-border-right w3-center"><?php echo $nomor++; ?></td>
        <td class="w3-border-right w3-center"><img src="../rt/foto_rt/<?php echo $row_rsPengurusRead['foto']; ?>" width="52" height="56"></td>
        <td class="w3-border-right w3-text-green" style="cursor:pointer" onclick="document.getElementById('<?php echo $row_rsPengurusRead['id_pengurus']; ?>').style.display='block'"><?php echo $row_rsPengurusRead['nama_lengkap']; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsPengurusRead['jabatan']; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsPengurusRead['kategori']; ?> <?php echo $row_rsPengurusRead['nomor']; ?></td>
		<td class="w3-border-right w3-center"><?php echo $row_rsPengurusRead['no_hp']; ?></td>
        
        <td class="w3-center"><a class="w3-tag w3-small w3-green" style="text-decoration:none"
 href="pengurus_update.php?id_pengurus=<?php echo $row_rsPengurusRead['id_pengurus']; ?>">Ubah</a> <a class="w3-tag w3-small w3-red" style="text-decoration:none"
 onclick="return confirm('Anda Yakin Ingin Menghapus?')" href="pengurus_delete.php?id_pengurus=<?php echo $row_rsPengurusRead['id_pengurus']; ?>">Hapus</a></td>
      </tr>
      
      <div id="<?php echo $row_rsPengurusRead['id_pengurus']; ?>" class="w3-modal">
  <div class="w3-modal-content" style="margin-top:-60px;">
    <div class="w3-container">
      <span onclick="document.getElementById('<?php echo $row_rsPengurusRead['id_pengurus']; ?>').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <p><i class="fa fa-image fa-fw"></i> Foto</p>
      <div class="w3-center w3-large"><strong><?php echo strtoupper($row_rsPengurusRead['nama_lengkap']); ?></strong></div>
      <center><img style="margin-top:8px;" src="../rt/foto_rt/<?php echo $row_rsPengurusRead['foto']; ?>" class="w3-image" width="400" height="400"></center>
      <div style="margin-top:8px;" class="w3-center"><?php echo $row_rsPengurusRead['jabatan']; ?> <?php echo $row_rsPengurusRead['kategori']; ?> <?php echo $row_rsPengurusRead['nomor']; ?></div>
      <br>

    </div>
  </div>
</div>
      <?php } while ($row_rsPengurusRead = mysql_fetch_assoc($rsPengurusRead)); ?>
  </table><br>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsPengurusRead);
?>
<?php if ($totalRows_rsPengurusRead == 0) { // Show if recordset empty ?>
  <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><a style="margin-top:8px; height:36px;" class="w3-btn w3-block w3-green w3-small" href="pengurus_create.php"><i class="fa fa-plus fa-fw"></i> Tambah Pengurus</a></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#pengurus', '.pengurus', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Pengurus<span class="w3-right"><?php echo $totalRows_rsPengurusRead ?></span>
        </div></div>
</div><table class="w3-table w3-border" style="margin-top:8px;">
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