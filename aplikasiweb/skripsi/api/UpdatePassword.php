<?php
include "../modules/config.php";
include "../modules/connect.php";
include "../modules/library.php";
if(isset($_POST['idUser'])){
  $idUser = $_POST['idUser'];
  $pwdBaru = sha1($_POST['pwdBaru']);
  $pwdLama = sha1($_POST['pwdLama']);
  $query = "SELECT * FROM user WHERE id_user='$idUser' AND password='$pwdLama'";
  $exe = query($query);
  if(mysqli_num_rows($exe) > 0){
    $Query = "UPDATE  `db_opr`.`user` SET  `password` =  '$pwdBaru' WHERE  `user`.`id_user` ='$idUser';";
    $Exe = query($Query);
    if($Exe){
      echo json_encode(array("status"=>"sukses"));
    }else{
      echo json_encode(array("status"=>"gagal"));
    }
  }
  else{
    echo json_encode(array("status"=>"gagal"));
  }

}
?>
