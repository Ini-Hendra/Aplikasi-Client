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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	if($_FILES['fotonya']['name'] == ""){
  $updateSQL = sprintf("UPDATE tb_pengurus SET nama_lengkap=%s, jabatan=%s, kategori=%s, nomor=%s, no_hp=%s WHERE id_pengurus=%s",
                       GetSQLValueString($_POST['nama_lengkap'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['nomor'], "text"),
					   GetSQLValueString($_POST['no_hp'], "text"),
                       GetSQLValueString($_POST['id_pengurus'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
	} else {
		$path = $_FILES['fotonya']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
		$updateSQL = sprintf("UPDATE tb_pengurus SET nama_lengkap=%s, jabatan=%s, kategori=%s, nomor=%s, no_hp=%s, foto=%s WHERE id_pengurus=%s",
                       GetSQLValueString($_POST['nama_lengkap'], "text"),
                       GetSQLValueString($_POST['jabatan'], "text"),
                       GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['nomor'], "text"),
					   GetSQLValueString($_POST['no_hp'], "text"),
                       GetSQLValueString($_POST['id_pengurus'].'.'.$ext, "text"),
                       GetSQLValueString($_POST['id_pengurus'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
  copy($_FILES['fotonya']['tmp_name'],'../rt/foto_rt/'.$_POST['id_pengurus'].'.'.$ext);
		}
  $updateGoTo = "pengurus_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsPengurusUpdate = "-1";
if (isset($_GET['id_pengurus'])) {
  $colname_rsPengurusUpdate = $_GET['id_pengurus'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsPengurusUpdate = sprintf("SELECT * FROM tb_pengurus WHERE id_pengurus = %s", GetSQLValueString($colname_rsPengurusUpdate, "text"));
$rsPengurusUpdate = mysql_query($query_rsPengurusUpdate, $koneksi) or die(mysql_error());
$row_rsPengurusUpdate = mysql_fetch_assoc($rsPengurusUpdate);
$totalRows_rsPengurusUpdate = mysql_num_rows($rsPengurusUpdate);
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
 <div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Ubah Data Pengurus</div>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div style="margin-top:8px;">
<input type="text" class="w3-input w3-border w3-small" required placeholder="Nama Lengkap" name="nama_lengkap" value="<?php echo htmlentities($row_rsPengurusUpdate['nama_lengkap'], ENT_COMPAT, ''); ?>" size="32" />
</div>

<div style="margin-top:8px;">
<input type="text" class="w3-input w3-border w3-small" required placeholder="Jabatan" name="jabatan" value="<?php echo htmlentities($row_rsPengurusUpdate['jabatan'], ENT_COMPAT, ''); ?>" size="32" />
</div>

<div style="margin-top:8px;">
<select name="kategori" class="w3-input w3-border w3-small" required style="cursor:pointer">
      <option value="RT" <?php if (!(strcmp("RT", htmlentities($row_rsPengurusUpdate['kategori'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>RT</option>
        <option value="RW" <?php if (!(strcmp("RW", htmlentities($row_rsPengurusUpdate['kategori'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>RW</option>
      </select>
</div>

<div style="margin-top:8px;">
<select name="nomor" class="w3-input w3-border w3-small" required style="cursor:pointer">
      
        <option value="01" <?php if (!(strcmp("01", htmlentities($row_rsPengurusUpdate['nomor'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>01</option>
        <option value="02" <?php if (!(strcmp("02", htmlentities($row_rsPengurusUpdate['nomor'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>02</option>
        <option value="03" <?php if (!(strcmp("03", htmlentities($row_rsPengurusUpdate['nomor'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>03</option>
      </select>
</div>

<div style="margin-top:8px;">
<input type="text" class="w3-input w3-border w3-small" required placeholder="Nomor HP" name="no_hp" value="<?php echo htmlentities($row_rsPengurusUpdate['no_hp'], ENT_COMPAT, ''); ?>" size="32" />
</div>

<div style="margin-top:8px;">
<div class="w3-small">Upload Foto Pengurus</div>
<img src="../rt/foto_rt/<?php echo $row_rsPengurusUpdate['foto']; ?>" width="98" height="96" /><br>
<input type="file" name="fotonya" id="fotonya" style="margin-top:6px;" />
</div>
  <table align="center" style="display:none">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_pengurus:</td>
      <td><?php echo $row_rsPengurusUpdate['id_pengurus']; ?></td>
    </tr>
   
   
  
    
  </table>
  <hr>
  <div class="w3-center">
  <a onClick="window.history.back()" style="cursor:pointer" class="w3-btn w3-small w3-red"><i class="fa fa-times-rectangle fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Simpan Perubahan</button>
  </div>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_pengurus" value="<?php echo $row_rsPengurusUpdate['id_pengurus']; ?>" />
</form>
<br>

<?php
mysql_free_result($rsPengurusUpdate);
?>

		<!-- InstanceEndEditable -->
        
        
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>