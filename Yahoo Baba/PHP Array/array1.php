<?php
// $color=['red','blue','green'];

// $color[0]='red';
// $color[1]='blue';
// $color[0]='green';

// echo $color[0];

#========================

$color = array ('red', 'blue','green');

// echo $color[2];

// echo "<pre>";
// print_r($color);
// echo "</pre>";


echo "<ul>";
for($i=0;$i<3;$i++)
{
    echo "<li>$color[$i]</li>";
}

echo "</ul>";

