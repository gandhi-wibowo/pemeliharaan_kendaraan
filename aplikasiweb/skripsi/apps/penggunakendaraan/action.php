<?php
session_start();
include "../../modules/config.php";
include "../../modules/connect.php";
include "../../modules/library.php";
include "../components/auth.php";

if(isset($_POST['insert'])){
	$nama_pengguna=strtoupper($_POST['nama_pengguna']); 
	$jabatan_pengguna=strtoupper($_POST['jabatan_pengguna']); 
	$no_telp=strtoupper($_POST['no_telp']); 

	if($nama_pengguna == NULL){ alert('Form  Nama Pengguna Harus di isi.'); }
	elseif($jabatan_pengguna==NULL){ alert('Form  Jabatan Pengguna Harus di isi .'); }
	elseif($no_telp == NULL){ alert('Form  Nomor Telepon Harus di isi.'); }

	$sql = "INSERT INTO `pengguna_kendaraan` (`id_penggunakendaraan`,`nama_pengguna`,`jabatan_pengguna`,`no_telp`)
			VALUES (NULL,'$nama_pengguna','$jabatan_pengguna','$no_telp')";
	$query = query($sql);

} else if(isset($_POST['update'])){
	$id_penggunakendaraan = $_POST['id_penggunakendaraan'];
	$nama_pengguna=($_POST['nama_pengguna']); 
	$jabatan_pengguna=($_POST['jabatan_pengguna']); 
	$no_telp=($_POST['no_telp']); 
		
	$sql = "UPDATE `pengguna_kendaraan` SET `nama_pengguna` = '$nama_pengguna', `jabatan_pengguna` = '$jabatan_pengguna', `no_telp` = '$no_telp'
	 		WHERE  `id_penggunakendaraan` =  '$id_penggunakendaraan'";
	$query = query($sql);

}else if(isset($_POST['delete'])){
	$id = $_POST['id_penggunakendaraan'];
	$sql = "DELETE FROM `pengguna_kendaraan` WHERE `id_penggunakendaraan` = '$id'";
	$query = query($sql);
	
}if($query){
	header ("Location:".APPURL.'/'.basename(__DIR__));
}
?>
