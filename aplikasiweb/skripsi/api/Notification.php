<?php
include "../modules/config.php";
include "../modules/connect.php";
include "../modules/library.php";



if(isset($_POST['idNotification'])){
  $idNotification = $_POST['idNotification'];
  $query = "SELECT n.id_notifikasi,
  k.no_polisi,
  k.jenis,
  k.merk,
  k.posisi_stnk,
  k.posisi_bpkb,
  n.judul_notifikasi,
  n.isi_notifikasi
  FROM notifikasi AS n, kendaraan AS k
  WHERE n.id_kendaraan = k.id_kendaraan
  AND n.id_notifikasi='$idNotification'
  ORDER BY n.id_notifikasi DESC LIMIT 10";
  $exe = query($query);
  $datas = array();
  if(mysqli_num_rows($exe) == 0){
    echo json_encode(array("status"=>"gagal"));
  }
  else{
    while($data = mysqli_fetch_assoc($exe)){
        $datas[] = $data;
    }
    echo json_encode($datas);
  }
}
elseif (isset($_POST['getNotif'])){
  $query = "SELECT n.id_notifikasi,
  k.no_polisi,
  k.jenis,
  k.merk,
  k.posisi_stnk,
  k.posisi_bpkb,
  n.isi_notifikasi,
  n.judul_notifikasi
  FROM notifikasi AS n, kendaraan AS k
  WHERE n.id_kendaraan = k.id_kendaraan
  ORDER BY n.id_notifikasi DESC LIMIT 10 ";
  $exe = query($query);
  $datas = array();
  if(mysqli_num_rows($exe) == 0){
    echo json_encode(array("status"=>"gagal"));
  }
  else{
    while($data = mysqli_fetch_assoc($exe)){
        $datas[] = $data;
    }
    echo json_encode($datas);
  }

}
?>
