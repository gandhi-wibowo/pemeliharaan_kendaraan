<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/laporan/">Laporan</a> &nbsp;&raquo;&nbsp;
    History Scan Barcode
</div>
<ul id="content-menu">
	<li><a class="btn" href='javascript:print()'>Cetak Halaman</a></li>
</ul>
<h2 class="content-title"><span>Laporan History Scan Barcode</span></h2>
<table border="1" class="list">
<tr>
	<th>No</th>
	<th>No.Polisi</th>
    <th>Tanggal Cari</th> 
    <th>User</th> 
    <th>Keterangan</th> 
</tr>
<?php 
$no =1;

#prepare base sql query
$sql = "SELECT *
        FROM barcode AS b, kendaraan AS k, user AS u
        WHERE b.id_kendaraan = k.id_kendaraan AND b.id_user=u.id_user ORDER BY id_barcode DESC";
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
			<td><?php echo date("d",strtotime($data['tgl_cari'])) .' '.monthToId(date('m', strtotime($data['tgl_cari']))). ' '.date('Y', strtotime($data['tgl_cari']));?></td>   
			<td><?php echo $data['namalengkap'];?></td> 
			<td>
				<?php 
					if($data['keterangan']==NULL){
						echo "-";
					}
					else{
						echo $data['keterangan'];
					}
					?>
			</td> 
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