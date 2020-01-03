<?php
#page id
$page = basename(__DIR__);

session_start();
include "../../modules/config.php";
include "../../modules/connect.php";
include "../../modules/library.php";
include "../components/auth.php";
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
        $datas[] = array(
            'expired'=>date('Y', $data['masa_berlaku']).'-'.date('m', $data['masa_berlaku']).'-'.date('d', $data['masa_berlaku']),
            'no_polisi' => $data['no_polisi'],
            'jenis' => $table
            );
        
    }    
}

?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Home</title>
	<link rel="stylesheet" href="../../css/style.css?t=<?php echo time();?>" />
</head>
<body>
	<?php include "../components/header.php";?>

	<div id="wrapper">
		<div id="segment-container">
			<div class="segment" style="margin-right:10px">
				<h3>Informasi Perangkat</h3>

				<div class="content">
					<div class="note">Menampilkan daftar perangkat Android yang terhubung ke sistem.</div>
					<table width="100%">

						<tr>
							<th>No.</th>
							<th>Nama Pengguna</th>
							<th>No Telp</th>
							<th>Tipe User</th>
						</tr>
											<?php 
					$sql ="SELECT * FROM user WHERE tipe_user!='admin'";
					$query = query($sql);
					$no =1;
					while($data = mysqli_fetch_array($query)){ ?>
						<tr align="center">
							<td><?php echo $no++; ?></td>
							<td><?php echo $data['namalengkap'] ?></td>
							<td><?php echo $data['no_telp'] ?></td>
							<td><?php echo $data['tipe_user'] ?></td>
						</tr>
					<?php } ?>
					</table>
				</div>
			</div>

			<div class="segment">
				<h3>Informasi Kendaraan</h3>

				<div class="content">
					<div class="note">Menampilkan informasi kendaraan dengan layanan stnk, kir dll. yang akan segera berakhir masa berlakuya.</div>

					<table width="100%">
						<tr>
							<th>No.</th>
							<th>No. Plat Kendaraan</th>
							<th>Jenis Layanan</th>
							<th>Masa Berakhir</th>
						</tr>
						<?php 
						$no =1;
						for($i = 0; $i<5; $i++){
							if($datas[$i] == NULL){}
							else { ?>
						<tr>
							<td align="center"><?php echo $no ; ?></td>
							<td><?php echo $datas[$i]['no_polisi']; ?></td>
							<td><?php echo $datas[$i]['jenis']; ?></td>
							<td><?php echo date("d",strtotime($datas[$i]['expired'])) .' '.monthToId(date('m', strtotime($datas[$i]['expired']))). ' '.date('Y', strtotime($datas[$i]['expired'])); ?>
							
							</td>
						</tr>						
								
					   <?php $no++; }} ?>
					</table>
				</div>
			</div>
		</div>

		<div id="container">
			<p><i>Ketika kita menunda-nunda, ingatlah bahwa hidup terus berjalan. 
			</br>SENECA</i></p>
		</div>
	</div>

	<?php require '../components/footer.php';?>
</body>
</html>
