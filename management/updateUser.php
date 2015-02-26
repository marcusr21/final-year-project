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
$pass=$_POST['password']

if(isset($_POST['type']) && $_POST['type']=='add'){

}
elseif(isset($_POST['type']) && $_POST['type']=='edit'){
  $sql="UPDATE user
  SET firstname='$first', surname='$surname', email='$email', access='$access'
  WHERE uid='$uid'";
  if(mysqli_query($conn, $sql)===TRUE){
    header('Location: manageUser.php?type=edit');
  }
  else{
    echo "Error: ".$conn->error;
  }
}
elseif(isset($_POST['type']) && $_POST['type']=='delete'){

}
?>
