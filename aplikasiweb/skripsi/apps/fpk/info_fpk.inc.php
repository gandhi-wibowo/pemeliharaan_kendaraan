<div id="info-fpk">
	<h4 class="content-title">Informasi FPK</h4>
	<?php
	$sql = "SELECT *
			FROM form_pengajuan_kerja fpk
			JOIN kendaraan kd ON kd.id_kendaraan=fpk.id_kendaraan
			JOIN user ON user.id_user=fpk.id_user
			WHERE fpk.status_fpk='approve' AND status_pelaksanaan='active' AND fpk.id_fpk='{$_GET['id']}'";
	$query = query($sql);
	$fpk = mysqli_fetch_array($query);
	
	$tgl_pengajuan = strtotime($fpk['tgl_pengajuan']);
	$tgl_persetujuan = strtotime($fpk['tgl_persetujuan']);
	$tgl_selesai = strtotime($fpk['tgl_selesai']);
	?>

	<table cellpadding="8">
	<tr>
		<td>
			<label>No. Polisi</label>
			<a href="javascript:void(0)" onClick="return popup('<?php echo BASEURL;?>/kendaraan/detail.php?id_kendaraan=<?php echo $fpk['id_kendaraan'];?>', 'Detail Kendaraan', 500, 500)"><?php echo $fpk['no_polisi'];?></a>
		</td>
		<td>
			<label>Jenis Kendaraan</label>
			<?php echo ucfirst($fpk['jenis']);?>
		</td>
		<td>
			<label>Petugas Lapangan</label>
			<?php echo $fpk['namalengkap'];?>
		</td>
	</tr>
	<tr valign="top">
		<td>
			<label>Tgl. Pengajuan FPK</label>
			<?php echo date('d', $tgl_pengajuan).' '.monthToId(date('m', $tgl_pengajuan)).' '.date('Y', $tgl_pengajuan);?>
		</td>
		<td>
			<label>Tgl. Persetujuan FPK</label>
			<?php echo date('d', $tgl_persetujuan).' '.monthToId(date('m', $tgl_persetujuan)).' '.date('Y', $tgl_persetujuan);?>
		</td>
		<td colspan="2">
			<label>Tgl. Selesai</label>
			<?php echo date('d', $tgl_selesai).' '.monthToId(date('m', $tgl_selesai)).' '.date('Y', $tgl_selesai);?>
		</td>
	</tr>
	<tr valign="top">
		<td>
			<label>Keterangan</label>
			<?php echo $fpk['keterangan'] ? $fpk['keterangan']: '-';?>
		</td>
	</table>
</div>