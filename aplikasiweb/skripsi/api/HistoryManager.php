<?php
include "../modules/config.php";
include "../modules/connect.php";
include "../modules/library.php";

if(isset($_POST['pending'])){
  $query = "SELECT k.no_polisi,f.id_fpk,f.tgl_persetujuan,f.status_fpk, f.tgl_pengajuan,f.peruntukan,f.keterangan
  FROM form_pengajuan_kerja  AS f, kendaraan AS k
  WHERE f.status_fpk='pending'
  AND f.id_kendaraan = k.id_kendaraan
  ";
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
if(isset($_POST['tidakPending'])){
  $query = "SELECT k.no_polisi,f.id_fpk,f.tgl_persetujuan,f.status_fpk, f.tgl_pengajuan,f.peruntukan,f.keterangan
  FROM form_pengajuan_kerja  AS f, kendaraan AS k
  WHERE f.status_fpk!='pending'
  AND f.id_kendaraan = k.id_kendaraan";
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
