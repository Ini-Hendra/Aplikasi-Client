<?php require_once('Connections/koneksi.php'); ?>
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
  $MM_redirectLoginSuccess = "cek.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_koneksi, $koneksi);
  
  $LoginRS__query=sprintf("SELECT username, password FROM tb_login WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $koneksi) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>LOGIN</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/w3.css">
<link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="assets/w3.js"></script>
</head>
<body class="w3-light-gray">

<div class="w3-container">
	<div class="w3-row">
    	<div class="w3-col l4">&nbsp;</div>
        <div class="w3-col l4">
        <div class="w3-center w3-xxlarge" style="margin-top:25px;"><strong>ANUGERAH TEKNIK</strong></div>
        
        <div class="w3-white w3-border" style="margin-top:8px;">
        	<div class="w3-row w3-green w3-padding-large">
            <div class="w3-center">
            
           	  <div><strong>SELAMAT DATANG DI APLIKASI</strong></div>
                <div class="w3-xlarge"><strong>PENYIMPANAN ARSIP</strong></div>
                <div>PT. ANUGRAH TEKNIK</div>
            </div>
            </div>
            
            <div class="w3-row w3-padding-large w3-white">
            	<div class="w3-center">
                	<div class="w3-small">Silahkan Masukkan Username & Password</div>
                </div>
                <hr>
                <form name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
   <div>
  <input autofocus type="text" class="w3-input w3-border" placeholder="Username" required name="textfield" id="textfield">
  </div>
  <div style="margin-top:8px;">
  <input type="password" class="w3-input w3-border" placeholder="Password" required name="textfield2" id="textfield2">
  </div>
  <hr>
  <button type="submit" class="w3-btn w3-block w3-green"><i class="fa fa-sign-in fa-fw"></i> Masuk</button>
</form><br>
            </div>
        </div>
        
        </div>
        <div class="w3-col l4">&nbsp;</div>
    </div>
</div><br>
<div class="w3-center w3-tiny">Copyright @ 2020 <strong>Aplikasi Arsip</strong><br>
All Right Reserved</div>
</body>
</html>
