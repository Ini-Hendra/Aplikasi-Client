<?php
    // koneksi ke engine host mysql
    // valuenya adalah host, user, dan password
    $Open = mysql_connect("localhost","root","");
        if (!$Open){
            die ("Koneksi ke Engine MySQL Gagal !<br /><br />");
        }
    
    // koneksi ke database mysql
    // valuenya adalah database name
    $Koneksi = mysql_select_db("db_ahmad");
        if (!$Koneksi){
            die ("Koneksi ke Database Gagal !");
        }
?>