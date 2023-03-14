<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<!DOCTYPE html>
<html>
<head>
<!-- TemplateBeginEditable name="doctitle" -->
<title>ADMINISTRATOR</title>
<!-- TemplateEndEditable -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/w3.css">
<link href="../assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<script src="../assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
</style>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
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
            	<li class="w3-hover-light-grey"><a href="gejala_read.php" style="text-decoration:none"><i class="fa fa-heartbeat fa-fw"></i> Data Gejala</a></li>
                <li class="w3-hover-light-grey"><a href="penyakit_read.php" style="text-decoration:none"><i class="fa fa-bug fa-fw"></i> Data Penyakit</a></li>
                <li class="w3-hover-light-grey"><a href="pengetahuan_read.php" style="text-decoration:none"><i class="fa fa-star fa-fw"></i> Data Pengetahuan</a></li>
                <li class="w3-hover-light-grey"><a href="solusi_read.php" style="text-decoration:none"><i class="fa fa-check-circle-o fa-fw"></i> Solusi Penyakit</a></li>
                <li class="w3-hover-light-grey"><a href="diagnosa_read.php" style="text-decoration:none"><i class="fa fa-file-archive-o fa-fw"></i> Data Diagnosa</a></li>
            	<li class="w3-hover-light-grey"><a href="admin_read.php" style="text-decoration:none"><i class="fa fa-user-circle fa-fw"></i> Data Admin</a></li>
                <li class="w3-hover-light-grey"><a href="artikel_read.php" style="text-decoration:none"><i class="fa fa-newspaper-o fa-fw"></i> Data Artikel</a></li>
                <li class="w3-hover-light-grey"><a href="info_read.php" style="text-decoration:none"><i class="fa fa-line-chart fa-fw"></i> Informasi Covid-19</a></li>
                <li class="w3-hover-light-grey"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
            </ul>
        </div>
        <div class="w3-col l9 w3-padding"><!-- TemplateBeginEditable name="EditRegion1" -->EditRegion1<!-- TemplateEndEditable -->
        
        
        </div>
    </div>
</div>

    
</body>
</html>