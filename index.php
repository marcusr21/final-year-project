<?php
session_start();
$url = $_SESSION['url'];
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
    <input class="btn btn-default btn-sm" type="submit" value="Submit">
  </form>
</div>
<!--Register form-->
<div class="container">
  <h3>Register</h3>
  <form name="register" id="register" action="userFunction.php" method="post">
    <div class="form-group">
      First name: <input type="text" name="fname"><br>
    </div>
    <div class="form-group">
      Surname: <input type="text" name="sname"><br>
    </div>
    <div class="form-group">
      Email: <input type="text" id="email" name="email"><br><!--live check required-->
    </div>
    <div class="form-group">
      Username: <input type="text" name="username">
    <?php if($url == '/userFunction.php'){
      echo "Please choose a new username";
    } ?><br>
    </div>
    <div class="form-group">
      Password: <input type="password" name="password"><br> <!-- live checking-->
    </div>
    <input class="btn btn-default btn-sm" type="submit" value="Register" id="registerButton">
  </form>
</div>

<?php
include('footer.php');
?>
