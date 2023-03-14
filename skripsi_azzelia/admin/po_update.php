<?php require_once('../Connections/koneksi.php'); ?>
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
  $updateSQL = sprintf("UPDATE tb_po SET no_po=%s, keterangan=%s, status=%s WHERE id_po=%s",
                       GetSQLValueString($_POST['no_po'], "text"),
                       GetSQLValueString($_POST['keterangan'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['id_po'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "po_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rsPOAdmProses = "-1";
if (isset($_GET['id_po'])) {
  $colname_rsPOAdmProses = $_GET['id_po'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsPOAdmProses = sprintf("SELECT * FROM tb_po WHERE id_po = %s", GetSQLValueString($colname_rsPOAdmProses, "text"));
$rsPOAdmProses = mysql_query($query_rsPOAdmProses, $koneksi) or die(mysql_error());
$row_rsPOAdmProses = mysql_fetch_assoc($rsPOAdmProses);
$totalRows_rsPOAdmProses = mysql_num_rows($rsPOAdmProses);
?>
<html>
<head></head>
<body onLoad="document.getElementById('form1').submit()">
<form method="post" name="form1" id="form1" action="<?php echo $editFormAction; ?>">
  <table align="center" style="display:none">
    <tr valign="baseline">
      <td nowrap align="right">Id_po:</td>
      <td><?php echo $row_rsPOAdmProses['id_po']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">No_po:</td>
      <td><input type="text" name="no_po" value="<?php echo htmlentities($row_rsPOAdmProses['no_po'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Keterangan:</td>
      <td><input type="text" name="keterangan" value="<?php echo htmlentities($row_rsPOAdmProses['keterangan'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Status:</td>
      <td><input type="text" name="status" value="Proses" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id_po" value="<?php echo $row_rsPOAdmProses['id_po']; ?>">
</form>
</body>
</html>
<?php
mysql_free_result($rsPOAdmProses);
?>
