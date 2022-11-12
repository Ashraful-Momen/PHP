<?php 

#multidimensional Array: ________________________________________

// $emp = [
//   [1,"Krishana","Manager",50000],
//   [2,"Salman","Salesman",20000],
//   [3,"Mohan","Computer Operator",12000],
//   [4,"Amir","Driver",5000]
// ];

// echo "<pre>";
// print_r($emp);
// echo "</pre>";

// echo $emp[0][0] . " "; #1
// echo $emp[0][1] . " "; #"Krishana"
// echo $emp[0][2] . " "; #"Manager"
// echo $emp[0][3] . " "; #5000
// echo "\n";
// echo $emp[1][0] . " "; 
// echo $emp[1][1] . " "; 
// echo $emp[1][2] . " "; 
// echo $emp[1][3] . " "; 

/* Multidimensional Array For Loop */
// for ($row = 0; $row < 4; $row++) {
//     for ($col = 0; $col < 4; $col++) {
//       echo $emp[$row][$col] . " ";
//     }
//     echo "<br>";
//   }



/* Multidimensional Array Foreach Loop */
/* Multidimensional Array Foreach Loop */
// foreach ($emp as $v1) {
//     foreach ($v1 as $v2){
//         echo $v2 . " ";
//     }
//     echo "<br>";
// }
#============================================


// foreach ($emp as $k1 => $v1) {   # row 
//     echo $k1." "."<br>";#index row ;
//     foreach ($v1 as $v2){
//         // echo $v2 . " ";   # row + column value ;
//     }
//     echo "<br>";
// }


#====================================
/* Print with Table tag */


// echo "<table border='2px' cellpadding='5px' cellspacing='0'>";
// echo "<tr>
//         <th>Emp Id</th>
//         <th>Emp Name</th>
//         <th>Designation</th>
//         <th>Salary</th>
//     </tr>";
//     foreach ($emp as $v1){
//         echo "<tr>";
//     foreach ($v1 as $v2){
//         echo "<td> $v2 </td>";
//     }
//     echo "</tr>";
// }
// echo "</table>";

#===================Multidimension Array with list($column1,$column2,$column3, $column4 etc ...)========================
/* ----------- Index Array----------- */
$emp = [
    [1,"Krishana","Manager",50000],
    [2,"Salman","Salesman",20000],
    [3,"Mohan","Computer Operator",12000],
    [4,"Amir","Driver",5000]
];


// foreach ($emp as list($id, $name,$desg,$salary)) {
// echo "$id $name $desg $salary \n </br>";
// }

/* print with table tag */
// echo "<table border='1px solid' cellpadding='5px' cellspacing='0'>
//     <tr>
//         <th>Emp Id</th>
//         <th>Emp Name</th>
//         <th>Designation</th>
//         <th>Salary</th>
//     </tr>";
// foreach ($emp as list($id, $name,$desg,$salary)) {
//   echo "<tr><td>$id</td><td>$name</td><td>$desg</td><td>$salary</td></tr>";
// }
// echo "</table>";

#==============================Multidimensional Associative Array with list('key'=>$col_value....)=====================


$emp = [
    ["id" => 1,"name" => "Krishana","designation" => "Manager","salary" => 50000],
    ["id" => 2,"name" => "Salman","designation" => "Salesman","salary" => 20000],
    ["id" => 3,"name" => "Mohan","designation" => "Computer Operator","salary" => 12000],
    ["id" => 4,"name" => "Amir","designation" => "Driver","salary" => 5000]
];

foreach ($emp as list("id" => $id, "name" => $name,"designation" => $desg,"salary" => $salary)) {
  echo "Id: $id; Name: $name; Designation: $desg; Salary: $salary</br>";
}
?>