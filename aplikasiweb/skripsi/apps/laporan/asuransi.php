<div class="breadcrumb print-hide">
    <a href="<?php echo APPURL;?>/laporan/">Laporan</a> &nbsp;&raquo;&nbsp;
    Laporan Masa Berlaku asuransi
</div>

<div class="print-hide" style="border-bottom:1px solid #ddd;overflow:hidden;margin:15px -20px;padding:0 20px;">
	<ul id="content-menu" style="margin-top:30px">
		<li><a class="btn" href='javascript:print()'>Cetak Halaman</a></li>
	</ul>

	<form method="get" action="" style="float:left">
		<input type="hidden" name="sub" value="asuransi.php" />
		<table cellpadding="5">
			<tr>
				<td>
					<div style="font-size:11px;font-weight:bold;margin-bottom:4px;">Kendaraan</div>
					<select name="kendaraan">
						<option value="">Semua Kendaraan</option>
						<?php
						$sql = "SELECT * FROM kendaraan ORDER BY no_polisi ASC";
						$query = query($sql);
						while($data = mysqli_fetch_array($query)){
							?><option value="<?php echo $data['id_kendaraan'];?>"<?php echo $data['id_kendaraan'] == $_GET['kendaraan'] ? ' selected="selected"' : '';?>><?php echo $data['no_polisi'];?></option><?php
						}?>
					</select>
				</td>
				<td>
					<div style="font-size:11px;font-weight:bold;margin-bottom:4px;">Tahun</div>
					<select name="tahun">
						<option value="">Semua Tahun</option>
						<?php
						$sql = "SELECT DISTINCT(YEAR(berlaku_asuransi)) AS year FROM asuransi ORDER BY berlaku_asuransi ASC";
						$query = query($sql);
						while($data = mysqli_fetch_array($query)){
							?><option value="<?php echo $data['year'];?>"<?php echo $data['year'] == $_GET['tahun'] ? ' selected="selected"' : '';?>><?php echo $data['year'];?></option><?php
						}?>
					</select>
				</td>
				<td>
					<div style="font-size:11px;font-weight:bold;margin-bottom:4px;">&nbsp;</div>
					<input type="submit" value="Tampilkan"/>
				</td>
			</tr>
		</table>
	</form>
</div>

<?php
$title = '';
if($_GET['kendaraan']){
	$sql = "SELECT no_polisi FROM kendaraan WHERE id_kendaraan='{$_GET['kendaraan']}'";
	$query = query($sql);
	$data = mysqli_fetch_array($query);

	$title .= $data['no_polisi'];
}

if($_GET['tahun']){
	$title .= ' Tahun '.$_GET['tahun'];
}
?>
<h2 class="content-title"><span>Laporan Masa Berlaku asuransi<?php echo ($title ? '<br/>'.$title : '');?></span></h2>

<table border="1" class="list">
<tr>
	<th>No</th>
	<th>No.Polisi</th>
    <th>Berlaku asuransi</th> 
    <th>Biaya asuransi</th>
	<th>Tgl. Bayar</th>
    <th>Keterangan</th>
	<th class="print-hide">Detail</th> 
</tr>
<?php 
$whereClause = '';
if($_GET['kendaraan']){
	$whereClause[] = "k.id_kendaraan='{$_GET['kendaraan']}'";
}

if($_GET['tahun']){
	$whereClause[] = "YEAR(s.berlaku_asuransi)='{$_GET['tahun']}'";
}

if(is_array($whereClause)){
	$whereClause = ' WHERE '.implode(' AND ', $whereClause);
}

$no =1;

#prepare base sql query
$sql = "SELECT *
		FROM asuransi AS s
		JOIN kendaraan AS k ON s.id_kendaraan = k.id_kendaraan
		$whereClause
		ORDER BY berlaku_asuransi DESC";
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
		<td colspan="7" class="nodata">Belum ada data</td>
	</tr>
	<?php
} else {
	while($data = mysqli_fetch_array($query)){
        $angka = $data['biaya_asuransi'];
        $jumlah_desimal =0;
        $pemisah_desimal =",";
        $pemisah_ribuan =".";
		?>
		<tr class="<?php echo $data['status'];?>">
			<td align="center"><?php echo $no;?></td>
			<td><a href="javascript:void(0)" onClick="return popup('<?php echo BASEURL;?>/apps/kendaraan/detail.php?id_kendaraan=<?php echo $data['id_kendaraan'];?>', 'Detail Kendaraan', 500, 500)"><?php echo $data['no_polisi'];?></a></td>
			<td><?php echo date("d",strtotime($data['berlaku_asuransi'])) .' '.monthToId(date('m', strtotime($data['berlaku_asuransi']))). ' '.date('Y', strtotime($data['berlaku_asuransi']));?></td>   
			<td align="right"><span style="float:left">Rp</span><?php echo number_format($angka, $jumlah_desimal, $pemisah_desimal, $pemisah_ribuan); ?></td>
			<td><?php echo date("d",strtotime($data['tgl_pelaksanaan'])) .' '.monthToId(date('m', strtotime($data['tgl_pelaksanaan']))). ' '.date('Y', strtotime($data['tgl_pelaksanaan']));?></td>   
			<td>
				<?php 
				/// copas ke yg lain ajah
				if($data['keterangan']==NULL){
					echo "-";
				}
				else{
					echo $data['keterangan'];
				}
				?>
			</td>
			<td align="center"  class="print-hide"><a class="btn" href="?sub=asuransi_detail.php&id=<?php echo $data['id_fpk'];?>">Detail</a></td>   
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