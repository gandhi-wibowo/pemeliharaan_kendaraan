<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/asuransi/">Master Asuransi</a> &nbsp;&raquo;&nbsp;
    Edit Master Asuransi
</div>

<h4 class="content-title">Form Edit Data Master Asuransi</h4>

<?php
$sql = "SELECT * FROM master_asuransi WHERE id_master_asuransi='{$_POST['id_master_asuransi']}'";
$query = query($sql);
$data = mysqli_fetch_array($query);
?>

<form action='action.php' method='POST'>
<input type='hidden' name='id_master_asuransi' value="<?php echo $_POST['id_master_asuransi']; ?>">
<table cellpadding="5">
<tr>
    <td width="200">Nama Asuransi</td>
    <td width="1">:</td>
    <td><input type='text' name='nama_asuransi' placeholder='' value="<?php echo $data['nama_asuransi']; ?>" size="50"></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td><input type='submit' name='update' value='Simpan'></td>
</tr>
</table>
</form>