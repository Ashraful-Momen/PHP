<?php 

session_start();

$_SESSION['Shuvo786']='786passwd';

print_r($_SESSION) ;

print_r("<br>".$_SESSION['Shuvo786']);

session_unset();

session_destroy();

echo "<br>session destroy now ";