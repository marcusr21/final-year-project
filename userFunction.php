<?php
$email = $_POST['email'];
$user = $_POST['username'];

if (isset($_POST['action'])){
  switch($_POST['action']){
    case 'login':
      login();
      break;
    case 'register':
      register($email, $user);
      break;
  }
}

function login() {

}

function register($email, $user) {
  $emailTest = mysql_real_escape_string($email);
  $userTest = mysql_real_escape_string($user);
  $emailResult = mysql_query(
  "SELECT email FROM users WHERE email='$emailTest' LIMIT 1"
  );

  if(mysql_fetch_array($emailResult) !== false){
    //redirect back to page - highlight email and say no
  }

  $userResult = mysql_query(
  "SELECT username FROM users WHERE username='$userTest' LIMIT 1"
  );

  if(mysql_fetch_array($userResult) !== false){
    //redirect back to page - highlight user and say no
  }

}

?>
