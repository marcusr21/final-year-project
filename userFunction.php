<?php
session_start();
$conn = mysqli_connect("localhost", "root", "toor", "nsumedia2");

$email = $_REQUEST['email'];
$user = $_REQUEST['username'];
$first = $_REQUEST['fname'];
$surname = $_REQUEST['sname'];
$password = $_REQUEST['password'];


  $hash = password_hash($password, PASSWORD_BCRYPT);

  $registerQuery = "INSERT INTO user (username, firstname, surname, email, password, access) VALUES ('$user', '$first', '$surname', '$email', '$hash', 'S')";

  if ($conn->query($registerQuery) === TRUE){

    $_SESSION['first'] = $first;
    $_SESSION['user'] = $user;
    header('Location: splash.php');
  }
  else {
    echo "Error: " . $registerQuery . "<br>" . $conn->error;
  }


  //echo "Success!";
  //header("Location: splash.php");


  //execute login function using username and password

?>
