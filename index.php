<?php
include_once('connect.php');
include('header.php');
?>
<div>
  <form name="login" action="userFunction.php" method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Submit">
  </form>
</div>

<div>
  <form name="register" action="userFunction.php" method="post">
    First name: <input type="text" name="fname"><br>
    Surname: <input type="text" name="sname"><br>
    Email: <input type="text" name="email"><br>
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Register">
  </form>
</div>

<?php
include('footer.php');
?>
