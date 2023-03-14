<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<?php require_once('../Connections/koneksi.php'); ?>
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
$query_rsTampilAktivasi = "SELECT * FROM tb_aktivasi ORDER BY kode_aktivasi DESC";
$rsTampilAktivasi = mysql_query($query_rsTampilAktivasi, $koneksi) or die(mysql_error());
$row_rsTampilAktivasi = mysql_fetch_assoc($rsTampilAktivasi);
$totalRows_rsTampilAktivasi = mysql_num_rows($rsTampilAktivasi);
$nomor = 1;
?>
<?php require_once('../Connections/koneksi.php');
date_default_timezone_set('Asia/Jakarta');
 ?>

<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/template-admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>AHMAD</title>
<!-- InstanceEndEditable -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/w3.css">
<link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../assets/w3.js"></script>
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
    	<div class="w3-col s12"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp; ADMINISTRATOR</div>
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
            	<li class="w3-hover-light-grey"><a href="barang_read.php" style="text-decoration:none"><i class="fa fa-database fa-fw"></i> Data Produk</a></li>
                <li class="w3-hover-light-grey"><a href="gudang_read.php" style="text-decoration:none"><i class="fa fa-home fa-fw"></i> Data Gudang</a></li>
                <li class="w3-hover-light-grey"><a href="aktivasi_read.php" style="text-decoration:none"><i class="fa fa-key fa-fw"></i> Data Kode Aktivasi</a></li>
            	<li class="w3-hover-light-grey"><a href="pemilik_read.php" style="text-decoration:none"><i class="fa fa-user-circle"></i> Data Pemilik</a></li>
                <li class="w3-hover-light-grey"><a href="admin_read.php" style="text-decoration:none"><i class="fa fa-user-secret fa-fw"></i> Data Admin</a></li>
               
                <li class="w3-hover-light-grey"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
            </ul>
        </div>
        <div class="w3-col l9 w3-padding"><!-- InstanceBeginEditable name="EditRegion1" -->
        <div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Generate Kode Aktivasi</div>
<form action="aktivasi_proses.php" method="POST"> 
  <div class="w3-row" style="margin-top:8px;">
  	<div class="w3-col l2" style="padding-right:2px;"><select name="kode_barang" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
<option value="">Pilih Kode Barang</option>
      <?php
  $dataBarang = mysql_query("SELECT * FROM tb_barang ORDER BY kode_barang ASC");
  if($dataBarang === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataBarang = mysql_fetch_array($dataBarang)){
		$kodeBarang = $hasil_dataBarang['kode_barang'];
   ?>
        <option value="<?php echo $kodeBarang ?>" <?php if (!(strcmp("$kodeBarang", ""))) {echo "SELECTED";} ?>><?php echo $kodeBarang ?></option>
        
         <?php } ?>
  </select></div>
  	<div class="w3-col l2" style="padding-right:2px; padding-left:2px;"><select name="tanggal" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
<option selected="selected">Tanggal</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select></div>
    <div class="w3-col l2" style="padding-right:2px; padding-left:2px;"><select name="bulan" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
<option selected="selected">Bulan</option>
<?php
$bulan=array("01","02","03","04","05","06","07","08","09","10","11","12");
$jlh_bln=count($bulan);
for($c=0; $c<$jlh_bln; $c+=1){
    echo"<option value=$bulan[$c]> $bulan[$c] </option>";
}
?>
</select></div>
    <div class="w3-col l2" style="padding-right:2px; padding-left:2px;"><select name="tahun" class="w3-input w3-border w3-small" style="outline:none; background-color:white;cursor:pointer; height:36px">
  <?php
$mulai= date('Y') - 10;
for($i = $mulai;$i<$mulai + 20;$i++){
    $sel = $i == date('Y') ? ' selected="selected"' : '';
    echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
}
?>
  </select></div>
    <div class="w3-col l2" style="padding-right:2px; padding-left:2px;"><select name="kode_gudang" class="w3-input w3-border w3-small" required style="cursor:pointer;height:36px;">
<option value="">Pilih Kode Gudang</option>
      <?php
  $dataGudang = mysql_query("SELECT * FROM tb_gudang ORDER BY kode_gudang ASC");
  if($dataGudang === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataGudang = mysql_fetch_array($dataGudang)){
		$kodeGudang = $hasil_dataGudang['kode_gudang'];
		$namaGudang = $hasil_dataGudang['nama_gudang'];
   ?>
        <option value="<?php echo $kodeGudang ?>" <?php if (!(strcmp("$kodeGudang", ""))) {echo "SELECTED";} ?>><?php echo $kodeGudang." | ".$namaGudang ?></option>
        
         <?php } ?>
      </select></div>
    <div class="w3-col l2" style="padding-left:2px;"><input type="number" min="1" class="w3-input w3-border w3-small" required placeholder="Jumlah" name="jumlah" value="" /></div>
  </div>
  
      
      


<hr>
  <div class="w3-center">
  <a onClick="window.history.back()" style="cursor:pointer" class="w3-btn w3-small w3-red"><i class="fa fa-times-rectangle fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Generate</button>
  </div>
    </form>
<br />
<?php if ($totalRows_rsTampilAktivasi > 0) { // Show if recordset not empty ?>
  <table border="1" style="display:none">
    <tr>
      <td>id</td>
      <td>kode_aktivasi</td>
      <td>Opsi</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $nomor++; ?></td>
        <td><?php echo $row_rsTampilAktivasi['kode_aktivasi']; ?></td>
        <td><a onclick="return confirm('Anda Yakin Ingin Menghapus?\nKode Aktivasi : <?php echo $row_rsTampilAktivasi['kode_aktivasi']; ?>')" href="aktivasi_delete.php?id=<?php echo $row_rsTampilAktivasi['id']; ?>">Hapus</a></td>
      </tr>
      <?php } while ($row_rsTampilAktivasi = mysql_fetch_assoc($rsTampilAktivasi)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsTampilAktivasi);
?>
<?php if ($totalRows_rsTampilAktivasi == 0) { // Show if recordset empty ?>
  <table width="100%" border="1" style="display:none">
    <tr>
      <td>Masih Kosong</td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>

		<!-- InstanceEndEditable -->
        
        
        
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>