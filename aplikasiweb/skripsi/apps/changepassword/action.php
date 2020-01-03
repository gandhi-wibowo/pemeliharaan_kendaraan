<?php
session_start();
include "../../modules/config.php";
include "../../modules/connect.php";
include "../../modules/library.php";
include "../components/auth.php";

if(isset($_POST['submit'])){
    $password = sha1($_POST['password_lama']);
    $passwordbaru = sha1($_POST['password_baru']);
    $passwordbarulagi = sha1($_POST['password_barulagi']);
    
	if(empty($_POST['password_lama']) or empty($_POST['password_baru']) or empty($_POST['password_barulagi'])){
		alert('Anda harus mengisi semua kolom yang diperlukan');
	} else {
		$query = "SELECT * FROM user WHERE id_user='{$_SESSION['id_user']}' AND password='$password'";
		$result=  query($query);
		if(mysqli_num_rows($result)>0){
			if($passwordbaru == $passwordbarulagi){
			$query2 = "UPDATE `user` SET `password` = '$passwordbarulagi' WHERE `id_user` = '{$_SESSION['id_user']}';";
			
			if(query($query2)){
				alert('Password berhasil diganti!');
			}
				
			} else {
				alert('Konfirmasi password tidak tepat!');
			}
		} else {
			alert('password lama salah');
		}
	}
}
?>