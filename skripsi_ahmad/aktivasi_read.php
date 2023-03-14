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

$colname_rsHasilPencarian = "-1";
if (isset($_POST['kodeAktivasi'])) {
  $colname_rsHasilPencarian = $_POST['kodeAktivasi'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsHasilPencarian = sprintf("SELECT * FROM tb_aktivasi WHERE kode_aktivasi = %s", GetSQLValueString($colname_rsHasilPencarian, "text"));
$rsHasilPencarian = mysql_query($query_rsHasilPencarian, $koneksi) or die(mysql_error());
$row_rsHasilPencarian = mysql_fetch_assoc($rsHasilPencarian);
$totalRows_rsHasilPencarian = mysql_num_rows($rsHasilPencarian);
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
<link rel="stylesheet" href="assets/w3.css">
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
    	<div class="w3-col s12"><i class="fa fa-search"></i>&nbsp;&nbsp; HASIL PENCARIAN KODE AKTIVASI</div>
    </div>
    </div>
    <br>
<br>
<br>
<div class="w3-container">
	<div class="w3-row">
    <div class="w3-col w3-hide-small m2 l2">&nbsp;</div>
    <div class="w3-col s12 m8 l8">
    <?php if ($totalRows_rsHasilPencarian > 0) { // Show if recordset not empty ?>
    <div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Kode Ditemukan</div>
     <?php do { ?>
    <ul class="w3-ul w3-border w3-small" style="margin-top:8px;">
    	<li>Kode Aktivasi<span class="w3-right w3-text-green"><strong><?php echo $row_rsHasilPencarian['kode_aktivasi']; ?></strong></span></li>
    	
    </ul>
   <?php $kodeNya = $row_rsHasilPencarian['kode_aktivasi']; ?>
    <?php $adaGa = mysql_num_rows(mysql_query("SELECT * FROM tb_pemilik WHERE kode_aktivasi='$kodeNya'")); ?>
    
    
    <?php
	if($adaGa == "0"){
		?>
        <div class="w3-border w3-center w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Silahkan Daftar Kepemilikan Kode Aktivasi Tersebut
        </div>
        <div style="margin-top:8px;" class="w3-row">
        	<div class="w3-col l6" style="padding-right:4px;"><a class="w3-block w3-btn w3-green" href="index.php">Cari Ulang</a></div>
            <div class="w3-col l6" style="padding-left:4px;"><a class="w3-block w3-btn w3-green" href="aktivasi_create.php?id=<?php echo $row_rsHasilPencarian['id']; ?>&kode_aktivasi=<?php echo $row_rsHasilPencarian['kode_aktivasi']; ?>">Daftar Kepemilikan</a></div>
        </div>
        
        <?php
		} else {
			?>
            <div class="w3-border w3-center w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Kode Aktivasi Sudah Didaftarkan
        </div>
    <div style="margin-top:8px;" class="w3-row">
        	<div class="w3-col l6" style="padding-right:4px;"><a class="w3-block w3-btn w3-green" href="index.php">Cari Ulang</a></div>
            <div class="w3-col l6" style="padding-left:4px;"><a class="w3-block w3-btn w3-green" href="#">Kirim Ulang Sertifikat</a></div>
        </div>
    <?php
			}
	?>
    
    
    
    
        <?php } while ($row_rsHasilPencarian = mysql_fetch_assoc($rsHasilPencarian)); ?>
  
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsHasilPencarian);
?>
<?php if ($totalRows_rsHasilPencarian == 0) { // Show if recordset empty ?>
  <div class="w3-border w3-center w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Kode Aktivasi <strong><?php echo $colname_rsHasilPencarian ?></strong> Tidak Ditemukan<br>
Silahkan Masukkan Kode Aktivasi Yang Valid
        </div>
  
  <form name="form1" method="post" action="aktivasi_read.php">
  <div style="margin-top:8px;">
  
  </div>
  <input type="text" class="w3-input w3-border w3-small w3-center" autofocus style="outline:none" required placeholder="Kode Aktivasi" name="kodeAktivasi" id="textfield">
 <button type="submit" style="margin-top:8px;" class="w3-btn w3-small w3-block w3-green"><i class="fa fa-search fa-fw"></i> Cari Kode Aktivasi</button>
</form>
  <?php } // Show if recordset empty ?>
    </div>
    <div class="w3-col w3-hide-small m2 l2">&nbsp;</div>
    </div>
    </div>
</body>
</html>

