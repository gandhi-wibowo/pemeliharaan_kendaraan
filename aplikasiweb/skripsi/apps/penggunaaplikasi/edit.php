<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/penggunaaplikasi/">Pengguna Aplikasi</a> &nbsp;&raquo;&nbsp;
    Edit data Pengguna Aplikasi
</div>

<h4 class="content-title">Form Edit Data Pengguna Aplikasi Kendaraan Operasional</h4>

<?php
    $sql = "SELECT * FROM user WHERE id_user='{$_POST['id_user']}'";
    $query = query($sql);
    $data = mysqli_fetch_array($query);
?>

<form action='action.php' method='POST'>
<input type='hidden' name='id_user' value="<?php echo $_POST['id_user']; ?>">
    <table cellpadding="5">
        <tr>
            <td width="200">Nama Pengguna</td>
            <td width="1">:</td>
            <td><input type='text' name='username' placeholder='' value="<?php echo $data['username']; ?>"size="50"></td>
        </tr>
        <tr>
            <td width="200">Nama Lengkap</td>
            <td width="1">:</td>
            <td><input type='text' name='namalengkap' placeholder='' value="<?php echo $data['namalengkap']; ?>"size="50"></td>
        </tr>
        <tr>
            <td width="200">Tipe Pengguna</td>
            <td width="1">:</td>
            <td>
                <select name="tipe_user">            
                <option value="">- Pilih Tipe Pengguna -</option>
                <option value="admin"<?php echo $data['tipe_user'] == 'admin' ? ' selected="selected"':'';?>>Admin</option>
                <option value="slapangan"<?php echo $data['tipe_user'] == 'slapangan' ? ' selected="selected"':'';?>>Petugas Lapangan</option>
                <option value="manager"<?php echo $data['tipe_user'] == 'manager' ? ' selected="selected"':'';?>>Manager</option>
                </select>
            </td>
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