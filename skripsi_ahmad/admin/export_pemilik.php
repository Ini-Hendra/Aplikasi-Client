<?php
if(isset($_POST["export"]))  { 
$connect = mysqli_connect("localhost", "root", "", "db_ahmad"); 
header('Content-Type: text/csv; charset=utf-8'); 
      header('Content-Disposition: attachment; filename=Data Pemilik.csv'); 
      $output = fopen("php://output", "w"); 
      fputcsv($output, array('ID Pemilik','Nama', 'No. Telp', 'Email', 'Kode Aktivasi', 'Tanggal Aktivasi')); 
      $query = "SELECT * FROM tb_pemilik ORDER BY nama ASC"; 
      $result = mysqli_query($connect, $query); 
while($row = mysqli_fetch_assoc($result)) 
      { 
           fputcsv($output, $row); 
      } 
      fclose($output); 
 } 
 ?> 