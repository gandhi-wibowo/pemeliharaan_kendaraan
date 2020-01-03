<ul id="content-menu">
	<li><a class="btn" href='javascript:print()'>Cetak Halaman</a></li>
</ul>

<h2 class="content-title">
	<span>Data Kode QR Kendaraan PT.Bangun Globalindo Perkasa (BGP)</span>
</h2>

<div style="text-align:center;margin-left:35px;margin-top:50px">
	<?php
	$no = 1;
	$sql = "SELECT * FROM kendaraan";
	$query = query($sql);
	if(mysqli_num_rows($query) == 0){
		?>
		Belum ada data
		<?php
	} else {
		while($data = mysqli_fetch_array($query)){
			?>
			<div class="qrlist">
				<img src="qrcode_generator.php?text=<?php echo $data['no_polisi'];?>"/>
				<div class="label"><span><?php echo strtoupper($data['no_polisi']);?></span></div>
			</div>
			<?php
		}
	}
	?>
</div>