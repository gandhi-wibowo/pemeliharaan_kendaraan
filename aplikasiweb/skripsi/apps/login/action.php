<?php
session_start();
include "../../modules/config.php";
include "../../modules/connect.php";
include "../../modules/library.php";

if(empty($_POST['username']) or empty($_POST['password'])){
	alert('username dan password harus diisi!');
} else {
	#sql query
	$sql = "SELECT * FROM user WHERE username='{$_POST['username']}' AND tipe_user='admin'";
	$query = query($sql);
	$data = mysqli_fetch_array($query);

	#if user exists
	if($data['password'] == sha1($_POST['password'])){
		#update last login info
		$sql = "UPDATE user SET terakhir_login='".date('Y-m-d H:i:s')."' WHERE id_user='{$data['id_user']}'";
		$query = query($sql);

		#set session
		$_SESSION['id_user'] = $data['id_user'];
		$_SESSION['tipe_user'] = $data['tipe_user'];

		#redirect user to dashboard
		header('location:'.APPURL);
		exit;
	} else {
		alert('username atau password yang anda masukkan salah');
	}
}