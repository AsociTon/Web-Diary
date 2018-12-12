<?php
session_start();
setcookie("email",$_SESSION['email'],time()+60*60*24*365);

$_COOKIE["email"];
$error = "";
$user = "root";
$pass = "";
$db = "mydb";
$row = "";
$db = new mysqli("localhost",$user,$pass,$db) or die("Unsucessfull");//skips the rest script in case db is not connected

  $sql = "SELECT entry from mydiary WHERE email='".mysqli_real_escape_string($db,$_COOKIE["email"])."';";

  if(mysqli_query($db,$sql)){

        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result);

  }else{

      $error =  "Unable to store entry";

  }


if(array_key_exists("log-out",$_POST)){

  setcookie("email","",time()*(-60)*60);//to delete/disable the cookie
  header("Location: index.php");//page to redirect to with the value of session variable

}

if(array_key_exists("save",$_POST)){

  $sql = "UPDATE mydiary SET entry='".mysqli_real_escape_string($db,$_POST["text_area"])."'  WHERE email='".mysqli_real_escape_string($db,$_COOKIE["email"])."';";

  if(mysqli_query($db,$sql)){

    $sql = "SELECT entry from mydiary WHERE email='".mysqli_real_escape_string($db,$_COOKIE["email"])."';";

    if(mysqli_query($db,$sql)){

          $result = mysqli_query($db,$sql);
          $row = mysqli_fetch_array($result);

    }else{

        $error =  "Unable to store entry";

    }


  }else{

      $error =  "Unable to store entry";

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

    textarea{

      margin-top: 5px;
      width:100%;
      height: 700px;
      background-color: #ffffff;
      opacity: 0.7;

    }

    .but1{

      float: right;
      margin-right: 2px;

    }

  </style>
</head>

<body style="background: url(diar.jfif) no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
  <div class="container">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Web Diary</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse but1" id="#navb">
      <form class="form-inline my-2 my-lg-0" method="post">
        <button class="btn btn-outline-success my-2 my-sm-0 but1" type="submit" name="save">Save</button>
        <button class="btn btn-outline-success my-2 my-sm-0 but1" type="submit" name="log-out">Log Out</button>
        <input type="hidden" id = "text_area_for_php" name="text_area">
      </form>
    </div>
  </nav>
  <div id="text_span">
    <textarea id="text_area">
      <?php echo $row[0]; ?>
    </textarea>
  </div>
</div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script type="text/javascript">

    $("#text_area").on("change keyup paste",function(){
      $("#text_area_for_php").val($("#text_area").val());
    });

  </script>
</body>
</html>
