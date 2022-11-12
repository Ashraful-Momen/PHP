<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <form method="post">

        Input Interger: <input type="text" name="number" value="" class="" placeholder="Please Input Valid Age number(Fraction is not allow) : ">
        Submit: <input type="submit" class="btn btn-outline-success">
    </form>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>

<?php

$number = $_REQUEST['number'];

// if (filter_var($number, FILTER_VALIDATE_INT )){
//     echo("$number : number is integer.");
// }else{
//     echo("$number: number is not integer.");
// }

#_________________________________________________________________________
//fix the problem with Zero :



// if (filter_var($number, FILTER_VALIDATE_INT ) || filter_var($number, FILTER_VALIDATE_INT ) ==0 ){
//     echo("$number : number is integer.");
// }else{
//     echo("$number: number is not integer.");
// }
#_________________________________________________________________________
//use range: 

// $options = array("options"=> array("min_range"=>0, "max_range"=>100));



// if (filter_var($number, FILTER_VALIDATE_INT,$options)){
//     echo("$number : number is integer.");
// }else{
//     echo("$number: number is not integer.");
// }

# same HW for : Boolean, Float, double.
#_________________________________________________________________________

// if (filter_var($number, FILTER_VALIDATE_BOOLEAN,$options)){
//     echo("$number : number is Boolean.");
// }else{
//     echo("$number: number is not Boolean.");
// }
#_________________________________________________________________________
// fix the boolean output: 

//$var4 = false;
//$var4 = true; //--- "on" / "yes" / 1 / "1"



//var = false; //--- "off" / "no" / 0 / "0"

// if boolean value is : off/ false / 0 in if (scope) then if/else is return false or else value ;



// $test = "true";

// echo var_dump(filter_var($test, FILTER_VALIDATE_BOOLEAN))."<br>";

// if (filter_var($test, FILTER_VALIDATE_BOOLEAN,FILTER_NULL_ON_FAILURE)){
//     echo("{$test} :  is Boolean.");
// }else{
//     echo("{$test}: is not Boolean.");
// }
#_________________________________________________________________________
/*-------FILTER_VALIDATE_EMAIL------- */

//$var6 = "hello";
$var6 = "hello@yahoobaba.net";
$var6 = "hel lo@yahoobaba.net";
$var6 = "hello@yahoobabanet";

if(filter_var($var6, FILTER_VALIDATE_EMAIL)){
  echo "$var6 is valid Email.<br>";
}else{
  echo "$var6 is not an valid Email.<br>";
} 

/*-------FILTER_VALIDATE_URL------- */

//$var7 = "yahoobaba";
$var7 = "www.yahoobaba.net";
$var7 = "https://www.yahoobaba.net";
$var7 = "https://www.yahoo baba.net";
$var7 = "https://www.yahooba^^ba.net";

$var7 = "https://www.yahoobaba.net/test/page.php";

if(filter_var($var7, FILTER_VALIDATE_URL)){
  echo "$var7 is valid URL.<br>";
}else{
  echo "$var7 is not an valid URL.<br>";
}

/*-------Flags :FILTER_FLAG_PATH_REQUIRED--- URL must have a path after the domain name (like www.example.com/example1/)------- */

 
$var8 = "https://www.yahoobaba.net/test/page.php";


if(filter_var($var8, FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED)){
  echo "$var8 is valid URL.<br>";
}else{
  echo "$var8 is not an valid URL.<br>";
} 

/*-------Flags :FILTER_FLAG_QUERY_REQUIRED---- URL must have a query string (like "example.php?name=Peter&age=37")------- */


$var9 = "https://www.yahoobaba.net/test.php?a=1&b=2";

if(filter_var($var9, FILTER_VALIDATE_URL,FILTER_FLAG_QUERY_REQUIRED)){
  echo "$var9 is valid URL.<br>";
}else{
  echo "$var9 is not an valid URL.<br>";
} 

/*-------FILTER_VALIDATE_IP --  Internet Protocol address------- */

$var10 = "192.168.1.1";
//$var10 = "192.168.1.0";
//$var10 = "192.168.1";
//$var10 = "192.168.1.800";
//$var10 = "192.168.1.100";

//not telling  IPv4 or IPv6 advance IP

if(filter_var($var10, FILTER_VALIDATE_IP)){
  echo "$var10 is valid IP.<br>";
}else{
  echo "$var10 is not an valid IP.<br>";
}

/*-------FILTER_VALIDATE_MAC  -- media access control address -- unique address of networking devices------- */

$var11 = "FA-F9-DD-B2-5E-0D";
//$var11 = "FA-F9-DD-B2-5E";

if(filter_var($var11, FILTER_VALIDATE_MAC)){
  echo "$var11 is valid MAC.<br>";
}else{
  echo "$var11 is not an valid MAC.<br>";
}
?>