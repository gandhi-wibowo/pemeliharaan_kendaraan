<?php
session_start();
include "../../modules/config.php";

if(empty($_SESSION['id_user'])){
    if($page != 'login'){
        header('location:'.APPURL.'/login/');
        exit;
    }
} else {
    /*if(empty($page)){
        die('page id is missing!');
    } elseif(($page == 'login' or $page == 'dashboard') or ($page != $_SESSION['tipe_user'])){
        // header('location:'.BASEURL.'/'.$_SESSION['tipe_user'].'/');
        exit;
    }*/
}
?>
