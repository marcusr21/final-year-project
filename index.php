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
<div>
  <h3>Login</h3>
  <form name="login" id="login" action="authenticate.php" method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="submit">
  </form>
</div>
<!--Register form-->
<div>
  <h3>Register</h3>
  <form name="register" id="register" action="userFunction.php" method="post">
    First name: <input type="text" name="fname"><br>
    Surname: <input type="text" name="sname"><br>
    Email: <input type="text" id="email" name="email"><br><!--live check required-->
    Username: <input type="text" name="username">
    <?php if($url == '/userFunction.php'){
      echo "Please choose a new username";
    } ?><br>
    Password: <input type="password" name="password"><br> <!-- live checking-->
    <input type="submit" value="register" id="registerButton">
  </form>
</div>

<?php
include('footer.php');
?>
