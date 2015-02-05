<?php
session_start();
$conn = mysqli_connect("localhost", "root", "toor", "nsumedia2");

$user = $_REQUEST['username'];
$password = $_REQUEST['password'];

$sql="SELECT username, password, firstname FROM user WHERE username = '$user'";

if($result=mysqli_query($conn,$sql)){
  while ($row=mysqli_fetch_row($result))
  {
    $hash = $row[1];
    $first = $row[2];
  }

  if(password_verify($password, $hash)){
    $_SESSION['first'] = $first;
    $_SESSION['user'] = $user;
    header('Location: splash.php');
  }
  else {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    header('Location: index.php');
  }

}
else {
  echo "Error: " . $registerQuery . "<br>" . $conn->error;
}

//Check if in DB
//Check hash against DB
//If no value returned - go back to webpage
//Else Pass through to session and redirect to splash page

?>
