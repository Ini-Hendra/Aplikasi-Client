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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['textfield'])) {
  $loginUsername=$_POST['textfield'];
  $password=base64_encode($_POST['textfield2']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_koneksi, $koneksi);
  
  $LoginRS__query=sprintf("SELECT username, password FROM tb_admin WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $koneksi) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<!DOCTYPE html>
<html>
<head>
<title>AHMAD</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/w3.css">
<link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
body{
	background-image:url(../assets/bg2.jpg);
	background-size:cover;
	background-repeat:no-repeat;
}
</style>
</head>
<body oncontextmenu="return false" onselectstart="return false">
<br>
<br>
<div class="w3-container">
	<div class="w3-row">
    	<div class="w3-col s12 m12 l12">
        	<div class="w3-center"><img src="../assets/logo2.png" width="316" height="116"></div>
        	<div class="w3-center w3-xlarge w3-text-black" style="margin-top:30px;"><strong>SISTEM AKTIVASI PRODUK</strong></div>
            <div class="w3-center w3-large w3-text-black"><strong>PT. DINAMIKA TIGA PILAR</strong></div>
            
<br>
<div class="w3-row">
    	<div class="w3-col s3 m4 l4 w3-center">&nbsp;</div>
        <div class="w3-col s6 m4 l4 w3-center">
        <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
        <div style="margin-top:8px;"><input type="text" name="textfield" class="w3-input w3-round-xlarge w3-center w3-small" placeholder="Username" style="outline:none; border:1px solid white; box-shadow:0 1px 6px 0 rgba(32, 33, 36, .28); background-color:white" id="textfield" autofocus></div>
        <div style="margin-top:8px;"><input type="password" name="textfield2" class="w3-input w3-round-xlarge w3-center w3-small" placeholder="Password" style="outline:none; border:1px solid white; box-shadow:0 1px 6px 0 rgba(32, 33, 36, .28); background-color:white" id="textfield2"></div>
        
        <div style="margin-top:8px;">
        	<button type="submit" style="outline:none" class="w3-btn w3-block w3-round-xlarge w3-blue w3-small"><i class="fa fa-sign-in fa-fw"></i> Masuk</button>
        </div>
        </form>
<div style="margin-top:20px;" class="w3-tiny w3-center">Copyright &copy; 2021 Ahmad<br>
    <strong>Sistem Aktivasi Produk</strong><br>
All Right Reserved</div>
<br>
<br>
<br>
<br>
<br>
<br>

        </div>
        <div class="w3-col s3 m4 l4 w3-center">&nbsp;</div>
    </div>
        </div>
    </div>
</div>
</body>
</html>
