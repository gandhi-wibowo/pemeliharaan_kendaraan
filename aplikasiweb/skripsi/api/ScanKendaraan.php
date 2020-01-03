<?php
include "../modules/config.php";
include "../modules/connect.php";
include "../modules/library.php";
if(isset($_POST['cekBm'])){
  $tglWaktu = date("Y-m-d H:i:s");
  $idUser = $_POST['idUser'];
  $noMobil = $_POST['cekBm'];
  $query = "
          SELECT
          ke.id_kendaraan,
          ke.no_polisi,
          ke.nama_stnk,
          ke.merk,
          ke.jenis,
          ke.no_rangka,
          ke.no_mesin,
          ke.posisi_stnk,
          ke.nama_bpkb,
          ke.posisi_bpkb,
          ke.status_kendaraan,
          st.berlaku_stnk,
          se.berlaku_service,
          p.berlaku_pajak
          FROM kendaraan AS ke,
          stnk AS st,
          service AS se,
          pajak AS p
          WHERE ke.no_polisi ='$noMobil'
          AND ke.id_kendaraan = se.id_kendaraan
          AND ke.id_kendaraan = st.id_kendaraan
          AND ke.id_kendaraan = p.id_kendaraan
  ";
  $exe = query($query);
  $data = mysqli_fetch_assoc($exe);
  $idKendaraan = $data['id_kendaraan'];
  if(mysqli_num_rows($exe) > 0){
    $queryHistory = "INSERT INTO `db_opr`.`barcode` (`id_barcode`, `id_kendaraan`, `tgl_cari`, `id_user`)
    VALUES (NULL, '$idKendaraan', '$tglWaktu', '$idUser');";
    $exeHistory = query($queryHistory);
    echo json_encode(array("status"=>"sukses"));
    // simpan ke history
  }
  else{
    echo json_encode(array("status"=>"gagal"));
  }
}
if(isset($_POST['detailMobil'])){
  // tampilkan detail mobil berdasarkan no polisi
  $noPol = $_POST['detailMobil'];
  $query = "SELECT
          ke.id_kendaraan,
          ke.no_polisi,
          ke.nama_stnk,
          ke.merk,
          ke.jenis,
          ke.no_rangka,
          ke.no_mesin,
          ke.posisi_stnk,
          ke.nama_bpkb,
          ke.posisi_bpkb,
          ke.status_kendaraan,
          st.berlaku_stnk,
          se.berlaku_service,
          p.berlaku_pajak,
          pk.nama_pengguna,
          pk.jabatan_pengguna,
          pk.no_telp
          FROM kendaraan AS ke,
          stnk AS st,
          service AS se,
          pajak AS p,
          pengguna_kendaraan AS pk
          WHERE ke.no_polisi ='$noPol'
          AND ke.id_kendaraan = se.id_kendaraan
          AND ke.id_kendaraan = st.id_kendaraan
          AND ke.id_kendaraan = p.id_kendaraan
          AND se.status='active'          
          AND p.status='active'
          AND st.status='active'
          AND ke.id_penggunakendaraan = pk.id_penggunakendaraan ";
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
if(isset($_POST['kir'])){
  $idKendaraan = $_POST['kir'];
  $query = "SELECT * FROM kir WHERE id_kendaraan='$idKendaraan' AND status='active'";
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
if(isset($_POST['asuransi'])){
  $idKendaraan = $_POST['asuransi'];
  $query = "SELECT * FROM asuransi WHERE id_kendaraan='$idKendaraan' AND status='active'";
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
