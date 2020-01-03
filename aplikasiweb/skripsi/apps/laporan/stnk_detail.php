<?php
$sql = "SELECT *
		FROM stnk s
		JOIN kendaraan k ON s.id_kendaraan = k.id_kendaraan
		WHERE id_stnk='{$_GET['id']}'";
$query = query($sql);
$data = mysqli_fetch_array($query);
?>
<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/laporan/">Laporan</a> &nbsp;&raquo;&nbsp;
	<a href="<?php echo APPURL;?>/laporan/?sub=stnk.php">Laporan Masa Berlaku STNK</a> &nbsp;&raquo;&nbsp;
	<?php echo $data['no_polisi'];?>
</div>

<?php require('info_fpk.inc.php');?>
