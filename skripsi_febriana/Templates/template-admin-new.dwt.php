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
<body class="w3-light-grey">


<div class="w3-bar w3-top w3-blue w3-large w3-padding-16" style="z-index:4">
  <span class="w3-left w3-hide-small w3-medium">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ADMINISTRATOR</span><button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey w3-medium" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right w3-hide-large w3-medium">ADMINISTRATOR</span>
</div>


<nav class="w3-sidebar w3-collapse w3-white" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row w3-hide-small">
    <div class="w3-col s12 w3-center" style="margin-top:5px;">
      
      <div style="margin-top:8px;">SISTEM PAKAR PENYAKIT</div>
      <div class="w3-small"><strong>CORONA VIRUS DESEASE</strong></div>
      <div class="w3-small"><strong>(COVID-19)</strong></div>
    </div>
    
  </div>


  
  <div class="w3-bar-block" style="margin-top:8px;">
    <ul class="w3-ul">
            	<li class="w3-hover-light-grey"><a href="home.php" style="text-decoration:none"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
            	<li class="w3-hover-light-grey"><a href="gejala_read.php" style="text-decoration:none"><i class="fa fa-heartbeat fa-fw"></i> Data Gejala</a></li>
                <li class="w3-hover-light-grey"><a href="penyakit_read.php" style="text-decoration:none"><i class="fa fa-bug fa-fw"></i> Data Penyakit</a></li>
                <li class="w3-hover-light-grey"><a href="pengetahuan_read.php" style="text-decoration:none"><i class="fa fa-star fa-fw"></i> Data Pengetahuan</a></li>
                <li class="w3-hover-light-grey"><a href="tentang_read.php" style="text-decoration:none"><i class="fa fa-check-circle-o fa-fw"></i> Tentang Penyakit</a></li>
                <li class="w3-hover-light-grey"><a href="diagnosa_read.php" style="text-decoration:none"><i class="fa fa-file-archive-o fa-fw"></i> Data Diagnosa</a></li>
            	<li class="w3-hover-light-grey"><a href="admin_read.php" style="text-decoration:none"><i class="fa fa-user-circle fa-fw"></i> Data Admin</a></li>
                <li class="w3-hover-light-grey"><a href="user_read.php" style="text-decoration:none"><i class="fa fa-user-circle fa-fw"></i> Data User</a></li>
                <li class="w3-hover-light-grey"><a href="artikel_read.php" style="text-decoration:none"><i class="fa fa-newspaper-o fa-fw"></i> Data Artikel</a></li>
                <li class="w3-hover-light-grey"><a href="info_read.php" style="text-decoration:none"><i class="fa fa-line-chart fa-fw"></i> Informasi Covid-19</a></li>
                <li class="w3-hover-light-grey"><a href="rs_read.php" style="text-decoration:none"><i class="fa fa-hospital-o fa-fw"></i> RS Rujukan</a></li>
                <li class="w3-hover-light-grey"><a href="<?php echo $logoutAction ?>" onClick="return confirm('Anda Yakin Ingin Keluar?')" style="text-decoration:none"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>
            </ul><br><br>
  </div>
</nav>



<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>


<div class="w3-main w3-padding" style="margin-left:300px;margin-top:43px;"><!-- TemplateBeginEditable name="EditRegion1" -->EditRegion1<!-- TemplateEndEditable -->

 
  
</div>

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
