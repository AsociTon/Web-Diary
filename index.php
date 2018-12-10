<?php
$error = "";
$user = "root";
$pass = "";
$db = "mydb";
$db = new mysqli("localhost",$user,$pass,$db) or die("Unsucessfull");//skips the rest script in case db is not connected

  $sql = "CREATE TABLE IF NOT EXISTS mydiary(email TEXT,password TEXT,entry TEXT)";

  if(mysqli_query($db,$sql)){

    $sql = "SELECT * FROM mydiary WHERE email='".mysqli_real_escape_string($db,$_POST['sign-up-email'])."'";//to save from sql injections
    $result = mysqli_query($db,$sql);

    if(mysqli_num_rows($result) > 0){  //to check whether the given is already present in the database

      $error = "That email is already registered";
      echo $error;

    }
    else{

    $sql = "INSERT INTO mydiary(email,password) VALUES('".mysqli_real_escape_string($db,$_POST['sign-up-email'])."','".$_POST['sign-up-password']."')";

    if(mysqli_query($db, $sql)){

      echo "DAta updated";
      session_start();//starting a session to make the email remebered
      $_SESSION['email'] = $_POST['sign-up-email'];
      header("Location: diary-page.php");//page to redirect to with the value of session variable

    }else{

      $error = "failed to update";

      }
    }

  }else{

    $error = "query Unsucessfull";

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  <title>My Diary</title>

</head>
<body>
  <form method="post">
    <div id="error">

    </div>
    <input type="text" id="email" name="sign-up-email" placeholder="Email"><br>
    <input type="password" id="password" name="sign-up-password"><br>
    <button type="submit" id="but1" name="sign-up">Sign Up</button><br>
    <a href="http://localhost/my-diary/sign-in.php">Already a member Sign In</a>
  </form>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script type="text/javascript">

    function check_pass(){

      if($("#password").val().length == 0){

        error_str += "<br>Password is a required field";

      }
      else{

        error_str = "";

      }

    }

    var error_str = "";

    $("#but1").click(function(){

        if($("#email").val().length == 0){

          error_str += "Email Id is required";
          check_pass();

        }
        else{

          error_str = "";
          check_pass();

        }

        if(error_str.length == 0){

          $("#error").html("");
          return true;

        }else{

          $("#error").html(error_str);
          return false;

        }

    });

  </script>
</body>
</html>