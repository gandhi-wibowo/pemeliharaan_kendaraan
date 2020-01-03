<?php
session_start();
include "../../modules/config.php";
include "../../modules/connect.php";
include "../../modules/library.php";
include "../components/auth.php";

if(isset($_POST['insert'])){
	$no_polisi=strtoupper($_POST['no_polisi']); 
	$nama_stnk=strtoupper($_POST['nama_stnk']); 
	$merk=strtoupper($_POST['merk']); 
	$jenis=strtoupper($_POST['jenis']); 
	$penggunakendaraan=$_POST['penggunakendaraan']; 
	$tahun_pembuatan=strtoupper($_POST['tahun_pembuatan']); 
	$no_rangka=$_POST['no_rangka']; 
	$no_mesin=$_POST['no_mesin']; 
	$posisi_stnk=strtoupper($_POST['posisi_stnk']); 
	$nama_bpkb=strtoupper($_POST['nama_bpkb']); 
	$posisi_bpkb=strtoupper($_POST['posisi_bpkb']); 
	$status_kendaraan=strtoupper($_POST['status_kendaraan']); 
	$asuransi=$_POST['asuransi']; 

	if($no_polisi == NULL){ alert('Form  No Polisi Harus di isi .'); }
	elseif($nama_stnk==NULL){ alert('Form  Nama Stnk Harus di isi .'); }
	elseif($merk == NULL){ alert('Form  Merk Harus di isi .'); }
	elseif($jenis == NULL){ alert('Form  Jenis Harus di isi .'); }
	elseif($tahun_pembuatan == NULL){ alert('Form  Tahun Pembuatan Harus di isi .'); }
	elseif($no_rangka == NULL ){ alert('Form  No Rangka Harus di isi .'); }
	elseif($no_mesin==NULL){ alert('Form  No Mesin Harus di isi .'); }
	elseif($posisi_stnk == NULL){ alert('Form  Posisi Stnk Harus di isi .'); }
	elseif($nama_bpkb== NULL){ alert('Form  Nama BPKB Harus di isi .'); }
	elseif($posisi_bpkb == NULL){ alert('Form  Posisi BPKB Harus di isi .'); }
	elseif($status_kendaraan == NULL){ alert('Form  Status Kendaraan Harus di isi .'); }
	elseif($asuransi == NULL){ alert('Form  Asuransi Harus di isi .'); }

		$fdata = array();
	foreach($_POST['info'] as $key => $value){
		$fdata[$key] = false;
		if($key =="stnk" || $key =="pajak" || $key =="service" ){
			if(count(array_filter($_POST['info'][$key])) > 0){
				if(count(array_filter($_POST['info'][$key])) < 3){
					$fdata[$key] = false;
					alert('Informasi '.strtoupper($key).' belum lengkap.');
					
				} else {
					$fdata[$key] = true;
				}
			}
			else{
				$fdata[$key] = false;
				alert('Informasi '.strtoupper($key).' Harus di isi .');
			}
		}
	}

 	$sql = "INSERT INTO `kendaraan` (`id_kendaraan`,`no_polisi`,`nama_stnk`,`merk`,`jenis`,`id_penggunakendaraan`,`tahun_pembuatan`,`no_rangka`,`no_mesin`,`posisi_stnk`,`nama_bpkb`,`posisi_bpkb`,`status_kendaraan`, `id_master_asuransi`)
		VALUES (NULL,'$no_polisi','$nama_stnk','$merk','$jenis','$penggunakendaraan','$tahun_pembuatan','$no_rangka','$no_mesin','$posisi_stnk','$nama_bpkb','$posisi_bpkb','$status_kendaraan', '$asuransi')";
	$query = query($sql);
	if($query){
		#get last id
		$sql = "SELECT id_kendaraan FROM kendaraan WHERE no_polisi='{$no_polisi}'";
		$query = query($sql);
		$data = mysqli_fetch_array($query);
		$id_kendaraan = $data['id_kendaraan'];

		$today = date('Y-m-d H:i:s');
		if($fdata['stnk']){
			$stnk = $_POST['info']['stnk'];
			$tgl_pelaksanaan = date('Y-m-d', strtotime(str_replace('/', '-', $stnk['tgl_pelaksanaan'])));
			$tgl_berlaku = date('Y-m-d', strtotime(str_replace('/', '-', $stnk['tgl_berlaku'])));
			$biaya = (int) str_replace(array('.', ','), '', $stnk['biaya']);
			
			$sql = "INSERT INTO stnk (id_kendaraan, berlaku_stnk, biaya_stnk, tgl_input, tgl_pelaksanaan, id_user, keterangan, status, id_fpk) 
					VALUES ('{$id_kendaraan}', '{$tgl_berlaku}', '{$biaya}', '{$today}', '{$tgl_pelaksanaan}', '{$_SESSION['id_user']}', '{$stnk['keterangan']}', 'active', '0')";
			$query = query($sql);
		}

		if($fdata['pajak']){
			$pajak = $_POST['info']['pajak'];
			$tgl_pelaksanaan = date('Y-m-d', strtotime(str_replace('/', '-', $pajak['tgl_pelaksanaan'])));
			$tgl_berlaku = date('Y-m-d', strtotime(str_replace('/', '-', $pajak['tgl_berlaku'])));
			$biaya = (int) str_replace(array('.', ','), '', $pajak['biaya']);
			
			$sql = "INSERT INTO pajak (id_kendaraan, berlaku_pajak, biaya_pajak, tgl_input, tgl_pelaksanaan, id_user, keterangan, status, id_fpk) 
					VALUES ('{$id_kendaraan}', '{$tgl_berlaku}', '{$biaya}', '{$today}', '{$tgl_pelaksanaan}', '{$_SESSION['id_user']}', '{$pajak['keterangan']}', 'active', '0')";
			$query = query($sql);
		}

		if($fdata['kir']){
			$kir = $_POST['info']['kir'];
			$tgl_pelaksanaan = date('Y-m-d', strtotime(str_replace('/', '-', $kir['tgl_pelaksanaan'])));
			$tgl_berlaku = date('Y-m-d', strtotime(str_replace('/', '-', $kir['tgl_berlaku'])));
			$biaya = (int) str_replace(array('.', ','), '', $kir['biaya']);
			
			$sql = "INSERT INTO kir (id_kendaraan, berlaku_kir, biaya_kir, tgl_input, tgl_pelaksanaan, id_user, keterangan, status, id_fpk) 
					VALUES ('{$id_kendaraan}', '{$tgl_berlaku}', '{$biaya}', '{$today}', '{$tgl_pelaksanaan}', '{$_SESSION['id_user']}', '{$kir['keterangan']}', 'active', '0')";
			$query = query($sql);
		}

		if($fdata['service']){
			$service = $_POST['info']['service'];
			$tgl_pelaksanaan = date('Y-m-d', strtotime(str_replace('/', '-', $service['tgl_pelaksanaan'])));
			$tgl_berlaku = date('Y-m-d', strtotime(str_replace('/', '-', $service['tgl_berlaku'])));
			$biaya = (int) str_replace(array('.', ','), '', $service['biaya']);
			
			$sql = "INSERT INTO service (id_kendaraan, berlaku_service, biaya_service, tgl_input, tgl_pelaksanaan, id_user, keterangan, status, id_fpk) 
					VALUES ('{$id_kendaraan}', '{$tgl_berlaku}', '{$biaya}', '{$today}', '{$tgl_pelaksanaan}', '{$_SESSION['id_user']}', '{$service['keterangan']}', 'active', '0')";
			$query = query($sql);
		}

		if($fdata['asuransi']){
			$asuransi = $_POST['info']['asuransi'];
			$tgl_pelaksanaan = date('Y-m-d', strtotime(str_replace('/', '-', $asuransi['tgl_pelaksanaan'])));
			$tgl_berlaku = date('Y-m-d', strtotime(str_replace('/', '-', $asuransi['tgl_berlaku'])));
			$biaya = (int) str_replace(array('.', ','), '', $asuransi['biaya']);
			
			$sql = "INSERT INTO asuransi (id_kendaraan, berlaku_asuransi, biaya_asuransi, tgl_input, tgl_pelaksanaan, id_user, keterangan, status, id_fpk, id_master_asuransi) 
					VALUES ('{$id_kendaraan}', '{$tgl_berlaku}', '{$biaya}', '{$today}', '{$tgl_pelaksanaan}', '{$_SESSION['id_user']}', '{$asuransi['keterangan']}', 'active', '0', '{$_POST['asuransi']}')";
			$query = query($sql);
		}
	}
} else if(isset($_POST['update'])){
	$fdata = array();
	foreach($_POST['info'] as $key => $value){
		$fdata[$key] = false;
		if(count(array_filter($_POST['info'][$key])) > 0){
			if(count(array_filter($_POST['info'][$key])) < 3){
				alert('Informasi '.strtoupper($key).' belum lengkap.');
			} else {
				$fdata[$key] = true;
			}
		}
	}	

	$id_kendaraan = $_POST['id_kendaraan'];

	$no_polisi=$_POST['no_polisi']; 
	$nama_stnk=$_POST['nama_stnk']; 
	$merk=$_POST['merk']; 
	$jenis=$_POST['jenis']; 
	$penggunakendaraan=$_POST['penggunakendaraan']; 
	$tahun_pembuatan=($_POST['tahun_pembuatan']); 
	$no_rangka=$_POST['no_rangka']; 
	$no_mesin=$_POST['no_mesin']; 
	$posisi_stnk=$_POST['posisi_stnk']; 
	$nama_bpkb=$_POST['nama_bpkb']; 
	$posisi_bpkb=$_POST['posisi_bpkb']; 
	$status_kendaraan=$_POST['status_kendaraan']; 
	$asuransi=$_POST['asuransi']; 
		
	$sql = "UPDATE `kendaraan` SET `no_polisi` = '$no_polisi',`id_penggunakendaraan` = '$penggunakendaraan',`nama_stnk` = '$nama_stnk',`merk` = '$merk',`jenis` = '$jenis',`tahun_pembuatan`= '$tahun_pembuatan',`no_rangka` = '$no_rangka',`no_mesin` = '$no_mesin',`posisi_stnk` = '$posisi_stnk',`nama_bpkb` = '$nama_bpkb',`posisi_bpkb` = '$posisi_bpkb',`status_kendaraan` = '$status_kendaraan', id_master_asuransi='$asuransi' WHERE  `id_kendaraan` =  '$id_kendaraan'";
	$query = query($sql);

	if($query){
		$today = date('Y-m-d H:i:s');

		foreach($fdata as $table => $value){
			if($fdata[$table]){
				$data = $_POST['info'][$table];
				$tgl_pelaksanaan = date('Y-m-d', strtotime(str_replace('/', '-', $data['tgl_pelaksanaan'])));
				$tgl_berlaku = date('Y-m-d', strtotime(str_replace('/', '-', $data['tgl_berlaku'])));
				$biaya = (int) str_replace(array('.', ','), '', $data['biaya']);
				
				$id = $data['id'] ? $data['id'] : 'NULL';
				if($table == 'asuransi'){
					$sql = "REPLACE INTO `{$table}`
						VALUES ($id, '{$id_kendaraan}', '{$tgl_berlaku}', '{$biaya}', '{$today}', '{$tgl_pelaksanaan}', '{$_SESSION['id_user']}', '{$data['keterangan']}', 'active', '0', '{$_POST['asuransi']}')";
				} else {
					$sql = "REPLACE INTO `{$table}`
						VALUES ($id, '{$id_kendaraan}', '{$tgl_berlaku}', '{$biaya}', '{$today}', '{$tgl_pelaksanaan}', '{$_SESSION['id_user']}', '{$data['keterangan']}', 'active', '0')";
				}

				$query = query($sql);
			}
		}
	}
} else if(isset($_POST['delete'])){
	$id = $_POST['id_kendaraan'];
	$sql = "DELETE FROM `kendaraan` WHERE `id_kendaraan` = '$id'";
	$query = query($sql);
}

if($query){
	header ("Location:".APPURL.'/'.basename(__DIR__));
}
?>
