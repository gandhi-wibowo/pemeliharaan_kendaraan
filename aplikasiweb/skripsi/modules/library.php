<?php
function alert($msg){
    echo '<script>alert("'.$msg.'");window.history.back();</script>';
    exit;
}

function monthToId($month){
    switch($month){
        case 1:
            $month = 'Januari';
            break;
        case 2:
            $month = 'Februari';
            break;
        case 3:
            $month = 'Maret';
            break;
        case 4:
            $month = 'April';
            break;
        case 5:
            $month = 'Mei';
            break;
        case 6:
            $month = 'Juni';
            break;
        case 7:
            $month = 'Juli';
            break;
        case 8:
            $month = 'Agustus';
            break;
        case 9:
            $month = 'September';
            break;
        case 10:
            $month = 'Oktober';
            break;
        case 11:
            $month = 'November';
            break;
        default:
            $month = 'Desember';
            break;
    }

    return $month;
}

function countFPK($type = null){
    $total = '';
     $whereClause = '';
    if($type){
        $whereClause = " AND peruntukan='{$type}'";
    }

    $sql = "SELECT COUNT(*) AS numOfFPK
        FROM form_pengajuan_kerja fpk
        JOIN kendaraan kd ON kd.id_kendaraan=fpk.id_kendaraan
        JOIN user ON user.id_user=fpk.id_user
        WHERE fpk.status_fpk='approve' AND status_pelaksanaan='active' $whereClause";
    $query = query($sql);
    if($query){
        $data = mysqli_fetch_array($query);
        $total = $data['numOfFPK'];
    }

    return $total;
}

function sendFCM($deviceId, $title, $body,$action /*, $data = array()*/) {
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array (
           /* 'registration_ids' => array (
                    $deviceId
            ),*/
            'to' => $deviceId,
            'notification'=>array(
              'title'=> $title,
              'body'=> $body,
              'click_action'=>$action,
              'icon'=>'ic_launcher',
              'sound'=>'RingtoneManager.TYPE_NOTIFICATION'
            )
           // ,'data' => $data // kaga tau kenapa, kalau dimatikan notifnya ke kirim om
    );
    $fields = json_encode ( $fields );

    $headers = array (
            'Authorization: key=' . FCM_SERVER_KEY,
            'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

    $result = curl_exec ( $ch );
    curl_close ( $ch );

    return json_decode($result, true);
}
