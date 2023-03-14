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
	if($_FILES['foto']['name'] == ""){
  $updateSQL = sprintf("UPDATE tb_warga SET nama_lengkap=%s, no_ktp=%s, no_kk=%s, jenis_kelamin=%s, tempat_lahir=%s, tanggal_lahir=%s, agama=%s, pendidikan=%s, jenis_pekerjaan=%s, status_perkawinan=%s, status_hubungan=%s, kewarganegaraan=%s, no_paspor=%s, no_kitap=%s, nama_ayah=%s, nama_ibu=%s, alamat=%s, kategori_rt=%s, kategori_rw=%s, username=%s, password=%s, tgl_input=%s WHERE id_warga=%s",
                       GetSQLValueString($_POST['nama_lengkap'], "text"),
                       GetSQLValueString($_POST['no_ktp'], "text"),
                       GetSQLValueString($_POST['no_kk'], "text"),
                       GetSQLValueString($_POST['jenis_kelamin'], "text"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tanggal_lahir'], "date"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['pendidikan'], "text"),
                       GetSQLValueString($_POST['jenis_pekerjaan'], "text"),
                       GetSQLValueString($_POST['status_perkawinan'], "text"),
                       GetSQLValueString($_POST['status_hubungan'], "text"),
                       GetSQLValueString($_POST['kewarganegaraan'], "text"),
                       GetSQLValueString($_POST['no_paspor'], "text"),
                       GetSQLValueString($_POST['no_kitap'], "text"),
                       GetSQLValueString($_POST['nama_ayah'], "text"),
                       GetSQLValueString($_POST['nama_ibu'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['kategori_rt'], "text"),
                       GetSQLValueString($_POST['kategori_rw'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['tgl_input'], "date"),
                       GetSQLValueString($_POST['id_warga'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
	} else {
		$updateSQL = sprintf("UPDATE tb_warga SET nama_lengkap=%s, no_ktp=%s, no_kk=%s, jenis_kelamin=%s, tempat_lahir=%s, tanggal_lahir=%s, agama=%s, pendidikan=%s, jenis_pekerjaan=%s, status_perkawinan=%s, status_hubungan=%s, kewarganegaraan=%s, no_paspor=%s, no_kitap=%s, nama_ayah=%s, nama_ibu=%s, alamat=%s, kategori_rt=%s, kategori_rw=%s, foto=%s, username=%s, password=%s, tgl_input=%s WHERE id_warga=%s",
                       GetSQLValueString($_POST['nama_lengkap'], "text"),
                       GetSQLValueString($_POST['no_ktp'], "text"),
                       GetSQLValueString($_POST['no_kk'], "text"),
                       GetSQLValueString($_POST['jenis_kelamin'], "text"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tanggal_lahir'], "date"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['pendidikan'], "text"),
                       GetSQLValueString($_POST['jenis_pekerjaan'], "text"),
                       GetSQLValueString($_POST['status_perkawinan'], "text"),
                       GetSQLValueString($_POST['status_hubungan'], "text"),
                       GetSQLValueString($_POST['kewarganegaraan'], "text"),
                       GetSQLValueString($_POST['no_paspor'], "text"),
                       GetSQLValueString($_POST['no_kitap'], "text"),
                       GetSQLValueString($_POST['nama_ayah'], "text"),
                       GetSQLValueString($_POST['nama_ibu'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['kategori_rt'], "text"),
                       GetSQLValueString($_POST['kategori_rw'], "text"),
                       GetSQLValueString($_POST['id_warga'].'.jpg', "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['tgl_input'], "date"),
                       GetSQLValueString($_POST['id_warga'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
  copy($_FILES['foto']['tmp_name'],'../foto_warga/'.$_POST['id_warga'].'.jpg');
		}
  $updateGoTo = "warga_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsWargaUpdate = "-1";
if (isset($_GET['id_warga'])) {
  $colname_rsWargaUpdate = $_GET['id_warga'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsWargaUpdate = sprintf("SELECT * FROM tb_warga WHERE id_warga = %s", GetSQLValueString($colname_rsWargaUpdate, "text"));
$rsWargaUpdate = mysql_query($query_rsWargaUpdate, $koneksi) or die(mysql_error());
$row_rsWargaUpdate = mysql_fetch_assoc($rsWargaUpdate);
$totalRows_rsWargaUpdate = mysql_num_rows($rsWargaUpdate);
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/template-rt.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>ATIKAH</title>
<link href="../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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
<script src="../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<!-- InstanceEndEditable -->
</head>
<body>
<div class="w3-container w3-top w3-text-white" style="background-color:#118eea;">
	<div class="w3-row w3-padding-16">
    	<div class="w3-col s12"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp; RUKUN TETANGGA <?php echo $_SESSION['MM_Username'] ?></div>
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
        
		<div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Ubah Data Warga</div>
        <div class="w3-border w3-border-yellow w3-center w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Silahkan Ubah Dengan Benar
        </div>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
<div style="margin-top:8px;" class="w3-row">
<div class="w3-col l4" style="padding-right:2px;"><input type="text" class="w3-input w3-border w3-small" required placeholder="Nama Lengkap" name="nama_lengkap" value="<?php echo htmlentities($row_rsWargaUpdate['nama_lengkap'], ENT_COMPAT, ''); ?>" size="32" /></div>
<div class="w3-col l4" style="padding-right:2px; padding-left:2px;"><span id="sprytextfield1">
<input type="number" name="no_ktp" id="text1" value="<?php echo htmlentities($row_rsWargaUpdate['no_ktp'], ENT_COMPAT, ''); ?>" class="w3-input w3-border w3-small" required placeholder="No. KTP" style="background-color:white">
<span class="textfieldRequiredMsg"> Tidak Boleh Kosong </span><span class="textfieldMinCharsMsg"> Minimal 16 Digit </span></span></div>
<div class="w3-col l4" style="padding-left:2px;"><input type="number" class="w3-input w3-border w3-small" required placeholder="No. KK" name="no_kk" value="<?php echo htmlentities($row_rsWargaUpdate['no_kk'], ENT_COMPAT, ''); ?>" size="32" /></div>
</div>



<div style="margin-top:8px;" class="w3-row">
<div class="w3-col l4" style="padding-right:2px;"><select name="jenis_kelamin" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
      	<option value="Pria" <?php if (!(strcmp("Pria", htmlentities($row_rsWargaUpdate['jenis_kelamin'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Pria</option>
        <option value="Wanita" <?php if (!(strcmp("Wanita", htmlentities($row_rsWargaUpdate['jenis_kelamin'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Wanita</option>
      </select></div>
<div class="w3-col l4" style="padding-right:2px; padding-left:2px;"><input type="text" class="w3-input w3-border w3-small" required placeholder="Tempat Lahir" name="tempat_lahir" value="<?php echo htmlentities($row_rsWargaUpdate['tempat_lahir'], ENT_COMPAT, ''); ?>" size="32" /></div>
<div class="w3-col l4" style="padding-left:2px;"><input style="height:36px;" type="date" class="w3-input w3-border w3-small" required placeholder="Tanggal Lahir" name="tanggal_lahir" value="<?php echo htmlentities($row_rsWargaUpdate['tanggal_lahir'], ENT_COMPAT, ''); ?>" size="32" /></div>
</div>

<div style="margin-top:8px;" class="w3-row">
<div class="w3-col l4" style="padding-right:2px;"><select name="agama" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
     <option value="Islam" <?php if (!(strcmp("Islam", htmlentities($row_rsWargaUpdate['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Islam</option>
        <option value="Protestan" <?php if (!(strcmp("Protestan", htmlentities($row_rsWargaUpdate['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Protestan</option>
        <option value="Katholik" <?php if (!(strcmp("Katholik", htmlentities($row_rsWargaUpdate['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Katholik</option>
        <option value="Hindu" <?php if (!(strcmp("Hindu", htmlentities($row_rsWargaUpdate['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Hindu</option>
        <option value="Buddha" <?php if (!(strcmp("Buddha", htmlentities($row_rsWargaUpdate['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Buddha</option>
        <option value="Kongucu" <?php if (!(strcmp("Kongucu", htmlentities($row_rsWargaUpdate['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Kongucu</option>
        <option value="Ateis" <?php if (!(strcmp("Ateis", htmlentities($row_rsWargaUpdate['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Ateis</option>
      </select></div>
<div class="w3-col l4" style="padding-right:2px; padding-left:2px;"><select name="pendidikan" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
     <option value="Tidak Tamat" <?php if (!(strcmp("Tidak Tamat", htmlentities($row_rsWargaUpdate['pendidikan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Tidak Tamat</option>
        <option value="SD" <?php if (!(strcmp("SD", htmlentities($row_rsWargaUpdate['pendidikan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>SD</option>
        <option value="SMP" <?php if (!(strcmp("SMP", htmlentities($row_rsWargaUpdate['pendidikan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>SMP</option>
        <option value="SMK/SMA" <?php if (!(strcmp("SMK/SMA", htmlentities($row_rsWargaUpdate['pendidikan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>SMK/SMA</option>
        <option value="Strata 1" <?php if (!(strcmp("Strata 1", htmlentities($row_rsWargaUpdate['pendidikan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Strata 1</option>
        <option value="Magister" <?php if (!(strcmp("Magister", htmlentities($row_rsWargaUpdate['pendidikan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Magister</option>
        <option value="Doktor" <?php if (!(strcmp("Doktor", htmlentities($row_rsWargaUpdate['pendidikan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Doktor</option>
      </select></div>
<div class="w3-col l4" style="padding-left:2px;"><input type="text" class="w3-input w3-border w3-small" required placeholder="Jenis Pekerjaan" name="jenis_pekerjaan" value="<?php echo htmlentities($row_rsWargaUpdate['jenis_pekerjaan'], ENT_COMPAT, ''); ?>" size="32" /></div>
</div>


<div style="margin-top:8px;" class="w3-row">
<div class="w3-col l4" style="padding-right:2px;"><select name="status_perkawinan" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
      	<option value="Belum Menikah" <?php if (!(strcmp("Belum Menikah", htmlentities($row_rsWargaUpdate['status_perkawinan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Belum Menikah</option>
        <option value="Menikah" <?php if (!(strcmp("Menikah", htmlentities($row_rsWargaUpdate['status_perkawinan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Menikah</option>
        <option value="Cerai Hidup" <?php if (!(strcmp("Cerai Hidup", htmlentities($row_rsWargaUpdate['status_perkawinan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Cerai Hidup</option>
        <option value="Cerai Mati" <?php if (!(strcmp("Cerai Mati", htmlentities($row_rsWargaUpdate['status_perkawinan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Cerai Mati</option>
      </select></div>
<div class="w3-col l4" style="padding-right:2px; padding-left:2px;"><select name="status_hubungan" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
      	<option value="Kepala Keluarga" <?php if (!(strcmp("Kepala Keluarga", htmlentities($row_rsWargaUpdate['status_hubungan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Kepala Keluarga</option>
        <option value="Ibu Rumah Tangga" <?php if (!(strcmp("Ibu Rumah Tangga", htmlentities($row_rsWargaUpdate['status_hubungan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Ibu Rumah Tangga</option>
        <option value="Anak" <?php if (!(strcmp("Anak", htmlentities($row_rsWargaUpdate['status_hubungan'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Anak</option>
      </select></div>
<div class="w3-col l4" style="padding-left:2px;"><input type="text" class="w3-input w3-border w3-small" required placeholder="Kewarganegaraan" name="kewarganegaraan" value="<?php echo htmlentities($row_rsWargaUpdate['kewarganegaraan'], ENT_COMPAT, ''); ?>" size="32" /></div>
</div>


<div style="margin-top:8px;" class="w3-row">
<div class="w3-col l4" style="padding-right:2px;"><input type="text" class="w3-input w3-border w3-small" required placeholder="Nama Ayah" name="nama_ayah" value="<?php echo htmlentities($row_rsWargaUpdate['nama_ayah'], ENT_COMPAT, ''); ?>" size="32" /></div>
<div class="w3-col l4" style="padding-right:2px; padding-left:2px;"><input type="text" class="w3-input w3-border w3-small" required placeholder="Nama Ibu" name="nama_ibu" value="<?php echo htmlentities($row_rsWargaUpdate['nama_ibu'], ENT_COMPAT, ''); ?>" size="32" /></div>
<div class="w3-col l4" style="padding-left:2px;"><select name="kategori_rt" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
      	<option value="01" <?php if (!(strcmp("01", htmlentities($row_rsWargaUpdate['kategori_rt'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>01</option>
        <option value="02" <?php if (!(strcmp("02", htmlentities($row_rsWargaUpdate['kategori_rt'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>02</option>
        <option value="03" <?php if (!(strcmp("03", htmlentities($row_rsWargaUpdate['kategori_rt'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>03</option>
      </select></div>
</div>


<div style="margin-top:8px;">
<input type="text" class="w3-input w3-border w3-small" required placeholder="Alamat Lengkap" name="alamat" value="<?php echo htmlentities($row_rsWargaUpdate['alamat'], ENT_COMPAT, ''); ?>" size="32" />
</div>


<div style="margin-top:8px;" class="w3-row w3-border w3-padding">
<div class="w3-border w3-border-yellow w3-center w3-pale-yellow w3-padding w3-small">
        Dokumen Imigrasi
        </div>
<div class="w3-col l6" style="padding-right:2px;margin-top:8px;"><input type="text" class="w3-input w3-border w3-small" placeholder="No. Paspor" name="no_paspor" value="<?php echo htmlentities($row_rsWargaUpdate['no_paspor'], ENT_COMPAT, ''); ?>" size="32" /></div>
<div class="w3-col l6" style="padding-left:2px; margin-top:8px;"><input type="text" class="w3-input w3-border w3-small" placeholder="No. KITAP" name="no_kitap" value="<?php echo htmlentities($row_rsWargaUpdate['no_kitap'], ENT_COMPAT, ''); ?>" size="32" /></div>
</div>


 
                

<div style="margin-top:8px;">
<label class="w3-small">Upload Foto Warga</label><br>
<img src="../foto_warga/<?php echo $row_rsWargaUpdate['foto']; ?>" style="margin-top:5px;" width="76" height="78" /><br>
<input type="file" name="foto" id="foto" style="margin-top:8px;" />
</div>


  <table align="center" style="display:none">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_warga:</td>
      <td><?php echo $row_rsWargaUpdate['id_warga']; ?></td>
    </tr>

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kategori_rw:</td>
      <td><input type="text" name="kategori_rw" value="<?php echo htmlentities($row_rsWargaUpdate['kategori_rw'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
   
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Username:</td>
      <td><input type="text" name="username" value="<?php echo htmlentities($row_rsWargaUpdate['username'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Password:</td>
      <td><input type="text" name="password" value="<?php echo htmlentities($row_rsWargaUpdate['password'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tgl_input:</td>
      <td><input type="text" name="tgl_input" value="<?php echo htmlentities($row_rsWargaUpdate['tgl_input'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    
  </table>
  <hr>
  <div class="w3-center">
  <a onClick="window.history.back()" style="cursor:pointer" class="w3-btn w3-small w3-red"><i class="fa fa-times-rectangle fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Simpan Perubahan</button>
  </div>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_warga" value="<?php echo $row_rsWargaUpdate['id_warga']; ?>" />
</form>
<br>

<?php
mysql_free_result($rsWargaUpdate);
?>

		<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:16, validateOn:["blur"]});
        </script>
        <!-- InstanceEndEditable -->
        
       
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>