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
    <form action="" method="post" enctype="multipart/form-data">
        Email: <input type="email" name="email"  class="form-control">
        <input type="submit" name="submit" class="btn btn-secondary" id="email" placeholder="Submit">
        Number: <input type="text" name="number"  class="form-control">
        <input type="submit" name="submit_number" class="btn btn-secondary" id="number" placeholder="Submit">
    </form>
    <?php
            if(isset($_REQUEST['submit_number'])){
             
                // echo "hello";
            // if(filter_input(INPUT_POST,"email", FILTER_VALIDATE_EMAIL)){
            //    echo "Email is valid : {$_REQUEST['email']}";

            //     }
            // else{
            //         echo "Email is not valid";
            //     }


            $options = array(
                "options" => array(
                    "min_range" => 1,
                    "max_range" => 100
                )
            );

            if (filter_input(INPUT_POST, "number", FILTER_VALIDATE_INT,$options)){
                echo("Marks is valid.");
            }else{
                echo("Marks is not valid.");
            }


            }
          
       

   

    ?>
 </section>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>