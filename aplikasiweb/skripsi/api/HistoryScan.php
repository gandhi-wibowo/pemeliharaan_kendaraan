<?php
include "../modules/config.php";
include "../modules/connect.php";
include "../modules/library.php";

if(isset($_POST['idUser'])){
  $idUser = $_POST['idUser'];
  $query = "SELECT k.no_polisi, b.tgl_cari
            FROM barcode AS b, kendaraan AS k
            WHERE b.id_user =  '$idUser'
            AND b.id_kendaraan = k.id_kendaraan
            ORDER BY b.id_barcode DESC";
  $exe = query($query);
  $datas = array();
  if(mysqli_num_rows($exe) > 0){
    while($data = mysqli_fetch_assoc($exe)){
        $datas[] = $data;
    }
    echo json_encode($datas);
  }
}
?>
