<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<?php require_once("../../Connections/koneksi.php"); ?>
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
        <div class="w3-col l9 w3-padding"><!-- InstanceBeginEditable name="EditRegion1" --><script src="../../assets/Chart.bundle.min.js"></script>
        <?php
		error_reporting(0);
	   $dataWarga = mysql_num_rows(mysql_query("SELECT * FROM tb_warga WHERE kategori_rt='$_SESSION[MM_Username]'"));
	   $dataWarga01 = mysql_num_rows(mysql_query("SELECT * FROM tb_warga WHERE kategori_rt='01'"));
	   $dataWarga02 = mysql_num_rows(mysql_query("SELECT * FROM tb_warga WHERE kategori_rt='02'"));
	   $dataWarga3 = mysql_num_rows(mysql_query("SELECT * FROM tb_warga WHERE kategori_rt='03'"));
	   $dataBerita = mysql_num_rows(mysql_query("SELECT * FROM tb_berita"));
	   $dataKomentar = mysql_num_rows(mysql_query("SELECT * FROM tb_comment"));
	   $dataJenisSurat = mysql_num_rows(mysql_query("SELECT * FROM tb_jenis"));
	   $dataKeluhan = mysql_num_rows(mysql_query("SELECT * FROM tb_keluhan WHERE kategori_rt='$_SESSION[MM_Username]'"));
	   $dataPengurus = mysql_num_rows(mysql_query("SELECT * FROM tb_pengurus"));
	   $dataSurat = mysql_num_rows(mysql_query("SELECT * FROM tb_surat WHERE kategori_rt='$_SESSION[MM_Username]'"));
	   
	    ?>
        <div class="w3-large w3-border-bottom" style="padding-bottom:8px;">Dashboard</div>
        <div class="w3-row" style="margin-top:8px;">
        	<div class="w3-col l4" style="padding-right:3px;">
            	<ul class="w3-ul w3-border">
                	<li class="w3-pale-yellow"><strong>Keseluruhan Data</strong></li>
                	<li>Data Warga RT <?php echo $_SESSION['MM_Username'] ?><span class="w3-right w3-tag"><?php echo $dataWarga ?></span></li>
                    <li>Data Berita<span class="w3-right w3-tag"><?php echo $dataBerita ?></span></li>
                    
                    <li>Data Keluhan<span class="w3-right w3-tag"><?php echo $dataKeluhan ?></span></li>
                    <li>Data Surat Pengantar<span class="w3-right w3-tag"><?php echo $dataSurat ?></span></li>
                    <li>Data Pengurus<span class="w3-right w3-tag"><?php echo $dataPengurus ?></span></li>
                    
                </ul>
                <ul class="w3-ul w3-border" style="margin-top:8px;">
                	<li class="w3-pale-yellow"><strong>Data Lainnya</strong></li>
                	<li>Data Komentar<span class="w3-right w3-tag"><?php echo $dataKomentar ?></span></li>
                    <li>Data Jenis Surat<span class="w3-right w3-tag"><?php echo $dataJenisSurat ?></span></li>
                </ul>
            	
            	
            </div>
         
            <div class="w3-col l8" style="padding-left:3px;">
            	<div class="w3-border w3-padding">
                <center><strong>JUMLAH WARGA</strong><br>
RUKUN WARGA 03
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
					
                    labels: ["RT 01","RT 02","RT 03"],
                    datasets: [{
                            label: 'Jumlah Data ',
                            data: ["<?php echo $dataWarga01 ?>","<?php echo $dataWarga02 ?>","<?php echo $dataWarga3 ?>"],
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
        </script><!-- InstanceEndEditable -->
        
       
        </div>
    </div>
</div>

    
</body>
<!-- InstanceEnd --></html>