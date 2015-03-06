<?php
session_start();
include('header.php');
include('connect.php');
?>
<div class="container">
  <div>
    If you have forgot your username or password, please enter your email in the form below and click the relevant button
    <form class="form-inline" action="reset.php" method="POST">
      <div class="form-group">
        <label for="email">Email: </label><input type="text" class="form-control" placeholder="user@user.com" id="email" />
        <input type="submit" class="btn btn-primary btn-sml" value="Username Reminder" id="username" />
        <input type="submit" class="btn btn-primary btn-sml" value="Password Reset" id="password" />
      </div>
    </form>
  </div>
</div>
<?php
include('footer.php');
?>
