<?php
include "../modules/config.php";
include "../modules/connect.php";
include "../modules/library.php";

if(isset($_POST['insert'])){
    $jk = $_POST['jk'];
    $ket = $_POST['ket'];
    $idUser = $_POST['idUser'];
    $plat = $_POST['plat'];
    $tanggal = date("Y-m-d");
    $queryIdKendaraan = "SELECT id_kendaraan
                        FROM kendaraan
                        WHERE no_polisi='$plat'";
    $exe = query($queryIdKendaraan);
    $data = mysqli_fetch_assoc($exe);
    $no_polisi = $data['id_kendaraan'];
    $queryCek = "SELECT *
                FROM `form_pengajuan_kerja`
                WHERE status_fpk = 'pending'
                AND tgl_pengajuan = '$tanggal'
                AND id_kendaraan = '$no_polisi'
                AND peruntukan = '$jk'";
    $exeS = query($queryCek);
    if(mysqli_num_rows($exeS) <= 0){
      $sql = "INSERT INTO `db_opr`.`form_pengajuan_kerja`
      (`id_fpk`, `tgl_persetujuan`, `tgl_selesai`, `status_fpk`, `status_pelaksanaan`, `tgl_pengajuan`, `id_kendaraan`, `peruntukan`, `keterangan`, `id_user`)
      VALUES (NULL, '0000-00-00', '0000-00-00', 'pending', 'active', '$tanggal', '$no_polisi', '$jk', '$ket', '$idUser')";
      $query = query($sql);
      if($query){
        $sqlS = "SELECT * FROM user WHERE tipe_user = 'manager' AND token != ''";
        $queryS = query($sqlS);
        $res = array();
        while($data = mysqli_fetch_array($queryS)){
                sendFCM($data['token'], "Pengajuan FPK", "Fpk baru telah diajukan", 'com.skripsi.marisonervan.FPK_MANAGER');
        }
        echo json_encode(array("status"=>"sukses"));
      }
      else{
        echo json_encode(array("status"=>"gagal"));
      }
    }
    else{
      echo json_encode(array("status"=>"gagal"));
    }

}
if(isset($_POST['approve'])){
  $waktu = date("Y-m-d H:i:s");
  $idFpk = $_POST['approve'];
  $query = "UPDATE  `db_opr`.`form_pengajuan_kerja` SET
  `status_fpk` =  'approve',`tgl_persetujuan`='$waktu'
  WHERE  `form_pengajuan_kerja`.`id_fpk` ='$idFpk';";
  $exe = query($query);
  if($exe){
    $sqlS = "SELECT * FROM user WHERE tipe_user = 'slapangan' AND token != ''";
    $queryS = query($sqlS);
    $res = array();
    while($data = mysqli_fetch_array($queryS)){
            sendFCM($data['token'], "FPK disetujui", "Fpk telah disetujui", 'com.skripsi.marisonervan.HISTORY_LAPANGAN');
    }
    echo json_encode(array("status"=>"sukses"));
  }
  else{
    echo json_encode(array("status"=>"gagal"));
  }
}
if(isset($_POST['reject'])){
  $idFpk = $_POST['reject'];
  $query = "UPDATE  `db_opr`.`form_pengajuan_kerja` SET  `status_fpk` =  'reject' WHERE  `form_pengajuan_kerja`.`id_fpk` ='$idFpk';";
  $exe = query($query);
  if($exe){
    $sqlS = "SELECT * FROM user WHERE tipe_user = 'slapangan' AND token != ''";
    $queryS = query($sqlS);
    $res = array();
    while($data = mysqli_fetch_array($queryS)){
            sendFCM($data['token'], "FPK ditolak", "Fpk anda tidak disetujui", 'com.skripsi.marisonervan.HISTORY_LAPANGAN');
    }
    echo json_encode(array("status"=>"sukses"));
  }
  else{
    echo json_encode(array("status"=>"gagal"));
  }
}
if(isset($_POST['selesai'])){
  $idFpk = $_POST['selesai'];
  $waktu = date("Y-m-d H:i:s");
  $query = "UPDATE  `db_opr`.`form_pengajuan_kerja`
  SET `tgl_selesai`='$waktu'
  WHERE  `form_pengajuan_kerja`.`id_fpk` ='$idFpk';";
  $exe = query($query);
  if($exe){
    echo json_encode(array("status"=>"sukses"));
  }
  else{
    echo json_encode(array("status"=>"gagal"));
  }
}
?>
