<?php
$sql = "SELECT * FROM kendaraan WHERE id_kendaraan='{$_POST['id_kendaraan']}'";
$query = query($sql);
$data = mysqli_fetch_array($query);

$masterData = array();
$tables = array('stnk', 'pajak', 'kir', 'service', 'asuransi');
foreach($tables as $table){
    #check each table
    $sqlx = "SELECT * FROM `{$table}` WHERE id_kendaraan='{$_POST['id_kendaraan']}' AND status='active' AND id_fpk=0";
    $queryx = query($sqlx);
    $row = mysqli_num_rows($queryx);
    $masterData[$table] = array(
        'record' =>  mysqli_fetch_array($queryx),
        'editable' => ($row <= 1) ? true : false
    );
}
?>

<div class="breadcrumb">
    <a href="<?php echo APPURL;?>/kendaraan/">Kendaraan</a> &nbsp;&raquo;&nbsp;
    Edit Kendaraan
</div>

<h4 class="content-title">Form Edit Data Kendaraan</h4>

<form action='action.php' method='POST'>
    <input type='hidden' name='id_kendaraan' value="<?php echo $_POST['id_kendaraan']; ?>">

     <div class="block">
        <table cellpadding="5">
            <tr>
                <td width="200">No.Polisi</td>
                <td width="1">:</td>
                <td><input type='text' name='no_polisi' placeholder='no_polisi' value="<?php echo $data['no_polisi']; ?>"></td>
            </tr>
            <tr>
                <td width="200"></span>Pengguna Kendaraan</td>
                <td width="1">:</td>
                <td>
                    <select name="penggunakendaraan">
                        <option value="">- Pilih Pengguna Kendaraan -</option>
                        <?php
                        $sql = "SELECT * FROM pengguna_kendaraan ORDER BY nama_pengguna ASC";
                        $query = query($sql);
                        while($datas = mysqli_fetch_array($query)){
                            ?><option <?php if($data['id_penggunakendaraan']==$datas['id_penggunakendaraan']){echo "selected";} ?> value="<?php echo $datas['id_penggunakendaraan'];?>"><?php echo $datas['nama_pengguna'];?></option><?php
                        }?>
                    </select>                
                </td>
            </tr>            
            <tr>
                <td>Nama STNK</td>
                <td>:</td>
                <td><input type='text' name='nama_stnk' placeholder='nama_stnk' value="<?php echo $data['nama_stnk']; ?>"></td>
            </tr>
            <tr>
                <td>Merk</td>
                <td>:</td>
                <td><input type='text' name='merk' placeholder='merk' value="<?php echo $data['merk']; ?>"></td>
            </tr>
            <tr>
                <td>Jenis Kendaraan</td>
                <td>:</td>
                <td>
                    <select name="jenis">
                        <option value="">- Pilih Jenis Kendaraan -</option>
                        <option value="mobil"<?php echo $data['jenis'] == 'mobil' ? ' selected="selected"':'';?>>Mobil</option>
                        <option value="truk"<?php echo $data['jenis'] == 'truk' ? ' selected="selected"':'';?>>Truk</option>
                        <option value="motor"<?php echo $data['jenis'] == 'motor' ? ' selected="selected"':'';?>>Sepeda Motor</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Tahun Pembuatan</td>
                <td>:</td>
                <td><input type='text' name='tahun_pembuatan' placeholder='tahun_pembuatan' value="<?php echo $data['tahun_pembuatan']; ?>"></td>
            </tr>
            <tr>
                <td>No.Rangka</td>
                <td>:</td>
                <td><input type='text' name='no_rangka' placeholder='no_rangka' value="<?php echo $data['no_rangka']; ?>"></td>
            </tr>
            <tr>
                <td>No.Mesin</td>
                <td>:</td>
                <td><input type='text' name='no_mesin' placeholder='no_mesin' value="<?php echo $data['no_mesin']; ?>"></td>
            </tr>
        </table>
    </div>
    <div class="block">
        <table cellpadding="5">
            <tr>
                <td>Posisi STNK</td>
                <td>:</td>
                <td><input type='text' name='posisi_stnk' placeholder='posisi_stnk' value="<?php echo $data['posisi_stnk']; ?>"></td>
            </tr>
            <tr>
                <td>Nama BPKB</td>
                <td>:</td>
                <td><input type='text' name='nama_bpkb' placeholder='nama_bpkb' value="<?php echo $data['nama_bpkb']; ?>"></td>
            </tr>
            <tr>
                <td>Posisi BPKB</td>
                <td>:</td>
                <td><input type='text' name='posisi_bpkb' placeholder='posisi_bpkb' value="<?php echo $data['posisi_bpkb']; ?>"></td>
            </tr>
            <tr>
                <td>Status Kendaraan</td>
                <td>:</td>
                <td><input type='text' name='status_kendaraan' placeholder='status_kendaraan' value="<?php echo $data['status_kendaraan']; ?>"></td>
            </tr>
            <tr>
                <td>Asuransi</td>
                <td>:</td>
                <td>
                    <select name="asuransi">
                        <option value="0">- Pilih Asuransi-</option>
                        <?php
                        $sql = "SELECT * FROM master_asuransi ORDER BY nama_asuransi ASC";
                        $query = query($sql);
                        while($datax = mysqli_fetch_array($query)){
                            ?><option value="<?php echo $datax['id_master_asuransi'];?>"<?php echo $datax['id_master_asuransi'] == $data['id_master_asuransi'] ? ' selected="selected"':'';?>><?php echo $datax['nama_asuransi'];?></option><?php
                        }?>
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <div style="clear:both"></div>
    <br/><br/>

    <div id="tab-container">
        <ul class="tab-nav">
            <?php
            if($masterData['stnk']['editable']){
                ?><li><a href="#tab-stnk">Informasi STNK</a></li><?php
            }

            if($masterData['pajak']['editable']){
                ?><li><a href="#tab-pajak">Informasi Pajak</a></li><?php
            }
            if($masterData['service']['editable']){
                ?><li><a href="#tab-service">Informasi Service</a></li><?php
            }

            if($masterData['kir']['editable']){
                ?><li><a href="#tab-kir">Informasi KIR</a></li><?php
            }
            
            if($masterData['asuransi']['editable']){
                ?><li><a href="#tab-asuransi">Informasi Asuransi</a></li><?php
            }?>
        </ul>

        <div id="target">
             <?php
            if($masterData['stnk']['editable']){
                $datax = $masterData['stnk']['record'];
                ?>                
                <div id="tab-stnk" class="tab">
                    <input type="hidden" name="info[stnk][id]" value="<?php echo $datax['id_stnk'];?>" />
                    <i class="note">Masukkan informasi mengenai pembayaran STNK kendaraan (*Jika ada).</i><br/><br/>
                    <table cellpadding="7">
                        <tr>
                            <td width="230"><span class="asterisk">*</span>Tanggal Pembayaran STNK</td>
                            <td width="1">:</td>
                            <td><input type='text' name='info[stnk][tgl_pelaksanaan]' placeholder='' size="30" class="datepicker" value="<?php echo $datax['tgl_pelaksanaan'] ? date('d/m/Y', strtotime($datax['tgl_pelaksanaan'])) : '';?>" readonly></td>
                        </tr>
                        <tr>
                            <td><span class="asterisk">*</span>Berlaku Hingga</td>
                            <td>:</td>
                            <td><input type='text' name='info[stnk][tgl_berlaku]' placeholder='' size="30" class="datepicker" value="<?php echo $datax['berlaku_stnk'] ? date('d/m/Y', strtotime($datax['berlaku_stnk'])) : '';?>" readonly></td>
                        </tr>
                        <tr>
                            <td><span class="asterisk">*</span>Biaya</td>
                            <td>:</td>
                            <td>Rp <input type='text' name='info[stnk][biaya]' placeholder='' size="30" value="<?php echo $datax['biaya_stnk'];?>"></td>
                        </tr>
                        <tr valign="top">
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><textarea name="info[stnk][keterangan]" cols="50" rows="4" maxlength="255"><?php echo $datax['keterangan'];?></textarea></td>
                        </tr>
                    </table>
                </div>
                <?php
            }?>

            <?php
            if($masterData['pajak']['editable']){
                $datax = $masterData['pajak']['record'];
                ?>         
                <div id="tab-pajak" class="tab">
                    <input type="hidden" name="info[pajak][id]" value="<?php echo $datax['id_pajak'];?>" />
                    <i class="note">Masukkan informasi mengenai pembayaran Pajak kendaraan (*Jika ada).</i><br/><br/>
                    <table cellpadding="7">
                        <tr>
                            <td width="230"><span class="asterisk">*</span>Tanggal Pembayaran Pajak</td>
                            <td width="1">:</td>
                            <td><input type='text' name='info[pajak][tgl_pelaksanaan]' placeholder='' size="30" class="datepicker" value="<?php echo $datax['tgl_pelaksanaan'] ? date('d/m/Y', strtotime($datax['tgl_pelaksanaan'])) : '';?>" readonly></td>
                        </tr>
                        <tr>
                            <td><span class="asterisk">*</span>Berlaku Hingga</td>
                            <td>:</td>
                            <td><input type='text' name='info[pajak][tgl_berlaku]' placeholder='' size="30" class="datepicker" value="<?php echo $datax['berlaku_pajak'] ? date('d/m/Y', strtotime($datax['berlaku_pajak'])) : '';?>" readonly></td>
                        </tr>
                        <tr>
                            <td><span class="asterisk">*</span>Biaya</td>
                            <td>:</td>
                            <td>Rp <input type='text' name='info[pajak][biaya]' placeholder='' size="30" value="<?php echo $datax['biaya_pajak'];?>"></td>
                        </tr>
                        <tr valign="top">
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><textarea name="info[pajak][keterangan]" cols="50" rows="4" maxlength="255"><?php echo $datax['keterangan'];?></textarea></td>
                        </tr>
                    </table>
                </div>
                <?php
            }?>

            <?php
            if($masterData['kir']['editable']){
                $datax = $masterData['kir']['record'];
                ?>    
                <div id="tab-kir" class="tab">
                    <input type="hidden" name="info[kir][id]" value="<?php echo $datax['id_kir'];?>" />
                    <i class="note">Masukkan informasi mengenai pembayaran KIR kendaraan (*Jika ada).</i><br/><br/>
                    <table cellpadding="7">
                        <tr>
                            <td width="230"><span class="asterisk">*</span>Tanggal Pembayaran KIR</td>
                            <td width="1">:</td>
                            <td><input type='text' name='info[kir][tgl_pelaksanaan]' placeholder='' size="30" class="datepicker" value="<?php echo $datax['tgl_pelaksanaan'] ? date('d/m/Y', strtotime($datax['tgl_pelaksanaan'])) : '';?>" readonly></td>
                        </tr>
                        <tr>
                            <td><span class="asterisk">*</span>Berlaku Hingga</td>
                            <td>:</td>
                            <td><input type='text' name='info[kir][tgl_berlaku]' placeholder='' size="30" class="datepicker" value="<?php echo $datax['berlaku_kir'] ? date('d/m/Y', strtotime($datax['berlaku_kir'])) : '';?>" readonly></td>
                        </tr>
                        <tr>
                            <td><span class="asterisk">*</span>Biaya</td>
                            <td>:</td>
                            <td>Rp <input type='text' name='info[kir][biaya]' placeholder='' size="30" value="<?php echo $datax['biaya_kir'];?>"></td>
                        </tr>
                        <tr valign="top">
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><textarea name="info[kir][keterangan]" cols="50" rows="4" maxlength="255"><?php echo $datax['keterangan'];?></textarea></td>
                        </tr>
                    </table>
                </div>
                <?php
            }?>

            <?php
            if($masterData['service']['editable']){
                $datax = $masterData['service']['record'];
                ?>    
                <div id="tab-service" class="tab">
                    <input type="hidden" name="info[service][id]" value="<?php echo $datax['id_service'];?>" />
                    <i class="note">Masukkan informasi mengenai pembayaran SERVICE kendaraan (*Jika ada).</i><br/><br/>
                    <table cellpadding="7">
                        <tr>
                            <td width="230"><span class="asterisk">*</span>Tanggal Pembayaran service</td>
                            <td width="1">:</td>
                            <td><input type='text' name='info[service][tgl_pelaksanaan]' placeholder='' size="30" class="datepicker" value="<?php echo $datax['tgl_pelaksanaan'] ? date('d/m/Y', strtotime($datax['tgl_pelaksanaan'])) : '';?>" readonly></td>
                        </tr>
                        <tr>
                            <td><span class="asterisk">*</span>Berlaku Hingga</td>
                            <td>:</td>
                            <td><input type='text' name='info[service][tgl_berlaku]' placeholder='' size="30" class="datepicker" value="<?php echo $datax['berlaku_service'] ? date('d/m/Y', strtotime($datax['berlaku_service'])) : '';?>" readonly></td>
                        </tr>
                        <tr>
                            <td><span class="asterisk">*</span>Biaya</td>
                            <td>:</td>
                            <td>Rp <input type='text' name='info[service][biaya]' placeholder='' size="30" value="<?php echo $datax['biaya_service'];?>"></td>
                        </tr>
                        <tr valign="top">
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><textarea name="info[service][keterangan]" cols="50" rows="4" maxlength="255"><?php echo $datax['keterangan'];?></textarea></td>
                        </tr>
                    </table>
                </div>
                <?php
            }?>

            <?php
            if($masterData['asuransi']['editable']){
                $datax = $masterData['asuransi']['record'];
                ?>    
                <div id="tab-asuransi" class="tab">
                    <input type="hidden" name="info[asuransi][id]" value="<?php echo $datax['id_asuransi'];?>" />
                    <i class="note">Masukkan informasi mengenai pembayaran ASURANSI kendaraan (*Jika ada).</i><br/><br/>
                    <table cellpadding="7">
                        <tr>
                            <td width="230"><span class="asterisk">*</span>Tanggal Pembayaran asuransi</td>
                            <td width="1">:</td>
                            <td><input type='text' name='info[asuransi][tgl_pelaksanaan]' placeholder='' size="30" class="datepicker" value="<?php echo $datax['tgl_pelaksanaan'] ? date('d/m/Y', strtotime($datax['tgl_pelaksanaan'])) : '';?>" readonly></td>
                        </tr>
                        <tr>
                            <td><span class="asterisk">*</span>Berlaku Hingga</td>
                            <td>:</td>
                            <td><input type='text' name='info[asuransi][tgl_berlaku]' placeholder='' size="30" class="datepicker" value="<?php echo $datax['berlaku_asuransi'] ? date('d/m/Y', strtotime($datax['berlaku_asuransi'])) : '';?>" readonly></td>
                        </tr>
                        <tr>
                            <td><span class="asterisk">*</span>Biaya</td>
                            <td>:</td>
                            <td>Rp <input type='text' name='info[asuransi][biaya]' placeholder='' size="30" value="<?php echo $datax['biaya_asuransi'];?>"></td>
                        </tr>
                        <tr valign="top">
                            <td>Keterangan</td>
                            <td>:</td>
                            <td><textarea name="info[asuransi][keterangan]" cols="50" rows="4" maxlength="255"><?php echo $datax['keterangan'];?></textarea></td>
                        </tr>
                    </table>
                </div>
                 <?php
            }?>
        </div>
    </div>

    <div style="margin:20px;text-align:center">
        <input type='submit' name='update' value='Simpan'>
    </div>
</form>