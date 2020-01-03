<?php
#page id
$page = basename(__DIR__);

session_start();
require '../../modules/config.php';
require '../../modules/connect.php';
require '../../modules/library.php';
require '../components/auth.php';

if(isset($_GET['id_kendaraan'])){    
    $sql = "SELECT * FROM kendaraan AS K, pengguna_kendaraan AS P WHERE K.id_penggunakendaraan=P.id_penggunakendaraan AND id_kendaraan = '{$_GET['id_kendaraan']}' ";
    $query = query($sql);
    if(mysqli_num_rows($query) == 0){
	?>
	<tr>
		<td colspan="12" class="nodata">Belum ada data</td>
	</tr>
	<?php
    } else {
        $data = mysqli_fetch_array($query);
    ?>

<html>
<head>
	<meta charset="utf-8" />
	<title>Form Pengajuan Kerja</title>
	<link rel="stylesheet" href="../../css/style.css?t=<?php echo time();?>" />
	<link rel="stylesheet" href="../../css/jquery.datepicker.css?t=<?php echo time();?>" />
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type="text/javascript" src="../../js/jquery.datepicker.js"></script>
	<script type="text/javascript" src="../../js/date.js"></script>
	<script type="text/javascript" src="../../js/function.js"></script>
</head>
<body>
<h4 class="content-title">Detail Data Kendaraan</h4>

<form action='action.php' method='POST'>
    
    <div id="tab-container">
        

        <div id="target">
            <div id="tab-informasi" class="tab">
                <div class="block">
                    <table cellpadding="5">
                        <tr>
                            <td >No.Polisi</td>
                            <td >:</td>
                            <td><?php echo strtoupper($data['no_polisi']); ?></td>
                        </tr>
                        <tr>
                            <td>Pengguna Kendaraan</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['nama_pengguna']); ?></td>
                        </tr>
                        <tr>
                            <td>Nama STNK</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['nama_stnk']); ?></td>
                        </tr>
                        <tr>
                            <td>Merk</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['merk']); ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kendaraan</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['jenis']); ?></td>
                        </tr>
                        <tr>
                            <td>Tahun Pembuatan</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['tahun_pembuatan']); ?></td>
                        </tr>
                        <tr>
                            <td>No.Rangka</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['no_rangka']); ?></td>
                        </tr>
                        <tr>
                            <td>No.Mesin</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['no_mesin']); ?></td>
                        </tr>

                        <tr>
                            <td>Posisi STNK</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['posisi_stnk']); ?></td>
                        </tr>
                        <tr>
                            <td>Nama BPKB</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['nama_bpkb']); ?></td>
                        </tr>
                        <tr>
                            <td>Posisi BPKB</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['posisi_bpkb']); ?></td>
                        </tr>
                        <tr>
                            <td>Status Kendaraan</td>
                            <td>:</td>
                            <td><?php echo strtoupper($data['status_kendaraan']); ?></td>
                        </tr>
                        <tr>
                            <td>Asuransi</td>
                            <td>:</td>
                            <td>
                                    <?php
                                    $sql = "SELECT * FROM master_asuransi WHERE id_master_asuransi='{$data['id_master_asuransi']}' ";
                                    $query = query($sql);
                                    $datax = mysqli_fetch_array($query); 
                                    if($datax['nama_asuransi']==NULL){
                                        echo "-";
                                    }
                                    else{
                                        echo $datax['nama_asuransi'];
                                    }
                                    ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
</form>
    <?php

        
    }
}
?>
	<?php require '../components/footer.php';?>
</body>
</html>