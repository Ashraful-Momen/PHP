<?php

// print_r(glob('*')); // print: file , folder as array elements ... 
// print_r(glob('*')); 

// print_r(glob("*st*/*"));//check sub folder

// // print_r(glob("k*"));
// print_r(glob('*uv*'));
// // print_r(glob("*.html"));
// print_r(glob("*.js"));
// print_r(glob("*.css"));
// print_r(glob("*.php"));


//secrch with single character : 

// echo "<pre>";
// print_r(glob("[st]*"));  // search with 's'/'t' latter:
// echo "<pre>"; 

// echo "<pre>";
// print_r(glob("*[st]*"));  // search with  latter + 's'/'t' +  latter:
// echo "<pre>"; 
//---------------------------------------------------------------------------
// $ary = glob("*");
// foreach ($ary as $filename) {
//     echo "$filename size " . filesize($filename) . "<br>";
// }

/* -------Real Path--------*/
echo "<pre>";
print_r(glob("*",GLOB_MARK));
echo "<pre>"; 

/* -------If file/folder is not found returns pattern--------*/
echo "<pre>";
print_r(glob("k*",GLOB_NOCHECK));
echo "<pre>"; 

/* -------Return only directories which match the pattern--------*/
echo "<pre>";
print_r(glob("*",GLOB_ONLYDIR));
echo "<pre>"; 

/* ------- -- Expands {a,b,c} to match 'a', 'b', or 'c'--------*/
echo "<pre>";
print_r(glob("{*.txt,*.html}",GLOB_BRACE));
echo "<pre>"; 


echo "<pre>";
print_r(glob("{css/*,js/*}",GLOB_BRACE));
echo "<pre>"; 
?>