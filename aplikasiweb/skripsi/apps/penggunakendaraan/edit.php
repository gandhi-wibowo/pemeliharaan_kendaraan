<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/penggunakendaraan/">Pengguna Kendaraan Operasional</a> &nbsp;&raquo;&nbsp;
    Tambah Data Pengguna Kendaraan Operasional
</div>
<h4 class="content-title">Form Edit Data Pengguna Kendaraan Operasional</h4>

<?php
    $sql = "SELECT * FROM pengguna_kendaraan WHERE id_penggunakendaraan='{$_POST['id_penggunakendaraan']}'";
    $query = query($sql);
    $data = mysqli_fetch_array($query);
?>

<form action='action.php' method='POST'>
<input type='hidden' name='id_penggunakendaraan' value="<?php echo $_POST['id_penggunakendaraan']; ?>">
    <table cellpadding="5">
        <tr>
            <td width="200">Nama Pengguna</td>
            <td width="1">:</td>
            <td><input type='text' name='nama_pengguna' placeholder='' value="<?php echo $data['nama_pengguna']; ?>" size="50"></td>
        </tr>
        <tr>
            <td width="200">Jabatan Pengguna</td>
            <td width="1">:</td>
            <td><input type='text' name='jabatan_pengguna' placeholder='' value="<?php echo $data['jabatan_pengguna']; ?>" size="50"></td>
        </tr>
        <tr>
            <td width="200">No.Telp</td>
            <td width="1">:</td>
            <td><input type='text' name='no_telp' placeholder='' value="<?php echo $data['no_telp']; ?>"size="50"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><input type='submit' name='update' value='Simpan'></td>
        </tr>
    </table>
</form>