<?php

echo "Name: ".$_REQUEST['name']."<br>";
echo "Number: ".$_REQUEST['number']."<br>";
echo "Number: ".$_REQUEST['number']."<br>";
echo "ID : ".$_REQUEST['id']."<br>";

echo "<pre>";
print_r( $_SERVER) ;
echo "</pre>";




#get method: mainly use search url which is not need to secure
#post method: use for securely data passing like form (username, password,email etc);


#$_REQUEST[]: can receive get/post both of methods ... even also can get including url pass variable value
# example: action="getdata.php?id=5" also possible to display the value : $_REQUEST['id']


#$_SERVER[]: user to know details about : 1.HTTP connection, 2.SERVER Information 3.HOST Information 4.URL information

# [PHP_SELF] => Working Page or file => PRINT EXAMPLE : /Ashraful/Yahoo Baba/99-Super Global variable/getdata.php