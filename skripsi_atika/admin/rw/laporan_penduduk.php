<?php require_once('../../Connections/koneksi.php'); ?>
<?php
session_start();
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
$query_rsPenduduk = "SELECT * FROM tb_warga ORDER BY nama_lengkap ASC";
$rsPenduduk = mysql_query($query_rsPenduduk, $koneksi) or die(mysql_error());
$row_rsPenduduk = mysql_fetch_assoc($rsPenduduk);
$totalRows_rsPenduduk = mysql_num_rows($rsPenduduk);
$nomor = 1;
?>
<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<!DOCTYPE html>
<html>
<head>
<title>CETAK LAPORAN WARGA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../assets/w3.css">
<link href="../../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../../assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
</style>
</head>
<body onLoad="window.print() ">

<div class="w3-container">
	<div class="w3-row">
    <div class="w3-center">
    	<div class="w3-large">LAPORAN DATA WARGA RW 03</div>
<div class="w3-small">Kelurahan Periuk Kecamatan Periuk Kota Tangerang</div>
    </div>
    <hr>
    <?php if ($totalRows_rsPenduduk > 0) { // Show if recordset not empty ?>
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" style="margin-top:8px;">
    <tr style="font-weight:bold" class="w3-hover-none">
      <td class="w3-border-right w3-center">No</td>
      <td class="w3-border-right w3-center">Nama Warga</td>
      <td class="w3-border-right w3-center">No. KTP</td>
      <td class="w3-border-right w3-center">Kelamin</td>
      <td class="w3-border-right w3-center">Tempat, Tanggal Lahir</td>
      <td class="w3-border-right w3-center">Pekerjaan</td>
      <td class="w3-border-right w3-center">Perkawinan</td>
      <td class="w3-center">RT</td>
    </tr>
    <?php do { ?>
      <tr>
        <td class="w3-border-right w3-center"><?php echo $nomor++; ?></td>
        <td class="w3-border-right"><?php echo $row_rsPenduduk['nama_lengkap']; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsPenduduk['no_ktp']; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsPenduduk['jenis_kelamin']; ?></td>
        <td class="w3-border-right"><?php echo $row_rsPenduduk['tempat_lahir']; ?>, <?php
		$year = substr($row_rsPenduduk['tanggal_lahir'],0,4);
		$mont = substr($row_rsPenduduk['tanggal_lahir'],5,2);
		$day = substr($row_rsPenduduk['tanggal_lahir'],8,2);
		 ?> <?php echo $day."-".$mont."-".$year; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsPenduduk['jenis_pekerjaan']; ?></td>
        <td class="w3-border-right w3-center"><?php echo $row_rsPenduduk['status_perkawinan']; ?></td>
        <td class="w3-center"><?php echo $row_rsPenduduk['kategori_rt']; ?></td>
        
      </tr>
      <?php } while ($row_rsPenduduk = mysql_fetch_assoc($rsPenduduk)); ?>
  </table>
  <div style="margin-top:8px;" class="w3-small">Dicetak Pada : <?php echo date('d-m-Y H:i:s'); ?><span class="w3-right">Jumlah Data : <?php echo $totalRows_rsPenduduk ?></span></div>
  <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_rsPenduduk == 0) { // Show if recordset empty ?>
      <table class="w3-table w3-border" style="margin-top:8px;">
        <tr>
          <td class="w3-center">Tidak Ada Data Warga</td>
        </tr>
      </table>
      <?php } // Show if recordset empty ?>

    </div>
</div>
</body>
</html>

<?php
mysql_free_result($rsPenduduk);
?>
