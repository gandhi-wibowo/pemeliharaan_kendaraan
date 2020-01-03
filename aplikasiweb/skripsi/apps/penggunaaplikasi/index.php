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
	<title>Pengguna Aplikasi</title>
	<link rel="stylesheet" href="../../css/style.css?t=<?php echo time();?>" />
	<link rel="stylesheet" href="../../modules/pagination/paginator.css?t=<?php echo time();?>" />
</head>
<body>
	<?php require "../components/header.php";?>
	
	<div id="wrapper">
		<div id="container">
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
