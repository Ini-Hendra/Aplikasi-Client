<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<?php
require_once("../Connections/koneksi.php");
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

<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/template-admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<title>AHMAD</title>
<!-- InstanceEndEditable -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/w3.css">
<link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../assets/w3.js"></script>
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
    	<div class="w3-col s12"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp; ADMINISTRATOR</div>
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
            	<li class="w3-hover-light-grey"><a href="barang_read.php" style="text-decoration:none"><i class="fa fa-database fa-fw"></i> Data Produk</a></li>
                <li class="w3-hover-light-grey"><a href="gudang_read.php" style="text-decoration:none"><i class="fa fa-home fa-fw"></i> Data Gudang</a></li>
                <li class="w3-hover-light-grey"><a href="aktivasi_read.php" style="text-decoration:none"><i class="fa fa-key fa-fw"></i> Data Kode Aktivasi</a></li>
            	<li class="w3-hover-light-grey"><a href="pemilik_read.php" style="text-decoration:none"><i class="fa fa-user-circle"></i> Data Pemilik</a></li>
                <li class="w3-hover-light-grey"><a href="admin_read.php" style="text-decoration:none"><i class="fa fa-user-secret fa-fw"></i> Data Admin</a></li>
               
                <li class="w3-hover-light-grey"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
            </ul>
        </div>
        <div class="w3-col l9 w3-padding"><!-- InstanceBeginEditable name="EditRegion1" -->
        <script src="../assets/Chart.bundle.min.js"></script>
        <?php
		error_reporting(0);
	   $dataTerdaftar = mysql_num_rows(mysql_query("SELECT * FROM tb_pemilik"));
	   $dataAwal = mysql_num_rows(mysql_query("SELECT * FROM tb_aktivasi"));
	   $dataBelumTerdaftar = $dataAwal-$dataTerdaftar;
	   $dataBarang = mysql_num_rows(mysql_query("SELECT * FROM tb_barang"));
	   $dataGudang = mysql_num_rows(mysql_query("SELECT * FROM tb_gudang"));
	   $dataKodeAktivasi = mysql_num_rows(mysql_query("SELECT * FROM tb_aktivasi"));
	   $dataPemilik = mysql_num_rows(mysql_query("SELECT * FROM tb_pemilik"));
	   $dataAdmin = mysql_num_rows(mysql_query("SELECT * FROM tb_admin"));
	   
	   
	    ?>
        <div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Dashboard</div>
        <div class="w3-row" style="margin-top:8px;">
        	<div class="w3-col l4" style="padding-right:3px;">
            	<ul class="w3-ul w3-border">
                	<li class="w3-pale-yellow"><strong>Keseluruhan Data</strong></li>
                	<li>Data Produk<span class="w3-right w3-tag"><?php echo $dataBarang ?></span></li>
                    <li>Data Gudang<span class="w3-right w3-tag"><?php echo $dataGudang ?></span></li>
                    
                    <li>Data Kode Aktivasi<span class="w3-right w3-tag"><?php echo $dataKodeAktivasi ?></span></li>
                    <li>Data Pemilik<span class="w3-right w3-tag"><?php echo $dataPemilik ?></span></li>
                    <li>Data Admin<span class="w3-right w3-tag"><?php echo $dataAdmin ?></span></li>
                    
                </ul>
                
            	
            	
            </div>
         
            <div class="w3-col l8" style="padding-left:3px;">
            	<div class="w3-border w3-padding">
                <center><strong>JUMLAH STATISTIK</strong><br>
KODE AKTIVASI
</center>
        <div class="container">
            <canvas id="myChart"></canvas>
        </div>
                </div>
            </div>
        </div>
        
        
        <br>
       
<script>
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
					
                    labels: ["Terdaftar","Belum Terdaftar"],
                    datasets: [{
                            label: 'Jumlah Data ',
                            data: ["<?php echo $dataTerdaftar ?>","<?php echo $dataBelumTerdaftar ?>"],
                            backgroundColor: [
                              
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 102, 102, 1)',
                                'rgba(61, 238, 96, 1)'
                            ],
                            borderColor: [
                                'rgba(32, 37, 42, 1)',
								'rgba(32, 37, 42, 1)',
								'rgba(32, 37, 42, 1)',
								'rgba(32, 37, 42, 1)',
								'rgba(32, 37, 42, 1)',
								
                            ],
                            borderWidth: 0
                        }]
                },
                options: {
                    scales: {
                        yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                    }
                }
            });
        </script>
		<!-- InstanceEndEditable -->
        
        
        
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>