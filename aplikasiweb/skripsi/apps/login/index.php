<?php
#page id
$page = basename(__DIR__);

session_start();
include "../../modules/config.php";
include "../../modules/connect.php";
include "../../modules/library.php";
include "../components/auth.php";
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>SISFO KENDARAAN OPERASIONAL PT.BGP - Login</title>
	<link rel="stylesheet" href="../../css/style.login.css" />
</head>
<body>
	<div id="bg"></div>
	<div id="box">
		<div id="contentBox-header"><div>HALAMAN LOGIN</div></div>
		<div id="contentBox">
			<form name="login" action="action.php" method="post" id="loginform">
				<table cellpadding="3" cellspacing="5">
				<tr>
					<td>
						<label>Username</label>
						<input type="text" name="username" size="32"/>
					</td>
				</tr>
				<tr>
					<td>
						<div style="margin-top:10px;">
							<label>Password</label>
							<input type="password" name="password" size="32"/>
						</div>
					</td>
				</tr>
				<tr>
					<td><input type="submit" value=" Login "/></td>
				</tr>
				</table>
			</form>
		</div>

		<div class="footer">SISFO KENDARAAN OPERASIONAL PT.BGP</div>
	</div>
</body>
</html>

