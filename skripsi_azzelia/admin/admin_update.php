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
  $updateSQL = sprintf("UPDATE tb_login SET username=%s, password=%s, `level`=%s WHERE id_login=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString(base64_encode($_POST['password']), "text"),
                       GetSQLValueString($_POST['level'], "text"),
                       GetSQLValueString($_POST['id_login'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "admin_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsAdminUpdate = "-1";
if (isset($_GET['id_login'])) {
  $colname_rsAdminUpdate = $_GET['id_login'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsAdminUpdate = sprintf("SELECT * FROM tb_login WHERE id_login = %s", GetSQLValueString($colname_rsAdminUpdate, "text"));
$rsAdminUpdate = mysql_query($query_rsAdminUpdate, $koneksi) or die(mysql_error());
$row_rsAdminUpdate = mysql_fetch_assoc($rsAdminUpdate);
$totalRows_rsAdminUpdate = mysql_num_rows($rsAdminUpdate);
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
<script src="../SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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

<div class="w3-border-bottom" style="padding-bottom:10px; margin-top:8px;"><strong><i class="fa fa-lock"></i> UBAH PASSWORD</strong></div>



<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" style="margin-top:8px;">
<div style="display:none">
<span id="sprytextfield1">
<label>Username</label>
      <input class="w3-input w3-border w3-small" type="text" name="username" value="<?php echo htmlentities($row_rsAdminUpdate['username'], ENT_COMPAT, ''); ?>" id="text1" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMinCharsMsg">Minimum number of characters not met.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span></span>
      </div>
      
      <div style="margin-top:8px;">
      <span id="spryconfirm1">
        <label>Masukkan Password Lama</label>
        <input type="password" class="w3-input w3-border w3-small" name="password1" id="password1" required style="background-color:white" />
      <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg" style="border:0px;">Password Lama Salah</span></span>
      </div>
      <div style="margin-top:8px;">
      <label>Masukkan Password Baru</label>
      <input style="background-color:white" type="password" class="w3-input w3-border w3-small" name="password" value="" size="32" id="pwd" required />
      </div>
      <div style="margin-top:8px;">
      <span id="spryconfirm2">
      <label>Ulangi Password Baru</label>
        <input style="background-color:white" type="password" class="w3-input w3-border w3-small" name="password2" id="password2" required />
      <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg" style="border:0px;">Password Baru Tidak Sama</span></span>
      </div>
      
      <div style="margin-top:8px; display:none">
      <label>Level</label>
      <select name="level" class="w3-input w3-border w3-small" style="cursor:pointer">
        <option value="Admin" <?php if (!(strcmp("Admin", htmlentities($row_rsAdminUpdate['level'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Admin</option>
        <option value="Manager" <?php if (!(strcmp("Manager", htmlentities($row_rsAdminUpdate['level'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Manager</option>
         <option value="Marketing" <?php if (!(strcmp("Marketing", htmlentities($row_rsAdminUpdate['level'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>>Marketing</option>
      </select>
      </div>
  <table align="center" style="display:none">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_login:</td>
      <td><?php echo $row_rsAdminUpdate['id_login']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Username</td>
      <td></td>
    </tr>
    <tr valign="baseline" style="display:none">
      <td nowrap="nowrap" align="right">Password Lama</td>
      <td><input type="text" id="pwdlama" value="<?php echo htmlentities($row_rsAdminUpdate['username'], ENT_COMPAT, ''); ?>" /></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Masukkan Password Lama</td>
      <td></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Masukkan Password Baru:</td>
      <td></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Ulangi Password Baru</td>
      <td></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Level:</td>
      <td></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td></td>
    </tr>
  </table>
  <hr>
  <div class="w3-center">
  <a href="admin_read.php" class="w3-btn w3-small w3-red"><i class="fa fa-chevron-left fa-fw"></i> Batal</a> <button type="submit" class="w3-btn w3-small w3-green"><i class="fa fa-save fa-fw"></i> Simpan Perubahan</button>
  </div>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_login" value="<?php echo $row_rsAdminUpdate['id_login']; ?>" />
</form>
<br>

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
mysql_free_result($rsAdminUpdate);
?>
<script type="text/javascript">
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "pwdlama");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:6, maxChars:15});
var spryconfirm2 = new Spry.Widget.ValidationConfirm("spryconfirm2", "pwd");
</script>
</body>
</html>