<?php require_once('Connections/koneksi.php'); ?>
<?php require_once('Connections/koneksi.php'); ?>
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
	
  $logoutGoTo = "index.php";
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
  $insertSQL = sprintf("INSERT INTO tb_comment (id_comment, id_berita, username, `comment`, tanggal) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_comment'], "text"),
                       GetSQLValueString($_POST['id_berita'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['comment'], "text"),
                       GetSQLValueString($_POST['tanggal'], "date"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "#";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_rsBeritaDetail = 10;
$pageNum_rsBeritaDetail = 0;
if (isset($_GET['pageNum_rsBeritaDetail'])) {
  $pageNum_rsBeritaDetail = $_GET['pageNum_rsBeritaDetail'];
}
$startRow_rsBeritaDetail = $pageNum_rsBeritaDetail * $maxRows_rsBeritaDetail;

$colname_rsBeritaDetail = "-1";
if (isset($_GET['id_berita'])) {
  $colname_rsBeritaDetail = $_GET['id_berita'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsBeritaDetail = sprintf("SELECT * FROM tb_berita WHERE id_berita = %s", GetSQLValueString($colname_rsBeritaDetail, "text"));
$query_limit_rsBeritaDetail = sprintf("%s LIMIT %d, %d", $query_rsBeritaDetail, $startRow_rsBeritaDetail, $maxRows_rsBeritaDetail);
$rsBeritaDetail = mysql_query($query_limit_rsBeritaDetail, $koneksi) or die(mysql_error());
$row_rsBeritaDetail = mysql_fetch_assoc($rsBeritaDetail);

if (isset($_GET['totalRows_rsBeritaDetail'])) {
  $totalRows_rsBeritaDetail = $_GET['totalRows_rsBeritaDetail'];
} else {
  $all_rsBeritaDetail = mysql_query($query_rsBeritaDetail);
  $totalRows_rsBeritaDetail = mysql_num_rows($all_rsBeritaDetail);
}
$totalPages_rsBeritaDetail = ceil($totalRows_rsBeritaDetail/$maxRows_rsBeritaDetail)-1;

$maxRows_rsTampilComment = 1000;
$pageNum_rsTampilComment = 0;
if (isset($_GET['pageNum_rsTampilComment'])) {
  $pageNum_rsTampilComment = $_GET['pageNum_rsTampilComment'];
}
$startRow_rsTampilComment = $pageNum_rsTampilComment * $maxRows_rsTampilComment;

$colname_rsTampilComment = "-1";
if (isset($_GET['id_berita'])) {
  $colname_rsTampilComment = $_GET['id_berita'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_rsTampilComment = sprintf("SELECT * FROM tb_comment WHERE id_berita = %s ORDER BY tanggal DESC", GetSQLValueString($colname_rsTampilComment, "text"));
$query_limit_rsTampilComment = sprintf("%s LIMIT %d, %d", $query_rsTampilComment, $startRow_rsTampilComment, $maxRows_rsTampilComment);
$rsTampilComment = mysql_query($query_limit_rsTampilComment, $koneksi) or die(mysql_error());
$row_rsTampilComment = mysql_fetch_assoc($rsTampilComment);

if (isset($_GET['totalRows_rsTampilComment'])) {
  $totalRows_rsTampilComment = $_GET['totalRows_rsTampilComment'];
} else {
  $all_rsTampilComment = mysql_query($query_rsTampilComment);
  $totalRows_rsTampilComment = mysql_num_rows($all_rsTampilComment);
}
$totalPages_rsTampilComment = ceil($totalRows_rsTampilComment/$maxRows_rsTampilComment)-1;
date_default_timezone_set('Asia/Jakarta');
?>
<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<!DOCTYPE html>
<html>
<head>
<title>ATIKA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/w3.css">
<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
</style>
</head>
<body>
<div class="w3-container w3-top w3-text-white" style="background-color:#118eea;">
	<div class="w3-row w3-padding-16">
    	<div class="w3-col s12"><i class="fa fa-user-circle"></i>&nbsp;&nbsp; DATA BERITA</div>
    </div>
</div>
    <br>
<br>
<br>
<div class="w3-container">
	<div class="w3-row">
    <div class="w3-col s12 m3 l3" style="padding-right:8px;">
    	<div class="w3-container w3-row w3-center w3-border">
        <?php
  $dataWarga = mysql_query("SELECT * FROM tb_warga WHERE username='$_SESSION[MM_Username]'");
  if($dataWarga === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataWarga = mysql_fetch_array($dataWarga)){
		$namaLengkap = $hasil_dataWarga['nama_lengkap'];
		$kategoriRT = $hasil_dataWarga['kategori_rt'];
		$noKTP = $hasil_dataWarga['no_ktp'];
		$foto = $hasil_dataWarga['foto'];
	}
   ?>
        
        <br>
    	<img src="admin/foto_warga/<?php echo $foto ?>" style="padding:4px; border:1px solid gray" width="118" height="118" class="w3-image w3-circle">
        <div style="margin-top:12px;" class="w3-small">Warga RT <?php echo $kategoriRT ?></div>
      	<div class="w3-large"><?php echo strtoupper($namaLengkap); ?></div>
        <div class="w3-small"><?php echo $noKTP ?></div>
        
       
         <hr style="margin-top:12px;">
        <div class="w3-bar-block" style="margin-top:-8px;">
    <a href="profil_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user-circle fa-fw"></i> Kelola Profil</a>
    <a href="surat_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-file fa-fw"></i> Surat Pengantar</a>
    <a href="keluhan_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-warning fa-fw"></i> Lapor Keluhan</a>
    
    <a href="pengurus_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user-circle-o fa-fw"></i> Data Pengurus</a>
    <a href="berita_read.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-newspaper-o fa-fw"></i> Berita</a>
    <a onClick="return confirm('Anda Yakin Ingin Keluar?')" href="<?php echo $logoutAction ?>" class="w3-bar-item w3-button w3-padding"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
    <div style="padding-bottom:8px;"></div>
    
  </div>
  </div>
    </div>
    <div class="w3-col s12 m9 l9">
    <div class="w3-large w3-border-bottom" style="padding-bottom:8px;"><a href="home.php" class="w3-tag w3-green"><i class="fa fa-home"></i></a> | <?php echo $row_rsBeritaDetail['judul']; ?></div>
    <?php do { ?><?php $idberita = $row_rsBeritaDetail['id_berita']; ?>
    <div class="w3-row" style="margin-top:16px;">
    	<div class="w3-center"><img src="admin/foto_berita/<?php echo $row_rsBeritaDetail['gambar']; ?>" class="w3-image w3-border w3-padding-small">
<div class="w3-small" style="margin-top:8px;white-space:pre-wrap">Penulis : <?php echo $row_rsBeritaDetail['author']; ?> | <i class="fa fa-clock-o"></i> <?php echo $row_rsBeritaDetail['posting']; ?></div></div>
        
    </div>
    <hr>
    <div style="margin-top:8px;" class="w3-justify w3-small"><?php echo $row_rsBeritaDetail['isi']; ?></div>
    <hr>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
    <div style="margin-top:8px;">
    <label>Berikan Komentar Anda <span class="w3-right"><i class="fa fa-comments"></i> <?php echo mysql_num_rows(mysql_query("SELECT * FROM tb_comment WHERE id_berita='$idberita'")) ?></span></label>
    <textarea name="comment" class="w3-input w3-border w3-small" required placeholder="Beri Komentar" style="max-width:100%;min-width:100%;max-height:60px;min-height:60px;margin-top:8px;" cols="50" rows="5"></textarea>
    </div>
          <table align="center" style="display:none">
            <tr valign="baseline">
              <td nowrap align="right">Id_comment:</td>
              <td><input type="text" name="id_comment" value="<?php echo date('dmYHis'); ?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Id_berita:</td>
              <td><input type="text" name="id_berita" value="<?php echo $row_rsBeritaDetail['id_berita']; ?>" size="32"></td>
            </tr>
            <tr valign="baseline">
              <td nowrap align="right">Username:</td>
              <td><input type="text" name="username" value="<?php echo $_SESSION['MM_Username']; ?>" size="32"></td>
            </tr>
            
            <tr valign="baseline">
              <td nowrap align="right">Tanggal:</td>
              <td><input type="text" name="tanggal" value="" size="32"></td>
            </tr>
           
          </table>
    
  <div class="w3-center" style="margin-top:8px;">
 <button type="submit" class="w3-btn w3-small w3-green w3-block"><i class="fa fa-send fa-fw"></i> Kirim Komentar</button>
  </div>
          <input type="hidden" name="MM_insert" value="form1">
        </form>
    <?php } while ($row_rsBeritaDetail = mysql_fetch_assoc($rsBeritaDetail)); ?>


<!-- KOMENTAR -->
<?php if ($totalRows_rsTampilComment > 0) { // Show if recordset not empty ?>
<ul class="w3-ul w3-border w3-small" style="margin-top:8px;">
<?php do { ?>
<?php $userNya = $row_rsTampilComment['username']; ?>
<?php
  $dataNama = mysql_query("SELECT * FROM tb_warga WHERE username='$userNya'");
  if($dataNama === FALSE){
	  die(mysql_error());
	  }
	while($hasil_dataNama = mysql_fetch_array($dataNama)){
		$namaLengkap = $hasil_dataNama['nama_lengkap'];
		$dariRT = $hasil_dataNama['kategori_rt'];
	}
   ?>
	<li>
    <div><strong><?php echo $namaLengkap ?></strong> dari RT <?php echo $dariRT ?><span class="w3-right"><?php echo $row_rsTampilComment['tanggal']; ?></span></div>
    <div class="w3-small w3-text-grey"><i><?php echo $row_rsTampilComment['comment']; ?></i></div>
    </li>
<?php } while ($row_rsTampilComment = mysql_fetch_assoc($rsTampilComment)); ?>
</ul>
  <br>

  <?php } // Show if recordset not empty ?>
<?php if ($totalRows_rsTampilComment == 0) { // Show if recordset empty ?>
  <table class="w3-table w3-border" style="margin-top:8px;">
    <tr>
      <td class="w3-center">Belum Ada Komentar</td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?><br>

    </div>
    
    </div>
</div>

</body>
</html>

<?php
mysql_free_result($rsBeritaDetail);

mysql_free_result($rsTampilComment);
?>
