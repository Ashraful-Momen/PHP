<?php
$cookie_name = "user";
$cookie_value = "Ashraful Momen";

setcookie($cookie_name,$cookie_value,time() + (86400 * 30), "/"); # '+' not delete the cookie untile expire the time and '-' sign use for delete the cookie with one time browsing  
?>

<html>
<body>
    <?php
        if(!isset($_COOKIE[$cookie_name])){
            echo "Cookie is not set";
        }else {
            echo $_COOKIE[$cookie_name];
        }
    ?>
</body>
</html>