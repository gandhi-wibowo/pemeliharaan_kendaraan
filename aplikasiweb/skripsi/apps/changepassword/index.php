<?php
#page id
$page = basename(__DIR__);

session_start();
require '../../modules/config.php';
require '../../modules/connect.php';
require '../../modules/library.php';
require '../components/auth.php';
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Ganti Password</title>
	<link rel="stylesheet" href="../../css/style.css?t=<?php echo time();?>" />
</head>
<body>
	<?php require "../components/header.php";?>
	
	<div id="wrapper">
		<div id="container">
			<h4 class="content-title">Form Ganti Password</h4>

			 <form action="action.php" method="POST">
				<table cellpadding="5">
					<tr>
						<td width="200">Password lama</td>
						<td>: <input type="password" name="password_lama" size="40"></td>
					</tr>
					<tr>
						<td>Password baru</td>
						<td>: <input type="password" name="password_baru" size="40"></td>
					</tr>
					<tr>
						<td>Konfirmasi password baru</td>
						<td>: <input type="password" name="password_barulagi" size="40"></td>
					</tr>
					<tr>
						<td />
						<td>&nbsp;&nbsp;<input class="btn btn-submit "type="submit" name="submit" value="Ganti Password"></td>
					</tr>
				</table>
			</form>
		</div>
	</div>   

	<?php require '../components/footer.php';?>
</body>
</html>
