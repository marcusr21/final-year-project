<?php
$email = $_POST['email'];

if (isset($_POST['action'])){
  switch($_POST['action']){
    case 'login':
      login();
      break;
    case 'register':
      register($email);
      break;
  }
}

function login() {

}

function register($email) {
  
}

?>
