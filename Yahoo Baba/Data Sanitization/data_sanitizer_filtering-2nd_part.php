

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <section>
    <form action="" method="post">
    Input : <input type="text" name="var" class="form-control btn btn-outline-danger " >
    <button class="form-control" type="submit" >Submit</button>
    </form>

   
    
  </section>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>

<?php
    
    $var = $_REQUEST['var'];
   

    echo "Before SANITIZE DATA => $var<br>";

    // echo $email_sanitize=filter_var($var,FILTER_SANITIZE_EMAIL)."<br>";
    
 
   
    // if(filter_var($var,FILTER_VALIDATE_EMAIL)){
    //     echo "valid : {$var}";
    // }
    // else{
         
    //     echo "Not valid => {$var}";
    // }
    #___________________________________________________
    
    // $email_sanitize=filter_var($var,FILTER_SANITIZE_URL)."<br>";
    // echo "AFTER SANITIZE DATA => ".$email_sanitize."<br>";
    
 
   
    // if(filter_var($var,FILTER_VALIDATE_URL,FILTER_FLAG_QUERY_REQUIRED)){
    //     echo "valid : {$var}";
    // }
    // else{
         
    //     echo "Not valid => {$var}";
    // }
    //$var7 = "yahoobaba";
    // $var = "https://www.yahoo #$%^&* baba.net";
    //$var = "https://www.ya hoo baba.net";
    
    //$var = "https://www.yah^^oo//baba.net";
    
    // $var = filter_var($var, FILTER_SANITIZE_URL);
    // echo $var."<br>";
    // if(filter_var($var, FILTER_VALIDATE_URL)){
    //   echo "<br>$var => is valid URL.<br>";
    // }else{
    //   echo "<br>$var => is not an valid URL.<br>";
    // }
    #=======================================================
    /*-------FILTER_SANITIZE_EMAIL -- removes all illegal characters from an email address------- */
$var = "ram(.kumar)@exa//mple.com";
/* $var = "(ram.kumar@example.com)";
$var = "ram/kumar@example.com";
$var = "ram kumar@example.com";

$var = "ram.kumar@example/com";
$var = "ram.kumar@exam/ple.com"; */

echo filter_var($var, FILTER_SANITIZE_EMAIL);

$var = filter_var($var, FILTER_SANITIZE_EMAIL);

if(filter_var($var, FILTER_VALIDATE_EMAIL)){
  echo "<br>$var is valid email.<br>";
}else{
  echo "<br>$var is not an valid email.<br>";
}

/*-------FILTER_SANITIZE_URL------- */
$var = "https://www.yahoo baba.net";
//$var = "https://www.ya hoo baba.net";

//$var = "https://www.yah^^oo//baba.net";

$var = filter_var($var, FILTER_SANITIZE_URL);

if(filter_var($var, FILTER_VALIDATE_URL)){
  echo "<br>$var is valid URL.<br>";
}else{
  echo "<br>$var is not an valid URL.<br>";
}

/*-------FILTER_SANITIZE_NUMBER_INT------- */

$var = "45";
//$var = "45.00";
//$var = "*45";
//$var = "&45";
//$var = "45^^";
//$var = "abcd45@#$%";

//$var = "+45";
//$var = "-45";
//$var = "45+";
//$var = "-45.00";
//$var = "-45.50";

$var = filter_var($var, FILTER_SANITIZE_NUMBER_INT);

if(filter_var($var, FILTER_SANITIZE_NUMBER_INT)){
  echo "<br>$var is valid Integer.<br>";
}else{
  echo "<br>$var is not an valid Integer.<br>";
}

/*-------FILTER_SANITIZE_NUMBER_FLOAT------- */

 $var = "45.50";
//$var = "45.50abc";

$var = filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT);

if(filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT)){
  echo "<br>$var is valid Float.<br>";
}else{
  echo "<br>$var is not an valid Float.<br>";
}


/*-------FILTER_FLAG_ALLOW_FRACTION - Allow fraction separator (like . )------- */
//$var = "45.50";
$var = "45.50abc";

$var = filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);

if(filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT)){
  echo "<br>$var is valid Float.<br>";
}else{
  echo "<br>$var is not an valid Float.<br>";
}


/*-------FILTER_FLAG_ALLOW_THOUSAND - Allow thousand separator (like , )------- */
$var = "1,50,000";

$var = filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_THOUSAND);

if(filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT)){
  echo "<br>$var is valid Float.<br>";
}else{
  echo "<br>$var is not an valid Float.<br>";
}

/*-------FILTER_FLAG_ALLOW_SCIENTIFIC - Allow scientific notation (like e and E)------- */
$var = "10e";
//$var = "10E"; 

$var = filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_SCIENTIFIC);

if(filter_var($var, FILTER_SANITIZE_NUMBER_FLOAT)){
  echo "<br>$var is valid Float.<br>";
}else{
  echo "<br>$var is not an valid Float.<br>";
}
   
?>