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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tb_pelamar SET username=%s, nama=%s, jenis_kelamin=%s, tempat_lahir=%s, tanggal_lahir=%s, ukuran_baju=%s, ukuran_sepatu=%s, tinggi_badan=%s, berat_badan=%s, status_kawin=%s, status_keluarga=%s, agama=%s, gol_darah=%s, no_hp=%s, email=%s, nik=%s, negara=%s, provinsi=%s, alamat=%s, kota=%s, kode_pos=%s, no_npwp=%s, no_bpjs_kesehatan=%s, no_bpjs_tenagakerja=%s, no_kk=%s WHERE id_pelamar=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['jenis_kelamin'], "text"),
                       GetSQLValueString($_POST['tempat_lahir'], "text"),
                       GetSQLValueString($_POST['tanggal_lahir'], "date"),
                       GetSQLValueString($_POST['ukuran_baju'], "text"),
                       GetSQLValueString($_POST['ukuran_sepatu'], "text"),
                       GetSQLValueString($_POST['tinggi_badan'], "int"),
                       GetSQLValueString($_POST['berat_badan'], "int"),
                       GetSQLValueString($_POST['status_kawin'], "text"),
                       GetSQLValueString($_POST['status_keluarga'], "text"),
                       GetSQLValueString($_POST['agama'], "text"),
                       GetSQLValueString($_POST['gol_darah'], "text"),
                       GetSQLValueString($_POST['no_hp'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['nik'], "text"),
                       GetSQLValueString($_POST['negara'], "text"),
                       GetSQLValueString($_POST['provinsi'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['kota'], "text"),
                       GetSQLValueString($_POST['kode_pos'], "text"),
                       GetSQLValueString($_POST['no_npwp'], "text"),
                       GetSQLValueString($_POST['no_bpjs_kesehatan'], "text"),
                       GetSQLValueString($_POST['no_bpjs_tenagakerja'], "text"),
                       GetSQLValueString($_POST['no_kk'], "text"),
                       GetSQLValueString($_POST['id_pelamar'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "pelamar_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsPelamarUpdate = "-1";
if (isset($_GET['id_pelamar'])) {
  $colname_rsPelamarUpdate = $_GET['id_pelamar'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsPelamarUpdate = sprintf("SELECT * FROM tb_pelamar WHERE id_pelamar = %s", GetSQLValueString($colname_rsPelamarUpdate, "text"));
$rsPelamarUpdate = mysql_query($query_rsPelamarUpdate, $koneksi) or die(mysql_error());
$row_rsPelamarUpdate = mysql_fetch_assoc($rsPelamarUpdate);
$totalRows_rsPelamarUpdate = mysql_num_rows($rsPelamarUpdate);
?>

<p>UBAH DATA PELAMAR<a href="<?php echo $logoutAction ?>">Log out</a></p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_pelamar:</td>
      <td><?php echo $row_rsPelamarUpdate['id_pelamar']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Username:</td>
      <td><input type="text" name="username" value="<?php echo htmlentities($row_rsPelamarUpdate['username'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama:</td>
      <td><input type="text" name="nama" value="<?php echo htmlentities($row_rsPelamarUpdate['nama'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jenis_kelamin:</td>
      <td><select name="jenis_kelamin">
        <option value="Pria" <?php if (!(strcmp("Pria", htmlentities($row_rsPelamarUpdate['jenis_kelamin'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Pria</option>
        <option value="Wanita" <?php if (!(strcmp("Wanita", htmlentities($row_rsPelamarUpdate['jenis_kelamin'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Wanita</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tempat_lahir:</td>
      <td><input type="text" name="tempat_lahir" value="<?php echo htmlentities($row_rsPelamarUpdate['tempat_lahir'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal_lahir:</td>
      <td><input type="text" name="tanggal_lahir" value="<?php echo htmlentities($row_rsPelamarUpdate['tanggal_lahir'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ukuran_baju:</td>
      <td><input type="text" name="ukuran_baju" value="<?php echo htmlentities($row_rsPelamarUpdate['ukuran_baju'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ukuran_sepatu:</td>
      <td><input type="text" name="ukuran_sepatu" value="<?php echo htmlentities($row_rsPelamarUpdate['ukuran_sepatu'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tinggi_badan:</td>
      <td><input type="text" name="tinggi_badan" value="<?php echo htmlentities($row_rsPelamarUpdate['tinggi_badan'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Berat_badan:</td>
      <td><input type="text" name="berat_badan" value="<?php echo htmlentities($row_rsPelamarUpdate['berat_badan'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status_kawin:</td>
      <td><input type="text" name="status_kawin" value="<?php echo htmlentities($row_rsPelamarUpdate['status_kawin'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status_keluarga:</td>
      <td><input type="text" name="status_keluarga" value="<?php echo htmlentities($row_rsPelamarUpdate['status_keluarga'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Agama:</td>
      <td><input type="text" name="agama" value="<?php echo htmlentities($row_rsPelamarUpdate['agama'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Gol_darah:</td>
      <td><input type="text" name="gol_darah" value="<?php echo htmlentities($row_rsPelamarUpdate['gol_darah'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">No_hp:</td>
      <td><input type="text" name="no_hp" value="<?php echo htmlentities($row_rsPelamarUpdate['no_hp'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="email" value="<?php echo htmlentities($row_rsPelamarUpdate['email'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nik:</td>
      <td><input type="text" name="nik" value="<?php echo htmlentities($row_rsPelamarUpdate['nik'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Negara:</td>
      <td><input type="text" name="negara" value="<?php echo htmlentities($row_rsPelamarUpdate['negara'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Provinsi:</td>
      <td><input type="text" name="provinsi" value="<?php echo htmlentities($row_rsPelamarUpdate['provinsi'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Alamat:</td>
      <td><input type="text" name="alamat" value="<?php echo htmlentities($row_rsPelamarUpdate['alamat'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kota:</td>
      <td><input type="text" name="kota" value="<?php echo htmlentities($row_rsPelamarUpdate['kota'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Kode_pos:</td>
      <td><input type="text" name="kode_pos" value="<?php echo htmlentities($row_rsPelamarUpdate['kode_pos'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">No_npwp:</td>
      <td><input type="text" name="no_npwp" value="<?php echo htmlentities($row_rsPelamarUpdate['no_npwp'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">No_bpjs_kesehatan:</td>
      <td><input type="text" name="no_bpjs_kesehatan" value="<?php echo htmlentities($row_rsPelamarUpdate['no_bpjs_kesehatan'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">No_bpjs_tenagakerja:</td>
      <td><input type="text" name="no_bpjs_tenagakerja" value="<?php echo htmlentities($row_rsPelamarUpdate['no_bpjs_tenagakerja'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">No_kk:</td>
      <td><input type="text" name="no_kk" value="<?php echo htmlentities($row_rsPelamarUpdate['no_kk'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_pelamar" value="<?php echo $row_rsPelamarUpdate['id_pelamar']; ?>" />
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($rsPelamarUpdate);
?>
