<ul id="content-menu">
	<li><a class="btn" href='?sub=add.php'>Tambah Data Asuransi</a></li>	
</ul>

<h2 class="content-title">
	<span>Data Asuransi PT.Bangun Globalindo Perkasa (BGP)</span>
</h2>

<table border="1" class="list">
<tr>
	<th width="40">No.</th>
	<th>Nama Asuransi</th> 
	<th width="150">Pengguna Asuransi</th>
	<th colspan='2'>Opsi</th>
</tr>
<?php
$no = 1;

#prepare base sql query
$sql = "SELECT *,
		(SELECT COUNT(*) FROM kendaraan WHERE kendaraan.id_master_asuransi=master_asuransi.id_master_asuransi) AS numOfUsed
		FROM master_asuransi ORDER BY nama_asuransi ASC";
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
		<td colspan="4" class="nodata">Belum ada data</td>
	</tr>
	<?php
} else {
	while($data = mysqli_fetch_array($query)){
		?>
		<tr>
			<td align="center"><?php echo $no;?></td>
			<td><?php echo $data['nama_asuransi'];?></td>
			<td  align="center"><?php echo $data['numOfUsed'] > 0 ? $data['numOfUsed'].' Kendaraan':'Tidak ada';?></td>
			<td align="center" width="80">
				<form method='POST' action='?sub=edit.php'>
				<input type='hidden' name='id_master_asuransi' value='<?php echo $data['id_master_asuransi'];?>'>
				<input type='submit' name='edit' Value='Edit'>
				</form>
			</td>
			<td align="center" width="80">
				<form method='POST' action='action.php'>
				<input type='hidden' name='id_master_asuransi' value='<?php echo $data['id_master_asuransi'];?>'>
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