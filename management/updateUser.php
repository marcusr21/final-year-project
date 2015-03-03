<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
include($connectPath);

$uid=$_POST['uid'];
$first=$_POST['first'];
$surname=$_POST['surname'];
$email=$_POST['email'];
$access=$_POST['access'];
$pass=$_POST['password'];

if(isset($_POST['type']) && $_POST['type']=='add'){
  $selectQuery="SELECT * FROM user WHERE email='$email' LIMIT 1";
  $result=mysqli_query($conn, $selectQuery);
  if(mysqli_num_rows($result) > 0){
    header('Location: manageUser.php?type=email');
  }
  else{
    $passHash=password_hash($pass, PASSWORD_BCRYPT);
    $sql="INSERT INTO user (firstname, surname, email, password, access)
    VALUES ('$first', '$surname', '$email', '$passHash', '$access')";
    if(mysqli_query($conn, $sql)===TRUE){
      header('Location: manageUser.php?type=added');
    }
  }
}
elseif(isset($_POST['type']) && $_POST['type']=='edit'){
  $sql="UPDATE user
  SET firstname='$first', surname='$surname', email='$email', access='$access'
  WHERE uid='$uid'";
  if(mysqli_query($conn, $sql)===TRUE){
    header('Location: manageUser.php?type=edited');
  }
  else{
    echo "Error: ".$conn->error;
  }
}
elseif(isset($_POST['type']) && $_POST['type']=='delete'){
  $sql="DELETE FROM user
  WHERE uid='$uid'";
  if(mysqli_query($conn, $sql)===TRUE){
    header('Location: manageUser.php?type=deleted');
  }
  else{
    echo "Error: ".$conn->error;
  }
}
?>
