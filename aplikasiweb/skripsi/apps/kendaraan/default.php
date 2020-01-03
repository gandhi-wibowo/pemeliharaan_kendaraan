<div style="border-bottom:1px solid #ddd;overflow:hidden;margin:0 -20px;padding:0 20px;">

	<ul id="content-menu">
		<li><a class="btn" href='?sub=add.php'>Tambah data kendaraan</a></li>
	</ul>

	<form method="get" action="index.php" style="float:left">
		<div style="font-size:11px;font-weight:bold;margin-bottom:4px;">Form Pencarian</div>
		<input name="q" type="text" value="<?php echo $_GET['q'];?>" placeholder="Contoh: BM 1234 XX"/>
		<input type="submit" value="Cari"/>
	</form>
</div>

<h2 class="content-title">
	<span>Data Kendaraan PT.Bangun Globalindo Perkasa (BGP)</span>
</h2>

<table border="1" class="list">
<tr>
	<th>No</th>
	<th>No.Polisi</th> 
	<th>Pengguna Kendaraan</th> 
	<th>Nama STNK</th> 
	<th>Merk</th> 
	<th>Jenis</th> 
	<th>Nama BPKB</th> 
	<th colspan='2'>Opsi</th>
</tr>
<?php
$whereClaue = '';
if($_GET['q']){
	$whereClaue = "AND no_polisi LIKE '%{$_GET['q']}%'";
}

#prepare base sql query
$sql = "SELECT * FROM kendaraan AS K, pengguna_kendaraan AS P WHERE K.id_penggunakendaraan=P.id_penggunakendaraan $whereClaue";
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
			<td width='100'>
				<a  href="javascript:void(0)" onClick="return popup('<?php echo BASEURL;?>/apps/kendaraan/detail.php?id_kendaraan=<?php echo $data['id_kendaraan'];?>', 'Detail Kendaraan', 500, 500)">
				<?php echo $data['no_polisi'];?>
				</a>			
			
			</td>
			<td><?php echo $data['nama_pengguna'];?></td>
			<td><?php echo $data['nama_stnk'];?></td>
			<td><?php echo $data['merk'];?></td>
			<td><?php echo ucfirst($data['jenis']);?></td>
			<td><?php echo $data['nama_bpkb'];?></td>
			<td align="center">
				<form method='POST' action='?sub=edit.php'>
				<input type='hidden' name='id_kendaraan' value='<?php echo $data['id_kendaraan'];?>'>
				<input type='submit' name='edit' Value='Edit'>
				</form>
			</td>
			<td align="center">
				<form class="delete" method='POST' action='action.php'>
				<input type='hidden' name='id_kendaraan' value='<?php echo $data['id_kendaraan'];?>'>
				<input type='submit' name='delete' Value='Hapus'>
				</form>
			</td>
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
