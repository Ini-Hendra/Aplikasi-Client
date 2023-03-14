<?php require_once('../../Connections/koneksi.php'); ?>
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

if ((isset($_GET['id_berita'])) && ($_GET['id_berita'] != "")) {
  $deleteSQL = sprintf("DELETE FROM tb_berita WHERE id_berita=%s",
                       GetSQLValueString($_GET['id_berita'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($deleteSQL, $koneksi) or die(mysql_error());
unlink("../foto_berita/".$_GET['id_berita'].".jpg");
  $deleteGoTo = "berita_read.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_koneksi, $koneksi);
$query_rsBeritaDelete = "SELECT * FROM tb_berita ORDER BY id_berita ASC";
$rsBeritaDelete = mysql_query($query_rsBeritaDelete, $koneksi) or die(mysql_error());
$row_rsBeritaDelete = mysql_fetch_assoc($rsBeritaDelete);
$totalRows_rsBeritaDelete = mysql_num_rows($rsBeritaDelete);
?>

<?php
mysql_free_result($rsBeritaDelete);
?>
