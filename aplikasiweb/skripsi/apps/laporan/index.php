<?php
#page id
$page = basename(__DIR__);

session_start();
include "../../modules/config.php";
include "../../modules/connect.php";
include "../../modules/library.php";
require '../../modules/pagination/paginator.php';
require '../components/auth.php';
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Laporan</title>
	<link rel="stylesheet" href="../../css/style.css?t=<?php echo time();?>" />
	<link rel="stylesheet" href="../../modules/pagination/paginator.css?t=<?php echo time();?>" />
	<script type="text/javascript" src="../../js/function.js"></script>
</head>
<body>
	<?php include "../components/header.php";?>

	<div id="wrapper">
		<div id="sidebar">
			<h3>Daftar Laporan</h3>
			<ul>
				<li><a href="?sub=stnk.php"<?php echo strpos($_GET['sub'], 'stnk') !== false ? ' class="active"' : '';?>>Laporan Masa Berlaku STNK</a></li>
				<li><a href="?sub=pajak.php"<?php echo strpos($_GET['sub'], 'pajak') !== false ? ' class="active"' : '';?>>Laporan Masa Berlaku Pajak</a></li>
				<li><a href="?sub=kir.php"<?php echo strpos($_GET['sub'], 'kir') !== false ? ' class="active"' : '';?>>Laporan Masa Berlaku KIR</a></li>
				<li><a href="?sub=service.php"<?php echo strpos($_GET['sub'], 'service') !== false ? ' class="active"' : '';?>>Laporan Masa Berlaku Service</a></li>
				<li><a href="?sub=asuransi.php"<?php echo strpos($_GET['sub'], 'asuransi') !== false ? ' class="active"' : '';?>>Laporan Masa Berlaku Asuransi</a></li>
				<li><a href="?sub=fpk.php"<?php echo strpos($_GET['sub'], 'fpk') !== false ? ' class="active"' : '';?>>Laporan FPK</a></li>
				<li><a href="?sub=scan.php"<?php echo strpos($_GET['sub'], 'scan') !== false ? ' class="active"' : '';?>>History Scan Barcode</a></li>
				<li><a href="?sub=notifikasi.php"<?php echo strpos($_GET['sub'], 'notifikasi') !== false ? ' class="active"' : '';?>>Notifikasi</a></li>
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
