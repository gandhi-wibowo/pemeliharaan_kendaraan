<?php
$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
if($connect){
    $selDb = mysqli_select_db($connect, DB_NAME);
    if(!$selDb){
        die('Database '.DB_NAME.' NOT FOUND!');
    }

    function query($sql){
        global $connect;

        $query = mysqli_query($connect, $sql);
        if($query === FALSE) { 
            return mysqli_error($connect);
        }

        return  $query;
    }
} else {
    die('Unable to connect to '.DB_HOST);
}
?>