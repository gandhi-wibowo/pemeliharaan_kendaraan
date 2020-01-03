<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/laporan/">Laporan</a> &nbsp;&raquo;&nbsp;
    Notifikasi
</div>
<ul id="content-menu">
	<li><a class="btn" href='javascript:print()'>Cetak Halaman</a></li>
</ul>
<h2 class="content-title"><span>Laporan Notifikasi</span></h2>

<table border="1" class="list">
<tr>
	<th>No</th>
	<th>No.Polisi</th>
    <th>Tanggal Kirim Notifikasi</th> 
    <th>Isi Notifikasi</th> 
    <th>Jenis Notifikasi</th> 
    <th>Pengguna</th> 
    <th>Status</th> 
</tr>
<?php 
$no =1;

#prepare base sql query
$sql = "SELECT *
		FROM notifikasi AS n, kendaraan AS k, user AS u
		WHERE n.id_kendaraan = k.id_kendaraan AND n.id_user = u.id_user
		ORDER BY id_notifikasi DESC";
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
		?>
		<tr>
			<td align="center"><?php echo $no;?></td>
			<td><a href="javascript:void(0)" onClick="return popup('<?php echo BASEURL;?>/apps/kendaraan/detail.php?id_kendaraan=<?php echo $data['id_kendaraan'];?>', 'Detail Kendaraan', 500, 500)"><?php echo $data['no_polisi'];?></a></td>
			<td><?php echo date("d",strtotime($data['tgl_kirim_notifikasi'])) .' '.monthToId(date('m', strtotime($data['tgl_kirim_notifikasi']))). ' '.date('Y H:i', strtotime($data['tgl_kirim_notifikasi']));?></td>   
			<td><?php echo $data['isi_notifikasi'];?></td> 
			<td><?php echo $data['pemilik'];?></td> 
			<td><?php echo $data['namalengkap'];?></td> 
			<td align="center"><span class="<?php echo $data['status'];?>";?><?php echo $data['status'] == 'failed' ? 'Gagal' : 'Berhasil';?></span></td>
		</tr>
		<?php
		++$no;
	}
}
?>
</table>

<?php
#show pagination
echo $pagination;
?>

<style>
	span.success{
		color: green;
		font-weight:bold;
	}

	span.failed{
		color: red;
		font-weight:bold;
	}
</style>