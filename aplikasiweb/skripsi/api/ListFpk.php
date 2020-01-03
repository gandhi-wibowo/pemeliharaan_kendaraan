<?php
include "../modules/config.php";
include "../modules/connect.php";
include "../modules/library.php";

if(isset($_GET['idUser'])){
    $idUser = $_GET['idUser'];
    $sql = "SELECT * 
    FROM  `form_pengajuan_kerja` 
    WHERE id_user='$idUser'";
    $query = query($sql);
    $noPol = array();
    if(mysqli_num_rows($query) == 0){
        ?>
        Data gak ada
        <?php
    } else {
        while($data = mysqli_fetch_assoc($query)){
            $noPol[] = $data;
        }
        echo json_encode($noPol);
    }
}
else{
    $sql = "SELECT * 
    FROM  `form_pengajuan_kerja` ";
    $query = query($sql);
    $noPol = array();
    if(mysqli_num_rows($query) == 0){
        ?>
        Data gak ada
        <?php
    } else {
        while($data = mysqli_fetch_assoc($query)){
            $noPol[] = $data;
        }
        echo json_encode($noPol);
    }
}


?>