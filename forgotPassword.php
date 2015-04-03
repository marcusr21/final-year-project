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
        <label for="emailLabel">Email: </label><input type="text" class="form-control" name="email" placeholder="user@user.com" id="email" />
        <button type="submit" class="btn btn-primary btn-sml" name="id" value="username">Username Reminder</button>
        <button type="submit" class="btn btn-primary btn-sml" name="id" value="password">Password Reminder</button>
      </div>
    </form>
  </div>
</div>
<?php
include('footer.php');
?>
