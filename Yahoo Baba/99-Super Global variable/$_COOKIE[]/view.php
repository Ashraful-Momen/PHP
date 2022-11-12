<?php
 echo "Cookie Value :" . $_COOKIE['user'];



 setcookie("user","" ,time() + (86400 * 30), "/");
?>