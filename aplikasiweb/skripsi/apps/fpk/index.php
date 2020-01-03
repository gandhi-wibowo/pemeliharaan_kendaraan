<?php
#page id
$page = basename(__DIR__);

session_start();
require '../../modules/config.php';
require '../../modules/connect.php';
require '../../modules/library.php';
require '../../modules/pagination/paginator.php';
require '../components/auth.php';
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Form Pengajuan Kerja</title>
	<link rel="stylesheet" href="../../css/style.css?t=<?php echo time();?>" />
	<link rel="stylesheet" href="../../css/jquery.datepicker.css?t=<?php echo time();?>" />
	<link rel="stylesheet" href="../../modules/pagination/paginator.css?t=<?php echo time();?>" />
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type="text/javascript" src="../../js/jquery.datepicker.js"></script>
	<script type="text/javascript" src="../../js/date.js"></script>
	<script type="text/javascript" src="../../js/function.js"></script>
	<script type="text/javascript">
		$(function(){
			$('.datepicker').datePicker();
		});
	</script>
</head>
<body>
	<?php require "../components/header.php";?>
	
	<div id="wrapper">
		<div id="sidebar">
			<h3>Jenis FPK</h3>
			<ul>
				<?php
				$countFPKStnk = countFPK('stnk');
				$countFPKPajak = countFPK('pajak');
				$countFPKKir = countFPK('kir');
				$countFPKService = countFPK('service');
				$countFPKAsuransi = countFPK('asuransi');
				?>
				<li><a href="?sub=list.php&type=stnk"<?php echo $_GET['type'] == 'stnk' ? ' class="active"' : '';?>>FPK Perpanjangan STNK<?php echo $countFPKStnk > 0 ? '<span class="count">'.$countFPKStnk.'</span>':'';?></a></li>
				<li><a href="?sub=list.php&type=pajak"<?php echo $_GET['type'] == 'pajak' ? ' class="active"' : '';?>>FPK Permbayaran Pajak<?php echo $countFPKPajak > 0 ? '<span class="count">'.$countFPKPajak.'</span>':'';?></a></li>
				<li><a href="?sub=list.php&type=kir"<?php echo $_GET['type'] == 'kir' ? ' class="active"' : '';?>>FPK Perngujian KIR<?php echo $countFPKKir > 0 ? '<span class="count">'.$countFPKKir.'</span>':'';?></a></li>
				<li><a href="?sub=list.php&type=service"<?php echo $_GET['type'] == 'service' ? ' class="active"' : '';?>>FPK Service Kendaraan<?php echo $countFPKService > 0 ? '<span class="count">'.$countFPKService.'</span>':'';?></a></li>
				<li><a href="?sub=list.php&type=asuransi"<?php echo $_GET['type'] == 'asuransi' ? ' class="active"' : '';?>>FPK Pembayaran Asuransi<?php echo $countFPKAsuransi > 0 ? '<span class="count">'.$countFPKAsuransi.'</span>':'';?></a></li>
			</ul>
		</div>

		<div id="container" style="margin-left:245px;">
			<?php
			$path = 'default.php';
			if($_GET['sub'] and is_file($_GET['sub'])){
				$path = basename($_GET['sub']);
			}

			require $path;
			?>
		</div>
	</div>   

	<?php require '../components/footer.php';?>
</body>
</html>
