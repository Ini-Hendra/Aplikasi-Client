<?php require_once('../Connections/koneksi.php'); ?>

<?php
date_default_timezone_set('Asia/Jakarta');
$hariini = date('Y-m-d');
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

$maxRows_rsDataKaryawan = 1000;
$pageNum_rsDataKaryawan = 0;
if (isset($_GET['pageNum_rsDataKaryawan'])) {
  $pageNum_rsDataKaryawan = $_GET['pageNum_rsDataKaryawan'];
}
$startRow_rsDataKaryawan = $pageNum_rsDataKaryawan * $maxRows_rsDataKaryawan;

mysql_select_db($database_koneksi, $koneksi);
$query_rsDataKaryawan = "SELECT * FROM tb_karyawan ORDER BY nik ASC";
$query_limit_rsDataKaryawan = sprintf("%s LIMIT %d, %d", $query_rsDataKaryawan, $startRow_rsDataKaryawan, $maxRows_rsDataKaryawan);
$rsDataKaryawan = mysql_query($query_limit_rsDataKaryawan, $koneksi) or die(mysql_error());
$row_rsDataKaryawan = mysql_fetch_assoc($rsDataKaryawan);

if (isset($_GET['totalRows_rsDataKaryawan'])) {
  $totalRows_rsDataKaryawan = $_GET['totalRows_rsDataKaryawan'];
} else {
  $all_rsDataKaryawan = mysql_query($query_rsDataKaryawan);
  $totalRows_rsDataKaryawan = mysql_num_rows($all_rsDataKaryawan);
}
$totalPages_rsDataKaryawan = ceil($totalRows_rsDataKaryawan/$maxRows_rsDataKaryawan)-1;
?>
<!DOCTYPE html>
<html>
<head>
<title>ADMIN</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/w3.css">
<link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../assets/w3.js"></script>
</head>
<body>
<?php if ($totalRows_rsDataKaryawan > 0) { // Show if recordset not empty ?>
  <input oninput="w3.filterHTML('#hendra', '.item', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-small" style="outline:none; margin-top:8px;" autofocus>

  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="hendra" style="margin-top:8px;">
    <tr style="font-weight:bold">
      
      <td class="w3-center">NIK</td>
      <td>Nama Karyawan</td>
      <td>Bagian</td>
      <td class="w3-center">Keterangan Absen</td>
    </tr>
    <?php do { ?>
      <tr class="item">
        
        <td class="w3-center"><?php $ininik = $row_rsDataKaryawan['nik']; echo $ininik; ?></td>
        <td><?php echo $row_rsDataKaryawan['nama_karyawan']; ?></td>
        <td><?php echo $row_rsDataKaryawan['bagian']; ?></td>
        
        <td class="w3-center">
        <?php
		$adaga = mysql_num_rows(mysql_query("SELECT * FROM tb_absensi WHERE nik='$ininik' AND tanggal='$hariini'"));
        if($adaga > 0){
			echo "Sudah Diabsen";
			} else {
				?>
                <a class="w3-tag w3-small w3-green" style="text-decoration:none" href="absensi_create_hadir.php?id_karyawan=<?php echo $row_rsDataKaryawan['id_karyawan']; ?>">Hadir</a> <a class="w3-tag w3-small w3-blue" style="text-decoration:none" href="absensi_create_alpha.php?id_karyawan=<?php echo $row_rsDataKaryawan['id_karyawan']; ?>">Alpha</a> <a class="w3-tag w3-small w3-yellow" style="text-decoration:none" href="absensi_create_izin.php?id_karyawan=<?php echo $row_rsDataKaryawan['id_karyawan']; ?>">Izin</a> <a class="w3-tag w3-small w3-grey" style="text-decoration:none" href="absensi_create_sakit.php?id_karyawan=<?php echo $row_rsDataKaryawan['id_karyawan']; ?>">Sakit</a> <a class="w3-tag w3-small w3-orange" style="text-decoration:none" href="absensi_create_cuti.php?id_karyawan=<?php echo $row_rsDataKaryawan['id_karyawan']; ?>">Cuti</a>
                <?php
				}
		?>
        </td>
      </tr>
      <?php } while ($row_rsDataKaryawan = mysql_fetch_assoc($rsDataKaryawan)); ?>
  </table><br>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsDataKaryawan);
?>
<?php if ($totalRows_rsDataKaryawan == 0) { // Show if recordset empty ?>
  <table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Data Karyawan Masih Kosong<br>
Silahkan Masukkan Data Karyawan Terlebih Dahulu<br>
<br>
<a href="karyawan_create.php" class="w3-btn w3-green"><i class="fa fa-plus fa-fw"></i> Input Karyawan</a><br>
<br>
</td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>
</body>
</html>