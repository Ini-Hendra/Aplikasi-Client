<?php require_once('Connections/koneksi.php'); ?>
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

$MM_restrictGoTo = "index.php";
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
<table border="1" style="display:none">
  <tr>
    <td>id_login</td>
    <td>nik</td>
    <td>nama_lengkap</td>
    <td>username</td>
    <td>password</td>
    <td>level</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsCek['id_login']; ?></td>
      <td><?php echo $row_rsCek['nik']; ?></td>
      <td><?php echo $row_rsCek['nama_lengkap']; ?></td>
      <td><?php echo $row_rsCek['username']; ?></td>
      <td><?php echo $row_rsCek['password']; ?></td>
      <td><?php $lepel = $row_rsCek['level']; echo $lepel ?></td>
    </tr>
    <?php } while ($row_rsCek = mysql_fetch_assoc($rsCek)); ?>
</table>
<?php
if($lepel == "Manager"){
	header('location: manager/home.php');
	} elseif($lepel == "Admin"){
	header('location: admin/home.php');
	} else {
		header('location: supervisor/home.php');
		}
?>
<?php
mysql_free_result($rsCek);
?>
