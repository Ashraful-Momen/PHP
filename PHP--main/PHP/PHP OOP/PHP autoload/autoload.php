<?php

// require "classes/first.php";
// require "classes/second.php";


// $obj =new first();
// $obj =new second();

function __autoload($class){
    require "classes/".$class.".php"; // require "classes/first.php";
}

$obj =new first();
$obj =new second();