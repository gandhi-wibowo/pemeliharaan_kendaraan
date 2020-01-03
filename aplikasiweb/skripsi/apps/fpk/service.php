<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/fpk/">FPK</a> &nbsp;&raquo;&nbsp;
    <a href="<?php echo APPURL;?>/fpk/?sub=list.php&type=service">FPK Perpanjangan SERVICE</a> &nbsp;&raquo;&nbsp;
    Input data perpanjangan SERVICE
</div>

<?php require('info_fpk.inc.php');?>

<div class="history-block">
	<a href="<?php echo APPURL;?>/laporan/?sub=service.php&kendaraan=<?php echo $fpk['id_kendaraan'];?>" target="_blank"><b>Klik disini</b></a> untuk melihat history pembayaran SERVICE kendaraan periode sebelumnya.
</div>

<h4 class="content-title">Form Input Data Perpanjangan SERVICE</h4>

<form action='action.php' method='POST'>
<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
<table cellpadding="5">
<tr>
    <td width="200"><span class="asterisk">*</span>Tanggal Pembayaran</td>
    <td width="1">:</td>
    <td><input type='text' name='tgl_pelaksanaan' placeholder='' size="30" class="datepicker" value="<?php echo date('d/m/Y', $tgl_selesai);?>" readonly></td>
</tr>
<?php
$sekarang = date("Y-m-d", $tgl_selesai);
$ditambah = strtotime('+6 month' , strtotime ($sekarang));
?>
<tr>
    <td><span class="asterisk">*</span>Berlaku Hingga</td>
    <td>:</td>
    <td><input type='text' name='tgl_berlaku' placeholder='' size="30" class="datepicker" readonly value="<?php echo date("d/m/Y", $ditambah); ?>"></td>
</tr>
<tr>
    <td><span class="asterisk">*</span>Biaya</td>
    <td>:</td>
    <td><input type='text' name='biaya' placeholder='' size="30"></td>
</tr>
<tr valign="top">
    <td>Keterangan</td>
    <td>:</td>
    <td>
    	<textarea name="keterangan" cols="50" rows="4" maxlength="255"></textarea>
    </td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td><input type='submit' name='insert' value='Simpan'></td>
</tr>
</table>
</form>