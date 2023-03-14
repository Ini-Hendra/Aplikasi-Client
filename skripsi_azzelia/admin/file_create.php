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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
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

  $insertSQL = sprintf("INSERT INTO tb_file (id_file, nama_customer, no_po, tgl_po, nama_file, `file`, file2, file3, file4, file5, file6, file7, file8, file9, file10, spesifikasi, kategori, tgl_upload) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_file'], "text"),
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
                       GetSQLValueString($_POST['tgl_upload'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());
  //copy($_FILES['gambar']['tmp_name'],'file/'.$_POST['id_file'].$namanya.'.'.$ext);
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
		
  $insertGoTo = "file_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rsFileCreate = 10;
$pageNum_rsFileCreate = 0;
if (isset($_GET['pageNum_rsFileCreate'])) {
  $pageNum_rsFileCreate = $_GET['pageNum_rsFileCreate'];
}
$startRow_rsFileCreate = $pageNum_rsFileCreate * $maxRows_rsFileCreate;

$colname_rsFileCreate = "-1";
if (isset($_GET['id_customer'])) {
  $colname_rsFileCreate = $_GET['id_customer'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsFileCreate = sprintf("SELECT * FROM tb_customer WHERE id_customer = %s", GetSQLValueString($colname_rsFileCreate, "text"));
$query_limit_rsFileCreate = sprintf("%s LIMIT %d, %d", $query_rsFileCreate, $startRow_rsFileCreate, $maxRows_rsFileCreate);
$rsFileCreate = mysql_query($query_limit_rsFileCreate, $koneksi) or die(mysql_error());
$row_rsFileCreate = mysql_fetch_assoc($rsFileCreate);

if (isset($_GET['totalRows_rsFileCreate'])) {
  $totalRows_rsFileCreate = $_GET['totalRows_rsFileCreate'];
} else {
  $all_rsFileCreate = mysql_query($query_rsFileCreate);
  $totalRows_rsFileCreate = mysql_num_rows($all_rsFileCreate);
}
$totalPages_rsFileCreate = ceil($totalRows_rsFileCreate/$maxRows_rsFileCreate)-1;
$idFilenya = "12345678987654321";
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

<div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-plus"></i> TAMBAH DATA ARSIP</strong></div>
<?php do { ?>
<ul class="w3-ul w3-border" style="margin-top:8px;">
  <li>Nama Customer<span class="w3-right"><strong><?php echo $row_rsFileCreate['nama_customer']; ?></strong></span></li>
  <li>No. PO<span class="w3-right"><strong><?php echo $row_rsFileCreate['no_po']; ?></strong></span></li>
  <li>Tanggal PO<span class="w3-right"><strong><?php 
  $year = substr($row_rsFileCreate['tgl_po'],0,4);
		$mont = substr($row_rsFileCreate['tgl_po'],5,2);
		$day = substr($row_rsFileCreate['tgl_po'],8,2);
		echo $day."-".$mont."-".$year;
   ?></strong></span></li>
</ul>
<hr>
<form action="<?php echo $editFormAction; ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <div>
      <label>Nama Arsip</label>
      <input type="text" name="nama_file" value="" size="32" class="w3-input w3-border w3-small" autofocus required />
      </div>
      <div style="margin-top:8px;">
      <label>Spesifikasi</label>
      <textarea name="spesifikasi"  class="w3-input w3-border w3-small" cols="3" rows="5" style="max-width:100%; overflow:hidden"></textarea>
      </div>
      
       <div style="margin-top:8px;">
      <label>Kategori Arsip</label>
      <select name="kategori" class="w3-input w3-border w3-small" style="cursor:pointer">
        <option value="Jasa Fabrikasi" <?php if (!(strcmp("Jasa Fabrikasi", ""))) {echo "SELECTED";} ?>>Jasa Fabrikasi</option>
        <option value="Jasa Balancing" <?php if (!(strcmp("Jasa Balancing", ""))) {echo "SELECTED";} ?>>Jasa Balancing</option>
         <option value="Spartpart" <?php if (!(strcmp("Spartpart", ""))) {echo "SELECTED";} ?>>Spartpart</option>
      </select>
      </div>
      
      <div style="margin-top:8px;">
      <label>Upload Arsip</label><br>
      <input type="file" name="gambar" id="gambar" required />
      </div>
      <div style="margin-top:8px; display:none" id="tag2">
      <input type="file" name="gambar2" id="gambar2" />
      </div>
      <div style="margin-top:8px; display:none" id="tag3">
      <input type="file" name="gambar3" id="gambar3" />
      </div>
      <div style="margin-top:8px; display:none" id="tag4">
      <input type="file" name="gambar4" id="gambar4" />
      </div>
      <div style="margin-top:8px; display:none" id="tag5">
      <input type="file" name="gambar5" id="gambar5" />
      </div>
      <div style="margin-top:8px; display:none" id="tag6">
      <input type="file" name="gambar6" id="gambar6" />
      </div>
      <div style="margin-top:8px; display:none" id="tag7">
      <input type="file" name="gambar7" id="gambar7" />
      </div>
      <div style="margin-top:8px; display:none" id="tag8">
      <input type="file" name="gambar8" id="gambar8" />
      </div>
      <div style="margin-top:8px; display:none" id="tag9">
      <input type="file" name="gambar9" id="gambar9" />
      </div>
      <div style="margin-top:8px; display:none" id="tag10">
      <input type="file" name="gambar10" id="gambar10" />
      </div>
      
      <div style="margin-top:8px;">
      <button type="button" id="btn1" onClick="document.getElementById('tag2').style.display='block';document.getElementById('btn1').style.display='none';document.getElementById('btn2').style.display='block'" class="w3-btn w3-small w3-black"><i class="fa fa-plus fa-fw"></i> Tambah File</button>
      
      <button type="button" id="btn2" style="display:none" onClick="document.getElementById('tag3').style.display='block';document.getElementById('btn2').style.display='none';document.getElementById('btn3').style.display='block'" class="w3-btn w3-small w3-black"><i class="fa fa-plus fa-fw"></i> Tambah File</button>
      
      <button type="button" id="btn3" style="display:none" onClick="document.getElementById('tag4').style.display='block';document.getElementById('btn3').style.display='none';document.getElementById('btn4').style.display='block'" class="w3-btn w3-small w3-black"><i class="fa fa-plus fa-fw"></i> Tambah File</button>
      
       <button type="button" id="btn4" style="display:none" onClick="document.getElementById('tag5').style.display='block';document.getElementById('btn4').style.display='none';document.getElementById('btn5').style.display='block'" class="w3-btn w3-small w3-black"><i class="fa fa-plus fa-fw"></i> Tambah File</button>
       
       <button type="button" id="btn5" style="display:none" onClick="document.getElementById('tag6').style.display='block';document.getElementById('btn5').style.display='none';document.getElementById('btn6').style.display='block'" class="w3-btn w3-small w3-black"><i class="fa fa-plus fa-fw"></i> Tambah File</button>
       
       <button type="button" id="btn6" style="display:none" onClick="document.getElementById('tag7').style.display='block';document.getElementById('btn6').style.display='none';document.getElementById('btn7').style.display='block'" class="w3-btn w3-small w3-black"><i class="fa fa-plus fa-fw"></i> Tambah File</button>
       
       <button type="button" id="btn7" style="display:none" onClick="document.getElementById('tag8').style.display='block';document.getElementById('btn7').style.display='none';document.getElementById('btn8').style.display='block'" class="w3-btn w3-small w3-black"><i class="fa fa-plus fa-fw"></i> Tambah File</button>
       
        <button type="button" id="btn8" style="display:none" onClick="document.getElementById('tag9').style.display='block';document.getElementById('btn8').style.display='none';document.getElementById('btn9').style.display='block'" class="w3-btn w3-small w3-black"><i class="fa fa-plus fa-fw"></i> Tambah File</button>
      
      <button type="button" id="btn9" style="display:none" onClick="document.getElementById('tag10').style.display='block';document.getElementById('btn9').style.display='none'" class="w3-btn w3-small w3-black"><i class="fa fa-plus fa-fw"></i> Tambah File</button>
      
      </div>
          <table align="center" style="display:none">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Id_file:</td>
              <td><input type="text" name="id_file" value="<?php echo "ARS".substr(str_shuffle($idFilenya),0,7); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Nama_customer:</td>
              <td><input type="text" name="nama_customer" value="<?php echo $row_rsFileCreate['nama_customer']; ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">No_po:</td>
              <td><input type="text" name="no_po" value="<?php echo $row_rsFileCreate['no_po']; ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Tgl_po:</td>
              <td><input type="text" name="tgl_po" value="<?php echo $row_rsFileCreate['tgl_po']; ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Nama_file:</td>
              <td></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">File:</td>
              <td></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Tgl_upload:</td>
              <td><input type="text" name="tgl_upload" value="<?php date_default_timezone_set('Asia/Jakarta'); echo date('d-m-Y H:i:s'); ?>" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td></td>
            </tr>
          </table>
          <hr>
  <div class="w3-center">
  <a style="cursor:pointer" onClick="window.history.back()" class="w3-btn w3-small w3-red"><i class="fa fa-chevron-left fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Simpan</button>
  </div>
          <input type="hidden" name="MM_insert" value="form1" />
        </form><br>
    <?php } while ($row_rsFileCreate = mysql_fetch_assoc($rsFileCreate)); ?>
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
mysql_free_result($rsFileCreate);
?>
</body>
</html>