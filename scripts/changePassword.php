<?php
session_start();

$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
include($connectPath);

$type=$_POST['type'];
$token=isset($_POST['value']);
$password=$_POST['checkPassword'];

$hash=password_hash($password, PASSWORD_BCRYPT);

if($type=='reset'){
  $sql="SELECT token FROM user WHERE token='$token' LIMIT 1";
  $result=mysqli_query($conn, $sql);
  $number=mysqli_num_rows($result);
  if($number==0){
    header("Location: ../index.php");
  }
  else{
    $updatePassword="UPDATE user SET password='$hash' WHERE token='$token'";
    if($result=mysqli_query($conn, $updatePassword)){
      $selectUser="SELECT UID, username, password, firstname FROM user WHERE token='$token' LIMIT 1";
      $selectResult=mysqli_query($conn, $selectUser);
      while($row=mysqli_fetch_array($selectResult)){
        $UID=$row['UID'];
        $storedHash = $row['password'];
        $first = $row['firstname'];
        $user=$row['username'];
      }
      if(password_verify($password, $storedHash)){
        $_SESSION['first'] = $first;
        $_SESSION['user'] = $user;
        $_SESSION['uid'] = $UID;
        $deleteToken="UPDATE user SET token='' WHERE token='$token'";
        mysqli_query($conn, $deleteToken);
        header('Location: ../splash.php');
      }
      else{
        echo "error error";
      }
    }
    else{
      echo "Error: ".$conn->error;
    }
  }
}
if($type=="change"){
  $oldPassword=$_POST['oldPass'];
  $uid=$_SESSION['UID'];

  $sql="SELECT password FROM user WHERE uid='$uid'";
  $result=mysqli_query($conn, $sql);
  while($row=mysqli_fetch_array($result)){
    $currentHash=$row['password'];
  }

  if(password_verify($oldPassword, $currentHash)){
    $hash=password_hash($password, PASSWORD_BCRYPT);
    $updatePassword="UPDATE user SET password='$hash' WHERE UID='$uid'";
    if($updateResult=mysqli_query($conn, $updatePassword)){
      header("Location: ../account.php?password=success");
    }
    else{
      header("Location: ../account.php?password=fail");
    }
  }
  else{
    header("Location: ../account.php?password=incorrect");
  }
}
?>
