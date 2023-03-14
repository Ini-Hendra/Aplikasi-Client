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
<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<?php
date_default_timezone_set('Asia/Jakarta');
$iniHari = date('d');
$iniBulan = date('m');
$iniTahun = date('Y');
 ?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/template-rt.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>ATIKAH</title>
<!-- InstanceEndEditable -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../assets/w3.css">
<link href="../../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../../assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
</style>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>
<body>
<div class="w3-container w3-top w3-text-white" style="background-color:#118eea;">
	<div class="w3-row w3-padding-16">
    	<div class="w3-col s12"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp; RUKUN TETANGGA <?php echo $_SESSION['MM_Username'] ?></div>
    </div>
    </div>
    <br>
<br>
<br>
<div class="w3-container">
	<div class="w3-row">
    	<div class="w3-col l3 w3-padding">
        	<ul class="w3-border w3-ul">
            	<li class="w3-hover-light-grey"><a href="home.php" style="text-decoration:none"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
            	<li class="w3-hover-light-grey"><a href="warga_read.php" style="text-decoration:none"><i class="fa fa-user-circle fa-fw"></i> Data Warga</a></li>
                <li class="w3-hover-light-grey"><a href="surat_read.php" style="text-decoration:none"><i class="fa fa-file fa-fw"></i> Data Surat Pengantar</a></li>
            	<li class="w3-hover-light-grey"><a href="admin_read.php" style="text-decoration:none"><i class="fa fa-user-circle-o fa-fw"></i> Data Admin</a></li>
                <li class="w3-hover-light-grey"><a href="pengurus_read.php" style="text-decoration:none"><i class="fa fa-user-circle-o fa-fw"></i> Data Pengurus</a></li>
                <li class="w3-hover-light-grey"><a href="berita_read.php" style="text-decoration:none"><i class="fa fa-newspaper-o fa-fw"></i> Data Berita</a></li>
                <li class="w3-hover-light-grey"><a href="keluhan_read.php" style="text-decoration:none"><i class="fa fa-warning fa-fw"></i> Data Keluhan</a></li>
                <li class="w3-hover-light-grey"><a href="laporan_read.php" style="text-decoration:none"><i class="fa fa-print fa-fw"></i> Cetak Laporan</a></li>
                <li class="w3-hover-light-grey"><a href="jenis_read.php" style="text-decoration:none"><i class="fa fa-database fa-fw"></i> Data Jenis Surat</a></li>
                <li class="w3-hover-light-grey"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
            </ul>
        </div>
        <div class="w3-col l9 w3-padding"><!-- InstanceBeginEditable name="EditRegion1" -->
        
        <div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Cetak Laporan</div>

       

<div class="w3-row" style="margin-top:8px;">
	<div class="w3-col l6 w3-padding" style="padding-right:4px;">
    <div class="w3-padding w3-center w3-pale-yellow w3-small w3-border">Cetak Laporan Penduduk</div>
   <a target="_blank" href="laporan_penduduk.php" style="margin-top:8px;" class="w3-btn w3-small w3-block w3-green"><i class="fa fa-print fa-fw"></i> Cetak Laporan Data Penduduk</a>


    </div>
    <div class="w3-col l6 w3-padding w3-border-left" style="padding-left:4px;"><div class="w3-padding w3-center w3-pale-yellow w3-small w3-border">Cetak Laporan Surat Pengantar</div>
    <button style="outline:none;margin-top:8px;" onclick="myFunction('Demo22')" class="w3-btn w3-block w3-green w3-small w3-left-align">Laporan Bulanan</button>
<div id="Demo22" class="w3-container w3-hide w3-border w3-padding">
  <form name="formBulanan" method="post" target="_blank" action="laporan_surat.php">
  <div class="w3-row">
  	<div class="w3-col l3" style="padding-right:2px;">
    <label>Bulan</label>
    <select name="bulanNya" id="bulanNya" class="w3-input w3-border w3-small" style="cursor:pointer">
  	<option value="01" <?php if($iniBulan == "01"){ echo "selected"; } ?>>Januari</option>
    <option value="02" <?php if($iniBulan == "02"){ echo "selected"; } ?>>Februari</option>
    <option value="03" <?php if($iniBulan == "03"){ echo "selected"; } ?>>Maret</option>
    <option value="04" <?php if($iniBulan == "04"){ echo "selected"; } ?>>April</option>
    <option value="05" <?php if($iniBulan == "05"){ echo "selected"; } ?>>Mei</option>
    <option value="06" <?php if($iniBulan == "06"){ echo "selected"; } ?>>Juni</option>
    <option value="07" <?php if($iniBulan == "07"){ echo "selected"; } ?>>Juli</option>
    <option value="08" <?php if($iniBulan == "08"){ echo "selected"; } ?>>Agustus</option>
    <option value="09" <?php if($iniBulan == "09"){ echo "selected"; } ?>>September</option>
    <option value="10" <?php if($iniBulan == "10"){ echo "selected"; } ?>>Oktober</option>
    <option value="11" <?php if($iniBulan == "11"){ echo "selected"; } ?>>November</option>
    <option value="12" <?php if($iniBulan == "12"){ echo "selected"; } ?>>Desember</option>
  </select>
    </div>
    <div class="w3-col l3" style="padding-right:2px;padding-left:2px;">
    <label>Tahun</label>
    <input type="number" class="w3-input w3-border w3-small" required name="tahunNya" id="tahunNya" value="<?php echo $iniTahun ?>">
    </div>
    <div class="w3-col l6" style="padding-left:2px;">
    <label>&nbsp;</label>
    <button type="submit" class="w3-btn w3-block w3-small w3-green">Cetak</button>
    </div>
  </div>
</form>
</div>

<button style="outline:none;margin-top:8px;" onclick="myFunction('Demo33')" class="w3-btn w3-block w3-green w3-small w3-left-align">Laporan Tahunan</button>
<div id="Demo33" class="w3-container w3-hide w3-border w3-padding">
  <form name="formTahunan" method="post" target="_blank" action="laporan_surat_tahunan.php">
  <div class="w3-row">
  	<div class="w3-col l3" style="padding-right:2px;">
    <label>Tahun</label>
    <select name="tahunNya" class="w3-input w3-border w3-small" style="outline:none; background-color:white;cursor:pointer">
  <?php
$mulai= date('Y') - 10;
for($i = $mulai;$i<$mulai + 20;$i++){
    $sel = $i == date('Y') ? ' selected="selected"' : '';
    echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
}
?>
  </select>
    </div>
    <div class="w3-col l9" style="padding-left:2px;">
    <label>&nbsp;</label>
    <button type="submit" class="w3-btn w3-block w3-small w3-green">Cetak</button>
    </div>
  </div>
 
  </form>
</div>


<script>
function myFunction(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script></div>
</div>
		<!-- InstanceEndEditable -->
        
       
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>