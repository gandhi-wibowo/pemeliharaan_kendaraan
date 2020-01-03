<?php
include "../modules/config.php";
include "../modules/connect.php";
include "../modules/library.php";

$sql = "SELECT no_polisi FROM kendaraan";
$query = query($sql);
$noPol = array();
if(mysqli_num_rows($query) == 0){
	echo json_encode(array("status"=>"gagal"));
} else {
	while($data = mysqli_fetch_assoc($query)){
        $noPol[] = $data;
    }
    echo json_encode($noPol);
}
?>
