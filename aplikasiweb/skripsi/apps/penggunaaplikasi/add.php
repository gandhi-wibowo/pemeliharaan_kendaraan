<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/penggunaaplikasi/">Pengguna Aplikasi</a> &nbsp;&raquo;&nbsp;
    Tambah data Pengguna Aplikasi
</div>

<h4 class="content-title">Form Tambah Data Pengguna Aplikasi Kendaraan Operasional</h4>

<form action='action.php' method='POST'>
<table cellpadding="5">
<tr>
    <td width="200"><span class="asterisk">*</span>Nama Pengguna</td>
    <td width="1">:</td>
    <td><input type='text' name='username' placeholder='' size="50"></td>
</tr>
<tr>
    <td width="200"><span class="asterisk">*</span>Nama Lengkap</td>
    <td width="1">:</td>
    <td><input type='text' name='namalengkap' placeholder='' size="50"></td>
</tr>
<tr>
    <td><span class="asterisk">*</span>Tipe Pengguna</td>
    <td>:</td>
    <td>
        <select name="tipe_user">
            <option value="">- Pilih Tipe Pengguna -</option>
            <option value="admin">Admin</option>
            <option value="slapangan">Petugas Lapangan</option>
            <option value="manager">Manager</option>
        </select>
    </td>
</tr>
<tr>
    <td width="200"><span class="asterisk">*</span>No.Telp</td>
    <td width="1">:</td>
    <td><input type='text' name='no_telp' placeholder='' size="50"></td>
</tr>
<tr>
    <td width="200"><span class="asterisk">*</span>Password</td>
    <td width="1">:</td>
    <td><input type='password' name='password' placeholder='' size="50"></td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td><input type='submit' name='insert' value='Simpan'></td>
</tr>
</table>
</form>
