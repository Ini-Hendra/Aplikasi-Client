<?php
if(isset($_POST["export"]))  { 
$connect = mysqli_connect("localhost", "root", "", "db_ahmad"); 
header('Content-Type: text/csv; charset=utf-8'); 
      header('Content-Disposition: attachment; filename=Data Aktivasi.csv'); 
      $output = fopen("php://output", "w"); 
      fputcsv($output, array('ID','Kode Aktivasi','Status','Pemilik')); 
      $query = "SELECT * FROM tb_aktivasi ORDER BY id DESC"; 
      $result = mysqli_query($connect, $query); 
while($row = mysqli_fetch_assoc($result)) 
      { 
           fputcsv($output, $row); 
      } 
      fclose($output); 
 } 
 ?> 