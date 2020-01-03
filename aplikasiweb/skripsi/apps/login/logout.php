<?php
session_start();
include "../../modules/config.php";

session_destroy();
header('location:'.APPURL);
exit;