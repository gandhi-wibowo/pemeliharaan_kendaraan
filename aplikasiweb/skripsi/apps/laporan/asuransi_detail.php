<?php
$sql = "SELECT *
		FROM asuransi s
		JOIN kendaraan k ON s.id_kendaraan = k.id_kendaraan
		WHERE id_asuransi='{$_GET['id']}'";
$query = query($sql);
$data = mysqli_fetch_array($query);
?>
<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/laporan/">Laporan</a> &nbsp;&raquo;&nbsp;
	<a href="<?php echo APPURL;?>/laporan/?sub=asuransi.php">Laporan Masa Berlaku asuransi</a> &nbsp;&raquo;&nbsp;
	<?php echo $data['no_polisi'];?>
</div>

<?php require('info_fpk.inc.php');?>
