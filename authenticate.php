<?php
include('connect.php');
session_start();

$user = $_REQUEST['username'];
$password = $_REQUEST['password'];

$sql="SELECT UID, username, password, firstname FROM user WHERE username = '$user'";

if($result=mysqli_query($conn,$sql)){
  while ($row=mysqli_fetch_row($result))
  {
    $UID=$row[0];
    $hash = $row[2];
    $first = $row[3];
  }

  if(password_verify($password, $hash)){
    $_SESSION['first'] = $first;
    $_SESSION['user'] = $user;
    $_SESSION['uid'] = $UID;
    mysqli_free_result($result);
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
