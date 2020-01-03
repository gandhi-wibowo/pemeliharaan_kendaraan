<?php
$basepath = realpath(dirname(__file__).'/..');
include "{$basepath}/modules/config.php";
include "{$basepath}/modules/connect.php";
include "{$basepath}/modules/library.php";

$device = 'fXig9tXWoPQ:APA91bHe7yNi6wWp4aY0rc0IUw1sv4kalkCv2kKZ-Ck37KFp8VwgQcs4d4MZEx96PNxslIpcKj_aR9xI4wz_QwsNt1WxsTem0pgFsZUutt9bCjZx6eA1AQp4P6cNt04H-JKJpNCvJztV';
$frequency = explode(',', NOTIFY_INTERVAL);
$today = date('Y-m-d');
$notify = array();

$tables = array('stnk', 'kir', 'pajak', 'service', 'asuransi');

foreach($tables as $table){
    #stnk
    $dates = array();
    foreach($frequency as $dayKey => $dayValue){                    
        $dates[] = "DATE_ADD({$table}.berlaku_{$table}, INTERVAL - {$dayValue} DAY)";
    }

    $dueDate = implode(',', $dates);
    $sql = "SELECT *, UNIX_TIMESTAMP(berlaku_{$table}) AS masa_berlaku
            FROM `{$table}` 
            JOIN kendaraan ON {$table}.id_kendaraan = kendaraan.id_kendaraan
            WHERE {$table}.status='active' AND '{$today}' IN({$dueDate})";
    $query = query($sql);
    while($data = mysqli_fetch_array($query)){
        $expired = date('d', $data['masa_berlaku']).' '.substr(monthToId(date('m', $data['masa_berlaku'])), 0, 3).' '.date('Y', $data['masa_berlaku']);
        $notify[] = array(
            'title' => 'Notifikasi '.strtoupper($table),
            'body' => 'Masa berlaku '.strtoupper($table).' kendaraan '.$data['no_polisi'].' akan berakhir pada '. $expired,
            'id_kendaraan' => $data['id_kendaraan'],
            'pemilik' => $table,
            'id_pemilik' => $data["id_{$table}"],
            'data' => array(
                'jenis' => $table,
                'no_polisi' => $data['no_polisi']
            )
        );
    }
}

#send FCM
$datetime = date('Y-m-d H:i:s');
$sql = "SELECT * FROM user WHERE tipe_user != 'admin' AND token != '' ";
$query = query($sql);
$res = array();
while($data = mysqli_fetch_array($query)){
    foreach($notify as $notification){

        $fcm = sendFCM($data['token'], $notification['title'], $notification['body'],'com.skripsi.marisonervan.TARGET_NOTIFICATION' /*$notification['data']*/);

        $res[] = $fcm;
        $status = ($fcm['success'] == 1 ? 'success':'failed');
        $sqlx = "INSERT INTO notifikasi VALUES(NULL, '{$notification['title']}', '{$notification['body']}', '{$notification['id_kendaraan']}', '{$datetime}', '{$status}', '{$notification['pemilik']}', '{$notification['id_pemilik']}', '{$data['id_user']}')";
        $queryx = query($sqlx);
        
    }
}

/* write log */
$file = fopen($basepath.'/services/notify.log', 'a');
fwrite($file, json_encode($res)."\r\n\r\n");
fclose($file);
/* end of log*/
?>