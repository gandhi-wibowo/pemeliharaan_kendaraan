<?php
include "../modules/config.php";
include "../modules/connect.php";
include "../modules/library.php";

if(isset($_POST['idUser'])){
  $idUser = $_POST['idUser'];
  $query = "SELECT
  k.no_polisi,f.id_fpk,f.tgl_persetujuan,f.status_fpk, f.tgl_pengajuan,f.peruntukan,f.keterangan
  FROM form_pengajuan_kerja  AS f, kendaraan AS k
  WHERE f.id_user='$idUser'
  AND f.id_kendaraan = k.id_kendaraan
  AND f.tgl_selesai LIKE '%0000%'";
  $exe = query($query);
  $datas = array();
  if(mysqli_num_rows($exe) > 0){
    while($data = mysqli_fetch_assoc($exe)){
        $datas[] = $data;
    }
    echo json_encode($datas);
  }
}
if(isset($_POST['idFpk'])){
  $idFpk = $_POST['idFpk'];
  $query = "SELECT k.no_polisi,f.id_fpk,f.tgl_persetujuan,f.status_fpk, f.tgl_pengajuan,f.peruntukan,f.keterangan
            FROM form_pengajuan_kerja AS f, kendaraan AS k
            WHERE f.id_fpk = '$idFpk'
            AND f.id_kendaraan = k.id_kendaraan
            ";
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
