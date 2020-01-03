<?php
    include('../../modules/phpqrcode/qrlib.php'); 
     
    // outputs image directly into browser, as PNG stream 
    if($_GET['text']){
    	QRcode::png($_GET['text'], false, 4,6);
    	#QRcode::png($_GET['text']);
	}
 ?>