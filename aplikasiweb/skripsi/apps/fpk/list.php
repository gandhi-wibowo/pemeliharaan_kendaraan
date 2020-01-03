<?php
switch($_GET['type']){
	case 'asuransi':
		$title = 'Pembayaran Asuransi';
		break;
	case 'kir':
		$title = 'Pengujian KIR';
		break;
	case 'pajak':
		$title = 'Pembayaran Pajak';
		break;
	case 'service':
		$title = 'Service Kendaraan';
		break;
	default:
		$title = 'Perpanjangan STNK';
		break;
}
?>

<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/fpk/">FPK</a> &nbsp;&raquo;&nbsp;
    FPK <?php echo $title;?>
</div>

<h2 class="content-title">
	<span>FPK <?php echo $title;?></span>
</h2>

<table border="1" class="list">
<tr>
	<th rowspan="2" width="20">No.</th>
	<th rowspan="2" width="90">No. Polisi</th> 
	<th rowspan="2" width="120">Jenis Kendaraan</th> 
	<th colspan="3">Informasi Tanggal</th> 
	<th rowspan="2">Keterangan</th> 
	<th rowspan="2">Petugas Lapangan</th>
	<th rowspan="2">Opsi</th>
</tr>
<tr>
	<th width="90">Pengajuan</th>
	<th width="90">Persetujuan</th>
	<th width="90">Selesai</th>
</tr>
<?php
$no = 1;

#prepare base sql query
$sql = "SELECT *
		FROM form_pengajuan_kerja fpk
		JOIN kendaraan kd ON kd.id_kendaraan=fpk.id_kendaraan
		JOIN user ON user.id_user=fpk.id_user
		WHERE fpk.status_fpk='approve' AND status_pelaksanaan='active' AND peruntukan='{$_GET['type']}'";
$query = query($sql);

$totalRows = mysqli_num_rows($query);

#pagination setup
$limit = 5;
$pages = new Paginator($limit, 'page');
$pages->set_total($totalRows);
parse_str($_SERVER['QUERY_STRING'], $params);
unset($params['page']);
$params = empty($params) ? '' : '&'.http_build_query($params);
$pagination = $pages->page_links('?', $params);

#prepare sql query using limmit, offset
$sql .= ' '.$pages->get_limit();
$query = query($sql);

#prepare row number 
$no = 1 + (( ($_GET['page'] ?  $_GET['page'] : 1) - 1) * $limit);

if($totalRows == 0){
	?>
	<tr>
		<td colspan="12" class="nodata">Belum ada data</td>
	</tr>
	<?php
} else {
	while($data = mysqli_fetch_array($query)){
		if($data['jenis'] == 'motor'){
			$data['jenis'] = 'Sepeda Motor';
		}
		?>
		<tr>
			<td align="center"><?php echo $no;?></td>
			<td><a href="javascript:void(0)" onClick="return popup('<?php echo BASEURL;?>/apps/kendaraan/detail.php?id_kendaraan=<?php echo $data['id_kendaraan'];?>', 'Detail Kendaraan', 500, 500)"><?php echo $data['no_polisi'];?></a></td>
			<td><?php echo ucfirst($data['jenis']);?></td>
			<td><?php echo $data['tgl_pengajuan'];?></td>
			<td><?php echo $data['tgl_persetujuan'];?></td>
			<td><?php echo $data['tgl_selesai'];?></td>
			<td><?php echo $data['keterangan'] ?  $data['keterangan'] : '-';?></td>
			<td><?php echo $data['namalengkap'];?></td>
			<td align="center"><a class="btn" href="?sub=<?php echo $data['peruntukan'];?>.php&type=<?php echo $data['peruntukan'];?>&id=<?php echo $data['id_fpk'];?>">Detail</a></td>
		</tr>
		<?php
		++$no;
	}
}?>
</table>

<?php
#show pagination
echo $pagination;
?>
