<!-- --------------------------------//
Programmer  : Muhamad Hendra, S.Kom
Phone / WA  : 0838 1212 1231
------------------------------------->
<!DOCTYPE html>
<html>
<!-- TemplateBeginEditable name="doctitle" -->
<title>ADMINISTRATOR</title>
<!-- TemplateEndEditable -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../assets/w3.css">
<link rel="stylesheet" href="../assets/plugins/font-awesome/css/font-awesome.min.css">
<script src="../assets/w3.js"></script>
<style>
img[alt*="www.000webhost.com"]{
display:none
}
</style>
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<body>
<div class="w3-hide-large">
<div class="w3-container w3-top w3-text-white" style="background-color:#118eea;">
	<div class="w3-row w3-padding-16">
    	<div class="w3-col s12"><span onclick="w3_open();" style="cursor:pointer"><i class="fa fa-bars"></i></span>&nbsp;&nbsp; ADMINISTRATOR</div>
    </div>
    </div>



<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:250px;margin-top:54px;" id="mySidebar">
  
 
  <div class="w3-bar-block">
    <ul class="w3-ul">
            	<li class="w3-hover-light-grey"><a href="home.php" style="text-decoration:none"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
            	<li class="w3-hover-light-grey"><a href="gejala_read.php" style="text-decoration:none"><i class="fa fa-heartbeat fa-fw"></i> Data Gejala</a></li>
                <li class="w3-hover-light-grey"><a href="penyakit_read.php" style="text-decoration:none"><i class="fa fa-bug fa-fw"></i> Data Penyakit</a></li>
                <li class="w3-hover-light-grey"><a href="pengetahuan_read.php" style="text-decoration:none"><i class="fa fa-star fa-fw"></i> Data Pengetahuan</a></li>
                
                <li class="w3-hover-light-grey"><a href="diagnosa_read.php" style="text-decoration:none"><i class="fa fa-file-archive-o fa-fw"></i> Data Diagnosa</a></li>
            	<li class="w3-hover-light-grey"><a href="admin_read.php" style="text-decoration:none"><i class="fa fa-user-circle fa-fw"></i> Data Admin</a></li>
                <li class="w3-hover-light-grey"><a href="user_read.php" style="text-decoration:none"><i class="fa fa-user-circle-o fa-fw"></i> Data User</a></li>
                <li class="w3-hover-light-grey"><a href="artikel_read.php" style="text-decoration:none"><i class="fa fa-newspaper-o fa-fw"></i> Data Artikel</a></li>
                <li class="w3-hover-light-grey"><a href="rs_read.php" style="text-decoration:none"><i class="fa fa-hospital-o fa-fw"></i> RS Rujukan</a></li>
                <li class="w3-hover-light-grey"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
            </ul><br><br>
  </div>
</nav>
</div>



<div class="w3-container w3-top w3-text-white w3-hide-small" style="background-color:#118eea;">
	<div class="w3-row w3-padding-16">
    	<div class="w3-col s12"><i class="fa fa-user-circle-o"></i>&nbsp;&nbsp; ADMINISTRATOR</div>
    </div>
    </div>
    <br>
<br>
<br>
<div class="w3-container">
	<div class="w3-row">
    	<div class="w3-col l3 w3-padding w3-hide-small">
        	<ul class="w3-border w3-ul">
            	<li class="w3-hover-light-grey"><a href="home.php" style="text-decoration:none"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
            	<li class="w3-hover-light-grey"><a href="gejala_read.php" style="text-decoration:none"><i class="fa fa-heartbeat fa-fw"></i> Data Gejala</a></li>
                <li class="w3-hover-light-grey"><a href="penyakit_read.php" style="text-decoration:none"><i class="fa fa-bug fa-fw"></i> Data Penyakit</a></li>
                <li class="w3-hover-light-grey"><a href="pengetahuan_read.php" style="text-decoration:none"><i class="fa fa-star fa-fw"></i> Data Pengetahuan</a></li>
               
                <li class="w3-hover-light-grey"><a href="diagnosa_read.php" style="text-decoration:none"><i class="fa fa-file-archive-o fa-fw"></i> Data Diagnosa</a></li>
            	<li class="w3-hover-light-grey"><a href="admin_read.php" style="text-decoration:none"><i class="fa fa-user-circle fa-fw"></i> Data Admin</a></li>
                <li class="w3-hover-light-grey"><a href="user_read.php" style="text-decoration:none"><i class="fa fa-user-circle-o fa-fw"></i> Data User</a></li>
                <li class="w3-hover-light-grey"><a href="artikel_read.php" style="text-decoration:none"><i class="fa fa-newspaper-o fa-fw"></i> Data Artikel</a></li>
                <li class="w3-hover-light-grey"><a href="rs_read.php" style="text-decoration:none"><i class="fa fa-hospital-o fa-fw"></i> RS Rujukan</a></li>
                <li class="w3-hover-light-grey"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
            </ul>
            <div class="w3-tiny" style="margin-top:15px;text-align:center">
            	Copyright &copy; 2021 Ika Roswati<br>
                <strong>Sistem Pakar Diagnosa Dini Penyakit<br>
Corona Virus Desease (COVID-19)</strong><br>
All Right Reserved
            </div>
        </div>
        <div class="w3-col l9 w3-padding"><!-- TemplateBeginEditable name="EditRegion1" -->EditRegion1<!-- TemplateEndEditable -->
        
        
        </div>
    </div>
</div>


<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>



<script>
var mySidebar = document.getElementById("mySidebar");
var overlayBg = document.getElementById("myOverlay");
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
</script>

</body>
</html>
