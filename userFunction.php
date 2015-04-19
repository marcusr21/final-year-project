<?php
session_start();
$conn = mysqli_connect("localhost", "root", "toor", "nsumedia2");

$email = $_REQUEST['email'];
$user = $_REQUEST['username'];
$first = $_REQUEST['fname'];
$surname = $_REQUEST['sname'];
$password = $_REQUEST['password'];

//If username taken, redirect and try again
$sql = "SELECT username, email FROM user WHERE username='$user' OR email='$email' LIMIT 1";
$result=mysqli_query($conn, $sql);
if(mysqli_num_rows($result) != 0){
  $_SESSION['url'] = $_SERVER['REQUEST_URI'];
  header('Location: index.php');
  //Need to figure out how to repopulate form
  //Send back in session and then clear?!
}
else {

  $hash = password_hash($password, PASSWORD_BCRYPT);

  $registerQuery = "INSERT INTO user (username, firstname, surname, email, password, access) VALUES ('$user', '$first', '$surname', '$email', '$hash', 'S')";

  if ($conn->query($registerQuery) === TRUE){
    $_SESSION['first'] = $first;
    $_SESSION['user'] = $user;
    $_SESSION['uid'] = mysqli_insert_id($conn);
    header('Location: splash.php');
  }
  else {
    echo "Error: " . $registerQuery . "<br>" . $conn->error;
  }
}

?>
