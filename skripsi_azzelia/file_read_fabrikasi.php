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

$maxRows_rsFabrikasi = 1000;
$pageNum_rsFabrikasi = 0;
if (isset($_GET['pageNum_rsFabrikasi'])) {
  $pageNum_rsFabrikasi = $_GET['pageNum_rsFabrikasi'];
}
$startRow_rsFabrikasi = $pageNum_rsFabrikasi * $maxRows_rsFabrikasi;

mysql_select_db($database_koneksi, $koneksi);
$query_rsFabrikasi = "SELECT * FROM tb_file WHERE kategori='Jasa Fabrikasi' ORDER BY tgl_upload DESC";
$query_limit_rsFabrikasi = sprintf("%s LIMIT %d, %d", $query_rsFabrikasi, $startRow_rsFabrikasi, $maxRows_rsFabrikasi);
$rsFabrikasi = mysql_query($query_limit_rsFabrikasi, $koneksi) or die(mysql_error());
$row_rsFabrikasi = mysql_fetch_assoc($rsFabrikasi);

if (isset($_GET['totalRows_rsFabrikasi'])) {
  $totalRows_rsFabrikasi = $_GET['totalRows_rsFabrikasi'];
} else {
  $all_rsFabrikasi = mysql_query($query_rsFabrikasi);
  $totalRows_rsFabrikasi = mysql_num_rows($all_rsFabrikasi);
}
$totalPages_rsFabrikasi = ceil($totalRows_rsFabrikasi/$maxRows_rsFabrikasi)-1;
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
<body class="w3-light-gray">


<br>
<div class="w3-container w3-light-gray">
	<div class="w3-row">
    	<div class="w3-col l1">&nbsp;</div>
        <div class="w3-col l10 w3-white">
        	<div class="w3-container"><br>
            	<div class="w3-row">
                	<div class="w3-col l6">
                    	<div class="w3-xlarge">MANAGER</div>
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
  <a href="home.php" style="text-decoration:none"><li style="border-bottom:1px solid #DDD;"><i class="fa fa-home fa-fw"></i> Beranda</li></a>
  <a href="po_read.php" style="text-decoration:none"><li style="border-bottom:1px solid #DDD;"><i class="fa fa-book fa-fw"></i> Data PO <span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_po")); ?></span></li></a>
  <li style="border-bottom:1px solid #DDD; width:100%" class="w3-dropdown-hover"><i class="fa fa-book fa-fw"></i> Data Arsip
  <div class="w3-dropdown-content w3-bar-block w3-border" style="margin-top:10px; width:100%">
    <a href="file_read_fabrikasi.php" class="w3-bar-item w3-button">1. Jasa Fabrikasi <span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_file WHERE kategori='Jasa Fabrikasi'")); ?></span></a>
    <a href="file_read_balancing.php" class="w3-bar-item w3-button">2. Jasa Balancing<span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_file WHERE kategori='Jasa Balancing'")); ?></span></a>
    <a href="file_read_spartpart.php" class="w3-bar-item w3-button">3. Spartpart<span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_file WHERE kategori='Spartpart'")); ?></span></a>
    <a href="home.php" class="w3-bar-item w3-button">4. Semua Kategori<span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_file")); ?></span></a>
  </div>
  </li>
  <a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><li><i class="fa fa-sign-out fa-fw"></i> Keluar</li></a>
</ul>
                        </div>
                    </div>
                    <div class="w3-col l9" style="padding-left:8px;">
                    	<div class="w3-border w3-padding">
                        <div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-book"></i> DATA ARSIP KATEGORI JASA FABRIKASI</strong></div>
                        <?php if ($totalRows_rsFabrikasi > 0) { // Show if recordset not empty ?>
  <input oninput="w3.filterHTML('#hendra6', '.item6', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-small" style="outline:none; margin-top:8px;" autofocus>
  <div class="w3-small w3-text-red" style="margin-top:8px;">*Klik Untuk Melihat Secara Detail</div>
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="hendra6" style="margin-top:8px;">
    <tr style="font-weight:bold">
      <td>No</td>
      <td>Nama Customer</td>
      <td>No. PO</td>
      <td>Tanggal PO</td>
      <td>Nama Arsip</td>
      <td>Kategori</td>
    </tr>
    <?php do { ?>
      <tr class="item6">
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsFabrikasi['id_file']; ?>').style.display='block'"><?php echo $nomor++; ?></td>
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsFabrikasi['id_file']; ?>').style.display='block'"><?php echo $row_rsFabrikasi['nama_customer']; ?></td>
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsFabrikasi['id_file']; ?>').style.display='block'"><?php echo $row_rsFabrikasi['no_po']; ?></td>
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsFabrikasi['id_file']; ?>').style.display='block'"><?php
        
		$year = substr($row_rsFabrikasi['tgl_po'],0,4);
		$mont = substr($row_rsFabrikasi['tgl_po'],5,2);
		$day = substr($row_rsFabrikasi['tgl_po'],8,2);
		echo $day."-".$mont."-".$year; ?></td>
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsFabrikasi['id_file']; ?>').style.display='block'"><?php echo $row_rsFabrikasi['nama_file']; ?></td>
        
        <td style="cursor:pointer" onClick="document.getElementById('<?php echo $row_rsFabrikasi['id_file']; ?>').style.display='block'"><?php echo $row_rsFabrikasi['kategori']; ?></td>
      </tr>
      
      
      <div id="<?php echo $row_rsFabrikasi['id_file']; ?>" class="w3-modal">
  <div class="w3-modal-content" style="margin-top:-40px;">
    <div class="w3-container">
      <span onclick="document.getElementById('<?php echo $row_rsFabrikasi['id_file']; ?>').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <p><i class="fa fa-search fa-fw"></i> Detail Arsip</p>
      <p>
	  <ul class="w3-ul w3-small">
  <li>Nama Customer<span class="w3-right"><?php echo $row_rsFabrikasi['nama_customer']; ?></span></li>
  <li>No. PO<span class="w3-right"><?php echo $row_rsFabrikasi['no_po']; ?></span></li>
  <li>Kategori Arsip<span class="w3-right"><?php echo $row_rsFabrikasi['kategori']; ?></span></li>
  <li>Tanggal PO<span class="w3-right"><?php
        
		$year = substr($row_rsFabrikasi['tgl_po'],0,4);
		$mont = substr($row_rsFabrikasi['tgl_po'],5,2);
		$day = substr($row_rsFabrikasi['tgl_po'],8,2);
		echo $day."-".$mont."-".$year; ?></span></li>
  <li>Spesifikasi<span class="w3-right"><?php echo $row_rsFabrikasi['spesifikasi']; ?></span></li>
  <li>Nama Arsip<span class="w3-right"><strong><?php echo $row_rsFabrikasi['nama_file']; ?></strong></span></li>
  
  
  <li><strong>Klik File Untuk Mencetak</strong><br>
  
  <?php
$apalah = $row_rsFabrikasi['id_file'];
$filekedua = $row_rsFabrikasi['file2'];
$fileketiga = $row_rsFabrikasi['file3'];
$filekeempat = $row_rsFabrikasi['file4'];
$filekelima = $row_rsFabrikasi['file5'];
$filekeenam = $row_rsFabrikasi['file6'];
$fileketujuh = $row_rsFabrikasi['file7'];
$filekedelapan = $row_rsFabrikasi['file8'];
$filekesembilan = $row_rsFabrikasi['file9'];
$filekesepuluh = $row_rsFabrikasi['file10'];
 ?>
  
<div>File 1<span class="w3-right"><a target="_blank" href="admin/file/<?php echo $row_rsFabrikasi['file']; ?>"><?php echo $row_rsFabrikasi['file']; ?></a></span></div>
<div>File 2<span class="w3-right"><?php 
if($apalah == $filekedua){
	echo "-";
	} else {
		?>
        <a target="_blank" href="admin/file2/<?php echo $row_rsFabrikasi['file2']; ?>"><?php echo $row_rsFabrikasi['file2']; ?></a>
        <?php
	}
 ?></span></div>
<div>File 3<span class="w3-right">
<?php 
if($apalah == $fileketiga){
	echo "-";
	} else {
		?>
        <a target="_blank" href="admin/file3/<?php echo $row_rsFabrikasi['file3']; ?>"><?php echo $row_rsFabrikasi['file3']; ?></a>
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
        <a target="_blank" href="admin/file4/<?php echo $row_rsFabrikasi['file4']; ?>"><?php echo $row_rsFabrikasi['file4']; ?></a>
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
        <a target="_blank" href="admin/file5/<?php echo $row_rsFabrikasi['file5']; ?>"><?php echo $row_rsFabrikasi['file5']; ?></a>
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
        <a target="_blank" href="file6/<?php echo $row_rsFabrikasi['file6']; ?>"><?php echo $row_rsFabrikasi['file6']; ?></a>
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
        <a target="_blank" href="file7/<?php echo $row_rsFabrikasi['file7']; ?>"><?php echo $row_rsFabrikasi['file7']; ?></a>
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
        <a target="_blank" href="file8/<?php echo $row_rsFabrikasi['file8']; ?>"><?php echo $row_rsFabrikasi['file8']; ?></a>
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
        <a target="_blank" href="file9/<?php echo $row_rsFabrikasi['file9']; ?>"><?php echo $row_rsFabrikasi['file9']; ?></a>
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
        <a target="_blank" href="file10/<?php echo $row_rsFabrikasi['file10']; ?>"><?php echo $row_rsFabrikasi['file10']; ?></a>
        <?php
	}
 ?>
</span></div>
</li>
  
  
  
  <li>Tanggal Buat Arsip<span class="w3-right"><?php echo $row_rsFabrikasi['tgl_upload']; ?></span></li>
</ul>
	  </p>
      
    </div>
  </div>
</div>
      
      
      <?php } while ($row_rsFabrikasi = mysql_fetch_assoc($rsFabrikasi)); ?>
  </table><br>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsFabrikasi);
?>
<?php if ($totalRows_rsFabrikasi == 0) { // Show if recordset empty ?>
  <table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Data Masih Kosong</td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>
                        
                        
                        </div>
                    
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


	
</body>
</html>

