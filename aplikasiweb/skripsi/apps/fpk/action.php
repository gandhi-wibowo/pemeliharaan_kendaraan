<?php
session_start();
include "../../modules/config.php";
include "../../modules/connect.php";
include "../../modules/library.php";
include "../components/auth.php";

if(empty($_POST['tgl_pelaksanaan']) or empty($_POST['tgl_berlaku']) or empty($_POST['biaya'])){
    alert('Anda harus mengisi semua kolom yang diperlukan');
} else {
    $id_fpk = $_POST['id'];
    $sql = "SELECT * FROM form_pengajuan_kerja WHERE id_fpk='{$id_fpk}'";
    $query = query($sql);
    $data = mysqli_fetch_array($query);
    $peruntukan = $data['peruntukan'];

    if($data['id_fpk']){
        $table = $data['peruntukan'];

        #update this fpk as history
        $sqlx = "UPDATE `form_pengajuan_kerja` SET status_pelaksanaan='history' WHERE id_fpk='{$data['id_fpk']}' AND peruntukan='{$table}'";
        $queryx = query($sqlx);

        if($queryx){
            #update old data as history
            $sqlx = "UPDATE `{$table}` SET status='history' WHERE id_kendaraan='{$data['id_kendaraan']}'";
            $queryx = query($sqlx);

            #set variables
            $today = date('Y-m-d H:i:s');
            $tgl_pelaksanaan = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['tgl_pelaksanaan'])));
            $tgl_berlaku = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['tgl_berlaku'])));
            $biaya = (int) str_replace(array('.', ','), '', $_POST['biaya']);
                
            #add new record
            if($table == 'asuransi'){
                #get id master asuransi
                $sqlxx = "SELECT id_master_asuransi FROM kendaraan WHERE id_kendaraan='{$data['id_kendaraan']}'";
                $queryxx = query($sqlxx);
                $dataxx = mysqli_fetch_array($queryxx);
                $id_master_asuransi = $dataxx['id_master_asuransi'];

                #build sql query
                $sqlx = "INSERT INTO `{$table}`
                    VALUES (NULL, '{$data['id_kendaraan']}', '{$tgl_berlaku}', '{$biaya}', '{$today}', '{$tgl_pelaksanaan}', '{$_SESSION['id_user']}', '{$_POST['keterangan']}', 'active', '{$id_fpk}', '{$id_master_asuransi}')";
            } else {
                #build sql query
                $sqlx = "INSERT INTO `{$table}`
                    VALUES (NULL, '{$data['id_kendaraan']}', '{$tgl_berlaku}', '{$biaya}', '{$today}', '{$tgl_pelaksanaan}', '{$_SESSION['id_user']}', '{$_POST['keterangan']}', 'active', '{$id_fpk}')";
            }

            #execute sql query
            $queryx = query($sqlx);
        }
    }
}

if($query){
	header ("Location:".APPURL.'/laporan/?sub='.$peruntukan.'.php');
}
?>