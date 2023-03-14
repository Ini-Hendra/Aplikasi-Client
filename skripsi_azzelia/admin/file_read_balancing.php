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

$maxRows_rsFileRead = 1000;
$pageNum_rsFileRead = 0;
if (isset($_GET['pageNum_rsFileRead'])) {
  $pageNum_rsFileRead = $_GET['pageNum_rsFileRead'];
}
$startRow_rsFileRead = $pageNum_rsFileRead * $maxRows_rsFileRead;

mysql_select_db($database_koneksi, $koneksi);
$query_rsFileRead = "SELECT * FROM tb_file WHERE kategori='Jasa Balancing' ORDER BY tgl_upload DESC";
$query_limit_rsFileRead = sprintf("%s LIMIT %d, %d", $query_rsFileRead, $startRow_rsFileRead, $maxRows_rsFileRead);
$rsFileRead = mysql_query($query_limit_rsFileRead, $koneksi) or die(mysql_error());
$row_rsFileRead = mysql_fetch_assoc($rsFileRead);

if (isset($_GET['totalRows_rsFileRead'])) {
  $totalRows_rsFileRead = $_GET['totalRows_rsFileRead'];
} else {
  $all_rsFileRead = mysql_query($query_rsFileRead);
  $totalRows_rsFileRead = mysql_num_rows($all_rsFileRead);
}
$totalPages_rsFileRead = ceil($totalRows_rsFileRead/$maxRows_rsFileRead)-1;
$nomor = 1;
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
<body class="w3-light-gray">
<br>
<div class="w3-container w3-light-gray">
	<div class="w3-row">
    	<div class="w3-col l1">&nbsp;</div>
        <div class="w3-col l10 w3-white">
        	<div class="w3-container"><br>
            	<div class="w3-row">
                	<div class="w3-col l6">
                    	<div class="w3-xlarge">ADMIN</div>
                    </div>
                    <div class="w3-col l6">
                    	
                    </div>
                </div>
                <hr>
            </div>
            
            <div class="w3-container">
            	<div class="w3-row">
                	<div class="w3-col l3">
                    	<div>
                        	<ul class="w3-ul w3-hoverable w3-border">
                             <a href="home.php" style="text-decoration:none;"><li style="border-bottom:1px solid #DDD;"><i class="fa fa-home fa-fw"></i> Beranda</li></a>
                             <a href="admin_read.php" style="text-decoration:none;"><li style="border-bottom:1px solid #DDD;"><i class="fa fa-lock fa-fw"></i> Data Admin<span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_login")); ?></span></li></a>
                             <a href="po_read.php" style="text-decoration:none;"><li style="border-bottom:1px solid #DDD;"><i class="fa fa-book fa-fw"></i> Data PO <span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_po")); ?></span></li></a>
  
  <a href="customer_read.php" style="text-decoration:none"><li style="border-bottom:1px solid #DDD;"><i class="fa fa-user fa-fw"></i> Data Customer<span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_customer")); ?></span></li></a>

  <li style="border-bottom:1px solid #DDD; width:100%" class="w3-dropdown-hover"><i class="fa fa-book fa-fw"></i> Data Arsip
  <div class="w3-dropdown-content w3-bar-block w3-border" style="margin-top:10px; width:100%">
    <a href="file_read_fabrikasi.php" class="w3-bar-item w3-button">1. Jasa Fabrikasi <span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_file WHERE kategori='Jasa Fabrikasi'")); ?></span></a>
    <a href="file_read_balancing.php" class="w3-bar-item w3-button">2. Jasa Balancing<span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_file WHERE kategori='Jasa Balancing'")); ?></span></a>
    <a href="file_read_spartpart.php" class="w3-bar-item w3-button">3. Spartpart<span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_file WHERE kategori='Spartpart'")); ?></span></a>
    <a href="file_read.php" class="w3-bar-item w3-button">4. Semua Kategori<span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_file")); ?></span></a>
  </div>
  </li>
  <a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><li><i class="fa fa-sign-out fa-fw"></i> Keluar</li></a>
</ul>
                        </div>
                    </div>
                    <div class="w3-col l9" style="padding-left:8px;">
                    	<div class="w3-border w3-padding">

<div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-book"></i> DATA ARSIP KATEGORI JASA BALANCING</strong></div>
<?php if ($totalRows_rsFileRead > 0) { // Show if recordset not empty ?>
  <input oninput="w3.filterHTML('#hendra3', '.item3', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-small" style="outline:none; margin-top:8px;" autofocus>
  <div class="w3-small w3-text-red" style="margin-top:8px;">*Klik Untuk Melihat Secara Detail</div>
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="hendra3" style="margin-top:8px;">
    <tr style="font-weight:bold">
      <td>No</td>
      <td>Nama Customer</td>
      <td>No. PO</td>
      <td>Tgl. PO</td>
      <td>Nama Arsip</td>
      
      <td>Opsi</td>
    </tr>
    <?php do { ?>
      <tr class="item3" style="cursor:pointer">
        <td onClick="document.getElementById('<?php echo $row_rsFileRead['id_file']; ?>').style.display='block'"><?php echo $nomor++; ?></td>
        <td onClick="document.getElementById('<?php echo $row_rsFileRead['id_file']; ?>').style.display='block'"><?php echo $row_rsFileRead['nama_customer']; ?></td>
        <td onClick="document.getElementById('<?php echo $row_rsFileRead['id_file']; ?>').style.display='block'"><?php echo $row_rsFileRead['no_po']; ?></td>
        <td onClick="document.getElementById('<?php echo $row_rsFileRead['id_file']; ?>').style.display='block'"><?php
        
		$year = substr($row_rsFileRead['tgl_po'],0,4);
		$mont = substr($row_rsFileRead['tgl_po'],5,2);
		$day = substr($row_rsFileRead['tgl_po'],8,2);
		echo $day."-".$mont."-".$year; ?></td>
        <td onClick="document.getElementById('<?php echo $row_rsFileRead['id_file']; ?>').style.display='block'"><?php echo $row_rsFileRead['nama_file']; ?></td>
        
        <td>
        <div class="w3-dropdown-hover">
    <span class="w3-tag w3-black w3-small"><i class="fa fa-cog fa-fw"></i> Opsi</span>
    <div class="w3-dropdown-content w3-bar-block w3-border">
      <a style="text-decoration:none" href="file_update.php?id_file=<?php echo $row_rsFileRead['id_file']; ?>" class="w3-tag w3-green w3-bar-item"><i class="fa fa-edit fa-fw"></i> Ubah</a>
      <a class="w3-tag w3-red w3-bar-item" href="file_delete.php?id_file=<?php echo $row_rsFileRead['id_file']; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus?\nNama Arsip : <?php echo $row_rsFileRead['nama_file']; ?>')" style="text-decoration:none"><i class="fa fa-trash-o fa-fw"></i> Hapus</a>
      <a style="text-decoration:none; cursor:pointer" onClick="document.getElementById('<?php echo $row_rsFileRead['id_file']; ?>').style.display='block'" class="w3-tag w3-blue w3-bar-item"><i class="fa fa-print fa-fw"></i> Cetak</a>
    </div>
  </div>
          </td>
      </tr>
      
      <div id="<?php echo $row_rsFileRead['id_file']; ?>" class="w3-modal">
  <div class="w3-modal-content" style="margin-top:-40px;">
    <div class="w3-container">
      <span onclick="document.getElementById('<?php echo $row_rsFileRead['id_file']; ?>').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <p><i class="fa fa-search fa-fw"></i> Detail Arsip</p>
      <p>
	  <ul class="w3-ul w3-small">
  <li>Nama Customer<span class="w3-right"><?php echo $row_rsFileRead['nama_customer']; ?></span></li>
  <li>No. PO<span class="w3-right"><?php echo $row_rsFileRead['no_po']; ?></span></li>
  <li>Kategori Arsip<span class="w3-right"><?php echo $row_rsFileRead['kategori']; ?></span></li>
  <li>Tanggal PO<span class="w3-right">
  
  <?php
        
		$year = substr($row_rsFileRead['tgl_po'],0,4);
		$mont = substr($row_rsFileRead['tgl_po'],5,2);
		$day = substr($row_rsFileRead['tgl_po'],8,2);
		echo $day."-".$mont."-".$year; ?>
 </span></li>
  
  
  <li>Nama Arsip<span class="w3-right"><strong><?php echo $row_rsFileRead['nama_file']; ?></strong></span></li>
  <li>Spesifikasi<span class="w3-right"><?php echo $row_rsFileRead['spesifikasi']; ?></span></li>
  <li><strong>Klik File Untuk Mencetak</strong><br>
  
  <?php
$apalah = $row_rsFileRead['id_file'];
$filekedua = $row_rsFileRead['file2'];
$fileketiga = $row_rsFileRead['file3'];
$filekeempat = $row_rsFileRead['file4'];
$filekelima = $row_rsFileRead['file5'];
$filekeenam = $row_rsFileRead['file6'];
$fileketujuh = $row_rsFileRead['file7'];
$filekedelapan = $row_rsFileRead['file8'];
$filekesembilan = $row_rsFileRead['file9'];
$filekesepuluh = $row_rsFileRead['file10'];
 ?>
  
<div>File 1<span class="w3-right"><a target="_blank" href="file/<?php echo $row_rsFileRead['file']; ?>"><?php echo $row_rsFileRead['file']; ?></a></span></div>
<div>File 2<span class="w3-right"><?php 
if($apalah == $filekedua){
	echo "-";
	} else {
		?>
        <a target="_blank" href="file2/<?php echo $row_rsFileRead['file2']; ?>"><?php echo $row_rsFileRead['file2']; ?></a>
        <?php
	}
 ?></span></div>
<div>File 3<span class="w3-right">
<?php 
if($apalah == $fileketiga){
	echo "-";
	} else {
		?>
        <a target="_blank" href="file3/<?php echo $row_rsFileRead['file3']; ?>"><?php echo $row_rsFileRead['file3']; ?></a>
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
        <a target="_blank" href="file4/<?php echo $row_rsFileRead['file4']; ?>"><?php echo $row_rsFileRead['file4']; ?></a>
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
        <a target="_blank" href="file5/<?php echo $row_rsFileRead['file5']; ?>"><?php echo $row_rsFileRead['file5']; ?></a>
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
        <a target="_blank" href="file6/<?php echo $row_rsFileRead['file6']; ?>"><?php echo $row_rsFileRead['file6']; ?></a>
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
        <a target="_blank" href="file7/<?php echo $row_rsFileRead['file7']; ?>"><?php echo $row_rsFileRead['file7']; ?></a>
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
        <a target="_blank" href="file8/<?php echo $row_rsFileRead['file8']; ?>"><?php echo $row_rsFileRead['file8']; ?></a>
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
        <a target="_blank" href="file9/<?php echo $row_rsFileRead['file9']; ?>"><?php echo $row_rsFileRead['file9']; ?></a>
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
        <a target="_blank" href="file10/<?php echo $row_rsFileRead['file10']; ?>"><?php echo $row_rsFileRead['file10']; ?></a>
        <?php
	}
 ?>
</span></div></li>
 
  <li>Tanggal Buat Arsip<span class="w3-right"><?php echo $row_rsFileRead['tgl_upload']; ?></span></li>
</ul>
	  </p>
      
    </div>
  </div>
</div>
      
      
      <?php } while ($row_rsFileRead = mysql_fetch_assoc($rsFileRead)); ?>
  </table><br>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsFileRead);
?>
<?php if ($totalRows_rsFileRead == 0) { // Show if recordset empty ?>
  <table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Data Masih Kosong</td>
    </tr>
  </table>
  <br>
  <?php } // Show if recordset empty ?></div>
                    
                    </div>
                </div>
            </div><br>

        </div>
        <div class="w3-col l1">&nbsp;</div>
    </div>
</div><br>
<br>
<div class="w3-center w3-small">Copyright @ 2020 <strong>Aplikasi Arsip</strong><br>
All Right Reserved</div>
<br>
  </body>
  </html>