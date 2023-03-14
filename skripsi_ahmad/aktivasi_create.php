<?php require_once('Connections/koneksi.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO tb_pemilik (id_pemilik, nama, no_telp, email, kode_aktivasi, tanggal_aktivasi) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_pemilik'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['no_telp'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['kode_aktivasi'], "text"),
                       GetSQLValueString($_POST['tanggal_aktivasi'], "date"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "aktivasi_success.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	if($_POST['pemilik'] == "-" || $_POST['pemilik'] == "" || trim($_POST['pemilik']) == ""){
		$updateSQL = sprintf("UPDATE tb_aktivasi SET kode_aktivasi=%s, status=%s, pemilik=%s WHERE id=%s",
                       GetSQLValueString($_POST['kode_aktivasi'], "text"),
                       GetSQLValueString("Belum Aktif", "text"),
                       GetSQLValueString($_POST['pemilik'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
		} else {
  $updateSQL = sprintf("UPDATE tb_aktivasi SET kode_aktivasi=%s, status=%s, pemilik=%s WHERE id=%s",
                       GetSQLValueString($_POST['kode_aktivasi'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['pemilik'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
		}
  //$updateGoTo = "#";
  //if (isset($_SERVER['QUERY_STRING'])) {
    //$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    //$updateGoTo .= $_SERVER['QUERY_STRING'];
  //}
  //header(sprintf("Location: %s", $updateGoTo));
}

$maxRows_rsDaftarKepemilikan = 10;
$pageNum_rsDaftarKepemilikan = 0;
if (isset($_GET['pageNum_rsDaftarKepemilikan'])) {
  $pageNum_rsDaftarKepemilikan = $_GET['pageNum_rsDaftarKepemilikan'];
}
$startRow_rsDaftarKepemilikan = $pageNum_rsDaftarKepemilikan * $maxRows_rsDaftarKepemilikan;

$colname_rsDaftarKepemilikan = "-1";
if (isset($_GET['id'])) {
  $colname_rsDaftarKepemilikan = $_GET['id'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsDaftarKepemilikan = sprintf("SELECT * FROM tb_aktivasi WHERE id = %s", GetSQLValueString($colname_rsDaftarKepemilikan, "int"));
$query_limit_rsDaftarKepemilikan = sprintf("%s LIMIT %d, %d", $query_rsDaftarKepemilikan, $startRow_rsDaftarKepemilikan, $maxRows_rsDaftarKepemilikan);
$rsDaftarKepemilikan = mysql_query($query_limit_rsDaftarKepemilikan, $koneksi) or die(mysql_error());
$row_rsDaftarKepemilikan = mysql_fetch_assoc($rsDaftarKepemilikan);

if (isset($_GET['totalRows_rsDaftarKepemilikan'])) {
  $totalRows_rsDaftarKepemilikan = $_GET['totalRows_rsDaftarKepemilikan'];
} else {
  $all_rsDaftarKepemilikan = mysql_query($query_rsDaftarKepemilikan);
  $totalRows_rsDaftarKepemilikan = mysql_num_rows($all_rsDaftarKepemilikan);
}
$totalPages_rsDaftarKepemilikan = ceil($totalRows_rsDaftarKepemilikan/$maxRows_rsDaftarKepemilikan)-1;

$colname_rsUpdateAktivasi = "-1";
if (isset($_GET['kode_aktivasi'])) {
  $colname_rsUpdateAktivasi = $_GET['kode_aktivasi'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsUpdateAktivasi = sprintf("SELECT * FROM tb_aktivasi WHERE kode_aktivasi = %s", GetSQLValueString($colname_rsUpdateAktivasi, "text"));
$rsUpdateAktivasi = mysql_query($query_rsUpdateAktivasi, $koneksi) or die(mysql_error());
$row_rsUpdateAktivasi = mysql_fetch_assoc($rsUpdateAktivasi);
$totalRows_rsUpdateAktivasi = mysql_num_rows($rsUpdateAktivasi);
$IDPemilik = "123456789987654321";
?>


<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<!DOCTYPE html>
<html>
<head>
<title>AHMAD</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="assets/w3.css">
<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="assets/w3.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="w3-container w3-top w3-text-white" style="background-color:#118eea;">
	<div class="w3-row w3-padding-16">
    	<div class="w3-col s12"><i class="fa fa-search"></i>&nbsp;&nbsp; HASIL PENCARIAN KODE AKTIVASI</div>
    </div>
</div>
    <br>
<br>
<br>
<div class="w3-container">
	<div class="w3-row">
    <div class="w3-col w3-hide-small m3 l3">&nbsp;</div>
    <div class="w3-col s12 m6 l6">
    <div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Daftar Kepemilikan</div>
    <div class="w3-border w3-center w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Silahkan Lengkapi Identitas Anda
        </div>
        <?php do { ?>
        <form method="post" name="form1" id="form1" action="<?php echo $editFormAction; ?>">
        <div style="display:none">
        <input type="text" name="id_pemilik" value="<?php echo "PMK".substr(str_shuffle($IDPemilik),0,7) ?>" size="32">
        <input type="text" name="kode_aktivasi" value="<?php echo $row_rsDaftarKepemilikan['kode_aktivasi']; ?>" size="32">
        </div>
        
        
        <div style="margin-top:8px;">
   <input type="text" class="w3-input w3-border w3-small" required placeholder="Nama Pemilik" name="nama" value="" id="iniNama" onKeyUp="copyText()" size="32">
   </div>
   
   <div style="margin-top:8px;">
   <input type="text" class="w3-input w3-border w3-small" required placeholder="No. Telp" name="no_telp" value="" size="32">
   </div>
   
   <div style="margin-top:8px;">
   <span id="sprytextfield1">
              <input type="text" class="w3-input w3-border w3-small" required placeholder="Email" name="email" id="text1" style="background-color:white">
              <span class="textfieldRequiredMsg"> Tidak Boleh Kosong </span><span class="textfieldInvalidFormatMsg"> Email Tidak Valid </span></span>
              </div>
              <hr>
  <div class="w3-center">
  <a onClick="window.history.back()" style="cursor:pointer" class="w3-btn w3-small w3-red"><i class="fa fa-times-rectangle fa-fw"></i> Batal</a> <button type="submit" onClick="document.getElementById('form2').submit()" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Daftar</button>
  </div>
  <input type="hidden" name="MM_insert" value="form1">
        </form>
        <form method="post" target="prosesUpdateAktivasi" name="form2" id="form2" action="<?php echo $editFormAction; ?>">
          <table align="center" style="display:none">
            <tr valign="baseline">
              <td nowrap align="right">Kode_aktivasi:</td>
              <td><input type="text" name="kode_aktivasi" value="<?php echo htmlentities($row_rsDaftarKepemilikan['kode_aktivasi'], ENT_COMPAT, ''); ?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Status:</td>
              <td><input type="text" name="status" value="Aktif" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Pemilik:</td>
              <td><input type="text" id="namaPemilik" name="pemilik" value="<?php echo htmlentities($row_rsDaftarKepemilikan['pemilik'], ENT_COMPAT, ''); ?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">&nbsp;</td>
              <td><input type="submit" value="Update record"></td>
            </tr>
          </table>
          <input type="hidden" name="id" value="<?php echo $row_rsDaftarKepemilikan['id']; ?>">
          <input type="hidden" name="MM_update" value="form2">
          <input type="hidden" name="id" value="<?php echo $row_rsDaftarKepemilikan['id']; ?>">
        </form>
        
<?php } while ($row_rsDaftarKepemilikan = mysql_fetch_assoc($rsDaftarKepemilikan)); ?>

    <iframe name="prosesUpdateAktivasi" style="display:none"></iframe>
    </div>
    <div class="w3-col w3-hide-small m3 l3">&nbsp;</div>
    </div>
    </div>
</body>
</html>

<?php
mysql_free_result($rsDaftarKepemilikan);

mysql_free_result($rsUpdateAktivasi);
?>
<script type="text/javascript">

function copyText() {
    src = document.getElementById("iniNama");
    dest = document.getElementById("namaPemilik");
    dest.value = src.value;
}

</script>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email", {validateOn:["blur"]});
</script>
