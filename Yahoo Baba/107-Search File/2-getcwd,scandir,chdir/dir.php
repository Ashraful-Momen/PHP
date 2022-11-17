<?php

// echo getcwd(); // get current working directokry.

// echo chdir('js');

// echo getcwd();

// echo chdir('../');

// echo getcwd();
#-----------------print all current folder elements-------------------

// $dir = ".";

// $a = scandir($dir);

// echo "<pre>";
// print_r($a);
// echo "</pre>";
#-----------------print all previous folder elements-------------------

// $dir = "../";

// $a = scandir($dir);

// echo "<pre>";
// print_r($a);
// echo "</pre>";
#-----------------print all  folder elements-------------------

// $dir = "../2-getcwd,scandir,chdir/";

// echo getcwd();
// $a = scandir($dir);

// echo "<pre>";
// print_r($a);
// echo "</pre>";
//-------------------------------
$dir = "../";  //------- change order -- descending

$c = scandir($dir,1);

echo "<pre>";
print_r($c);
echo "</pre>";



?>