<?php
  $error="";
  $user = "root";
  $pass = "";
  $db = "mydb";
  $db = new mysqli("localhost",$user,$pass,$db) or die("Unsucessfull");//skips the rest script in case db is not connected

    $sql = "CREATE TABLE IF NOT EXISTS mydiary(name TEXT, email TEXT, password TEXT, entry TEXT)";

if(array_key_exists("sign-up",$_POST)){

    if(mysqli_query($db,$sql)){

      $sql = "SELECT * FROM mydiary WHERE email='".mysqli_real_escape_string($db,$_POST['sign-up-email'])."'";//to save from sql injections
      $result = mysqli_query($db,$sql);

      if(mysqli_num_rows($result) > 0){  //to check whether the given is already present in the database

        $error = "That email is already registered";

      }
      else{

      $sql = "INSERT INTO mydiary(name, email, password) VALUES('".mysqli_real_escape_string($db,$_POST['first-name'])."','".mysqli_real_escape_string($db,$_POST['sign-up-email'])."','".$_POST['sign-up-password']."')";

      if(mysqli_query($db, $sql)){

        session_start();//starting a session to make the email remebered
        $_SESSION['email'] = $_POST['sign-up-email'];
        header("Location:Web-Diary/diary-page.php");//page to redirect to with the value of session variable

      }else{

        $error = "failed to update";

        }
      }

    }else{

      $error = "query Unsucessfull";

    }
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

  <style type="text/css">

    .index{

        text-align: center;
    }

    #index{
      margin-top: 100px;
      width:400px;
      height:400px;

    }

    #error{

      display:<?php if(strlen($error != 0)){ echo "block"; } ?>;

    }

  </style>

</head>
<body style="background: url(diar.jfif) no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">


  <div class="container" id="index">

    <div class="alert alert-danger" id="error" role="alert"><?php if(strlen($error) != 0){echo $error;}?></div>

    <form method="post">

      <div class="form-group">
        <label for="first-name">Name</label>
        <input type="text" class="form-control" id="first-name" name="first-name" placeholder="First name, nick-name e.g.">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Email addres</label>
        <input type="email" class="form-control" id="email" name="sign-up-email" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="sign-up-password" placeholder="Enter Password">
      </div>
      <div class="index"><button type="submit" id="but1" class="btn btn-primary" name="sign-up">Sign Up</button></div><br>
      <a href="https://github.com/AsociTon/Web-Diary/sign-in.php">Already a member Sign In</a>

    </form>

</div>
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

        error_str = "";

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
          $("#error").css("display","none");
          return true;

        }else{

          $("#error").html(error_str);
          $("#error").css("display","block");
          return false;

        }

    });

  </script>
</body>
</html>
