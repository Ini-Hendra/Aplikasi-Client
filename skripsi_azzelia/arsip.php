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

$maxRows_rsArsipReadMgr = 1000;
$pageNum_rsArsipReadMgr = 0;
if (isset($_GET['pageNum_rsArsipReadMgr'])) {
  $pageNum_rsArsipReadMgr = $_GET['pageNum_rsArsipReadMgr'];
}
$startRow_rsArsipReadMgr = $pageNum_rsArsipReadMgr * $maxRows_rsArsipReadMgr;

mysql_select_db($database_koneksi, $koneksi);
$query_rsArsipReadMgr = "SELECT * FROM tb_file ORDER BY tgl_upload DESC";
$query_limit_rsArsipReadMgr = sprintf("%s LIMIT %d, %d", $query_rsArsipReadMgr, $startRow_rsArsipReadMgr, $maxRows_rsArsipReadMgr);
$rsArsipReadMgr = mysql_query($query_limit_rsArsipReadMgr, $koneksi) or die(mysql_error());
$row_rsArsipReadMgr = mysql_fetch_assoc($rsArsipReadMgr);

if (isset($_GET['totalRows_rsArsipReadMgr'])) {
  $totalRows_rsArsipReadMgr = $_GET['totalRows_rsArsipReadMgr'];
} else {
  $all_rsArsipReadMgr = mysql_query($query_rsArsipReadMgr);
  $totalRows_rsArsipReadMgr = mysql_num_rows($all_rsArsipReadMgr);
}
$totalPages_rsArsipReadMgr = ceil($totalRows_rsArsipReadMgr/$maxRows_rsArsipReadMgr)-1;
$nomor = 1;
?>
<!DOCTYPE html>
<html>
<head>
<title>MANAGER</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/w3.css">
<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="assets/w3.js"></script>
</head>
<body>

<?php if ($totalRows_rsArsipReadMgr > 0) { // Show if recordset not empty ?>
  <input oninput="w3.filterHTML('#hendra5', '.item5', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-small" style="outline:none; margin-top:8px;" autofocus>
  <div class="w3-small w3-text-red" style="margin-top:8px;">*Klik Untuk Melihat Secara Detail</div>
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="hendra5" style="margin-top:8px;">
    <tr style="font-weight:bold">
      <td>No</td>
      <td>Nama Customer</td>
      <td>No. PO</td>
      <td>Tanggal PO</td>
      <td>Nama Arsip</td>
      <td>Kategori</td>
    </tr>
    <?php do { ?>
      <tr class="item5">
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsArsipReadMgr['id_file']; ?>').style.display='block'"><?php echo $nomor++; ?></td>
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsArsipReadMgr['id_file']; ?>').style.display='block'"><?php echo $row_rsArsipReadMgr['nama_customer']; ?></td>
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsArsipReadMgr['id_file']; ?>').style.display='block'"><?php echo $row_rsArsipReadMgr['no_po']; ?></td>
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsArsipReadMgr['id_file']; ?>').style.display='block'"><?php
        
		$year = substr($row_rsArsipReadMgr['tgl_po'],0,4);
		$mont = substr($row_rsArsipReadMgr['tgl_po'],5,2);
		$day = substr($row_rsArsipReadMgr['tgl_po'],8,2);
		echo $day."-".$mont."-".$year; ?></td>
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsArsipReadMgr['id_file']; ?>').style.display='block'"><?php echo $row_rsArsipReadMgr['nama_file']; ?></td>
        
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsArsipReadMgr['id_file']; ?>').style.display='block'"><?php echo $row_rsArsipReadMgr['kategori']; ?></td>
      </tr>
      
      
      <div id="<?php echo $row_rsArsipReadMgr['id_file']; ?>" class="w3-modal">
  <div class="w3-modal-content" style="margin-top:-40px;">
    <div class="w3-container">
      <span onclick="document.getElementById('<?php echo $row_rsArsipReadMgr['id_file']; ?>').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <p><i class="fa fa-search fa-fw"></i> Detail Arsip</p>
      <p>
	  <ul class="w3-ul w3-small">
  <li>Nama Customer<span class="w3-right"><?php echo $row_rsArsipReadMgr['nama_customer']; ?></span></li>
  <li>No. PO<span class="w3-right"><?php echo $row_rsArsipReadMgr['no_po']; ?></span></li>
  <li>Kategori Arsip<span class="w3-right"><?php echo $row_rsArsipReadMgr['kategori']; ?></span></li>
  <li>Tanggal PO<span class="w3-right"><?php
        
		$year = substr($row_rsArsipReadMgr['tgl_po'],0,4);
		$mont = substr($row_rsArsipReadMgr['tgl_po'],5,2);
		$day = substr($row_rsArsipReadMgr['tgl_po'],8,2);
		echo $day."-".$mont."-".$year; ?></span></li>
  <li>Spesifikasi<span class="w3-right"><?php echo $row_rsArsipReadMgr['spesifikasi']; ?></span></li>
  <li>Nama Arsip<span class="w3-right"><strong><?php echo $row_rsArsipReadMgr['nama_file']; ?></strong></span></li>
  
  
  <li><strong>Klik File Untuk Mencetak</strong><br>
  
  <?php
$apalah = $row_rsArsipReadMgr['id_file'];
$filekedua = $row_rsArsipReadMgr['file2'];
$fileketiga = $row_rsArsipReadMgr['file3'];
$filekeempat = $row_rsArsipReadMgr['file4'];
$filekelima = $row_rsArsipReadMgr['file5'];
$filekeenam = $row_rsArsipReadMgr['file6'];
$fileketujuh = $row_rsArsipReadMgr['file7'];
$filekedelapan = $row_rsArsipReadMgr['file8'];
$filekesembilan = $row_rsArsipReadMgr['file9'];
$filekesepuluh = $row_rsArsipReadMgr['file10'];
 ?>
  
<div>File 1<span class="w3-right"><a target="_blank" href="admin/file/<?php echo $row_rsArsipReadMgr['file']; ?>"><?php echo $row_rsArsipReadMgr['file']; ?></a></span></div>
<div>File 2<span class="w3-right"><?php 
if($apalah == $filekedua){
	echo "-";
	} else {
		?>
        <a target="_blank" href="admin/file2/<?php echo $row_rsArsipReadMgr['file2']; ?>"><?php echo $row_rsArsipReadMgr['file2']; ?></a>
        <?php
	}
 ?></span></div>
<div>File 3<span class="w3-right">
<?php 
if($apalah == $fileketiga){
	echo "-";
	} else {
		?>
        <a target="_blank" href="admin/file3/<?php echo $row_rsArsipReadMgr['file3']; ?>"><?php echo $row_rsArsipReadMgr['file3']; ?></a>
        <?php
	}
 ?>
</span></div>
<div>File 4<span class="w3-right">
<?php 
if($apalah == $filekeempat){
	echo "-";
	} else {
		?>
        <a target="_blank" href="admin/file4/<?php echo $row_rsArsipReadMgr['file4']; ?>"><?php echo $row_rsArsipReadMgr['file4']; ?></a>
        <?php
	}
 ?>
</span></div>
<div>File 5<span class="w3-right">
<?php 
if($apalah == $filekelima){
	echo "-";
	} else {
		?>
        <a target="_blank" href="admin/file5/<?php echo $row_rsArsipReadMgr['file5']; ?>"><?php echo $row_rsArsipReadMgr['file5']; ?></a>
        <?php
	}
 ?>
</span></div>
<div>File 6<span class="w3-right">
<?php 
if($apalah == $filekeenam){
	echo "-";
	} else {
		?>
        <a target="_blank" href="file6/<?php echo $row_rsArsipReadMgr['file6']; ?>"><?php echo $row_rsArsipReadMgr['file6']; ?></a>
        <?php
	}
 ?>
</span></div>
<div>File 7<span class="w3-right">
<?php 
if($apalah == $fileketujuh){
	echo "-";
	} else {
		?>
        <a target="_blank" href="file7/<?php echo $row_rsArsipReadMgr['file7']; ?>"><?php echo $row_rsArsipReadMgr['file7']; ?></a>
        <?php
	}
 ?>
</span></div>
<div>File 8<span class="w3-right">
<?php 
if($apalah == $filekedelapan){
	echo "-";
	} else {
		?>
        <a target="_blank" href="file8/<?php echo $row_rsArsipReadMgr['file8']; ?>"><?php echo $row_rsArsipReadMgr['file8']; ?></a>
        <?php
	}
 ?>
</span></div>
<div>File 9<span class="w3-right">
<?php 
if($apalah == $filekesembilan){
	echo "-";
	} else {
		?>
        <a target="_blank" href="file9/<?php echo $row_rsArsipReadMgr['file9']; ?>"><?php echo $row_rsArsipReadMgr['file9']; ?></a>
        <?php
	}
 ?>
</span></div>
<div>File 10<span class="w3-right">
<?php 
if($apalah == $filekesepuluh){
	echo "-";
	} else {
		?>
        <a target="_blank" href="file10/<?php echo $row_rsArsipReadMgr['file10']; ?>"><?php echo $row_rsArsipReadMgr['file10']; ?></a>
        <?php
	}
 ?>
</span></div></li>
  
  
  
  <li>Tanggal Buat Arsip<span class="w3-right"><?php echo $row_rsArsipReadMgr['tgl_upload']; ?></span></li>
</ul>
	  </p>
      
    </div>
  </div>
</div>
      
      
      <?php } while ($row_rsArsipReadMgr = mysql_fetch_assoc($rsArsipReadMgr)); ?>
  </table><br>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsArsipReadMgr);
?>
<?php if ($totalRows_rsArsipReadMgr == 0) { // Show if recordset empty ?>
  <table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Data Masih Kosong</td>
    </tr>
  </table>
  <br>
  <?php } // Show if recordset empty ?>
</body>
</html>