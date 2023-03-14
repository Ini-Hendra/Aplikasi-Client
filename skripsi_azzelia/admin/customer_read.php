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

$maxRows_rsCustomerRead = 1000;
$pageNum_rsCustomerRead = 0;
if (isset($_GET['pageNum_rsCustomerRead'])) {
  $pageNum_rsCustomerRead = $_GET['pageNum_rsCustomerRead'];
}
$startRow_rsCustomerRead = $pageNum_rsCustomerRead * $maxRows_rsCustomerRead;

mysql_select_db($database_koneksi, $koneksi);
$query_rsCustomerRead = "SELECT * FROM tb_customer ORDER BY nama_customer ASC";
$query_limit_rsCustomerRead = sprintf("%s LIMIT %d, %d", $query_rsCustomerRead, $startRow_rsCustomerRead, $maxRows_rsCustomerRead);
$rsCustomerRead = mysql_query($query_limit_rsCustomerRead, $koneksi) or die(mysql_error());
$row_rsCustomerRead = mysql_fetch_assoc($rsCustomerRead);

if (isset($_GET['totalRows_rsCustomerRead'])) {
  $totalRows_rsCustomerRead = $_GET['totalRows_rsCustomerRead'];
} else {
  $all_rsCustomerRead = mysql_query($query_rsCustomerRead);
  $totalRows_rsCustomerRead = mysql_num_rows($all_rsCustomerRead);
}
$totalPages_rsCustomerRead = ceil($totalRows_rsCustomerRead/$maxRows_rsCustomerRead)-1;
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

<div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-user"></i> DATA CUSTOMER</strong><span class="w3-right"><a href="customer_create.php" class="w3-tag" style="text-decoration:none"><i class="fa fa-plus fa-fw"></i> Tambah Data</a></span></div>


<?php if ($totalRows_rsCustomerRead > 0) { // Show if recordset not empty ?>
<input oninput="w3.filterHTML('#hendra2', '.item2', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-small" style="outline:none; margin-top:8px;" autofocus>
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="hendra2" style="margin-top:8px;">
    <tr style="font-weight:bold">
      <td>No</td>
      <td>Nama Customer</td>
      <td>No. PO</td>
      <td>Tanggal PO</td>
      <td>Opsi</td>
    </tr>
    <?php do { ?>
      <tr class="item2">
        <td><?php echo $nomor++; ?></td>
        <td><?php echo $row_rsCustomerRead['nama_customer']; ?></td>
        <td><?php echo $row_rsCustomerRead['no_po']; ?></td>
        <td><?php
        
		$year = substr($row_rsCustomerRead['tgl_po'],0,4);
		$mont = substr($row_rsCustomerRead['tgl_po'],5,2);
		$day = substr($row_rsCustomerRead['tgl_po'],8,2);
		
		echo $day."-".$mont."-".$year; ?></td>
        <td><a href="customer_update.php?id_customer=<?php echo $row_rsCustomerRead['id_customer']; ?>" class="w3-tag w3-small w3-green" style="text-decoration:none"><i class="fa fa-edit fa-fw"></i> Ubah</a> <a class="w3-tag w3-small w3-red" style="text-decoration:none" href="customer_delete.php?id_customer=<?php echo $row_rsCustomerRead['id_customer']; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus?\nNama Customer   : <?php echo $row_rsCustomerRead['nama_customer']; ?>\nNo. PO                  : <?php echo $row_rsCustomerRead['no_po']; ?>\nTanggal PO           : <?php echo $day."-".$mont."-".$year; ?>')"><i class="fa fa-trash-o fa-fw"></i> Hapus</a> <a class="w3-tag w3-small w3-blue" style="text-decoration:none" href="file_create.php?id_customer=<?php echo $row_rsCustomerRead['id_customer']; ?>"><i class="fa fa-book fa-fw"></i> Tambah Arsip</a></td>
      </tr>
      <?php } while ($row_rsCustomerRead = mysql_fetch_assoc($rsCustomerRead)); ?>
  </table><br>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsCustomerRead);
?>
<?php if ($totalRows_rsCustomerRead == 0) { // Show if recordset empty ?>
  <table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Data Masih Kosong</td>
    </tr>
  </table>
  <br>
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
<br></body>
</html>