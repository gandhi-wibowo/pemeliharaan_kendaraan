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
	<title>Kendaraan</title>
	<link rel="stylesheet" href="../../css/style.css?t=<?php echo time();?>" />
	<link rel="stylesheet" href="../../css/jquery.datepicker.css?t=<?php echo time();?>" />
	<link rel="stylesheet" href="../../modules/pagination/paginator.css?t=<?php echo time();?>" />
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type="text/javascript" src="../../js/jquery.datepicker.js"></script>
	<script type="text/javascript" src="../../js/date.js"></script>
	<script type="text/javascript" src="../../js/function.js"></script>

	<style>
	.block{
		width:48%;
		float:left;
	}

    #tab-container{
       
    }

    .tab-nav{
        padding:0;
        margin:0;
        border-bottom:2px solid #187dbb;
        background-color:#2F3D44;
    }

    .tab-nav li{
        display:inline-block;
        margin:0;
        padding:0;
    }

    .tab-nav li a{
        padding:13px 20px;
        display:block;
        background-color:#2F3D44;
        color:#fff;
        text-decoration:none;
        font-size:11px;
        font-weight:bold;
    }

    .tab-nav li a.active{
        background-color:#187dbb;
    }

    .tab{
        display:none;
        padding:25px 15px;
        overflow:hidden;
        border:1px dotted #187dbb;
        border-top:0;
    }
</style>
<script>
		$(document).ready(function(){
			var c = $('#tab-container');
			c.find('.tab-nav a').click(function(e){
				var hash = $(this).attr('href');
				window.location.hash = hash;
				e.preventDefault();
				
				c.find('.tab').hide();
				current = $(this).attr('data-target');

				c.find(hash).show();
				c.find('.tab-nav a').removeClass('active');
				$(this).addClass('active');
			});

			var urlhash = window.location.hash;
			if(urlhash){
				$("a[href='"+ urlhash +"']").trigger('click');
			}

			c.find('li:first-child a').trigger('click');
			$('html, body').animate({scrollTop:0},500);
			if(c.find('ul li').length == 0){
				c.hide();
			}
		});

		$(function(){
			$('.datepicker').datePicker();

			$('.delete').submit(function(e){
				if(! confirm('Anda yakin ingin menghapus kendaraan ini?')){
					e.preventDefault();
					return;
				}
				
			})
		});
	</script>
</head>
<body>
	<?php require "../components/header.php";?>
	
	<div id="wrapper">
		<div id="sidebar">
			<h3>Menu</h3>
			<ul>
				<li><a href="?sub=default.php"<?php echo ($_GET['sub'] != 'qrcode.php') ? ' class="active"' : '';?>>Data Kendaraan</a></li>
				<li><a href="?sub=qrcode.php"<?php echo $_GET['sub'] == 'qrcode.php' ? ' class="active"' : '';?>>Data kode QR</a></li>
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
