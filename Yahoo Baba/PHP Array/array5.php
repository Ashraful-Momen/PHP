<?php
$fruit = ['orange', 'banana', 'apple', 'grapes'];

$veggie = ['carrot', 'pea'];

$newArray = array_replace($fruit, $veggie);

echo "<pre>";
print_r($newArray);
echo "</pre>";


/*----- Index Array --------  */
$color = ['red', 'green', 'blue'];

$newArray = array_replace($fruit, $veggie, $color);


/* ----------------Associative Array------------------- */
$veggie = ['a' => 'carrot', 'b' => 'pea'];

$veggie = ['a' => 'carrot', 1 => 'pea'];


/* --------------Array Replace Function----------------- */
$fruit = ['orange', 'b' => 'banana', 'apple', 'grapes'];


/* ---- array_replace_recursive----------- */
$array1 = array("a"=>array("red"),"b"=>array("green","pink"));

$array2 = array("a"=>array("yellow"),"b"=>array("black"));

$newArray = array_replace_recursive($array1, $array2);

print_r($newArray) ;

?>