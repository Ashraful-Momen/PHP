<?php
require "first.php";
require "second.php";

//Namespace help to call class,function ... etc one php file to another php file . 
//in first.php file has namespace first; and another function name is test(). 
//now if we want to call first.php classe->function into the third.php file , then we just create object. 

$obj=new first\test();
$obj->show();

$obj2= new second\test2();

$obj2->show();
