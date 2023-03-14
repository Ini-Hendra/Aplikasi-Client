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
  $insertSQL = sprintf("INSERT INTO tb_customer (id_customer, nama_customer, no_po, tgl_po) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_customer'], "text"),
                       GetSQLValueString($_POST['nama_customer'], "text"),
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['tgl_po'], "date"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "customer_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_rsCustomerCreate = "-1";
if (isset($_GET['id_customer'])) {
  $colname_rsCustomerCreate = $_GET['id_customer'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsCustomerCreate = sprintf("SELECT * FROM tb_customer WHERE id_customer = %s", GetSQLValueString($colname_rsCustomerCreate, "text"));
$rsCustomerCreate = mysql_query($query_rsCustomerCreate, $koneksi) or die(mysql_error());
$row_rsCustomerCreate = mysql_fetch_assoc($rsCustomerCreate);
$totalRows_rsCustomerCreate = mysql_num_rows($rsCustomerCreate);
$idCustomer = "1234567898987654321";
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

<div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-plus"></i> TAMBAH DATA CUSTOMER</strong></div>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" style="margin-top:8px;">
<div>
<label>Nama Customer</label>
<input type="text" name="nama_customer" class="w3-input w3-border w3-small" value="" size="32" required />
</div>
<div style="margin-top:8px;">
<label>No. PO</label>
<input type="text" name="no_po" class="w3-input w3-border w3-small" value="" size="32" required />
</div>
<div style="margin-top:8px;">
<label>Tanggal PO</label>
<input type="date" class="w3-input w3-border w3-small" style="cursor:pointer" name="tgl_po" value="<?php date_default_timezone_set('Asia/Jakarta'); echo date('Y-m-d'); ?>" size="32" required />
</div>
  <table align="center" style="display:none">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_customer:</td>
      <td><input type="text" name="id_customer" value="<?php echo "CUS".substr(str_shuffle($idCustomer),0,7); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama_customer:</td>
      <td></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">No_po:</td>
      <td></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tgl_po:</td>
      <td></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td></td>
    </tr>
  </table>
  <hr>
  <div class="w3-center">
  <a href="customer_read.php" class="w3-btn w3-small w3-red"><i class="fa fa-chevron-left fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Simpan</button>
  </div>
  <input type="hidden" name="MM_insert" value="form1" />
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
mysql_free_result($rsCustomerCreate);
?>
</body>
</html>