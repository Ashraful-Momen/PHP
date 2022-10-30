<?php
require "first.php";
require "second.php";

$obj=new first\test();
$obj->show();

$obj2= new second\test2();

$obj2->show();