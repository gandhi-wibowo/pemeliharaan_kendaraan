<?php
session_start();

include "../modules/config.php";
include "../modules/connect.php";
include "../modules/library.php";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    $token = $_POST['token'];
    $query = "SELECT * FROM user WHERE username='$username' AND password='$password' AND tipe_user!='admin'";
    $exe = query($query);
    $data = mysqli_fetch_assoc($exe);

    if($data['password'] == $password){
    #update last login info
    $sql = "UPDATE user SET terakhir_login='".date('Y-m-d H:i:s')."' WHERE id_user='{$data['id_user']}'";
    $query = query($sql);

    $idUser = $data['id_user'];
    $Query = "UPDATE  `db_opr`.`user` SET  `token` = '$token' WHERE  `user`.`id_user` ='$idUser';";
    $Exe = query($Query);

    echo json_encode(array(
        "status"=>"sukses",
        "id_user"=>$data['id_user'],
        "username"=>$data['username'],
        "namalengkap"=>$data['namalengkap'],
        "tipe_user"=>$data['tipe_user'],
        "password"=>$data['password'],
        "session" => session_id()
    ));
  }
  else{
    echo json_encode(array("status"=>"gagal"));
  }
}

if(isset($_POST['cekLogin'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $query = "SELECT * FROM user WHERE username='$username' AND password='$password' AND tipe_user!='admin'";
  $exe = query($query);
  if(mysqli_num_rows($exe) > 0){
    $data = mysqli_fetch_assoc($exe);
    echo json_encode(array(
      "status"=>"sukses",
      "id_user"=>$data['id_user'],
      "username"=>$data['username'],
      "tipe_user"=>$data['tipe_user'],
      "password"=>$data['password']
    ));
  }
  else{
    echo json_encode(array("status"=>"gagal"));
  }
}
if(isset($_POST['cekJaringan'])){
  echo json_encode(array("status"=>"online"));
}

 ?>
