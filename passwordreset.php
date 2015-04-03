<?php
include('connect.php');
include('header.php');

$token=$_GET['token'];

if(isset($_GET['token'])){
  echo "<div class='container'>\n";
  echo "<form name='reset' action='scripts/changePassword.php' method='POST'>\n";
  echo "New Password: <input type='text' id='newPassword' />\n";
  echo "Repeat Password: <input type='text' id='checkPassword' />\n";
  echo "<input type='hidden' name='value' id='value' value='".$token."' />\n";
  echo "<input type='hidden' id='type' name='type' value='reset' />\n";
  echo "<button type='submit' class='btn btn-default btn-sml'>Change Password</button>\n";
  echo "</form>\n";
  echo "</div>\n";
}

?>
