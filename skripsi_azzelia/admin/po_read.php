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

$maxRows_rsPOAdmRead = 1000;
$pageNum_rsPOAdmRead = 0;
if (isset($_GET['pageNum_rsPOAdmRead'])) {
  $pageNum_rsPOAdmRead = $_GET['pageNum_rsPOAdmRead'];
}
$startRow_rsPOAdmRead = $pageNum_rsPOAdmRead * $maxRows_rsPOAdmRead;

mysql_select_db($database_koneksi, $koneksi);
$query_rsPOAdmRead = "SELECT * FROM tb_po ORDER BY status ASC";
$query_limit_rsPOAdmRead = sprintf("%s LIMIT %d, %d", $query_rsPOAdmRead, $startRow_rsPOAdmRead, $maxRows_rsPOAdmRead);
$rsPOAdmRead = mysql_query($query_limit_rsPOAdmRead, $koneksi) or die(mysql_error());
$row_rsPOAdmRead = mysql_fetch_assoc($rsPOAdmRead);

if (isset($_GET['totalRows_rsPOAdmRead'])) {
  $totalRows_rsPOAdmRead = $_GET['totalRows_rsPOAdmRead'];
} else {
  $all_rsPOAdmRead = mysql_query($query_rsPOAdmRead);
  $totalRows_rsPOAdmRead = mysql_num_rows($all_rsPOAdmRead);
}
$totalPages_rsPOAdmRead = ceil($totalRows_rsPOAdmRead/$maxRows_rsPOAdmRead)-1;
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
                        <div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-book"></i> DATA PO</strong></div>
                        <?php if ($totalRows_rsPOAdmRead > 0) { // Show if recordset not empty ?>
  <input oninput="w3.filterHTML('#hendra99', '.item99', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-small" style="outline:none; margin-top:8px;" autofocus>
  <div class="w3-small w3-text-red" style="margin-top:8px;">*Klik Untuk Melihat Secara Detail</div>
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="hendra99" style="margin-top:8px;">
    <tr style="font-weight:bold">
      <td>No</td>
      <td>No. PO</td>
      <td>Perusahaan</td>
      <td class="w3-center">Keterangan</td>
      <td class="w3-center">Status</td>
      <td class="w3-center">Opsi</td>
    </tr>
    <?php do { ?>
      <tr class="item99">
        <td onclick="document.getElementById('<?php echo $row_rsPOAdmRead['id_po']; ?>').style.display='block'"><?php echo $nomor++; ?></td>
        <td onclick="document.getElementById('<?php echo $row_rsPOAdmRead['id_po']; ?>').style.display='block'"><?php echo $row_rsPOAdmRead['no_po']; ?></td>
        <td onclick="document.getElementById('<?php echo $row_rsPOAdmRead['id_po']; ?>').style.display='block'"><?php echo $row_rsPOAdmRead['nama_pt']; ?></td>
        <td class="w3-center"><a style="cursor:pointer" onclick="document.getElementById('<?php echo $row_rsPOAdmRead['id_po']; ?>').style.display='block'" class="w3-tag w3-black w3-small"><i class="fa fa-search fa-fw"></i> Lihat</a></td>
        <td onclick="document.getElementById('<?php echo $row_rsPOAdmRead['id_po']; ?>').style.display='block'" class="w3-center"><?php $tt = $row_rsPOAdmRead['status']; echo $tt; ?></td>
        <td class="w3-center">
        <?php
		if($tt == "Diterima"){
			?>
            <a onClick="return confirm('Anda Yakin Ingin Proses?\nNo. PO : <?php echo $row_rsPOAdmRead['no_po']; ?>')" class="w3-tag w3-small w3-green" style="text-decoration:none" href="po_update.php?id_po=<?php echo $row_rsPOAdmRead['id_po']; ?>">Proses</a> <a onClick="return confirm('Anda Yakin Ingin Close?\nNo. PO : <?php echo $row_rsPOAdmRead['no_po']; ?>')" class="w3-tag w3-small w3-red" style="text-decoration:none" href="po_close.php?id_po=<?php echo $row_rsPOAdmRead['id_po']; ?>">Close</a>
            <?php
			} elseif($tt == "Proses"){
				?>
                <a onClick="return confirm('Anda Yakin Ingin Close?\nNo. PO : <?php echo $row_rsPOAdmRead['no_po']; ?>')" class="w3-tag w3-small w3-red" style="text-decoration:none" href="po_close.php?id_po=<?php echo $row_rsPOAdmRead['id_po']; ?>">Close</a>
                <?php
				
				} elseif($tt == "Close"){
					?>
                    <span class="w3-text-red">Close</span>
                    <?php
					} else {
				echo "-";
				}
		?>
        </td>
      </tr>
      
      
      
      
      
      <div id="<?php echo $row_rsPOAdmRead['id_po']; ?>" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('<?php echo $row_rsPOAdmRead['id_po']; ?>').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <p><i class="fa fa-search fa-fw"></i> Detail PO</p>
      <p>
	  <ul class="w3-ul w3-small">
  <li>No. PO<span class="w3-right"><?php echo $row_rsPOAdmRead['no_po']; ?></span></li>
  <li>Perusahaan<span class="w3-right"><?php echo $row_rsPOAdmRead['nama_pt']; ?></span></li>
  <li>Status<span class="w3-right"><?php echo $row_rsPOAdmRead['status']; ?></span></li>
  <li>Keterangan PO
  <p align="justify" style="white-space:pre-wrap; height:200px; overflow:auto" class="w3-padding w3-border w3-pale-yellow"><?php echo $row_rsPOAdmRead['keterangan']; ?></p></li>
</ul>
	  </p>
      
    </div>
  </div>
</div>
      
      
      
      
      
      
      <?php } while ($row_rsPOAdmRead = mysql_fetch_assoc($rsPOAdmRead)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsPOAdmRead);
?>
<?php if ($totalRows_rsPOAdmRead == 0) { // Show if recordset empty ?>
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

