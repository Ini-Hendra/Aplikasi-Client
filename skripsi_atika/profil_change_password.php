<?php require_once('Connections/koneksi.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
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
                       GetSQLValueString($_POST['foto'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString(base64_encode($_POST['password']), "text"),
                       GetSQLValueString($_POST['tgl_input'], "date"),
                       GetSQLValueString($_POST['id_warga'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "profil_logout.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsPasswordChange = "-1";
if (isset($_GET['id_warga'])) {
  $colname_rsPasswordChange = $_GET['id_warga'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsPasswordChange = sprintf("SELECT * FROM tb_warga WHERE id_warga = %s", GetSQLValueString($colname_rsPasswordChange, "text"));
$rsPasswordChange = mysql_query($query_rsPasswordChange, $koneksi) or die(mysql_error());
$row_rsPasswordChange = mysql_fetch_assoc($rsPasswordChange);
$totalRows_rsPasswordChange = mysql_num_rows($rsPasswordChange);
?>


<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<!DOCTYPE html>
<html>
<head>
<title>ATIKA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/w3.css">
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
</style>
</head>
<body>
<div class="w3-container w3-top w3-text-white" style="background-color:#118eea;">
	<div class="w3-row w3-padding-16">
    	<div class="w3-col s12"><i class="fa fa-user-circle"></i>&nbsp;&nbsp; KELOLA PROFIL</div>
    </div>
    </div>
    <br>
<br>
<br>
<div class="w3-container">
	<div class="w3-row">
    <div class="w3-col s12 m3 l3" style="padding-right:8px;">
    	<div class="w3-container w3-row w3-center w3-border">
        <?php
  $dataWarga = mysql_query("SELECT * FROM tb_warga WHERE username='$_SESSION[MM_Username]'");
  if($dataWarga === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataWarga = mysql_fetch_array($dataWarga)){
		$namaLengkap = $hasil_dataWarga['nama_lengkap'];
		$kategoriRT = $hasil_dataWarga['kategori_rt'];
		$noKTP = $hasil_dataWarga['no_ktp'];
		$foto = $hasil_dataWarga['foto'];
	}
   ?>
        
        <br>
    	<img src="admin/foto_warga/<?php echo $foto ?>" style="padding:4px; border:1px solid gray" width="118" height="118" class="w3-image w3-circle">
        <div style="margin-top:12px;" class="w3-small">Warga RT <?php echo $kategoriRT ?></div>
      	<div class="w3-large"><?php echo strtoupper($namaLengkap); ?></div>
        <div class="w3-small"><?php echo $noKTP ?></div>
        
       
         <hr style="margin-top:12px;">
        <div class="w3-bar-block" style="margin-top:-8px;">
    <a href="profil_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user-circle fa-fw"></i> Kelola Profil</a>
    <a href="surat_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-file fa-fw"></i> Surat Pengantar</a>
    <a href="keluhan_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-warning fa-fw"></i> Lapor Keluhan</a>
    
    <a href="pengurus_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user-circle-o fa-fw"></i> Data Pengurus</a>
    <a href="berita_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-newspaper-o fa-fw"></i> Berita</a>
    <a onClick="return confirm('Anda Yakin Ingin Keluar?')" href="<?php echo $logoutAction ?>" class="w3-bar-item w3-button w3-padding"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
    <div style="padding-bottom:8px;"></div>
    
  </div>
  </div>
    </div>
    <div class="w3-col s12 m9 l9">
    <div class="w3-large w3-border-bottom" style="padding-bottom:8px;"><a href="home.php" class="w3-tag w3-green"><i class="fa fa-home"></i></a> | Ubah Password</div>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <div class="w3-border w3-center w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Silahkan Ubah Password Anda<br>
Setalah Anda Ubah, Anda Diharuskan Login Kembali<br>
Pastikan Password Mudah Diingat
        </div>
        <div style="margin-top:8px;">
        <span id="spryconfirm1">
        <input type="password" name="text1" class="w3-input w3-border w3-small" required placeholder="Masukkan Password Lama" style="background-color:white" id="text1">
      <span class="confirmRequiredMsg">Tidak Boleh Kosong</span><span class="confirmInvalidMsg">Password Lama Tidak Cocok</span></span>
        </div>
        
        <div style="margin-top:8px;">
        <input type="password" id="passNew" class="w3-input w3-border w3-small" required placeholder="Masukkan Password Baru" name="password" value="" size="32">
        </div>
        
        <div style="margin-top:8px;">
        <span id="spryconfirm2">
        <input type="password" name="text2" class="w3-input w3-border w3-small" required placeholder="Ulangi Password Baru" style="background-color:white" id="text2">
      <span class="confirmRequiredMsg">Tidak Boleh Kosong</span><span class="confirmInvalidMsg">Ulangi Password Dengan Benar</span></span>
        </div>
        <div><span class="w3-right"><input type="checkbox" class="w3-check w3-small" onclick="myFunction()"> Show Password
        </span></div><br>

		<script type="text/javascript">
function myFunction() {
  var x = document.getElementById("text1");
  var y = document.getElementById("passNew");
  var z = document.getElementById("text2");
  if (x.type === "password" || y.type === "password" || z.type === "password") {
    x.type = "text";
	y.type = "text";
	z.type = "text";
  } else {
    x.type = "password";
	y.type = "password";
	z.type = "password";
  }
}
</script>
        <table align="center" style="display:none">
    <tr valign="baseline">
      <td nowrap align="right">Id_warga:</td>
      <td><?php echo $row_rsPasswordChange['id_warga']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nama_lengkap:</td>
      <td><input type="text" name="nama_lengkap" value="<?php echo htmlentities($row_rsPasswordChange['nama_lengkap'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">No_ktp:</td>
      <td><input type="text" name="no_ktp" value="<?php echo htmlentities($row_rsPasswordChange['no_ktp'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">No_kk:</td>
      <td><input type="text" name="no_kk" value="<?php echo htmlentities($row_rsPasswordChange['no_kk'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Jenis_kelamin:</td>
      <td><select name="jenis_kelamin">
        <option value="Pria" <?php if (!(strcmp("Pria", htmlentities($row_rsPasswordChange['jenis_kelamin'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Pria</option>
        <option value="Wanita" <?php if (!(strcmp("Wanita", htmlentities($row_rsPasswordChange['jenis_kelamin'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Wanita</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tempat_lahir:</td>
      <td><input type="text" name="tempat_lahir" value="<?php echo htmlentities($row_rsPasswordChange['tempat_lahir'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tanggal_lahir:</td>
      <td><input type="text" name="tanggal_lahir" value="<?php echo htmlentities($row_rsPasswordChange['tanggal_lahir'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Agama:</td>
      <td><select name="agama">
        <option value="Islam" <?php if (!(strcmp("Islam", htmlentities($row_rsPasswordChange['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Islam</option>
        <option value="Protestan" <?php if (!(strcmp("Protestan", htmlentities($row_rsPasswordChange['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Protestan</option>
        <option value="Katholik" <?php if (!(strcmp("Katholik", htmlentities($row_rsPasswordChange['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Katholik</option>
        <option value="Hindu" <?php if (!(strcmp("Hindu", htmlentities($row_rsPasswordChange['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Hindu</option>
        <option value="Buddha" <?php if (!(strcmp("Buddha", htmlentities($row_rsPasswordChange['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Buddha</option>
        <option value="Kongucu" <?php if (!(strcmp("Kongucu", htmlentities($row_rsPasswordChange['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Kongucu</option>
        <option value="Ateis" <?php if (!(strcmp("Ateis", htmlentities($row_rsPasswordChange['agama'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Ateis</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Pendidikan:</td>
      <td><input type="text" name="pendidikan" value="<?php echo htmlentities($row_rsPasswordChange['pendidikan'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Jenis_pekerjaan:</td>
      <td><input type="text" name="jenis_pekerjaan" value="<?php echo htmlentities($row_rsPasswordChange['jenis_pekerjaan'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Status_perkawinan:</td>
      <td><input type="text" name="status_perkawinan" value="<?php echo htmlentities($row_rsPasswordChange['status_perkawinan'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Status_hubungan:</td>
      <td><input type="text" name="status_hubungan" value="<?php echo htmlentities($row_rsPasswordChange['status_hubungan'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Kewarganegaraan:</td>
      <td><input type="text" name="kewarganegaraan" value="<?php echo htmlentities($row_rsPasswordChange['kewarganegaraan'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">No_paspor:</td>
      <td><input type="text" name="no_paspor" value="<?php echo htmlentities($row_rsPasswordChange['no_paspor'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">No_kitap:</td>
      <td><input type="text" name="no_kitap" value="<?php echo htmlentities($row_rsPasswordChange['no_kitap'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nama_ayah:</td>
      <td><input type="text" name="nama_ayah" value="<?php echo htmlentities($row_rsPasswordChange['nama_ayah'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nama_ibu:</td>
      <td><input type="text" name="nama_ibu" value="<?php echo htmlentities($row_rsPasswordChange['nama_ibu'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Alamat:</td>
      <td><input type="text" name="alamat" value="<?php echo htmlentities($row_rsPasswordChange['alamat'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Kategori_rt:</td>
      <td><input type="text" name="kategori_rt" value="<?php echo htmlentities($row_rsPasswordChange['kategori_rt'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Kategori_rw:</td>
      <td><input type="text" name="kategori_rw" value="<?php echo htmlentities($row_rsPasswordChange['kategori_rw'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Foto:</td>
      <td><input type="text" name="foto" value="<?php echo htmlentities($row_rsPasswordChange['foto'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Username:</td>
      <td><input type="text" name="username" value="<?php echo htmlentities($row_rsPasswordChange['username'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
   <tr valign="baseline">
      <td nowrap align="right">Username:</td>
      <td><input type="text" id="passOld" value="<?php echo htmlentities(base64_decode($row_rsPasswordChange['password']), ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tgl_input:</td>
      <td><input type="text" name="tgl_input" value="<?php echo htmlentities($row_rsPasswordChange['tgl_input'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    
  </table>
  
  <hr>
  <div class="w3-center">
  <a onClick="window.history.back()" style="cursor:pointer" class="w3-btn w3-small w3-red"><i class="fa fa-times-rectangle fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Ubah Password</button>
  </div>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_warga" value="<?php echo $row_rsPasswordChange['id_warga']; ?>">
</form><br>

    </div>
    
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($rsPasswordChange);
?>
<script type="text/javascript">
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "passOld");
var spryconfirm2 = new Spry.Widget.ValidationConfirm("spryconfirm2", "passNew");
</script>
