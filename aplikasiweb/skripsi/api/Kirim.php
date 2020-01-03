<?php
$url = 'https://fcm.googleapis.com/fcm/send';
$msg = array
  (
    'body' => "Pesan",
    'title' => "PUSH NOTIFICATION"
  );
$fields = array
  (
    'registration_ids' => "fql6UXKwlnI:APA91bGygyaltgRAMJNOXWA_kbJZlxie42Uk5TVhWbXTTyX1RfNmDLIzc9o-6T7sQVnbH_r_mm6jH5UzxR8OpNHgk4wNjjRNoc8DTEwy33qZWiSvrzPfJAQEnAWxvpO2U3bkoa2PuU-M",
    'notification' => $msg
  );
$headers = array(
    'Authorization:key=AIzaSyCe3FXYyQiR0d-3BluE7VdRnQx_x8iUfdM',
    'Content-Type: application/json'
  );

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
$result = curl_exec($ch);
if ($result === FALSE) {
die('Curl failed: ' . curl_error($ch));
}
curl_close($ch);
return $result;
 ?>
