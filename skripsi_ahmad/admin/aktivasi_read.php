 <!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
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

mysql_select_db($database_koneksi, $koneksi);
$query_rsAktivasiRead = "SELECT * FROM tb_aktivasi ORDER BY id DESC";
$rsAktivasiRead = mysql_query($query_rsAktivasiRead, $koneksi) or die(mysql_error());
$row_rsAktivasiRead = mysql_fetch_assoc($rsAktivasiRead);
$totalRows_rsAktivasiRead = mysql_num_rows($rsAktivasiRead);
$nomor = 1;
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
        <div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Data Kode Aktivasi</div>
<?php if ($totalRows_rsAktivasiRead > 0) { // Show if recordset not empty ?>
  <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><div class="w3-dropdown-hover w3-block" style="margin-top:8px;height:36px">
    <button class="w3-button w3-green w3-block w3-small" style="height:36px"><i class="fa fa-chevron-down fa-fw"></i> Opsi</button>
    <div class="w3-dropdown-content w3-bar-block w3-border w3-small">
      <a href="aktivasi_create.php" class="w3-bar-item w3-button"><i class="fa fa-plus fa-fw"></i> Tambah Manual</a>
      <a href="aktivasi_generate.php" class="w3-bar-item w3-button"><i class="fa fa-fort-awesome fa-fw"></i> Generate Kode Aktivasi</a>
      <a onclick="document.getElementById('uploadAktivasi').style.display='block'" class="w3-bar-item w3-button"><i class="fa fa-upload fa-fw"></i> Import CSV</a>
      
      <a onClick="document.getElementById('btnExport').click()" class="w3-bar-item w3-button"><i class="fa fa-download fa-fw"></i> Export CSV</a>
    </div>
  </div></div>
  <form method="post" action="export_aktivasi.php" align="center" style="display:none"> 
<button id="btnExport" style="margin-top:8px; height:36px;" class="w3-bar-item w3-button" type="submit" name="export"><i class="fa fa-download fa-fw"></i> Export CSV</button>
                     

                </form>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#kodeAktiv', '.kodeAktiv', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Kode Aktivasi<span class="w3-right"><?php echo $totalRows_rsAktivasiRead ?></span>
        </div></div>
</div>

        
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="kodeAktiv" style="margin-top:8px;">
      <tr style="font-weight:bold" class="w3-hover-none">
      <td class="w3-border-right w3-center">No</td>
      <td class="w3-border-right w3-center">Kode Aktivasi</td>
      <td class="w3-border-right w3-center">Status</td>
      <td class="w3-border-right w3-center">Pemilik</td>
      <td class="w3-center">Opsi</td>
    </tr>
    <?php do { ?>
	<?php $kodeNya = $row_rsAktivasiRead['kode_aktivasi']; ?>
    
    <?php $adaGa = mysql_num_rows(mysql_query("SELECT * FROM tb_pemilik WHERE kode_aktivasi='$kodeNya'")); ?>
    
      <tr class="kodeAktiv">
        <td class="w3-border-right w3-center"><?php echo $nomor++; ?></td>
        <td class="w3-border-right w3-center"><?php echo $kodeNya; ?></td>
        <td class="w3-border-right w3-center"><?php if($adaGa == "0"){
			echo "Belum Aktif";
			} else {
				echo "Aktif";
				} ?></td>
				<?php $pmk = $row_rsAktivasiRead['pemilik']; ?>
        <td class="w3-border-right w3-center w3-text-green" <?php if($pmk == "-"){
			
			} else {
				?>
                onclick="document.getElementById('<?php echo $row_rsAktivasiRead['id']; ?>').style.display='block'" style="cursor:pointer"
                <?php
				} ?>><?php echo $row_rsAktivasiRead['pemilik']; ?></td>
        <td class="w3-center"><a class="w3-tag w3-small w3-green" style="text-decoration:none" href="aktivasi_update.php?id=<?php echo $row_rsAktivasiRead['id']; ?>">Ubah</a> <a class="w3-tag w3-small w3-red" style="text-decoration:none" onClick="return confirm('Anda Yakin Ingin Menghapus?\nKode Aktivasi : <?php echo $row_rsAktivasiRead['kode_aktivasi']; ?>')" href="aktivasi_delete.php?id=<?php echo $row_rsAktivasiRead['id']; ?>">Hapus</a></td>
        
      </tr>
      <div id="<?php echo $row_rsAktivasiRead['id']; ?>" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('<?php echo $row_rsAktivasiRead['id']; ?>').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <p><i class="fa fa-search fa-fw"></i> Detail Pemilik</p>
      <p>
      <?php
  $dataSektor = mysql_query("SELECT * FROM tb_pemilik WHERE kode_aktivasi='$kodeNya'");
  if($dataSektor === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataSektor = mysql_fetch_array($dataSektor)){
		$nama = $hasil_dataSektor['nama'];
		$notelp = $hasil_dataSektor['no_telp'];
		$email = $hasil_dataSektor['email'];
		$tanggalAktivasi = $hasil_dataSektor['tanggal_aktivasi'];
	}
   ?>
	  <ul class="w3-ul w3-small w3-border">
  <li>Nama<span class="w3-right"><strong><?php echo $nama ?></strong></span></li>
  <li>Kode Aktivasi<span class="w3-right"><strong><?php echo $kodeNya ?></strong></span></li>
  <li>Status<span class="w3-right"><strong><?php echo $row_rsAktivasiRead['status']; ?></strong></span></li>
  <li>No. Telp<span class="w3-right"><?php echo $notelp ?></span></li>
  <li>Email<span class="w3-right"><?php echo $email ?></span></li>
  <li>Tanggal Aktivasi<span class="w3-right"><?php echo $tanggalAktivasi ?></span></li>
</ul>
<ul class="w3-ul w3-small w3-border" style="margin-top:8px">
<li>Kode Produk<span class="w3-right"><?php echo $barang = substr($kodeNya,0,3) ?></span></li>
<li>Kode Gudang<span class="w3-right"><?php echo substr($kodeNya,9,1) ?></span></li>
<?php
  $dataPro = mysql_query("SELECT * FROM tb_barang WHERE kode_barang='$barang'");
  if($dataPro === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataPro = mysql_fetch_array($dataPro)){
		$namaBarang = $hasil_dataPro['nama_barang'];
		$jenis = $hasil_dataPro['jenis'];
		$ukuran = $hasil_dataPro['ukuran'];
	}
   ?>
<li>Nama Produk<span class="w3-right"><?php echo $namaBarang ?></span></li>
<li>Jenis<span class="w3-right"><?php echo $jenis ?></span></li>
<li>Ukuran<span class="w3-right"><?php echo $ukuran ?></span></li>
</ul>
	  </p>
      
    </div>
  </div>
</div>
      <?php } while ($row_rsAktivasiRead = mysql_fetch_assoc($rsAktivasiRead)); ?>
  </table><br>

  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsAktivasiRead);
?>
<?php if ($totalRows_rsAktivasiRead == 0) { // Show if recordset empty ?>
  <div class="w3-row">
 	<div class="w3-col l3" style="padding-right:4px;"><div class="w3-dropdown-hover w3-block" style="margin-top:8px;height:36px">
    <button class="w3-button w3-green w3-block w3-small" style="height:36px"><i class="fa fa-chevron-down fa-fw"></i> Opsi</button>
    <div class="w3-dropdown-content w3-bar-block w3-border w3-small">
      <a href="aktivasi_create.php" class="w3-bar-item w3-button"><i class="fa fa-plus fa-fw"></i> Tambah Manual</a>
      <a href="aktivasi_generate.php" class="w3-bar-item w3-button"><i class="fa fa-fort-awesome fa-fw"></i> Generate Kode Aktivasi</a>
      <a onclick="document.getElementById('uploadAktivasi').style.display='block'" class="w3-bar-item w3-button"><i class="fa fa-upload fa-fw"></i> Import CSV</a>
      
    </div>
  </div></div>
	<div class="w3-col l3" style="padding-right:4px; padding-left:4px;"><input oninput="w3.filterHTML('#kodeAktiv', '.kodeAktiv', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-center w3-small" style="outline:none;margin-top:8px;" autofocus></div>
    <div class="w3-col l6" style="padding-left:4px;"><div class="w3-border w3-border-yellow w3-pale-yellow w3-padding w3-small" style="margin-top:8px;">
        Total Kode Aktivasi<span class="w3-right"><?php echo $totalRows_rsAktivasiRead ?></span>
        </div></div>
</div>
<table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Data Masih Kosong</td>
      </tr>
    </table>
  <?php } // Show if recordset empty ?>


<div id="uploadAktivasi" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('uploadAktivasi').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <p><i class="fa fa-file-excel-o fa-fw"></i> Import CSV</p>
      <div class="w3-border w3-border-red w3-pale-yellow w3-padding w3-small w3-justify" style="margin-top:8px;"><strong><i class="fa fa-warning"></i> PERHATIAN</strong><br>
<i>Pastikan Format CSV Anda Benar, Silahkan <a href="csv/Format_Aktivasi.csv" style="text-decoration:none" class="w3-text-red" title=" Format Import CSV Mahasiswa "><strong>Klik Disini</strong></a> Untuk Mengunduh Template CSV.</i></div><br>
<?php


if (isset($_POST['submit'])) {
    if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
        //readfile($_FILES['filename']['tmp_name']);
    }

    $handle = fopen($_FILES['filename']['tmp_name'], "r");
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $import="INSERT into tb_aktivasi (id,kode_aktivasi,status,pemilik) values('$data[0]','$data[1]','$data[2]','$data[3]')";
        mysql_query($import) or die(mysql_error());
    }

    fclose($handle);
	header('location:aktivasi_read.php');
    //echo "<br><strong>Import data selesai.</strong>";
   
} else { ?>

   
   <form enctype='multipart/form-data' action='' method='post'>
	<input type='file' class="w3-input" name='filename' required size='100'>
   <input type='submit' class="w3-btn w3-block w3-green" style="margin-top:8px;" name='submit' value='Import'>
   </form>

<?php }
mysql_close();
?>
      <br>
      
    </div>
  </div>
</div>

		<!-- InstanceEndEditable -->
        
        
        
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>