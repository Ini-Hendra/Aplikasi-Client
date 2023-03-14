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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
	
	$path = $_FILES['gambar']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);

$path2 = $_FILES['gambar2']['name'];
$ext2 = pathinfo($path2, PATHINFO_EXTENSION);

$path3 = $_FILES['gambar3']['name'];
$ext3 = pathinfo($path3, PATHINFO_EXTENSION);

$path4 = $_FILES['gambar4']['name'];
$ext4 = pathinfo($path4, PATHINFO_EXTENSION);

$path5 = $_FILES['gambar5']['name'];
$ext5 = pathinfo($path5, PATHINFO_EXTENSION);

$path6 = $_FILES['gambar6']['name'];
$ext6 = pathinfo($path6, PATHINFO_EXTENSION);

$path7 = $_FILES['gambar7']['name'];
$ext7 = pathinfo($path7, PATHINFO_EXTENSION);

$path8 = $_FILES['gambar8']['name'];
$ext8 = pathinfo($path8, PATHINFO_EXTENSION);

$path9 = $_FILES['gambar9']['name'];
$ext9 = pathinfo($path9, PATHINFO_EXTENSION);

$path10 = $_FILES['gambar10']['name'];
$ext10 = pathinfo($path10, PATHINFO_EXTENSION);	
	
	//GetSQLValueString("File2 - ".$_POST['id_file'].'.'.$ext2, "text"),
	//GetSQLValueString("File3 - ".$_POST['id_file'].'.'.$ext3, "text"),
	//GetSQLValueString("File4 - ".$_POST['id_file'].'.'.$ext4, "text"),
	//GetSQLValueString("File5 - ".$_POST['id_file'].'.'.$ext5, "text"),
	
	
$namanya = $_FILES['gambar']['name'];
$namanya2 = $_FILES['gambar2']['name'];
$namanya3 = $_FILES['gambar3']['name'];
$namanya4 = $_FILES['gambar4']['name'];
$namanya5 = $_FILES['gambar5']['name'];
$namanya6 = $_FILES['gambar6']['name'];
$namanya7 = $_FILES['gambar7']['name'];
$namanya8 = $_FILES['gambar8']['name'];
$namanya9 = $_FILES['gambar9']['name'];
$namanya10 = $_FILES['gambar10']['name'];
	
	
	if($_FILES['gambar']['name'] <> ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, `file`=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['id_file'].$namanya, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar']['tmp_name'],'file/'.$_POST['id_file'].$namanya);
		} elseif($_FILES['gambar']['name'] == "" && $_FILES['gambar2']['name'] <> ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, file2=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['id_file'].$namanya2, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar2']['tmp_name'],'file2/'.$_POST['id_file'].$namanya2);
		} elseif($_FILES['gambar']['name'] == "" && $_FILES['gambar2']['name'] == "" && $_FILES['gambar3']['name'] <> ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, file3=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['id_file'].$namanya3, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar3']['tmp_name'],'file3/'.$_POST['id_file'].$namanya3);
		} elseif($_FILES['gambar']['name'] == "" && $_FILES['gambar2']['name'] == "" && $_FILES['gambar3']['name'] == "" && $_FILES['gambar4']['name'] <> ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, file4=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['id_file'].$namanya4, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar4']['tmp_name'],'file4/'.$_POST['id_file'].$namanya4);
		} elseif($_FILES['gambar']['name'] == "" && $_FILES['gambar2']['name'] == "" && $_FILES['gambar3']['name'] == "" && $_FILES['gambar4']['name'] == "" && $_FILES['gambar5']['name'] <> ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, file5=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['id_file'].$namanya5, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar5']['tmp_name'],'file5/'.$_POST['id_file'].$namanya5);
		} elseif($_FILES['gambar']['name'] == "" && $_FILES['gambar2']['name'] == "" && $_FILES['gambar3']['name'] == "" && $_FILES['gambar4']['name'] == "" && $_FILES['gambar5']['name'] == "" && $_FILES['gambar6']['name'] <> ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, file6=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['id_file'].$namanya6, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar6']['tmp_name'],'file6/'.$_POST['id_file'].$namanya6);
		} elseif($_FILES['gambar']['name'] == "" && $_FILES['gambar2']['name'] == "" && $_FILES['gambar3']['name'] == "" && $_FILES['gambar4']['name'] == "" && $_FILES['gambar5']['name'] == "" && $_FILES['gambar6']['name'] == "" && $_FILES['gambar7']['name'] <> ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, file7=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['id_file'].$namanya7, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar7']['tmp_name'],'file7/'.$_POST['id_file'].$namanya7);
		} elseif($_FILES['gambar']['name'] == "" && $_FILES['gambar2']['name'] == "" && $_FILES['gambar3']['name'] == "" && $_FILES['gambar4']['name'] == "" && $_FILES['gambar5']['name'] == "" && $_FILES['gambar6']['name'] == "" && $_FILES['gambar7']['name'] == "" && $_FILES['gambar8']['name'] <> ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, file8=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['id_file'].$namanya8, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar8']['tmp_name'],'file8/'.$_POST['id_file'].$namanya8);
		} elseif($_FILES['gambar']['name'] == "" && $_FILES['gambar2']['name'] == "" && $_FILES['gambar3']['name'] == "" && $_FILES['gambar4']['name'] == "" && $_FILES['gambar5']['name'] == "" && $_FILES['gambar6']['name'] == "" && $_FILES['gambar7']['name'] == "" && $_FILES['gambar8']['name'] == "" && $_FILES['gambar9']['name'] <> ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, file9=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['id_file'].$namanya9, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar9']['tmp_name'],'file9/'.$_POST['id_file'].$namanya9);
		} elseif($_FILES['gambar']['name'] == "" && $_FILES['gambar2']['name'] == "" && $_FILES['gambar3']['name'] == "" && $_FILES['gambar4']['name'] == "" && $_FILES['gambar5']['name'] == "" && $_FILES['gambar6']['name'] == "" && $_FILES['gambar7']['name'] == "" && $_FILES['gambar8']['name'] == "" && $_FILES['gambar9']['name'] == "" && $_FILES['gambar10']['name'] <> ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, file10=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['id_file'].$namanya10, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar10']['tmp_name'],'file10/'.$_POST['id_file'].$namanya10);
		} elseif($_FILES['gambar']['name'] == "" && $_FILES['gambar2']['name'] == "" && $_FILES['gambar3']['name'] == "" && $_FILES['gambar4']['name'] == "" && $_FILES['gambar5']['name'] == "" && $_FILES['gambar6']['name'] == "" && $_FILES['gambar7']['name'] == "" && $_FILES['gambar8']['name'] == "" && $_FILES['gambar9']['name'] == "" && $_FILES['gambar10']['name'] == ""){
		$updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
		} else {



  $updateSQL = sprintf("UPDATE tb_file SET nama_customer=%s, no_po=%s, tgl_po=%s, nama_file=%s, `file`=%s, file2=%s, file3=%s, file4=%s, file5=%s, file6=%s, file7=%s, file8=%s, file9=%s, file10=%s, spesifikasi=%s, kategori=%s, tgl_upload=%s WHERE id_file=%s",
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"),
                       GetSQLValueString($_POST['nama_file'], "text"),
                       GetSQLValueString($_POST['id_file'].$namanya, "text"),
					   GetSQLValueString($_POST['id_file'].$namanya2, "text"),
					   GetSQLValueString($_POST['id_file'].$namanya3, "text"),
					   GetSQLValueString($_POST['id_file'].$namanya4, "text"),
					   GetSQLValueString($_POST['id_file'].$namanya5, "text"),
					   GetSQLValueString($_POST['id_file'].$namanya6, "text"),
					   GetSQLValueString($_POST['id_file'].$namanya7, "text"),
					   GetSQLValueString($_POST['id_file'].$namanya8, "text"),
					   GetSQLValueString($_POST['id_file'].$namanya9, "text"),
					   GetSQLValueString($_POST['id_file'].$namanya10, "text"),
					   GetSQLValueString($_POST['spesifikasi'], "text"),
					   GetSQLValueString($_POST['kategori'], "text"),
                       GetSQLValueString($_POST['tgl_upload'], "text"),
                       GetSQLValueString($_POST['id_file'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());
copy($_FILES['gambar']['tmp_name'],'file/'.$_POST['id_file'].$namanya);
copy($_FILES['gambar2']['tmp_name'],'file2/'.$_POST['id_file'].$namanya2);
copy($_FILES['gambar3']['tmp_name'],'file3/'.$_POST['id_file'].$namanya3);
copy($_FILES['gambar4']['tmp_name'],'file4/'.$_POST['id_file'].$namanya4);
copy($_FILES['gambar5']['tmp_name'],'file5/'.$_POST['id_file'].$namanya5);
copy($_FILES['gambar6']['tmp_name'],'file6/'.$_POST['id_file'].$namanya6);
copy($_FILES['gambar7']['tmp_name'],'file7/'.$_POST['id_file'].$namanya7);
copy($_FILES['gambar8']['tmp_name'],'file8/'.$_POST['id_file'].$namanya8);
copy($_FILES['gambar9']['tmp_name'],'file9/'.$_POST['id_file'].$namanya9);
copy($_FILES['gambar10']['tmp_name'],'file10/'.$_POST['id_file'].$namanya10);
		}
  $updateGoTo = "file_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsFileUpdate = "-1";
if (isset($_GET['id_file'])) {
  $colname_rsFileUpdate = $_GET['id_file'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsFileUpdate = sprintf("SELECT * FROM tb_file WHERE id_file = %s", GetSQLValueString($colname_rsFileUpdate, "text"));
$rsFileUpdate = mysql_query($query_rsFileUpdate, $koneksi) or die(mysql_error());
$row_rsFileUpdate = mysql_fetch_assoc($rsFileUpdate);
$totalRows_rsFileUpdate = mysql_num_rows($rsFileUpdate);
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

<div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-edit"></i> UBAH DATA ARSIP</strong></div>


<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1" style="margin-top:8px;">
<div>
<label>Nama Customer</label>
<input class="w3-input w3-border w3-small" type="text" name="nama_customer" value="<?php echo htmlentities($row_rsFileUpdate['nama_customer'], ENT_COMPAT, ''); ?>" size="32" required />
</div>
<div style="margin-top:8px;">
<label>No. PO</label>
<input type="text" class="w3-input w3-border w3-small" name="no_po" value="<?php echo htmlentities($row_rsFileUpdate['no_po'], ENT_COMPAT, ''); ?>" size="32" required />
</div>
<div style="margin-top:8px;">
<label>Tanggal PO</label>
<input type="date" class="w3-input w3-border w3-small" name="tgl_po" value="<?php echo htmlentities($row_rsFileUpdate['tgl_po'], ENT_COMPAT, ''); ?>" size="32" required />
</div>
<div style="margin-top:8px;">
<label>Nama File</label>
<input class="w3-input w3-border w3-small" type="text" name="nama_file" value="<?php echo htmlentities($row_rsFileUpdate['nama_file'], ENT_COMPAT, ''); ?>" size="32" required />
</div>
<div style="margin-top:8px;">
<label>Spesifikasi</label>
<textarea cols="3" rows="5" name="spesifikasi" class="w3-input w3-border w3-small"><?php echo htmlentities($row_rsFileUpdate['spesifikasi'], ENT_COMPAT, ''); ?></textarea>
</div>


<div style="margin-top:8px;">
<label>Kategori Arsip</label>
<select name="kategori" class="w3-input w3-border w3-small" style="cursor:pointer">
        <option value="Jasa Fabrikasi" <?php if (!(strcmp("Jasa Fabrikasi", htmlentities($row_rsFileUpdate['kategori'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Jasa Fabrikasi</option>
        <option value="Jasa Balancing" <?php if (!(strcmp("Jasa Balancing", htmlentities($row_rsFileUpdate['kategori'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Jasa Balancing</option>
        <option value="Spartpart" <?php if (!(strcmp("Spartpart", htmlentities($row_rsFileUpdate['kategori'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Spartpart</option>
      </select>
</div>

<?php
$apalah = $row_rsFileUpdate['id_file'];
$filekedua = htmlentities($row_rsFileUpdate['file2'], ENT_COMPAT, '');
$fileketiga = htmlentities($row_rsFileUpdate['file3'], ENT_COMPAT, '');
$filekeempat = htmlentities($row_rsFileUpdate['file4'], ENT_COMPAT, '');
$filekelima = htmlentities($row_rsFileUpdate['file5'], ENT_COMPAT, '');
$filekeenam = htmlentities($row_rsFileUpdate['file6'], ENT_COMPAT, '');
$fileketujuh = htmlentities($row_rsFileUpdate['file7'], ENT_COMPAT, '');
$filekedelapan = htmlentities($row_rsFileUpdate['file8'], ENT_COMPAT, '');
$filekesembilan = htmlentities($row_rsFileUpdate['file9'], ENT_COMPAT, '');
$filekesepuluh = htmlentities($row_rsFileUpdate['file10'], ENT_COMPAT, '');
 ?>

<div style="margin-top:8px;">
<label>File 1 = <a style="text-decoration:none" class="w3-text-blue" target="_blank" href="file/<?php echo $row_rsFileUpdate['file']; ?>"><?php echo $row_rsFileUpdate['file']; ?></a></label>

<?php if($apalah == $filekedua){
	
	} else {
		?>
        <br>
<label>File 2 = <a style="text-decoration:none" class="w3-text-blue" target="_blank" href="file2/<?php echo $row_rsFileUpdate['file2']; ?>"><?php echo $row_rsFileUpdate['file2']; ?></a></label>
<?php
		} ?>

<?php if($apalah == $fileketiga){
	
	} else {
		?>
        <br>
<label>File 3 = <a style="text-decoration:none" class="w3-text-blue" target="_blank" href="file3/<?php echo $row_rsFileUpdate['file3']; ?>"><?php echo $row_rsFileUpdate['file3']; ?></a></label>
<?php
		} ?>
        
        <?php if($apalah == $filekeempat){
	
	} else {
		?>
        <br>
<label>File 4 = <a style="text-decoration:none" class="w3-text-blue" target="_blank" href="file4/<?php echo $row_rsFileUpdate['file4']; ?>"><?php echo $row_rsFileUpdate['file4']; ?></a></label>
<?php
		} ?>
        
        <?php if($apalah == $filekelima){
	
	} else {
		?>
        <br>
<label>File 5 = <a style="text-decoration:none" class="w3-text-blue" target="_blank" href="file5/<?php echo $row_rsFileUpdate['file5']; ?>"><?php echo $row_rsFileUpdate['file5']; ?></a></label>
<?php
		} ?>
        
        <?php if($apalah == $filekeenam){
	
	} else {
		?>
        <br>
<label>File 6 = <a style="text-decoration:none" class="w3-text-blue" target="_blank" href="file6/<?php echo $row_rsFileUpdate['file6']; ?>"><?php echo $row_rsFileUpdate['file6']; ?></a></label>
<?php
		} ?>
        <?php if($apalah == $fileketujuh){
	
	} else {
		?>
        <br>
<label>File 7 = <a style="text-decoration:none" class="w3-text-blue" target="_blank" href="file7/<?php echo $row_rsFileUpdate['file7']; ?>"><?php echo $row_rsFileUpdate['file7']; ?></a></label>
<?php
		} ?>
        
        <?php if($apalah == $filekedelapan){
	
	} else {
		?>
        <br>
<label>File 8 = <a style="text-decoration:none" class="w3-text-blue" target="_blank" href="file8/<?php echo $row_rsFileUpdate['file8']; ?>"><?php echo $row_rsFileUpdate['file8']; ?></a></label>
<?php
		} ?>
        
        <?php if($apalah == $filekesembilan){
	
	} else {
		?>
        <br>
<label>File 9 = <a style="text-decoration:none" class="w3-text-blue" target="_blank" href="file9/<?php echo $row_rsFileUpdate['file9']; ?>"><?php echo $row_rsFileUpdate['file9']; ?></a></label>
<?php
		} ?>
        
        <?php if($apalah == $filekesepuluh){
	
	} else {
		?>
        <br>
<label>File 10 = <a style="text-decoration:none" class="w3-text-blue" target="_blank" href="file10/<?php echo $row_rsFileUpdate['file10']; ?>"><?php echo $row_rsFileUpdate['file10']; ?></a></label>
<?php
		} ?>
</div>
<hr>
<div style="margin-top:8px;">
      <label>Ubah File 1</label><br>
      <input type="file" name="gambar" id="gambar" />
      </div>
      <div style="margin-top:8px;" id="tag2">
      <label>Ubah File 2</label><br>
      <input type="file" name="gambar2" id="gambar2" />
      </div>
      <div style="margin-top:8px;" id="tag3">
      <label>Ubah File 3</label><br>
      <input type="file" name="gambar3" id="gambar3" />
      </div>
      <div style="margin-top:8px;" id="tag4">
      <label>Ubah File 4</label><br>
      <input type="file" name="gambar4" id="gambar4" />
      </div>
      <div style="margin-top:8px;" id="tag5">
      <label>Ubah File 5</label><br>
      <input type="file" name="gambar5" id="gambar5" />
      </div>
      
     <div style="margin-top:8px;" id="tag5">
      <label>Ubah File 6</label><br>
      <input type="file" name="gambar6" id="gambar6" />
      </div>
      <div style="margin-top:8px;" id="tag5">
      <label>Ubah File 7</label><br>
      <input type="file" name="gambar7" id="gambar7" />
      </div>
      <div style="margin-top:8px;" id="tag5">
      <label>Ubah File 8</label><br>
      <input type="file" name="gambar8" id="gambar8" />
      </div>
      <div style="margin-top:8px;" id="tag5">
      <label>Ubah File 9</label><br>
      <input type="file" name="gambar9" id="gambar9" />
      </div>
      <div style="margin-top:8px;" id="tag5">
      <label>Ubah File 10</label><br>
      <input type="file" name="gambar10" id="gambar10" />
      </div>
      
      
      
      
      
  <table align="center" style="display:none">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_file:</td>
      <td><?php echo $row_rsFileUpdate['id_file']; ?></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">File:</td>
      <td></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tgl_upload:</td>
      <td><input type="text" name="tgl_upload" value="<?php echo htmlentities($row_rsFileUpdate['tgl_upload'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td></td>
    </tr>
  </table>
  <hr>
  <div class="w3-center">
  <a onClick="window.history.back()" style="cursor:pointer" class="w3-btn w3-small w3-red"><i class="fa fa-chevron-left fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Simpan</button>
  </div>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_file" value="<?php echo $row_rsFileUpdate['id_file']; ?>" />
</form><br>
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
<br>
<?php
mysql_free_result($rsFileUpdate);
?>
</body>
</html>