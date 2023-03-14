<?php require_once('Connections/koneksi.php'); ?>
<?php
session_start();
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

$maxRows_rsCek = 10;
$pageNum_rsCek = 0;
if (isset($_GET['pageNum_rsCek'])) {
  $pageNum_rsCek = $_GET['pageNum_rsCek'];
}
$startRow_rsCek = $pageNum_rsCek * $maxRows_rsCek;

$colname_rsCek = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsCek = $_SESSION['MM_Username'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsCek = sprintf("SELECT * FROM tb_login WHERE username = %s", GetSQLValueString($colname_rsCek, "text"));
$query_limit_rsCek = sprintf("%s LIMIT %d, %d", $query_rsCek, $startRow_rsCek, $maxRows_rsCek);
$rsCek = mysql_query($query_limit_rsCek, $koneksi) or die(mysql_error());
$row_rsCek = mysql_fetch_assoc($rsCek);

if (isset($_GET['totalRows_rsCek'])) {
  $totalRows_rsCek = $_GET['totalRows_rsCek'];
} else {
  $all_rsCek = mysql_query($query_rsCek);
  $totalRows_rsCek = mysql_num_rows($all_rsCek);
}
$totalPages_rsCek = ceil($totalRows_rsCek/$maxRows_rsCek)-1;
?>
<center>Mengalihkan..</center>
<table border="1" style="display:none">
  <tr>
    <td>id_login</td>
    <td>username</td>
    <td>password</td>
    <td>level</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsCek['id_login']; ?></td>
      <td><?php echo $row_rsCek['username']; ?></td>
      <td><?php echo $row_rsCek['password']; ?></td>
      <td><?php echo $aksesnya = $row_rsCek['level']; ?></td>
    </tr>
    <?php } while ($row_rsCek = mysql_fetch_assoc($rsCek)); ?>
</table>
<?php if($aksesnya == "Admin"){
	header('location:admin/home.php');
	} elseif($aksesnya == "Manager"){
		header('location:home.php');
		} elseif($aksesnya == "Marketing"){
		header('location:marketing/home.php');
		} elseif($aksesnya == "") {
		header('location:index.php');
		}?>
<?php
mysql_free_result($rsCek);
?>
