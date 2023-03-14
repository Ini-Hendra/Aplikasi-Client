<?php
	include "../Connections/koneksi-lain.php";
	if (empty($_POST['kode_barang']) || empty($_POST['kode_gudang']) || empty($_POST['jumlah']) || empty($_POST['tanggal']) || empty($_POST['bulan']) || empty($_POST['tahun'])) {
        header('location: aktivasi_generate.php');
    } else {
	$kodeBarang = $_POST['kode_barang'];
	$tanggalNya = $_POST['tanggal'];
	$bulanNya = $_POST['bulan'];
	$tahunNya = substr($_POST['tahun'],2,2);
	$kodeGudang = $_POST['kode_gudang'];
	$jumlahNya = $_POST['jumlah'];
	$noSeri = mysql_num_rows(mysql_query("SELECT * FROM tb_aktivasi"));
	$jml_dipilih = $noSeri++;
        for($x=0;$x<$jumlahNya;$x++){
			$noSeri = mysql_num_rows(mysql_query("SELECT * FROM tb_aktivasi"));
			$hasilJumlah = $noSeri + 1;
			if($noSeri == 0 || $noSeri == ""){
				$noKwitansi = "00".($noSeri + 1);
				} elseif($noSeri > 0 && $noSeri <= 8){
				$jumlah = $noSeri + 1;
				$noKwitansi = "00".$jumlah;
				} elseif($noSeri >= 9 && $noSeri <= 98){
				$jumlah = $noSeri + 1;
				$noKwitansi = "0".$jumlah;
				}
            mysql_query("INSERT INTO tb_aktivasi VALUES ('', '$kodeBarang$tanggalNya$bulanNya$tahunNya$kodeGudang$noKwitansi','Belum Aktif','-')");
        }
        ?>
        <script language="JavaScript">
            alert('Kode Aktivasi Berhasil Ditambahkan');
        </script>
        
        <?php
		header('location: aktivasi_read.php');
    }    
?>