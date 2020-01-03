<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/penggunakendaraan/">Pengguna Kendaraan Operasional</a> &nbsp;&raquo;&nbsp;
    Tambah Data Pengguna Kendaraan Operasional
</div>

<h4 class="content-title">Form Tambah Data Pengguna Kendaraan Operasional</h4>
<form action='action.php' method='POST'>
    <table cellpadding="5">
        <tr>
            <td width="200"><span class="asterisk">*</span>Nama Pengguna</td>
            <td width="1">:</td>
            <td><input type='text' name='nama_pengguna' placeholder='' size="50"></td>
        </tr>
        <tr>
            <td width="200"><span class="asterisk">*</span>Jabatan Pengguna</td>
            <td width="1">:</td>
            <td><input type='text' name='jabatan_pengguna' placeholder='' size="50"></td>
        </tr>
        <tr>
            <td width="200"><span class="asterisk">*</span>No.Telp</td>
            <td width="1">:</td>
            <td><input type='text' name='no_telp' placeholder='' size="50"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><input type='submit' name='insert' value='Simpan'></td>
        </tr>
    </table>
</form>
