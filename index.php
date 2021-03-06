<?php
session_start();
$url = isset($_SESSION['url']);
?>

<?php
//include_once('connect.php');
include('header.php');
?>


<script>
$(document).ready(function() {
  $('#email').on('input', function() {
    var input=$(this);
    var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var is_email=re.test(input.val());
    if(is_email){input.removeClass("invalid").addClass("valid");}
    else{input.removeClass("valid").addClass("invalid");}
  });

  $('#registerButton').click(function(e){
    if($('#email').hasClass("invalid")){
      alert('Please complete all registration fields');
      e.preventDefault(e);
    }
  });
});
</script>

<!--Login form-->
<div class="container">
  <div class="loginForm">
  <h3>Login</h3>
  <form name="login" id="login" action="authenticate.php" method="post">
    <?php
    if($url == '/authenticate.php'){
      echo "Login details incorrect, please try again";
    }
    ?>
    <div class="form-group">
      Username: <input type="text" name="username"><br>
    </div>
    <div class="form-group">
      Password: <input type="password" name="password"><br>
    </div>
    <input class="btn btn-default btn-sml" type="submit" value="Submit">
  </form><br/>
  <p>Forgot your username or password? Click <a href="forgotPassword.php">here</a>
</div>

<!--Register form-->

  <div class="loginForm">
    <h3>Register</h3>
    <form name="register" id="register" class="form-inline" action="userFunction.php" method="post">
      <div class="form-group">
        <label for ="first">First name:</label> <input type="text" class="form-control" name="fname"><br>
      </div>
      <div class="form-group">
        <label for="surname">Surname:</label> <input type="text" class="form-control" name="sname"><br>
      </div>
      <div class="form-group">
        <label for="email">Email:</label> <input type="text" id="email" class="form-control" name="email"><br><!--live check required-->
      </div>
      <div class="form-group">
        <label for="username">Username:</label> <input type="text" class="form-control" name="username">
      <?php if($url == '/userFunction.php'){
        echo "Please choose a new username";
      } ?><br>
      </div>
      <div class="form-group">
        <label for="password">Password:</label> <input type="password" class="form-control" name="password"><br> <!-- live checking-->
      </div>
      <input class="btn btn-default btn-sml" type="submit" value="Register" id="registerButton">
    </form>
  </div>
</div>

<?php
include('footer.php');
?>
