<ul id="content-menu">
	<li><a class="btn" href='?sub=add.php'>Tambah Data Pengguna Aplikasi</a></li>	
</ul>

<h2 class="content-title">
	<span>Data Pengguna Aplikasi Kendaraan Operasional</span>
</h2>

<table border="1" class="list">
<tr>
	<th width="40">No.</th>
	<th>Nama Pengguna</th> 
	<th>Nama Lengkap</th> 
	<th>Tipe Pengguna </th> 
	<th>No.Telp</th>
	<th colspan='2'>Opsi</th>
</tr>
<?php
$no = 1;

#prepare base sql query
$sql = "SELECT * FROM user ORDER BY namalengkap ASC";
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
			<td><?php echo $data['username'];?></td>
			<td><?php echo $data['namalengkap'];?></td>
			<td><?php echo $data['tipe_user'];?></td>
			<td><?php echo $data['no_telp'];?></td>
			<td align="center" width="80">
				<form method='POST' action='?sub=edit.php'>
				<input type='hidden' name='id_user' value='<?php echo $data['id_user'];?>'>
				<input type='submit' name='edit' Value='Edit'>
				</form>
			</td>
			<td align="center" width="80">
				<form method='POST' action='action.php'>
				<input type='hidden' name='id_user' value='<?php echo $data['id_user'];?>'>
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