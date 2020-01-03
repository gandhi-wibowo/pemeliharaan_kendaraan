<?php
session_start();
include "../../modules/config.php";
include "../../modules/connect.php";
include "../../modules/library.php";
include "../components/auth.php";

if(isset($_POST['insert'])){
	if(empty($_POST['nama_asuransi'])){
		alert('Nama Asuransi Harus diisi');
	} else {		
		$sql = "INSERT INTO `master_asuransi` (`id_master_asuransi`,`nama_asuransi`)
			VALUES (NULL, '{$_POST['nama_asuransi']}')";
		$query = query($sql);
	}	
} else if(isset($_POST['update'])){
	if(empty($_POST['nama_asuransi'])){
		alert('Nama Asuransi Harus diisi');
	} else {
		$id = $_POST['id_master_asuransi'];

		$sql = "UPDATE `master_asuransi` SET `nama_asuransi` = '{$_POST['nama_asuransi']}' WHERE `id_master_asuransi` =  '$id'";
		$query = query($sql);
	}	
} else if(isset($_POST['delete'])){
	$id = $_POST['id_master_asuransi'];

	#cek asuransi
	$sql = "SELCT COUNT(*) as numOfUsed FROM asuransi WHERE id_master_asuransi='$id'";
	$query = query($sql);
	$data = mysqli_fetch_array($query);

	if($data['numOfUsed'] > 0){
		alert('Asuransi ini tidak dapat dihapus!');
	} else {
		$sql = "DELETE FROM `master_asuransi` WHERE `id_master_asuransi` = '$id'";
		$query = query($sql);
	}
}

if($query){
	header ("Location:".APPURL.'/'.basename(__DIR__));
}
?>
