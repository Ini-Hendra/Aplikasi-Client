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

$MM_restrictGoTo = "../index.php";
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

$maxRows_rsPORead = 1000;
$pageNum_rsPORead = 0;
if (isset($_GET['pageNum_rsPORead'])) {
  $pageNum_rsPORead = $_GET['pageNum_rsPORead'];
}
$startRow_rsPORead = $pageNum_rsPORead * $maxRows_rsPORead;

mysql_select_db($database_koneksi, $koneksi);
$query_rsPORead = "SELECT * FROM tb_po ORDER BY status ASC";
$query_limit_rsPORead = sprintf("%s LIMIT %d, %d", $query_rsPORead, $startRow_rsPORead, $maxRows_rsPORead);
$rsPORead = mysql_query($query_limit_rsPORead, $koneksi) or die(mysql_error());
$row_rsPORead = mysql_fetch_assoc($rsPORead);

if (isset($_GET['totalRows_rsPORead'])) {
  $totalRows_rsPORead = $_GET['totalRows_rsPORead'];
} else {
  $all_rsPORead = mysql_query($query_rsPORead);
  $totalRows_rsPORead = mysql_num_rows($all_rsPORead);
}
$totalPages_rsPORead = ceil($totalRows_rsPORead/$maxRows_rsPORead)-1;
$nomor = 1;
?>
<!DOCTYPE html>
<html>
<head>
<title>MARKETING</title>
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
                    	<div class="w3-xlarge">MARKETING</div>
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
  <a href="po_read.php" style="text-decoration:none;"><li style="border-bottom:1px solid #DDD;"><i class="fa fa-book fa-fw"></i> Data PO<span class="w3-right w3-tag"><?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_po")); ?></span></li></a>
  <a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><li><i class="fa fa-sign-out fa-fw"></i> Keluar</li></a>
</ul>


                        </div>
                    </div>
                    <div class="w3-col l9" style="padding-left:8px;">
                    	<div class="w3-border w3-padding">
                        <div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-book"></i> DATA PO</strong><span class="w3-right"><a href="po_create.php" class="w3-tag" style="text-decoration:none"><i class="fa fa-plus fa-fw"></i> Tambah Data PO</a></span></div>
                       <?php if ($totalRows_rsPORead > 0) { // Show if recordset not empty ?>
 <input oninput="w3.filterHTML('#hendra66', '.item66', this.value)" placeholder="Pencarian Data" class="w3-input w3-border w3-small" style="outline:none; margin-top:8px;" autofocus>
 <div class="w3-small w3-text-red" style="margin-top:8px;">*Klik Untuk Melihat Secara Detail</div>
  <table class="w3-table w3-striped w3-small w3-hoverable w3-bordered w3-border" id="hendra66" style="margin-top:8px;">
    <tr style="font-weight:bold">

      <td>No</td>
      <td>No. PO</td>
      <td>Perusahaan</td>
      <td class="w3-center">Keterangan</td>
      <td class="w3-center">Status</td>
      <td class="w3-center">Opsi</td>
    </tr>
    <?php do { ?>
      <tr class="item66">
        <td onclick="document.getElementById('<?php echo $row_rsPORead['id_po']; ?>').style.display='block'"><?php echo $nomor++; ?></td>
        <td onclick="document.getElementById('<?php echo $row_rsPORead['id_po']; ?>').style.display='block'"><?php echo $row_rsPORead['no_po']; ?></td>
        <td onclick="document.getElementById('<?php echo $row_rsPORead['id_po']; ?>').style.display='block'"><?php echo $row_rsPORead['nama_pt']; ?></td>
        <td class="w3-center"><a style="cursor:pointer" onclick="document.getElementById('<?php echo $row_rsPORead['id_po']; ?>').style.display='block'" class="w3-tag w3-black w3-small"><i class="fa fa-search fa-fw"></i> Lihat</a></td>
        <td onclick="document.getElementById('<?php echo $row_rsPORead['id_po']; ?>').style.display='block'" class="w3-center"><?php $ret = $row_rsPORead['status']; echo $ret; ?></td>
        <td class="w3-center">
        <?php
		if($ret == "Menunggu Approval Manager"){
			?>
            <a class="w3-tag w3-small w3-blue" style="text-decoration:none" href="po_update.php?id_po=<?php echo $row_rsPORead['id_po']; ?>">Ubah</a> <a class="w3-tag w3-small w3-red" style="text-decoration:none" href="po_delete.php?id_po=<?php echo $row_rsPORead['id_po']; ?>" onClick="return confirm('Anda Yakin Ingin Menghapus?')">Hapus</a>
            <?php
			} else {
				echo "-";
				}
		?>
        </td>
      </tr>
      
      
      
      
      
      <div id="<?php echo $row_rsPORead['id_po']; ?>" class="w3-modal">
  <div class="w3-modal-content">
    <div class="w3-container">
      <span onclick="document.getElementById('<?php echo $row_rsPORead['id_po']; ?>').style.display='none'"
      class="w3-button w3-display-topright">&times;</span>
      <p><i class="fa fa-search fa-fw"></i> Detail PO</p>
      <p>
	  <ul class="w3-ul w3-small">
  <li>No. PO<span class="w3-right"><?php echo $row_rsPORead['no_po']; ?></span></li>
  <li>Perusahaan<span class="w3-right"><?php echo $row_rsPORead['nama_pt']; ?></span></li>
  <li>Status<span class="w3-right"><?php echo $row_rsPORead['status']; ?></span></li>
  <li>Keterangan PO
  <p align="justify" style="white-space:pre-wrap; height:200px; overflow:auto" class="w3-padding w3-border w3-pale-yellow"><?php echo $row_rsPORead['keterangan']; ?></p></li>
</ul>
	  </p>
      
    </div>
  </div>
</div>
      
      
      
      
      
      
      
      <?php } while ($row_rsPORead = mysql_fetch_assoc($rsPORead)); ?>
  </table><br>
  <?php } // Show if recordset not empty ?>
<?php
mysql_free_result($rsPORead);
?>
<?php if ($totalRows_rsPORead == 0) { // Show if recordset empty ?>
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

