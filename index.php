<?php
$error="";
include("connection.php");

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
        header("Location: diary-page.php");//page to redirect to with the value of session variable

      }else{

        $error = "failed to update";

        }
      }

    }else{

      $error = "query Unsucessfull";

    }
}


  if(array_key_exists("sign-in",$_POST)){ //when the sign in button is clicked

  $sql = "SELECT password FROM mydiary WHERE email='".mysqli_real_escape_string($db,$_POST['sign-in-email'])."';";

      $result = mysqli_query($db,$sql);

  if(mysqli_query($db,$sql)){

      $row = mysqli_fetch_array(mysqli_query($db,$sql));

      if($row[0] == $_POST['sign-in-password']){

      session_start();//starting a session to make the email remebered
      $_SESSION['email'] = $_POST['sign-in-email'];
      echo "passwrord matched";
      header("Location: diary-page.php");//page to redirect to with the value of session variable

    }else if($row[0]){

      $error = "Incorrect password";

    }else{

      $error = "Invalid credentials";

    }

  }else{

      $error =  "Unable to Sign In, server connection time out..";

  }
}

?>

<?php include("header.php");?>
 
 <div class="container index">

  <?php if(strlen($error) != 0){echo '<div class="alert alert-danger" id="error" role="alert">'.$error.'</div>';}?>

  <form method="post" id="sign_up_form">
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
    <button type="submit" id="but1" class="btn btn-primary" name="sign-up">Sign Up</button><br>
      <p><a class="toggle_forms">Already a member Sign In</a></p>

  </form>

  <form method="post" id="sign_in_form">

      <div class="form-group">
        <label for="email">Email addres</label>
        <input type="email" class="form-control" id="email" name="sign-in-email" aria-describedby="emailHelp" placeholder="Enter email">
      </div>
      <div class="form-group">
        <label for="password">Enter password</label>
        <input type="password" class="form-control" id="password" name="sign-in-password">
      </div>
      <button type="submit" id="but1" class="btn btn-primary" name="sign-in">Sign In</button><br>
      <p><a class="toggle_forms">Not a member, Sign Up</a></p>

    </form>
</div>
 <script type = "text/javascript">
  $(".toggle_forms").click(function(){
    $("#sign_up_form").toggle();//makes it disappear if it is appearing and vice versa
    //having an href in the sign_up_form link makes the page refresh thus undoing the toggle effect
    $("#sign_in_form").toggle();

  });
 </script>   

<?php include("footer.php");?>
