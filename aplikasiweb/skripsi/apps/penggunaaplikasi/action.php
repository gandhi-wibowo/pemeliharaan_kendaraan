<?php
session_start();
include "../../modules/config.php";
include "../../modules/connect.php";
include "../../modules/library.php";
include "../components/auth.php";

if(isset($_POST['insert'])){
	$username=strtoupper($_POST['username']); 
	$namalengkap=strtoupper($_POST['namalengkap']); 
	$tipe_user=strtoupper($_POST['tipe_user']); 
	$no_telp=strtoupper($_POST['no_telp']); 
	$password=($_POST['password']); 

	if($username == NULL){ alert('Form  Nama Pengguna Harus di isi.'); }
	elseif($namalengkap==NULL){ alert('Form  Nama Lengkap Harus di isi.'); }
	elseif($tipe_user==NULL){ alert('Form  Tipe Pengguna Harus di isi.'); }
	elseif($no_telp == NULL){ alert('Form  Nomor Telepon Harus di isi.'); }

	$sql = "INSERT INTO `user` (`id_user`,`username`,`namalengkap`,`tipe_user`,`no_telp`,`password`)
			VALUES (NULL,'$username','$namalengkap','$tipe_user','$no_telp','$password')";
	$query = query($sql);

} else if(isset($_POST['update'])){
	$id_user = $_POST['id_user'];
    $username=($_POST['username']); 
	$namalengkap=($_POST['namalengkap']); 
	$tipe_user=($_POST['tipe_user']); 
	$no_telp=($_POST['no_telp']); 
		
	$sql = "UPDATE `user` SET `username`='$username',`namalengkap`='$namalengkap', `tipe_user` = '$tipe_user',`no_telp`='$no_telp'
	 		WHERE  `id_user`='$id_user'";
	$query = query($sql);

}else if(isset($_POST['delete'])){
	$id = $_POST['id_user'];
	$sql = "DELETE FROM `user` WHERE `id_user` = '$id'";
	$query = query($sql);
	
}if($query){
	header ("Location:".APPURL.'/'.basename(__DIR__));
}
?>