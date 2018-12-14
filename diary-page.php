<?php
session_start();

if(array_key_exists("email", $_SESSION) && $_SESSION["email"]){

  setcookie("email",$_SESSION['email'],time()+60*60*24*365);

}

$error = "";
include("connection.php");

if(array_key_exists("email", $_COOKIE) && $_COOKIE["email"]){
$sql = "SELECT entry from mydiary WHERE email='".mysqli_real_escape_string($db,$_COOKIE["email"])."';";

  if(mysqli_query($db,$sql)){

        $result = mysqli_query($db,$sql);
        $row = mysqli_fetch_array($result);

  }else{

      $error =  "Unable to store entry";

  }
}

if(array_key_exists("log-out",$_POST)){

  setcookie("email","",time()-60*60);//to delete/disable the cookie
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

<?php include("header.php"); ?>

<div class="container-fluid"> 
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Web Diary</a>
      <form class="form-inline my-2 my-lg-0" method="post">
        <button class="btn btn-outline-success my-2 my-sm-0 but1" type="submit" name="save">Save</button>
        <button class="btn btn-outline-success my-2 my-sm-0 but1" type="submit" name="log-out">Log Out</button>
        <input type="hidden" id = "text_area_for_php" name="text_area">
      </form>
    </nav>
      <textarea id="text_area" class="form-control">
        <?php if(isset($row)){echo $row[0];} ?>
      </textarea>
</div>

  <script type="text/javascript">

    $("#text_area").on("change keyup paste",function(){

      $("#text_area_for_php").val($("#text_area").val());

    });

  </script>

<?php include("footer.php"); ?>