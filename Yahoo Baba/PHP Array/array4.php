<?php
$food = array('orange', 'banana', 'apple', 'grapes');

echo in_array("lime", $food);

/* ---- If Condition InArray------ */
if (in_array("apple", $food)) {
    echo "Find Successfully.";
}else{
    echo "Can't Find.";	
}


echo in_array(55, $food,true); /* ---- strict mode------ */


/* --------Multipledimensional Associative Array------------- */
$a = array(array('p', 'h'), array('p', 'r'), 'o');

if (in_array(array('p', 'h'), $a)){}


/* ----------Array Search------------- */
echo array_search("apple", $food);



/* -----------Associative Array-------------- */
$food = array('a' => 'orange', 'b' => 'banana', 'c' => 'apple', 'd' => 'grapes');

echo array_search("apple", $food);

echo in_array("apple", $food);
 
?>