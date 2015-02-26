<?php
session_start();
$path = $_SERVER['DOCUMENT_ROOT'];
$connectPath .= $path;
$connectPath .= "/connect.php";
include($connectPath);

$array=array();
if(isset($_POST['uid'])){
  $uid=$_POST['uid'];
  $sql="SELECT uid, firstname, surname, email, access FROM user
  WHERE uid = '$uid'";
  $query=mysqli_query($conn, $sql);
  while($row=mysqli_fetch_array($query)){
    $array=array('uid'=>$row['uid'], 'first'=>$row['firstname'], 'surname'=>$row['surname'], 'email'=>$row['email'], 'access'=>$row['access']);
  }

  echo json_encode($array);
}
?>
